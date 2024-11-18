<?php

declare(strict_types=1);

namespace Syde\UserListing\Container;

use Psr\Container\ContainerInterface;
use Syde\UserListing\Exceptions\ContainerException;
use ReflectionClass;

/**
 * Class Container
 * 
 * This will utilise the autowiring concept to do the depedency injection
 * so that we don't have to set it manually.
 * 
 * @package Syde\UserListing\Container
 */
class Container implements ContainerInterface
{

    private array $bindings = [];
    private array $instances = [];


    /**
     * Set the entry of the identifier and returns it
     * 
     * @param string $id The identifier of the id
     * @param callable $resolver The resolver of the id
     * @return void
     * @since 1.0.0
     * @access public
     */
    public function set(string $id, callable $resolver): void
    {
        $this->bindings[$id] = $resolver;
    }

    /**
     * Get the entry of the identifier and returns it
     * 
     * @param string $id The identifier of the id
     * @return mixed
     * @since 1.0.0
     * @access public
     */
    public function get(string $id): mixed
    {
        // Check if the id is already in the instances array.
        if (isset($this->instances[$id])) {
            return $this->instances[$id];
        }

        if (isset($this->bindings[$id])) {
            $this->instances[$id] = $this->bindings[$id];
            return $this->instances[$id];
        }

        if (class_exists($id)) {
            return $this->resolver($id);
        }

        throw new ContainerException("Class {$id} is not instantiable.");
    }

    /**
     * Check if the container can return an entry for the given identifier.
     * 
     * @param string $id The identifier of the entry to look for.
     * 
     * @return bool
     * @since 1.0.0
     * @access public
     */
    public function has(string $id): bool
    {
        return isset($this->bindings[$id]) || class_exists($id);
    }


    public function resolver(string $id): callable
    {
        try {
            // Check if the container is instanitiable.
            $reflection = new ReflectionClass($id);
            if (! $reflection->isInstantiable()) {
                throw new ContainerException("Class {$id} is not instantiable.");
            }

            // Check if the class has a constructor.
            $constructor = $reflection->getConstructor();
            if (!$constructor) {
                return new $id;
            }

            // Check for the dependencies.
            $depedencies = [];
            foreach ($constructor->getParameters() as $parameter) {
                $depedencies[] = $this->get($parameter->getType()->getName());
            }

            // return new $id($depedencies);
            return $reflection->newInstanceArgs($depedencies);
        } catch (\Exception $e) {
            throw new ContainerException("Error resolving class {$id}: " . $e->getMessage());
        }
    }
}
