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
 * A simple Dependency Injection (DI) container that implements autowiring. 
 * It resolves dependencies automatically by inspecting class constructors and 
 * supports manual bindings of classes to resolvers.
 * 
 * This implementation is based on the PSR-11 container interface.
 *
 * @package Syde\UserListing\Container
 */
class Container implements ContainerInterface
{
    /**
     * The bindings of the container. 
     * Manual bindings can be set using the `set` method.
     *
     * @var array<string, callable>
     */
    private array $bindings = [];

    /**
     * The instances of the container. Stores already resolved instances to avoid redundant resolution.
     * 
     * @var array<string, object>
     */
    private array $instances = [];

    /**
     * Cache of ReflectionClass instances to avoid re-reflecting the same class.
     * This improves performance when resolving classes multiple times.
     *
     * @var array<string, ReflectionClass>
     */
    private array $reflectionCache = [];

    /**
     * Set a binding for a given identifier. 
     * Use this method to manually define how a class or interface should be resolved.
     *
     * @param string $id The identifier of the binding (e.g., class name or interface).
     * @param callable $resolver The resolver function or closure that returns the instance.
     * @return void
     */
    public function set(string $id, callable $resolver): void
    {
        $this->bindings[$id] = $resolver;
    }

    /**
     * Retrieve an entry from the container by its identifier.
     * It will attempt to resolve the class dynamically, using the `resolve` method,
     * or return an existing instance if it has already been created.
     *
     * @param string $id The identifier of the entry (e.g., class name or interface).
     * @return object The resolved instance of the class.
     * @throws ContainerException If the class cannot be resolved or is not registered.
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

        // Attempt to resolve the class dynamically if not already bound
        if (class_exists($id)) {
            return $this->instances[$id] = $this->resolve($id);
        }

        // If no binding or class is found, throw an exception
        throw new ContainerException("Class {$id} cannot be resolved or is not registered.");
    }

    /**
     * Check if the container can resolve an entry for the given identifier.
     * This method checks if the class is bound or if it can be resolved dynamically.
     *
     * @param string $id The identifier to check.
     * @return bool True if the container can resolve the identifier, false otherwise.
     */
    public function has(string $id): bool
    {
        return isset($this->bindings[$id]) || class_exists($id);
    }

    /**
     * Resolve a class dynamically by inspecting its constructor and resolving dependencies.
     * This method uses reflection to analyze the constructor parameters and inject any dependencies.
     *
     * @param string $id The class name to resolve.
     * @return object The resolved class instance.
     * @throws ContainerException If the class or its dependencies cannot be resolved.
     */
    private function resolve(string $id): object
    {
        try {
            // Use cached ReflectionClass instance if already created
            $reflectionClass = $this->reflectionCache[$id] ??= new ReflectionClass($id);

            // Ensure the class is instantiable
            if (!$reflectionClass->isInstantiable()) {
                throw new ContainerException("Class {$id} is not instantiable.");
            }

            $constructor = $reflectionClass->getConstructor();

            // If the class has no constructor, instantiate it directly
            if (!$constructor) {
                return new $id;
            }

            // Resolve constructor parameters and inject dependencies
            $dependencies = array_map(
                fn(ReflectionParameter $parameter) => $this->resolveParameter($parameter, $id),
                $constructor->getParameters()
            );

            return $reflectionClass->newInstanceArgs($dependencies);
        } catch (\Exception $e) {
            throw new ContainerException("Error resolving class {$id}: " . $e->getMessage());
        }
    }

    /**
     * Resolve a constructor parameter.
     * This method resolves the type of each parameter and attempts to inject it from the container
     * or uses its default value if available.
     *
     * @param ReflectionParameter $parameter The parameter to resolve.
     * @param string $className The name of the class being resolved (for error messages).
     * @return mixed The resolved parameter value.
     * @throws ContainerException If the parameter cannot be resolved.
     */
    private function resolveParameter(ReflectionParameter $parameter, string $className): mixed
    {
        $type = $parameter->getType();

        if (!$type) {
            // No type hint provided, resolve as null or default value
            return $parameter->isDefaultValueAvailable() ? $parameter->getDefaultValue() : null;
        }

        // Handle union types or non-class types (e.g., int, string)
        if ($type instanceof \ReflectionUnionType) {
            throw new ContainerException("Union types are not supported for parameter '{$parameter->getName()}' in class {$className}.");
        }

        if ($type instanceof \ReflectionNamedType && !$type->isBuiltin()) {
            // If the type is a class, resolve it from the container
            return $this->get($type->getName());
        }

        throw new ContainerException("Unsupported type for parameter '{$parameter->getName()}' in class {$className}.");
    }
}
