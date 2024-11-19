<?php


declare(strict_types=1);

namespace Syde\UserListing\Controllers;

use Syde\UserListing\Factories\ServiceFactory;

/**
 * Cache controller class for caching the user data.
 * 
 * @since 1.0.0
 * 
 * @package Syde\UserListing\Controllers
 */
class CacheController{

    /**
     * CacheController constructor.
     * 
     * @since 1.0.0
     * 
     * @access public
     * 
     * @param ServiceFactory $serviceFactory
     * @return void
     * 
     */
    public function __construct(private ServiceFactory $serviceFactory){}


    /**
     * Get the user cache.
     * 
     * @since 1.0.0
     * 
     * @access public
     * 
     * @param string $cache_name
     * @param string $endpoint
     * @return array
     * 
     */
    public function getUserCache( string $cache_name, string $endpoint ): array{
        $cache = $this->serviceFactory->createCacheService()->getCache( $cache_name, $endpoint );
        return $cache;
    }

    /**
     * Set the user cache.
     * 
     * @since 1.0.0
     * 
     * @access public
     * 
     * @param string $cache_name
     * @param array $user_info
     * @return void
     *  
     */
    public function setUserCache( string $cache_name, array $user_info ): void{
        $this->serviceFactory->createCacheService()->setCache( $cache_name, $user_info );
    }
}