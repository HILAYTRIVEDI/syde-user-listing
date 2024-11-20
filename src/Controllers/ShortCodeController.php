<?php

declare(strict_types=1);

namespace Syde\UserListing\Controllers;


use Syde\UserListing\Controllers\APIController;
use Syde\UserListing\Factories\ServiceFactory;
use Syde\UserListing\Controllers\CacheController;


/**
 * Class ShourtCodeController
 * 
 * @package Syde\UserListing\Controllers
 */
class ShortcodeController{

    /**
     * ShortcodeController constructor.
     * 
     * @since 1.0.0
     * @access public
     * 
     * @return void
     * 
     */
    public function __construct( 
        private APIController $apiController, 
        private ServiceFactory $serviceFactory,
        private CacheController $cacheController
        )
    {
        add_shortcode('syde_user_listing', [$this, 'renderShortCode']);

        // Enqueue style file.
        add_action('wp_enqueue_scripts', [$this, 'enqueueStyle']);

        // Enqueue the script file.
        add_action('wp_enqueue_scripts', [$this, 'enqueueScript']);
    }


    /**
     * Enqueue the style file.
     * 
     * @since 1.0.0
     * 
     * @access public
     * 
     * @return void
     * 
     */
    public function enqueueStyle(): void
    {
        wp_enqueue_style(
            'syde-user-listing-style',
            SYDE_USER_LISTING_PLUGIN_URL . '/src/assets/css/style.css',
            [],
            SYDE_USER_LISTING_VERSION,
            'all'
        );
    }

    /**
     * Enqueue the script file.
     * 
     * @since 1.0.0
     * 
     * @access public
     * 
     * @return void
     * 
     */
    public function enqueueScript(): void
    {
        wp_enqueue_script(
            'syde-user-listing-script',
            SYDE_USER_LISTING_PLUGIN_URL . '/src/assets/js/scrit.js',
            ['jquery'],
            SYDE_USER_LISTING_VERSION,
            true
        );

        wp_localize_script(
            'syde-user-listing-script',
            'syde_user_listing',
            [
                'ajax_url' => admin_url( 'admin-ajax.php' ),
                'nonce' => wp_create_nonce( 'syde_user_listing' ),
            ]
        );
    }

    /**
     * Render the shortcode.
     * 
     * @since 1.0.0
     * @access public
     * 
     * @param string $atts The shortcode attributes.
     * @param string $content The shortcode content.
     * 
     * @return string
     */
    public function renderShortCode($atts, $content = null): string
    {

        // Check if the shortcode is disabled.
        if (defined('SHORTCODE_DISABLED')) {
            return esc_html__('Shortcode is disabled.', 'syde-user-listing');
        }

        // Get api_endpoint_name from options.
        $api_endpoint_name = get_option('api_endpoint_name') ?? 'https://jsonplaceholder.typicode.com';
        $api_endpoint_url = get_option('api_endpoint_url') ?? '/users';

        $atts = shortcode_atts(
            [
                'endpoint' => $api_endpoint_url . $api_endpoint_name,
            ],
            $atts,
            'syde_user_listing'
        );

        /**
         * Action: Before fetching user data.
         */
        do_action('syde_user_listing_before_fetch', $atts);

        // Check if the cache is present.
        $users = $this->cacheController->getUserCache('user_list', $atts['endpoint']);

        if(empty($users) || ! is_array($users)){
            $users = $this->serviceFactory->createApiService()->fetch($atts['endpoint']);
            $this->cacheController->setUserCache('user_list', $users);
        }

        /**
        * Filter: Modify users before rendering.
        */
        $users = apply_filters('syde_user_listing_users', $users, $atts);

        ob_start();
        include_once SYDE_USER_LISTING_PLUGIN_DIR . 'src/Views/table-info.php';
        return ob_get_clean();
    }
}