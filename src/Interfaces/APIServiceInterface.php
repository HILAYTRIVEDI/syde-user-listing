<?php

declare(strict_types=1);

namespace Syde\UserListing\Interfaces;

/**
 * Interface APIServiceInterface
 * @package Syde\UserListing\Interfaces
 */
interface APIServiceInterface
{
    public function fetch( string $url, array $headers = [] );
}