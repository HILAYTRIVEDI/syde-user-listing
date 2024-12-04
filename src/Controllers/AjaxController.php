<?php

/**
 * This file contains the Ajax controller class for the Syde User Listing plugin
 * that handles the AJAX requests for fetching user details and removing the cache.
 *
 *
 * @package Syde\UserListing\Controllers
 *
 * @since 1.0.0
 */

declare(strict_types=1);

namespace Syde\UserListing\Controllers;

use Syde\UserListing\Services\APIService;
use Syde\UserListing\Services\SydeSanitizationService;
use Syde\UserListing\Controllers\CacheController;

/**
 * Class AjaxController
 *
 * Handles AJAX requests for fetching user details from an external API.
 *
 * @package Syde\UserListing\Controllers
 * @since 1.0.0
 */
class AjaxController
{
    /**
     * AjaxController constructor.
     *
     * Initializes the controller by registering necessary actions.
     *
     * @param APIService $apiService The API service responsible for fetching user details.
     * @param CacheController $cacheController The cache controller for managing caching.
     * @param SydeSanitizationService $sanitizationService
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function __construct(
        private APIService $apiService,
        private CacheController $cacheController,
        private SydeSanitizationService $sanitizationService
    ) {
    }

    /**
     * Register actions for fetching user details.
     *
     * Hooks into WordPress AJAX actions to process requests for user data.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function register(): void
    {
        add_action('wp_ajax_fetch_user_details', [$this, 'fetchUserDetails']);
        add_action('wp_ajax_nopriv_fetch_user_details', [$this, 'fetchUserDetails']);

        add_action('wp_ajax_remove_cache', [$this, 'removeCache']);
        add_action('wp_ajax_nopriv_remove_cache', [$this, 'removeCache']);
    }

    /**
     * Fetch user details from the API.
     *
     * Processes the AJAX request, verifies nonce security, and fetches the user
     * details using the provided user ID. Returns the user details as HTML
     * if successful.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function fetchUserDetails(): void
    {
        $nonce = isset($_POST['_wpnonce']) ?
                $this->sanitizationService->sanitizeTextField(wp_unslash($_POST['_wpnonce']))
            : '';

        if (!wp_verify_nonce($nonce, 'syde_user_listing')) {
            wp_send_json_error('Invalid nonce');
            return;
        }

        // Get and validate the user ID from POST
        $userId =
            isset($_POST['userId']) ?
            $this->sanitizationService->sanitizeInt(wp_unslash($_POST['userId'])) : 0;
        $apiEndpoint = isset($_POST['_apiEndpoint'])
        ? $this->sanitizationService->sanitizeUrl(wp_unslash($_POST['_apiEndpoint'])) : '';


        if (!$userId) {
            wp_send_json_error('Invalid userId');
            return;
        }

        $userDetails = $this->apiService->userDetails($apiEndpoint, $userId);

        if (empty($userDetails)) {
            wp_send_json_error('User not found');
            return;
        }

        // Capture the user details HTML for response
        try {
            ob_start();
            require_once SYDE_USER_LISTING_PLUGIN_DIR . 'src/Views/single-user.php';
            $userDetailsHtml = ob_get_clean();
        } catch (\Exception $error) {
            ob_end_clean();
            wp_send_json_error($error->getMessage());
            return;
        }


        // Return the success response with HTML content
        wp_send_json_success($userDetailsHtml);
        wp_die();
    }

    /**
     * Remove cache.
     *
     * This function removes the cache for the given url in the admin panel
     * and returns a success or error message.
     *
     * @return void
     * @since 1.0.0
     * @access public
     */
    public function removeCache(): void
    {
        $nonce = isset($_POST['_wpnonce']) ?
                $this->sanitizationService->sanitizeTextField(wp_unslash($_POST['_wpnonce']))
            : '';

        if (!wp_verify_nonce($nonce, 'syde_user_listing_admin')) {
            wp_send_json_error('Invalid nonce');
            return;
        }

        // ge the data and encode it in md5 to prepare for cache key
        $data = isset($_POST['data'])
                ? $this->sanitizationService->sanitizeTextField(wp_unslash($_POST['data']))
                : '';

        if (!$data) {
            wp_send_json_error('Invalid data');
            return;
        }

        $cacheKey = md5($data);

        try {
            $this->cacheController->deleteCache('data_list_' . $cacheKey);
        } catch (\Exception $error) {
            wp_send_json_error($error->getMessage());
            return;
        }

        wp_send_json_success();
        wp_die();
    }
}
