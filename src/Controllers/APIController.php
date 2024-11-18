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

    public function __construct( private APIService $apiService ){
        $this->register();
    }

    public function register(): void
    {
        add_action('wp_ajax_fetch_user_details', [$this, 'fetchUserDetails']);
        add_action('wp_ajax_nopriv_fetch_user_details', [$this, 'fetchUserDetails']);
    }

    public function fetchUserDetails(): void
    {

        $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : 0;
        // Check type of user_id
        if( ! is_numeric($user_id) ){
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