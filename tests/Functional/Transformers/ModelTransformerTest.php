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
    protected $transformer;

    /**
     * Creates the transformer instance.
     */
    public function setUp()
    {
        parent::setUp();

        $this->transformer = new ExampleModelTransformer();
    }

    /**
     * Tests that the model can be transformed to a namespaced array.
     */
    public function testTransformItem()
    {
        $id = $this->faker->randomNumber();
        $value = new ExampleModel([
            'id' => $id,
        ]);

        $result = $this->transformer->transform($value);

        $expected = [
            'id' => $id,
        ];

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests that an array of the model can be transformed to a namespaced array of arrays.
     */
    public function testTransformCollection()
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
