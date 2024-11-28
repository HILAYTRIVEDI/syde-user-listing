<?php

declare(strict_types=1);

namespace Syde\UserListing\Factories;

use Syde\UserListing\Services\APIService;
use Syde\UserListing\Services\CacheService;
use Syde\UserListing\Services\SydeSanitizationService;
use Syde\UserListing\Services\SydeErrorService;

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

    /**
     * Create an instance of SydeSanitizationService.
     *
     * Provides a sanitization mechanism for user input.
     *
     * @since 1.0.0
     *
     * @return SydeSanitizationService The created sanitization service instance.
     */
    public static function createSanitizationService(): SydeSanitizationService
    {
        return new SydeSanitizationService();
    }


    /**
     * Create an instance of SydeErrorService.
     *
     * Provides a mechanism for handling errors.
     *
     * @since 1.0.0
     *
     * @return SydeErrorService The created error service instance.
     */
    public static function createErrorService(): SydeErrorService
    {
        return new SydeErrorService();
    }
}
