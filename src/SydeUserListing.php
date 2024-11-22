<?php

declare(strict_types=1);

namespace Syde\UserListing;

use Syde\UserListing\Container\SydeContainer;
use Syde\UserListing\Controllers\AdminController;
use Syde\UserListing\Controllers\ShortcodeController;

/**
 * Main plugin class that initializes and registers services.
 *
 * @package Syde\UserListing
 * @since 1.0.0
 */
final class SydeUserListing
{
    /**
     * Constructor.
     *
     * @param SydeContainer $container The dependency injection container.
     * @since 1.0.0
     */
    public function __construct(private SydeContainer $container)
    {
        $this->container = $container;
    }

    /**
     * Bootstrap the plugin.
     *
     * This method initializes the plugin and registers its services.
     *
     * @return void
     * @since 1.0.0
     */
    public static function bootstrap(): void
    {
        $plugin = new self(new SydeContainer());
        $plugin->registerServices();
    }

    /**
     * Register necessary plugin services.
     *
     * This method ensures that controllers and other services are
     * retrieved from the container and properly initialized.
     *
     * @return void
     * @throws \RuntimeException If a required service is not available.
     * @since 1.0.0
     */
    public function registerServices(): void
    {
        $adminController = $this->container->get(AdminController::class);
        if (!$adminController) {
            throw new \RuntimeException(
                'AdminController could not be retrieved from the container.'
            );
        }
        $adminController->register();

        $shortcodeController = $this->container->get(ShortcodeController::class);
        if (!$shortcodeController) {
            throw new \RuntimeException(
                'ShortcodeController could not be retrieved from the container.'
            );
        }
    }
}
