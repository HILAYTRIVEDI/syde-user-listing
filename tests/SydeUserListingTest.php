<?php

declare(strict_types=1);

namespace Syde\UserListing\Tests;

use PHPUnit\Framework\TestCase;
use WP_Mock;

class SydeUserListingTest extends TestCase
{

    public function setup(): void
    {
        parent::setup();
        WP_Mock::setUp();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        WP_Mock::tearDown();
    }
}

