<?php

declare(strict_types=1);

namespace Syde\UserListing\Tests\Unit\Services;

use Syde\UserListing\Tests\SydeUserListingTest;
use Syde\UserListing\Services\APIService;
use PHPUnit\Framework\MockObject\MockObject;

class APIServiceTest extends SydeUserListingTest
{
    /**
     * Test the fetch method of the APIService.
     *
     * @return void
     */
    public function testFetch(): void
    {
        // Mock the APIService class
        $apiServiceMock = $this->createMock(APIService::class);

        // Mock the response from the external API
        $mockedResponse = [
            'id' => 1,
            'name' => 'John Doe',
            'username' => 'johndoe',
        ];

        // Mock the fetch method to return the mocked response
        $apiServiceMock->method('fetch')
            ->willReturn($mockedResponse);

        // Call the fetch method
        $result = $apiServiceMock->fetch('https://jsonplaceholder.typicode.com/users/1');

        // Assert that the returned result is an array
        $this->assertIsArray($result);

        // Assert that the array contains the expected data
        $this->assertArrayHasKey('id', $result);
        $this->assertArrayHasKey('name', $result);
        $this->assertArrayHasKey('username', $result);

        // Assert that the values are correct
        $this->assertEquals(1, $result['id']);
        $this->assertEquals('John Doe', $result['name']);
        $this->assertEquals('johndoe', $result['username']);
    }
}
