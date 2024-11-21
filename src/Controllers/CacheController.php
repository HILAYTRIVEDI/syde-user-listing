<?php

declare(strict_types=1);

namespace Syde\UserListing\Controllers;

use Syde\UserListing\Factories\ServiceFactory;

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
    public function __construct(private ServiceFactory $serviceFactory)
    {
    }

    /**
     * Get the user cache.
     *
     * Fetches cached user data from the cache service.
     *
     * @param string $cache_name The name of the cache (e.g., 'user_list').
     * @param string $endpoint The API endpoint associated with the cache.
     *
     * @return array|bool The cached user data, or false if not found.
     *
     * @since 1.0.0
     * @access public
     */
    public function getUserCache(string $cache_name, string $endpoint): array|bool
    {
        // Fetch cache using the cache service
        $cache = $this->serviceFactory->createCacheService()->getCache($cache_name, $endpoint);
        return $cache;
    }

    /**
     * Set the user cache.
     *
     * Sets the cached user data in the cache service.
     *
     * @param string $cache_name The name of the cache (e.g., 'user_list').
     * @param array $user_info The user data to be cached.
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function setUserCache(string $cache_name, array $user_info): void
    {
        // Store user data in the cache
        $this->serviceFactory->createCacheService()->setCache($cache_name, $user_info);
    }
}
