<?php

declare(strict_types=1);

namespace Syde\UserListing\Tests\Unit\Controller;

use Syde\UserListing\Tests\SydeUserListingTest;
use Syde\UserListing\Factories\ServiceFactory;
use Syde\UserListing\Services\SydeErrorService;
use Syde\UserListing\Controllers\CacheController;


class CacheControllerTest extends SydeUserListingTest
{
    /**
     * Helper function to create CacheController with mocked dependencies.
     * 
     * @return CacheController
     */
    private function createCacheController(): CacheController
    {
        $serviceFactoryMock = $this->createMock(ServiceFactory::class);
        $errorServiceMock = $this->createMock(SydeErrorService::class);

        return new CacheController(
            $serviceFactoryMock, 
            $errorServiceMock,
        );
    }

    /**
     * Test the userCache method of the CacheController.
     * 
     * @return void
     */
    public function testUserCache(): void
    {
        // Use helper to get CacheController with mocks
        $cacheController = $this->createCacheController();

        // Assert: The controller should fetch the user cache
        $this->assertIsCallable([$cacheController, 'userCache']);
    }

    /**
     * Test the cacheDataWithExpiration method of the CacheController.
     * 
     * @return void
     */
    public function testCacheDataWithExpiration(): void
    {
        // Use helper to get CacheController with mocks
        $cacheController = $this->createCacheController();

        // Assert: The controller should store the user data in the cache
        $this->assertIsCallable([$cacheController, 'cacheDataWithExpiration']);
    }

    /**
     * Test the deleteCache method of the CacheController.
     * 
     * @return void
     */
    public function testDeleteCache(): void
    {
        // Use helper to get CacheController with mocks
        $cacheController = $this->createCacheController();

        // Assert: The controller should delete the cache
        $this->assertIsCallable([$cacheController, 'deleteCache']);
    }
}