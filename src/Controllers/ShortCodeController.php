<?php

declare(strict_types=1);

namespace Syde\UserListing\Controllers;
use Syde\UserListing\Services\APIService;

/**
 * Class ShourtCodeController
 * 
 * @package Syde\UserListing\Controllers
 */
class ShortCodeController{

    /**
     * ShortCodeController constructor.
     * 
     * @since 1.0.0
     * @access public
     * 
     * @return void
     * 
     */
    public function __construct( private APIController $apiController, private APIService $apiService )
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

        $atts = shortcode_atts(
            [
                'endpoint' => 'https://jsonplaceholder.typicode.com/users',
            ],
            $atts,
            'syde_user_listing'
        );
        $users = $this->apiService->fetch( $atts['endpoint'] );

        ob_start();
        include_once SYDE_USER_LISTING_PLUGIN_DIR . 'src/Views/table-info.php';
        return ob_get_clean();
    }
}