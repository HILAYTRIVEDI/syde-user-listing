<?php

declare(strict_types=1);

namespace Syde\UserListing\Container;

use Psr\Container\ContainerInterface;
use Syde\UserListing\Exceptions\ContainerException;
use ReflectionClass;
use ReflectionParameter;

/**
 * Class Container
 *
 * Implements autowiring for dependency injection, eliminating manual bindings.
 *
 * @package Syde\UserListing\Container
 */
class Container implements ContainerInterface
{
    /**
     * The bindings of the container.
     *
     * @var array<string, callable>
     * 
     * @access private
     */
    private array $bindings = [];

    /**
     * The instances of the container.
     *
     * @var array<string, object>
     * 
     * @access private
     */
    private array $instances = [];

    /**
     * Set a binding for a given identifier.
     *
     * @param string $id The identifier of the binding.
     * @param callable $resolver The resolver function.
     * @return void
     * @access public
     */
    public function set(string $id, callable $resolver): void
    {
        $this->bindings[$id] = $resolver;
    }

    /**
     * Get an entry from the container by its identifier.
     *
     * @param string $id The identifier of the entry to fetch.
     * @return object The resolved entry.
     * @throws ContainerException If the class cannot be resolved.
     * 
     * @access public
     */
    public function get(string $id): object
    {
        // Return an existing instance if available
        if (isset($this->instances[$id])) {
            return $this->instances[$id];
        }

        // Resolve a binding if it exists
        if (isset($this->bindings[$id])) {
            return $this->instances[$id] = ($this->bindings[$id])($this);
        }

        // Attempt to resolve the class dynamically
        if (class_exists($id)) {
            return $this->instances[$id] = $this->resolve($id);
        }

        throw new ContainerException("Class {$id} cannot be resolved or is not registered.");
    }

    /**
     * Check if the container has an entry for the given identifier.
     *
     * @param string $id The identifier to check.
     * @return bool True if the container can resolve the identifier, false otherwise.
     * 
     * @access public
     */
    public function has(string $id): bool
    {
        return isset($this->bindings[$id]) || class_exists($id);
    }

    /**
     * Resolve a class dynamically by inspecting its constructor and dependencies.
     *
     * @param string $id The class name to resolve.
     * @return object The resolved class instance.
     * @throws ContainerException If the class or its dependencies cannot be resolved.
     * 
     * @access private
     */
    private function resolve(string $id): object
    {
        try {
            $reflectionClass = new ReflectionClass($id);

            if (!$reflectionClass->isInstantiable()) {
                throw new ContainerException("Class {$id} is not instantiable.");
            }

            $constructor = $reflectionClass->getConstructor();

            // If no constructor, instantiate the class without dependencies
            if (!$constructor) {
                return new $id;
            }

            // Resolve constructor parameters
            $dependencies = array_map(fn(ReflectionParameter $parameter) => $this->resolveParameter($parameter, $id), $constructor->getParameters());

            return $reflectionClass->newInstanceArgs($dependencies);
        } catch (\Exception $e) {
            throw new ContainerException("Error resolving class {$id}: " . $e->getMessage());
        }
    }

    /**
     * Resolve a constructor parameter.
     *
     * @param ReflectionParameter $parameter The parameter to resolve.
     * @param string $className The name of the class being resolved (for error messages).
     * @return mixed The resolved parameter.
     * @throws ContainerException If the parameter cannot be resolved.
     * 
     * @access private
     */
    private function resolveParameter(ReflectionParameter $parameter, string $className): mixed
    {
        $type = $parameter->getType();

        if (!$type) {
            throw new ContainerException("Cannot resolve parameter '{$parameter->getName()}' for class {$className}: No type hint provided.");
        }

        if ($type instanceof \ReflectionUnionType) {
            throw new ContainerException("Cannot resolve parameter '{$parameter->getName()}' for class {$className}: Union types are not supported.");
        }

        if ($type instanceof \ReflectionNamedType && !$type->isBuiltin()) {
            return $this->get($type->getName());
        }

        throw new ContainerException("Cannot resolve parameter '{$parameter->getName()}' for class {$className}: Unsupported type.");
    }
}
