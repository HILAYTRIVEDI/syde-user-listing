<?php

declare(strict_types=1);

namespace Syde\UserListing\Services;

use Syde\UserListing\Services\APIService;

/**
 * CacheService class.
 * 
 * @since 1.0.0
 * 
 * @package Syde\UserListing\Services
 */
class CacheService
{
    /**
     * Get the cache.
     * 
     * @since 1.0.0
     * 
     * @access public
     * 
     * @param string $cache_key
     * @return array
     */
    public function getCache(string $cache_key): array
    {

        $data = get_transient($cache_key);
        return $data;
    }

    /**
     * Set the cache.
     * 
     * @since 1.0.0
     * 
     * @access public
     * 
     * @param string $cache_name
     * @param array $user_info
     * @return void
     */
    public function setCache( string $cache_name, array $user_info ): void{
        set_transient($cache_name, $user_info, 12 * HOUR_IN_SECONDS);
    }


}
