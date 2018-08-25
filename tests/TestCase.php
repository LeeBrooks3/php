<?php

namespace LeeBrooks3\Tests;

use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class TestCase extends PHPUnitTestCase
{
    /**
     * A faker instance.
     *
     * @var Generator
     */
    protected $faker;

    /**
     * Sets up the tests.
     */
    public function setUp()
    {
        parent::setUp();

        $this->setUpFaker();
    }

    /**
     * Sets up the faker instance.
     */
    protected function setUpFaker()
    {
        $this->faker = Factory::create(Factory::DEFAULT_LOCALE);
    }
}
