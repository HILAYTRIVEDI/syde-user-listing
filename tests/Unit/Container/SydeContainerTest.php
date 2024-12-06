<?php

declare(strict_types=1);

namespace Syde\UserListing\Tests\Unit\Container;

use PHPUnit\Framework\TestCase;
use Syde\UserListing\Container\SydeContainer;

class SydeContainerTest extends TestCase
{
    public function testSetAndGetBinding()
    {
        $container = new SydeContainer();
        $container->set('test', fn() => new \stdClass());

        $this->assertInstanceOf(\stdClass::class, $container->get('test'));
    }

    public function testGetExistingInstance()
    {
        $container = new SydeContainer();
        $instance = new \stdClass();
        $container->set('test', fn() => $instance);

        $this->assertSame($instance, $container->get('test'));
    }

    public function testHasBinding()
    {
        $container = new SydeContainer();
        $container->set('test', fn() => new \stdClass());

        $this->assertTrue($container->has('test'));
        $this->assertFalse($container->has('nonexistent'));
    }

    public function testResolveClassWithoutConstructor()
    {
        $container = new SydeContainer();
        $instance = $container->get(\stdClass::class);

        $this->assertInstanceOf(\stdClass::class, $instance);
    }

    public function testResolveClassWithConstructor()
    {
        $container = new SydeContainer();
        $container->set(Dependency::class, fn() => new Dependency());

        $instance = $container->get(ClassWithDependency::class);

        $this->assertInstanceOf(ClassWithDependency::class, $instance);
        $this->assertInstanceOf(Dependency::class, $instance->dependency);
    }
}

class Dependency
{
}

class ClassWithDependency
{
    public Dependency $dependency;

    public function __construct(Dependency $dependency)
    {
        $this->dependency = $dependency;
    }
}