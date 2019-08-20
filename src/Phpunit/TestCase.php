<?php # -*- coding: utf-8 -*-

namespace ProjectTestsHelper\Phpunit;

use Brain\Monkey;
use Mockery;
use \PHPUnit\Framework\TestCase as PHPUnitTestCase;

/**
 * Class TestCase
 */
class TestCase extends PHPUnitTestCase
{
    use MockerTrait;

    /**
     * SetUp
     */
    protected function setUp()
    {
        parent::setUp();
        Monkey\setUp();
    }

    /**
     * TearDown
     */
    protected function tearDown()
    {
        Monkey\tearDown();
        Mockery::close();
        parent::tearDown();
    }
}
