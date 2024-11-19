<?php

declare(strict_types=1);

namespace Syde\UserListing\Factories;

use Syde\UserListing\Services\ApiService;
use Syde\UserListing\Services\CacheService;


/**
 * ServiceFactory class.
 * 
 * @since 1.0.0
 * 
 * @package Syde\UserListing\Factories
 */
class ServiceFactory
{
    /**
     * Create an instance of ApiService.
     * 
     * @since 1.0.0
     * 
     * @return ApiService
     */
    public static function createApiService(): ApiService
    {
        return new ApiService();
    }

    /**
     * Create an instance of CacheService.
     * 
     * @since 1.0.0
     * 
     * @return CacheService
     */
    public static function createCacheService(): CacheService
    {
        return new CacheService();
    }
}