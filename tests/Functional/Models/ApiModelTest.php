<?php

namespace LeeBrooks3\Tests\Functional\Models;

use LeeBrooks3\Tests\Examples\Models\ExampleApiModel;
use LeeBrooks3\Tests\Examples\Models\ExampleModel;
use LeeBrooks3\Tests\TestCase;

class ApiModelTest extends TestCase
{
    /**
     * Tests that a relationship to a single item can be loaded and returned.
     */
    public function testExampleRelationship()
    {
        $model = new ExampleApiModel([
            'example' => [
                'id' => $this->faker->randomNumber(),
            ],
        ]);

        $this->assertInstanceOf(ExampleModel::class, $model->getAttribute('example'));
    }

    /**
     * Tests that a relationship to multiple items can be loaded and returned.
     */
    public function testExamplesRelationship()
    {
        $model = new ExampleApiModel([
            'examples' => [
                [
                    'id' => $this->faker->randomNumber(),
                ],
            ],
        ]);

        $this->assertInstanceOf(ExampleModel::class, $model->getAttribute('examples')[0]);
    }

    /**
     * Tests that an attribute can still be returned.
     */
    public function testGetAttribute()
    {
        $id = $this->faker->randomNumber();
        $model = new ExampleApiModel([
            'id' => $id,
        ]);

        $this->assertEquals($id, $model->getAttribute('id'));
    }
}
