<?php # -*- coding: utf-8 -*-
// phpcs:disable
namespace ProjectTestsHelper\Phpunit;

use Brain\Monkey;
use \PHPUnit\Framework\TestCase as PHPUnitFrameworkTestCase;

/**
 * Class TestCase
 */
class TestCase extends PHPUnitFrameworkTestCase
{
    /**
     * Constructs a test case with the given name.
     *
     * @param string $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
    }

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
        \Mockery::close();
        parent::tearDown();
    }
}
