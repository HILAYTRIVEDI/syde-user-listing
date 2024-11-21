<?php

/**
 * Main bootstrap file for the plugin.
 *
 * @package Syde\UserListing
 *
 * @since 1.0.0
 */

declare(strict_types=1);

namespace Syde\UserListing;

use Syde\UserListing\Container\Container;
use Syde\UserListing\Controllers\AdminController;
use Syde\UserListing\Controllers\ShortcodeController;

/**
 * Class Plugin
 *
 * The main plugin class that initializes and registers services.
 * It is responsible for setting up the plugin and linking necessary controllers.
 *
 * @package Syde\UserListing
 * @since 1.0.0
 */
class Plugin
{
    /**
     * The container instance for dependency injection.
     *
     * @param Container $container An instance of the container class.
     * @return void
     * @since 1.0.0
     */
    public function __construct(private Container $container)
    {
    }

    /**
     * Initialize the plugin.
     *
     * This method serves as the entry point for plugin initialization.
     * It registers necessary services such as controllers for the admin panel
     * and shortcodes.
     *
     * @return void
     * @since 1.0.0
     */
    public function init(): void
    {
        // Register plugin services
        $this->registerServices();
    }

    /**
     * Register services such as controllers.
     *
     * This method fetches the required controllers from the container and
     * ensures that they are properly registered. It helps to decouple the plugin
     * logic from WordPress by relying on the container for service management.
     *
     * @return void
     * @since 1.0.0
     */
    public function registerServices(): void
    {
        $adminController = $this->container->get(AdminController::class)?->register();

        $shortcodeController = $this->container->get(ShortcodeController::class);
    }
}
