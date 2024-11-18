<?php

declare(strict_types=1);

namespace Syde\UserListing\Controllers;

/**
 * Class AdminController
 * 
 * @package Syde\UserListing\Controllers
 */
class AdminController{

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
            'API Endpoint',
            'API Endpoint',
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
    public function renderApiEndpointPage(): void
    {
        echo '<h1>API Endpoint</h1>';
    }

}