<?php

declare(strict_types=1);

namespace Syde\UserListing\Tests\Unit\Controller;

use Syde\UserListing\Tests\SydeUserListingTest;
use Syde\UserListing\Controllers\AdminController;
use Syde\UserListing\Controllers\MenuPageController;
use Syde\UserListing\Controllers\CacheController;
use Syde\UserListing\Services\SydeSanitizationService;
use WP_Mock;

/**
 * Class AdminControllerTest
 * Tests for AdminController
 */
class AdminControllerTest extends SydeUserListingTest
{
    /**
     * Helper function to create AdminController with mocked dependencies.
     * 
     * @return AdminController
     */
    private function createAdminController(): AdminController
    {
        $menuPageControllerMock = $this->createMock(MenuPageController::class);
        $cacheControllerMock = $this->createMock(CacheController::class);
        $sydeSanitizationServiceMock = $this->createMock(SydeSanitizationService::class);

        return new AdminController(
            $menuPageControllerMock,
            $cacheControllerMock,
            $sydeSanitizationServiceMock
        );
    }

    /**
     * Test the register method of the AdminController.
     * 
     * @return void
     */
    public function testRegister(): void
    {
        // Set up the WP_Mock expectations
        WP_Mock::expectActionAdded('admin_menu', [$this->anything(), 'addApiEndpointMenu']);
        WP_Mock::expectActionAdded('admin_init', [$this->anything(), 'registerAPIEndpointFields']);
        WP_Mock::expectActionAdded('admin_enqueue_scripts', [$this->anything(), 'enqueueAdminPageScript']);

        // Call the register method and ensure it's adding the actions
        $adminController = $this->createAdminController();
        $adminController->register();

        // Assert that the actions were added
        WP_Mock::assertActionsCalled('admin_menu');
        WP_Mock::assertActionsCalled('admin_init');
        WP_Mock::assertActionsCalled('admin_enqueue_scripts');
    }
}
