<?php

/**
 * This file contains the APIServiceInterface interface for the Syde User Listing plugin
 * that defines the contract for an API service.
 *
 * @package Syde\UserListing\Interfaces
 *
 * @since 1.0.0
 */

declare(strict_types=1);

namespace Syde\UserListing\Interfaces;

/**
 * Interface APIServiceInterface
 *
 * Defines the contract for an API service.
 *
 * @package Syde\UserListing\Interfaces
 */
interface APIServiceInterface
{
    /**
     * Fetch data from an API endpoint.
     *
     * @param string $url The API endpoint to fetch data from.
     * @param array $headers Optional headers to include in the request.
     * @return array The response data as an associative array.
     */
    public function fetch(string $url, array $headers = []): array|\WP_Error;
}
