<?php

declare(strict_types=1);

namespace Syde\UserListing\Controllers;

use Syde\UserListing\Services\APIService;
use Syde\UserListing\Controllers\CacheController;

/**
 * Class APIController
 *
 * Handles AJAX requests for fetching user details from an external API.
 *
 * @package Syde\UserListing\Controllers
 * @since 1.0.0
 */
class APIController
{
    /**
     * APIController constructor.
     *
     * Initializes the controller by registering necessary actions.
     *
     * @param APIService $apiService The API service responsible for fetching user details.
     * @param CacheController $cacheController The cache controller for managing caching.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function __construct(private APIService $apiService, private CacheController $cacheController)
    {
        $this->register();
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
    }

    /**
     * Fetch user details from the API.
     *
     * Processes the AJAX request, verifies nonce security, and fetches the user details
     * using the provided user ID. Returns the user details as HTML if successful.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function fetchUserDetails(): void
    {
        // Verify nonce for security
        if (!wp_verify_nonce($_POST['_wpnonce'], 'syde_user_listing')) {
            wp_send_json_error('Invalid nonce');
            return;
        }

        // Get and validate the user ID from POST
        $user_id = isset($_POST['user_id']) && is_numeric($_POST['user_id']) ? (int) $_POST['user_id'] : 0;

        if (!$user_id) {
            wp_send_json_error('Invalid user_id');
            return;
        }

        $user_details = $this->apiService->getUserDetails($user_id);

        if (empty($user_details)) {
            wp_send_json_error('User not found');
            return;
        }

        // Capture the user details HTML for response
        ob_start();
        require_once SYDE_USER_LISTING_PLUGIN_DIR . 'src/Views/single-user.php';
        $user_details_html = ob_get_clean();

        // Return the success response with HTML content
        wp_send_json_success($user_details_html);
        wp_die();
    }
}
