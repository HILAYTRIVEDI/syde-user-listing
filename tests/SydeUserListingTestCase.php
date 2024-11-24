<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;

abstract class SydeUserListingTestCase extends TestCase
{
    /**
     * Set up the test environment before each test runs.
     */
    public function setUp(): void
    {
        // No need for Brain Monkey, setup any general test state here if needed
        parent::setUp();
    }

    /**
     * Tear down the test environment after each test runs.
     */
    public function tearDown(): void
    {
        // Cleanup after each test
        parent::tearDown();
    }
}
