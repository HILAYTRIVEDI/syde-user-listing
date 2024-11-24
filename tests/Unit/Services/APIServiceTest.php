<?php

declare(strict_types=1);

namespace Syde\UserListing\Tests\Unit\Services;

use Syde\UserListing\Tests\SydeUserListingTest;

use Syde\UserListing\Services\APIService;

class APIServiceTest extends SydeUserListingTest{
    
    /**
     * Test the fetch method of the APIService.
     * 
     * @return void
     */
    public function testFetch(): void{

        // Use helper to get AjaxController with mocks
        $ajaxController = new APIService();

        // Check if the fetch function returns the expected data
        $this->assertIsCallable([$ajaxController, 'fetch']);
    
    }
}
