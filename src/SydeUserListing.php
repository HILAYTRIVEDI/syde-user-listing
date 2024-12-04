<?php

/**
 * This file is the main file for the Syde User Listing plugin. It contains the
 * main class and the plugin bootstrap.
 *
 * @package Syde\UserListing
 *
 * @since 1.0.0
 */

declare(strict_types=1);

namespace Syde\UserListing;

use Syde\UserListing\Container\SydeContainer;
use Syde\UserListing\Controllers\AdminController;
use Syde\UserListing\Controllers\ShortcodeController;
use Syde\UserListing\Controllers\AjaxController;

/**
 * Main plugin class that initializes and registers services.
 *
 * @package Syde\UserListing
 * @since 1.0.0
 */
final class SydeUserListing
{
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
        $plugin = new SydeContainer();
        $plugin->get(AdminController::class)?->register();
        $plugin->get(ShortcodeController::class)->register();
        $plugin->get(AjaxController::class)->register();
    }
}
