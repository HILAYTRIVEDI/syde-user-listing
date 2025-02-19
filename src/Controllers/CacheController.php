<?php

/**
 * This file contains the CacheController class for the Syde User Listing plugin
 * that handles caching of user data.
 *
 * @package Syde\UserListing\Controllers
 *
 * @since 1.0.0
 */

declare(strict_types=1);

namespace Syde\UserListing\Controllers;

use Syde\UserListing\Factories\ServiceFactory;
use Syde\UserListing\Services\SydeErrorService;

/**
 * Cache controller class for caching the data and storing it in the options table.
 *
 * @since 1.0.0
 *
 * @package Syde\UserListing\Controllers
 */
class CacheController
{
    /**
     * CacheController constructor.
     *
     * @param ServiceFactory $serviceFactory The service factory for creating the cache service.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function __construct(private ServiceFactory $serviceFactory, private SydeErrorService $errorService)
    {
    }

    /**
     * Get the user cache.
     *
     * Fetches cached user data from the cache service.
     *
     * @param string $cacheName The name of the cache (e.g., 'user_list').
     * @param string $endpoint The API endpoint associated with the cache.
     *
     * @return array|bool The cached user data, or false if not found.
     *
     * @since 1.0.0
     * @access public
     */
    public function userCache(string $cacheName): array|bool
    {
        // Fetch cache using the cache service
        $cache = $this->serviceFactory->createCacheService()->returnCache($cacheName);
        return $cache;
    }

    /**
     * Set the user cache.
     *
     * Sets the cached user data in the cache service.
     *
     * @param string $cacheName The name of the cache (e.g., 'user_list').
     * @param array $userInfo The user data to be cached.
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function cacheDataWithExpiration(string $cacheName, array $userInfo): void
    {
        // Store user data in the cache
        try {
            $this->serviceFactory->createCacheService()->cacheDataWithExpiration($cacheName, $userInfo);
        } catch (\Exception $error) {
            $this->errorService->handleError(
                'cache_storage_failed',
                'An error occurred while storing the cache.'
            );
            return;
        }
    }

    /**
     * Delete the cache.
     *
     * Deletes the cache with the given name.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @param string $cacheName The name of the cache to delete.
     *
     * @return void
     *
     */
    public function deleteCache(string $cacheName): void
    {
        try {
            $this->serviceFactory->createCacheService()->deleteCache($cacheName);
        } catch (\Exception $error) {
            // Handle any exceptions that may occur during cache deletion.
            $this->errorService->handleError(
                'cache_deletion_failed',
                'An error occurred while deleting the cache.'
            );
            return;
        }
    }
}
