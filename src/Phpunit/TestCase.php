<?php # -*- coding: utf-8 -*-

namespace ProjectTestsHelper\Phpunit;

use Brain\Monkey;
use Mockery;
use PHPUnit\Framework\MockObject\MockBuilder;
use \PHPUnit\Framework\TestCase as PHPUnitFrameworkTestCase;
use ReflectionException;
use ReflectionMethod;

/**
 * Class TestCase
 */
class TestCase extends PHPUnitFrameworkTestCase
{
    /**
     * SetUp
     */
    protected function setUp(): void
    {
        parent::setUp();
        Monkey\setUp();
    }

    /**
     * TearDown
     */
    protected function tearDown(): void
    {
        Monkey\tearDown();
        Mockery::close();
        parent::tearDown();
    }

    /**
     * Build the Testee Mock Object
     *
     * Basic configuration available for all of the testee objects, call `getMock` to get the mock.
     *
     * @param string $className
     * @param array $constructorArguments
     * @param array $methods
     * @return MockBuilder
     */
    protected function buildTesteeMock(
        string $className,
        array $constructorArguments,
        array $methods
    ): MockBuilder {

        $testee = $this->getMockBuilder($className);

        $constructorArguments
            ? $testee->setConstructorArgs($constructorArguments)
            : $testee->disableOriginalConstructor();

        if ($methods) {
            $testee->setMethods($methods);
        }

        return $testee;
    }

    /**
     * Retrieve a Testee Mock to Test Protected Methods
     *
     * return MockBuilder
     * @param string $className
     * @param array $constructorArguments
     * @param string $method
     * @param array $methods
     * @return array
     * @throws ReflectionException
     */
    protected function buildTesteeMethodMock(
        string $className,
        array $constructorArguments,
        string $method,
        array $methods
    ): array {

        $testee = $this->buildTesteeMock(
            $className,
            $constructorArguments,
            $methods,
            ''
        )->getMock();
        $reflectionMethod = new ReflectionMethod($className, $method);
        $reflectionMethod->setAccessible(true);
        return [
            $testee,
            $reflectionMethod,
        ];
    }
}
