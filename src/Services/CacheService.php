<?php

declare(strict_types=1);

namespace Syde\UserListing\Services;

/**
 * CacheService class.
 *
 * A service to manage caching using WordPress transients.
 * Provides methods to get, set, and clear cached data efficiently.
 *
 * @since 1.0.0
 * @package Syde\UserListing\Services
 */
class CacheService
{
    /**
     * Retrieve data from the cache.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @param string $cacheKey The key under which the data is stored in the cache.
     * @return mixed Cached data if it exists and is valid, or false if not.
     */
    public function returnCache(string $cacheKey): mixed
    {
        return get_transient($cacheKey);
    }

    /**
     * Store data in the cache.
     *
     * Stores the given data in a transient for a specified duration (default: 12 hours).
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @param string $cacheKey The key under which the data should be stored.
     * @param mixed $data The data to cache (e.g., array, object, string).
     * @param int $expiration The expiration time for the cache in seconds (default: 12 hours).
     * @return void
     */
    public function cacheDataWithExpiration(string $cacheKey, mixed $data, int $expiration = 12 * HOUR_IN_SECONDS): void
    {
        set_transient($cacheKey, $data, $expiration);
    }

    /**
     * Delete data from the cache.
     *
     * Removes a specific key from the cache.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @param string $cacheKey The key of the cache entry to delete.
     * @return bool True if the cache entry was successfully deleted, false otherwise.
     */
    public function deleteCache(string $cacheKey): bool
    {
        return delete_transient($cacheKey);
    }

    /**
     * Check if a cache entry exists.
     *
     * A utility method to check if valid cached data exists for the given key.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @param string $cacheKey The key of the cache entry to check.
     * @return bool True if valid cache data exists, false otherwise.
     */
    public function hasCache(string $cacheKey): bool
    {
        return $this->returnCache($cacheKey) !== false;
    }
}
