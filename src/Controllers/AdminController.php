<?php

/**
 * This file contains the admin controller class for the Syde User Listing plugin
 * that handles the admin page functionalities.
 *
 * @package Syde\UserListing\Controllers
 *
 * @since 1.0.0
 */

declare(strict_types=1);

namespace Syde\UserListing\Controllers;

use Syde\UserListing\Services\SydeSanitizationService;

/**
 * Class AdminController
 *
 * THis class is responsible for handling the admin page functionalities in the
 * Syde User Listing plugin.It includes registering the admin page, registering
 * the required settings fields, and rendering the admin page.
 *
 * @package Syde\UserListing\Controllers
 */
class AdminController
{
    public function __construct(
        private MenuPageController $menuPageController,
        private CacheController $cacheController,
        private SydeSanitizationService $sanitizationService,
    ) {
    }

    /**
     * Register the admin menu.
     *
     * This method registers the admin menu and initializes the admin page.
     * It also registers the required settings fields and actions.
     *
     * @return void
     * @since 1.0.0
     * @access public
     */
    public function register(): void
    {
        add_action('admin_menu', [$this, 'addApiEndpointMenu']);
        add_action('admin_init', [$this, 'registerAPIEndpointFields']);

        // Enqueue the admin page script
        add_action('admin_enqueue_scripts', [$this, 'enqueueAdminPageScript']);
    }

    /**
     * Enqueue the admin page script.
     *
     * This method enqueues the admin page script to handle the removal of the cache.
     *
     * @return void
     * @since 1.0.0
     * @access public
     */
    public function enqueueAdminPageScript(): void
    {

        // Get the current admin page slug
        $current_page = get_current_screen();

        if ($current_page->id !== 'toplevel_page_api_endpoint') {
            return;
        }

        wp_enqueue_script(
            'syde-user-listing-admin-script',
            SYDE_USER_LISTING_PLUGIN_URL . 'src/assets/js/admin-script.js',
            [],
            SYDE_USER_LISTING_VERSION,
            true
        );

        wp_localize_script(
            'syde-user-listing-admin-script',
            'syde_user_listing_admin',
            [
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('syde_user_listing_admin'),
            ]
        );
    }

    /**
     * Add the API endpoint menu.
     *
     * This method adds the API endpoint menu to the admin menu to allow users
     * to configure the Default API Endpoint URL and additional settings.
     *
     * @return void
     * @since 1.0.0
     * @access public
     */
    public function addApiEndpointMenu(): void
    {
        add_menu_page(
            'API Endpoint Settings',
            'API Endpoint Settings',
            'manage_options',
            'api_endpoint',
            [$this, 'renderApiEndpointPage'],
            'dashicons-admin-generic',
            10
        );
    }

    /**
     * Render the API endpoint page.
     *
     * This method renders the admin page for configuring the API endpoint URL
     * and it utilizes the `registerMenuPageField` method to register the
     * settings fields. It also adds the `additional_api_endpoint_fields` hook
     * to allow for additional fields to be added.
     *
     * @return void
     * @since 1.0.0
     * @access public
     *
     * @action admin_menu
     */
    public function registerAPIEndpointFields(): void
    {
        // Register settings with sanitization
        $this->menuPageController->registerMenuPageField(
            'api_endpoint_settings',
            'api_endpoint_url',
            [$this->sanitizationService, 'sanitizeUrl']
        );

        $this->menuPageController->registerMenuPageField(
            'api_endpoint_settings',
            'api_endpoint_remove_cache_url',
            [$this->sanitizationService, 'sanitizeUrl']
        );
        // Add hooks for extensibility
        do_action('register_api_endpoint_fields');
    }

    /**
     * Render the admin page.
     *
     * This method renders the admin page for configuring the API endpoint URL and
     * also allows to add the specific url for removing the cache.
     *
     * @return void
     * @since 1.0.0
     * @access public
     *
     * @action admin_menu
     */
    public function renderApiEndpointPage(): void
    {
        try {
            require_once SYDE_USER_LISTING_PLUGIN_DIR . 'src/Views/admin-page.php';
        } catch (\Exception $error) {
            printf(
                /* translators: error message comming from the $error object. */
                esc_html__(
                    'An error occurred while rendering the admin page: %s',
                    'syde-user-listing'
                ),
                esc_html($error->getMessage())
            );
        }
    }
}
