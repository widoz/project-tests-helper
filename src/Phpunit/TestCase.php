<?php # -*- coding: utf-8 -*-

namespace ProjectTestsHelper\Phpunit;

use Brain\Monkey;
use Faker\Factory;
use Faker\Generator;
use Mockery;
use \PHPUnit\Framework\TestCase as PHPUnitTestCase;

/**
 * Class TestCase
 */
class TestCase extends PHPUnitTestCase
{
    use MockerTrait;

    /**
     * @var Generator
     */
    protected $faker;

    /**
     * SetUp
     */
    protected function setUp()
    {
        parent::setUp();
        Monkey\setUp();
        $this->setupFaker();
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

    /**
     * Create Faker instance
     *
     * @return void
     */
    protected function setupFaker()
    {
        if ($this->faker) {
            return;
        }

        $fakeFactory = new Factory();
        $this->faker = $fakeFactory->create();
    }
}
