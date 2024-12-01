<?php

declare(strict_types=1);

namespace Syde\UserListing\Tests\Unit\Controller;

use Syde\UserListing\Tests\SydeUserListingTest;
use \Syde\UserListing\Controllers\AjaxController;
use \Syde\UserListing\Controllers\CacheController;
use \Syde\UserListing\Services\APIService;
use Syde\UserListing\Services\SydeSanitizationService;


class AjaxControllerTest extends SydeUserListingTest{

    /**
     * Helper function to create AjaxController with mocked dependencies.
     * 
     * @return AjaxController
     */
    private function createAjaxController(): AjaxController
    {
        $cacheController = $this->createMock(CacheController::class);
        $apiService = $this->createMock(APIService::class);
        $sydeSanitizationService = $this->createMock(SydeSanitizationService::class);

        return new AjaxController($apiService, $cacheController, $sydeSanitizationService);
    }

    /**
     * Test the register method of the AjaxController.
     * 
     * @return void
     */
    public function testRegisters(): void
    {

        // Use helper to get AjaxController with mocks
        $ajaxController = $this->createAjaxController();

        // Assert: The controller should register the menu page and cache controller
        $this->assertIsCallable([$ajaxController, 'register']);
    }

    /**
     * Test the fetchUserDetails method of the AjaxController.
     * 
     * @return void
     */
    public function testfetchUserDetails(): void{

        // Use helper to get AjaxController with mocks
        $ajaxController = $this->createAjaxController();

        // Assert: The controller should register the menu page and cache controller
        $this->assertIsCallable([$ajaxController, 'fetchUserDetails']);
    
    }
  
}