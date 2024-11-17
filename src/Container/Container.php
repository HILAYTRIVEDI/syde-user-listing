<?php

declare(strict_types=1);

namespace Syde\SydeUserListing\Container;

use Psr\Container\ContainerInterface;


/**
 * Class Container
 * 
 * @package Syde\SydeUserListing\Container
 */
class Container implements ContainerInterface{

    /**
     * Get the entry of the identifier and returns it
     * 
     * @param string $id The identifier of the id
     * @return void
     * @since 1.0.0
     * @access public
     */
    public function get(string $id){}

    /**
     * Check if the container can return an entry for the given identifier.
     * 
     * @param string $id The identifier of the entry to look for.
     * 
     * @return bool
     * @since 1.0.0
     * @access public
     */
    public function has(string $id):bool{
        return  true;
    }

}