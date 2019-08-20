<?php # -*- coding: utf-8 -*-

/*
 * This file is part of the Request Auth package.
 *
 * (c) Guido Scialfa <dev@guidoscialfa.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ProjectTestsHelper;

use ReflectionMethod;
use ReflectionProperty;

/**
 * Class Proxy
 *
 * Class extracted from ptrofimov/xpmock
 * @link https://github.com/ptrofimov/xpmock
 * @see https://github.com/ptrofimov/xpmock/blob/master/src/Xpmock/Reflection.php
 */
class Proxy
{
    /**
     * @var string
     */
    private $class;

    /**
     * @var mixed
     */
    private $object;

    /**
     * Proxy constructor
     * @param $classOrObject
     */
    public function __construct($classOrObject)
    {
        list($this->class, $this->object) = is_object($classOrObject)
            ? [get_class($classOrObject), $classOrObject]
            : [(string)$classOrObject, null];
    }

    /**
     * @param $key
     * @return mixed
     */
    public function __get(string $key)
    {
        $property = new ReflectionProperty($this->class, $key);
        if (!$property->isPublic()) {
            $property->setAccessible(true);
        }

        return $property->isStatic()
            ? $property->getValue()
            : $property->getValue($this->object);
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function __set(string $key, $value): self
    {
        $property = new ReflectionProperty($this->class, $key);
        if (!$property->isPublic()) {
            $property->setAccessible(true);
        }
        $property->isStatic()
            ? $property->setValue($value)
            : $property->setValue($this->object, $value);

        return $this;
    }

    /**
     * @param $methodName
     * @param array $args
     * @return mixed
     */
    public function __call($methodName, array $args)
    {
        $method = new ReflectionMethod($this->class, $methodName);

        if (!$method->isPublic()) {
            $method->setAccessible(true);
        }

        return $method->isStatic()
            ? $method->invokeArgs(null, $args)
            : $method->invokeArgs($this->object, $args);
    }
}
