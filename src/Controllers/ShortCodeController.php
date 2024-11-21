<?php

declare(strict_types=1);

namespace Syde\UserListing\Controllers;

use Syde\UserListing\Controllers\APIController;
use Syde\UserListing\Factories\ServiceFactory;
use Syde\UserListing\Controllers\CacheController;

/**
 * Class ShortcodeController
 *
 * This class is responsible for handling the shortcode functionalities in the Syde User Listing plugin.
 * It includes registering the shortcode, enqueueing the required scripts and styles, and rendering the
 * shortcode output for displaying user listings.
 *
 * @package Syde\UserListing\Controllers
 * @since 1.0.0
 */
class ShortcodeController
{
    /**
     * Constructor to initialize the dependencies and hook actions.
     *
     * @param APIController $apiController The controller to interact with the external API.
     * @param ServiceFactory $serviceFactory The factory that creates services like API service.
     * @param CacheController $cacheController The controller that manages caching of user data.
     *
     * @since 1.0.0
     */
    public function __construct(
        private APIController $apiController,
        private ServiceFactory $serviceFactory,
        private CacheController $cacheController
    ) {
        // Register the shortcode for rendering user listing.
        add_shortcode('syde_user_listing', [$this, 'renderShortCode']);

        // Hook into WordPress to enqueue styles.
        add_action('wp_enqueue_scripts', [$this, 'enqueueStyle']);

        // Hook into WordPress to enqueue scripts.
        add_action('wp_enqueue_scripts', [$this, 'enqueueScript']);
    }

    /**
     * Enqueue the style file for the frontend.
     *
     * This method adds the CSS stylesheet for the Syde User Listing plugin to the frontend of the site.
     *
     * @since 1.0.0
     *
     * @return void
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
     * Enqueue the script file for the frontend.
     *
     * This method adds the JavaScript file for the Syde User Listing plugin to the frontend of the site
     * and also localizes the script to pass necessary data like the AJAX URL and a security nonce.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function enqueueScript(): void
    {
        wp_enqueue_script(
            'syde-user-listing-script',
            SYDE_USER_LISTING_PLUGIN_URL . '/src/assets/js/script.js',
            ['jquery'],
            SYDE_USER_LISTING_VERSION,
            true
        );

        wp_localize_script(
            'syde-user-listing-script',
            'syde_user_listing',
            [
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('syde_user_listing'),
            ]
        );
    }

    /**
     * Render the shortcode output.
     *
     * This method is responsible for rendering the output of the [syde_user_listing] shortcode. It fetches
     * the user data either from the cache or directly from the API and then displays the results in a table format.
     *
     * @since 1.0.0
     *
     * @param array<string, mixed> $atts Shortcode attributes passed by the user.
     * @param string|null $content The content inside the shortcode, if any.
     *
     * @return string The HTML output generated by the shortcode.
     */
    public function renderShortCode(array $atts, ?string $content = null): string
    {
        // Check if the shortcode has been disabled.
        if (defined('SHORTCODE_DISABLED')) {
            return esc_html__('Shortcode is disabled.', 'syde-user-listing');
        }

        // Get the API endpoint from the plugin options, or use defaults.
        $api_endpoint_name = get_option('api_endpoint_name') ?? 'https://jsonplaceholder.typicode.com';
        $api_endpoint_url = get_option('api_endpoint_url') ?? '/users';

        // Merge shortcode attributes with defaults.
        $atts = shortcode_atts(
            [
                'endpoint' => $api_endpoint_url . $api_endpoint_name,
            ],
            $atts,
            'syde_user_listing'
        );

        /**
         * Action hook before fetching user data.
         * Allows other parts of the plugin to modify attributes before fetching data.
         */
        do_action('syde_user_listing_before_fetch', $atts);

        // Attempt to fetch cached user data for the given endpoint.
        $users = $this->cacheController->getUserCache('user_list', $atts['endpoint']);

        if (empty($users) || !is_array($users)) {
            // Fetch fresh data from the API if cache is empty or not valid.
            $users = $this->serviceFactory->createApiService()->fetch($atts['endpoint']);
            $this->cacheController->setUserCache('user_list', $users);
        }

        /**
         * Filter hook to modify users before rendering.
         * Allows other plugins or parts of the system to modify the users list before it is displayed.
         */
        $users = apply_filters('syde_user_listing_users', $users, $atts);

        // Capture the output of the table info template.
        ob_start();
        include_once SYDE_USER_LISTING_PLUGIN_DIR . 'src/Views/table-info.php';

        // Return the generated HTML output.
        return ob_get_clean();
    }
}
