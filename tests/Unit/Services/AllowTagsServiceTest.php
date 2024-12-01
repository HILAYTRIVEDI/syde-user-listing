<?php


declare(strict_types=1);

namespace Syde\UserListing\Tests\Unit\Services;

use Syde\UserListing\Tests\SydeUserListingTest;
use Syde\UserListing\Services\AllowTagsService;

class AllowTagsServiceTest extends SydeUserListingTest{

    /**
     * Test the getAllowedTagsAtributes method of the AllowTagsService.
     * 
     * @return void
     */
    public function testGetAllowedTagsAtributes(): void{

        // Use helper to get AjaxController with mocks
        $ajaxController = new AllowTagsService();

        // Check if the fetch function returns the expected data
        $this->assertIsCallable([$ajaxController, 'getAllowedTagsAtributes']);

        // Check if the fetch function returns the expected data
        $this->assertIsArray([$ajaxController, 'getAllowedTagsAtributes']);
    
    }
}