<?php

declare(strict_types=1);

namespace Syde\UserListing\Controllers;

use Syde\UserListing\Services\APIService;

/**
 * Class APIController
 * 
 * @package Syde\UserListing\Controllers
 */
class APIController{

    /**
     * APIController constructor.
     * 
     * @since 1.0.0
     * 
     * @access public
     * 
     * @param APIService $apiService
     * @return void
     * 
     */
    public function __construct( private APIService $apiService ){
        $this->register();
    }

    /**
     * Register the api controller.
     * 
     * @since 1.0.0
     * 
     * @access public
     * 
     * @return void
     * 
     */
    public function register(): void
    {
        add_action('wp_ajax_fetch_user_details', [$this, 'fetchUserDetails']);
        add_action('wp_ajax_nopriv_fetch_user_details', [$this, 'fetchUserDetails']);
    }

    /**
     * Fetch the user details.
     * 
     * @since 1.0.0
     * 
     * @access public
     * 
     * @return void
     * 
     */
    public function fetchUserDetails(): void
    {
        // Verify nonce
        if (! wp_verify_nonce($_POST['_wpnonce'], 'syde_user_listing')) {
            wp_send_json_error('Invalid nonce');
            return;
        }

        $user_id = isset($_POST['user_id']) && is_numeric($_POST['user_id']) ? (int)$_POST['user_id'] : 0;

        if (!$user_id) {
            wp_send_json_error('Invalid user_id');
            return;
        }

        $user_details = $this->apiService->getUserDetails( (int)$user_id );

        if( empty($user_details) ){
            wp_send_json_error('User not found');
            return;
        }

        ob_start();
        require_once SYDE_USER_LISTING_PLUGIN_DIR . 'src/Views/single-user.php';
        $user_details_html = ob_get_clean();

        wp_send_json_success($user_details_html);
        wp_die();
    }

}