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
 * @package Syde\UserListing
 */
class Plugin{

    public function __construct(private Container $container){}
    
    /**
     * Initialize the plugin.
     * 
     * @return void
     * @since 1.0.0
     * @access public
     * @static
     * 
     */
    public function init(): void
    {
        $this->registerServices();
    }

    public function registerServices(): void
    {
        $this->container->get(AdminController::class)->register();
        $this->container->get(ShortcodeController::class);
    }

}
