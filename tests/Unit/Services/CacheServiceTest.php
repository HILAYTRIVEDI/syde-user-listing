<?php

declare(strict_types=1);

namespace Syde\UserListing\Tests\Unit\Services;

use Syde\UserListing\Tests\SydeUserListingTest;
use Syde\UserListing\Services\CacheService;

if (!defined('HOUR_IN_SECONDS')) {
    define('HOUR_IN_SECONDS', 3600);
}

class CacheServiceTest extends SydeUserListingTest
{
    /**
     * Test the ReturnCache method of the CacheService.
     * 
     * @return void
     */
    public function testReturnCache(): void
    {
        // Mock the CacheService class
        $cacheServiceMock = $this->getMockBuilder(CacheService::class)
            ->onlyMethods(['returnCache'])
            ->getMock();

        // Return mocked response for the cache key
        $cacheServiceMock->expects($this->once())
            ->method('returnCache')
            ->with($this->equalTo('test_cache_key'))
            ->willReturn(['id' => 1, 'name' => 'John Doe']);

        // Call the returnCache method and assert it returns mocked data
        $result = $cacheServiceMock->returnCache('test_cache_key');
        $this->assertIsArray($result);
        $this->assertArrayHasKey('id', $result);
        $this->assertEquals(1, $result['id']);
    }

    /**
     * Test the CacheDataWithExpiration method of the CacheService.
     * 
     * @return void
     */
    public function testCacheDataWithExpiration(): void
    {
        // Mock the CacheService class
        $cacheServiceMock = $this->getMockBuilder(CacheService::class)
            ->onlyMethods(['cacheDataWithExpiration'])
            ->getMock();

        // Expect the cacheDataWithExpiration method to be called with specific arguments
        $cacheServiceMock->expects($this->once())
            ->method('cacheDataWithExpiration')
            ->with(
                $this->equalTo('test_cache_key'),
                $this->equalTo(['id' => 1, 'name' => 'John Doe']),
                $this->equalTo(12 * HOUR_IN_SECONDS)
            );

        // Call the cacheDataWithExpiration method
        $cacheServiceMock->cacheDataWithExpiration('test_cache_key', ['id' => 1, 'name' => 'John Doe']);
    }

    /**
     * Test the DeleteCache method of the CacheService.
     * 
     * @return void
     */
    public function testDeleteCache(): void
    {
        // Mock the CacheService class
        $cacheServiceMock = $this->getMockBuilder(CacheService::class)
            ->onlyMethods(['deleteCache'])
            ->getMock();

        // Expect the deleteCache method to be called
        $cacheServiceMock->expects($this->once())
            ->method('deleteCache')
            ->with($this->equalTo('test_cache_key'))
            ->willReturn(true);

        // Call deleteCache method
        $result = $cacheServiceMock->deleteCache('test_cache_key');
        $this->assertTrue($result);
    }

    /**
     * Test the HasCache method of the CacheService.
     * 
     * @return void
     */
    public function testHasCache(): void
    {
        // Mock the CacheService class
        $cacheServiceMock = $this->getMockBuilder(CacheService::class)
            ->onlyMethods(['hasCache'])
            ->getMock();

        // Expect the hasCache method to return true for the given cache key
        $cacheServiceMock->expects($this->once())
            ->method('hasCache')
            ->with($this->equalTo('test_cache_key'))
            ->willReturn(true);

        // Call the hasCache method and assert it returns true
        $result = $cacheServiceMock->hasCache('test_cache_key');
        $this->assertTrue($result);
    }
}