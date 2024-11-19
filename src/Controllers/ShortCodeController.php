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

        // Enqueue the script file.
        add_action('wp_enqueue_scripts', [$this, 'enqueueScript']);
    }

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
            return '';
        }

        $atts = shortcode_atts(
            [
                'endpoint' => 'https://jsonplaceholder.typicode.com/users',
            ],
            $atts,
            'syde_user_listing'
        );

        // Check if the cache is present.
        $users = $this->cacheController->getUserCache('user_list', $atts['endpoint']);

        if(empty($users)){
            $users = $this->serviceFactory->createApiService()->fetch($atts['endpoint']);
            $this->cacheController->setUserCache('user_list', $atts['endpoint'], $users);
        }


        // $users = $this->serviceFactory->createApiService()->fetch($atts['endpoint']);

        ob_start();
        include_once SYDE_USER_LISTING_PLUGIN_DIR . 'src/Views/table-info.php';
        return ob_get_clean();
    }
}