<?php

declare(strict_types=1);

namespace Syde\UserListing\Controllers;

/**
 * Class AdminController
 *
 * @package Syde\UserListing\Controllers
 */
class AdminController
{
    public function __construct(
        private MenuPageController $menuPageController, 
        private CacheController $cacheController)
    {
    }

    /**
     * Register the admin menu.
     *
     * @return void
     * @since 1.0.0
     * @access public
     */
    public function register(): void
    {
        add_action('admin_menu', [$this, 'addApiEndpointMenu']);
        add_action('admin_init', [$this, 'registerAPIEndpointFields']);
    }


    /**
     * Add the API endpoint menu.
     *
     * @return void
     * @since 1.0.0
     * @access public
     */
    public function addApiEndpointMenu(): void
    {
        add_menu_page(
            'Default API Endpoint',
            'DefaultAPI Endpoint',
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
            'sanitize_text_field'
        );

        // Add hooks for extensibility
        do_action('register_api_endpoint_fields');
    }

    public function renderApiEndpointPage(): void
    {
        ob_start();
        include_once SYDE_USER_LISTING_PLUGIN_DIR . 'src/Views/admin-page.php';
        $output = ob_get_clean();

        echo wp_kses($output, [
            'table' => [
                'class' => [],
            ],
            'tr' => [
                'class' => [],
            ],
            'th' => [
                'scope' => [],
                'class' => [],
            ],
            'td' => [
                'class' => [],
            ],
            'input' => [
                'type' => [],
                'name' => [],
                'value' => [],
                'class' => [],
            ],
            'h1' => [
                'class' => [],
            ],
            'form' => [
                'method' => [],
                'action' => [],
                'class' => [],
            ],
        ]);
    }
}
