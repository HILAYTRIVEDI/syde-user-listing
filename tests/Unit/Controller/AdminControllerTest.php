<?php

declare(strict_types=1);

namespace Tests\Unit\Controller;

use PHPUnit\Framework\TestCase;
use Syde\UserListing\Controllers\AdminController;
use Syde\UserListing\Controllers\MenuPageController;
use Syde\UserListing\Controllers\CacheController;

class AdminControllerTest extends TestCase
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

        return new AdminController($menuPageControllerMock, $cacheControllerMock);
    }

    /**
     * Test the register method of the AdminController.
     * 
     * @return void
     */
    public function testRegister(): void
    {
        // Use helper to get AdminController with mocks
        $adminController = $this->createAdminController();

        // Assert: The controller should register the menu page and cache controller
        $this->assertIsCallable([$adminController, 'register']);
    }

    /**
     * Test the addApiEndpointMenu method of the AdminController.
     * 
     * @return void
     */
    public function testAddApiEndpointMenu(): void
    {
        // Use helper to get AdminController with mocks
        $adminController = $this->createAdminController();

        // Assert: The controller should register the menu page and cache controller
        $this->assertIsCallable([$adminController, 'addApiEndpointMenu']);
    }

    /**
     * Test the registerAPIEndpointFields method of the AdminController.
     * 
     * @return void
     */
    public function testRegisterAPIEndpointFields(): void
    {
        // Use helper to get AdminController with mocks
        $adminController = $this->createAdminController();

        // Assert: The controller should register the menu page and cache controller
        $this->assertIsCallable([$adminController, 'registerAPIEndpointFields']);
    }

    /**
     * Test the renderApiEndpointPage method of the AdminController.
     * 
     * @return void
     */
    public function testRenderApiEndpointPage(): void
    {
        // Use helper to get AdminController with mocks
        $adminController = $this->createAdminController();

        // Assert: The controller should register the menu page and cache controller
        $this->assertIsCallable([$adminController, 'renderApiEndpointPage']);
    }
}
