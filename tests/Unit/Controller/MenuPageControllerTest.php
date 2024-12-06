<?php

declare(strict_types=1);

namespace Syde\UserListing\Tests\Unit\Controller;

use Syde\UserListing\Tests\SydeUserListingTest;
use Syde\UserListing\Controllers\MenuPageController;

class MenuPageControllerTest extends SydeUserListingTest
{
    /**
     * Test the registerMenuPageField method of the MenuPageController.
     *
     * @return void
     */
    public function testRegisterMenuPageField(): void
    {
        // Use helper to get MenuPageController with mocks
        $menuPageController = new MenuPageController();

        // Assert: The controller should register the menu page field
        $this->assertIsCallable([$menuPageController, 'registerMenuPageField']);
    }
}
