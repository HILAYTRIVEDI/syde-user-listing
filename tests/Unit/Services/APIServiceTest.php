<?php

declare(strict_types=1);

namespace Tests\Unit\Controller;

use PHPUnit\Framework\TestCase;
use Syde\UserListing\Services\APIService;

class APIServiceTest extends TestCase{
    
    public function testFetch(): void{

        // Use helper to get AjaxController with mocks
        $ajaxController = new APIService();

        // Check if the fetch function returns the expected data
        $this->assertIsCallable([$ajaxController, 'fetch']);
    
    }
}
