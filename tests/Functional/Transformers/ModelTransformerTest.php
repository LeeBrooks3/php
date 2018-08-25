<?php

namespace LeeBrooks3\Tests\Functional\Transformers;

use LeeBrooks3\Tests\Examples\Models\ExampleModel;
use LeeBrooks3\Tests\Examples\Transformers\ExampleModelTransformer;
use LeeBrooks3\Tests\TestCase;

class ModelTransformerTest extends TestCase
{
    /**
     * The transformer instance.
     *
     * @var ExampleModelTransformer
     */
    private $transformer;

    /**
     * Creates the transformer instance.
     */
    public function setUp()
    {
        parent::setUp();

        $this->transformer = new ExampleModelTransformer();
    }

    /**
     * Tests that an array of the model can be transformed to an array of arrays.
     */
    public function testTransform()
    {
        $id = $this->faker->randomNumber();
        $value = [
            new ExampleModel([
                'id' => $id,
            ]),
        ];

        $result = $this->transformer->transform($value);

        $expected = [
            [
                'id' => $id,
            ],
        ];

        $this->assertEquals($expected, $result);
    }
}
