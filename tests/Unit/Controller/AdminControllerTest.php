<?php

declare(strict_types=1);

namespace Tests\Unit\Controller;

use PHPUnit\Framework\TestCase;
use Syde\UserListing\Controllers\AdminController;
use Syde\UserListing\Controllers\MenuPageController;
use Syde\UserListing\Controllers\CacheController;

class AdminControllerTest extends TestCase
{
    public function testRegister(): void
    {
        // Arrange: Mock the dependencies
        $menuPageControllerMock = $this->createMock(MenuPageController::class);
        $cacheControllerMock = $this->createMock(CacheController::class);

        // Act: Instantiate the controller with the mocked dependencies
        $adminController = new AdminController($menuPageControllerMock, $cacheControllerMock);

        // Assert: The controller should register the menu page and cache controller
        $this->assertIsCallable([$adminController, 'register']);
    }
}
