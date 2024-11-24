<?php

declare(strict_types=1);

namespace Syde\UserListing\Tests\Services;

use Syde\UserListing\Tests\SydeUserListingTest;
use Syde\UserListing\Services\CacheService;

class CacheServiceTest extends SydeUserListingTest{

    /**
     * Test the ReturnCache method of the CacheService.
     * 
     * @return void
     */
    public function testReturnCache(): void{

        // Use helper to get AjaxController with mocks
        $ajaxController = new CacheService();

        // Check if the fetch function returns the expected data
        $this->assertIsCallable([$ajaxController, 'returnCache']);
    
    }

    /**
     * Test the CacheDataWithExpiration method of the CacheService.
     * 
     * @return void
     */
    public function testCacheDataWithExpiration(): void{

        // Use helper to get AjaxController with mocks
        $ajaxController = new CacheService();

        // Check if the fetch function returns the expected data
        $this->assertIsCallable([$ajaxController, 'cacheDataWithExpiration']);
    
    }

    /**
     * Test the DeleteCache method of the CacheService.
     * 
     * @return void
     */
    public function testDeleteCache(): void{

        // Use helper to get AjaxController with mocks
        $ajaxController = new CacheService();

        // Check if the fetch function returns the expected data
        $this->assertIsCallable([$ajaxController, 'deleteCache']);
    
    }

    /**
     * Test the HasCache method of the CacheService.
     * 
     * @return void
     */
    public function testHasCache(): void{

        // Use helper to get AjaxController with mocks
        $ajaxController = new CacheService();

        // Check if the fetch function returns the expected data
        $this->assertIsCallable([$ajaxController, 'hasCache']);
    
    }
}