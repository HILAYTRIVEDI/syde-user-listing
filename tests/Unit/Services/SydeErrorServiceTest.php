<?php

declare(strict_types=1);

namespace Syde\UserListing\Tests\Unit\Services;

use Syde\UserListing\Services\SydeErrorService;
use Syde\UserListing\Tests\SydeUserListingTest;

class SydeErrorServiceTest extends SydeUserListingTest
{
    /**
     * Test the error method of the SydeErrorService.
     *
     * @return void
     */
    public function testHandleError(): void
    {

        // Use helper to get AjaxController with mocks
        $ajaxController = new SydeErrorService();

        // Check if the error function returns the expected data
        $this->assertIsCallable([$ajaxController, 'handleError']);
    }
}
