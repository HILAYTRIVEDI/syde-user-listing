<?php

declare(strict_types=1);

namespace Syde\UserListing\Factories;

use Syde\UserListing\Services\APIService;
use Syde\UserListing\Services\CacheService;

/**
 * Factory class to create service instances.
 * 
 * @since 1.0.0
 * 
 * @package Syde\UserListing\Factories
 */
class ServiceFactory
{
    /**
     * Create an instance of APIService.
     * 
     * Creates a concrete implementation of APIServiceInterface.
     * 
     * @since 1.0.0
     * 
     * @return APIServiceInterface The created API service instance.
     */
    public static function createApiService(): APIService
    {
        return new APIService();
    }

    /**
     * Create an instance of CacheService.
     * 
     * Provides a caching mechanism for API responses.
     * 
     * @since 1.0.0
     * 
     * @return CacheService The created cache service instance.
     */
    public static function createCacheService(): CacheService
    {
        return new CacheService();
    }
}
