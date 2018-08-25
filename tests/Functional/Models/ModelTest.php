<?php

namespace LeeBrooks3\Tests\Functional\Models;

use Carbon\Carbon;
use LeeBrooks3\Tests\Examples\Models\ExampleModel;
use LeeBrooks3\Tests\TestCase;

class ModelTest extends TestCase
{
    /**
     * The model instance.
     *
     * @var ExampleModel
     */
    private $model;

    /**
     * Creates the model instance.
     */
    public function setUp()
    {
        parent::setUp();

        $this->model = new ExampleModel();
    }

    /**
     * Provides attributes to test being filled and whether we expect them to be in the array of attributes.
     */
    public function providerFill()
    {
        $this->setUp();

        return [
            'guarded attribute' => [
                $key = 'id',
                $value = $this->faker->randomNumber(),
                $expected = false,
            ],
            'fillable attribute' => [
                $key = 'boolean',
                $value = $this->faker->numberBetween(0, 1),
                $expected = true,
            ],
        ];
    }

    /**
     * Tests that only fillable/non-guarded attributes are filled.
     *
     * @param string $key
     * @param $value
     * @param $expected
     *
     * @dataProvider providerFill
     */
    public function testFill(string $key, $value, $expected)
    {
        $this->model->fill([
            $key => $value,
        ]);

        if ($expected) {
            $this->assertArrayHasKey($key, $this->model->getAttributes());
        } else {
            $this->assertArrayNotHasKey($key, $this->model->getAttributes());
        }
    }

    /**
     * Provides different types of attributes to test that they are returned as expected.
     */
    public function providerAttributes()
    {
        $this->setUp();

        return [
            'regular attribute' => [
                $key = 'id',
                $value = $this->faker->randomNumber(),
                $expected = $value,
            ],
            'boolean' => [
                $key = 'boolean',
                $value = 1,
                $expected = true,
            ],
            'float' => [
                $key = 'float',
                $value = '1.0',
                $expected = 1.0,
            ],
            'integer' => [
                $key = 'integer',
                $value = '1',
                $expected = 1,
            ],
            'string' => [
                $key = 'string',
                $value = true,
                $expected = '1',
            ],
            'date' => [
                $key = 'date',
                $value = Carbon::now()->toDateString(),
                $expected = Carbon::parse($value),
            ],
            'datetime' => [
                $key = 'datetime',
                $value = Carbon::now()->toDateTimeString(),
                $expected = Carbon::parse($value),
            ],
            'timestamp' => [
                $key = 'timestamp',
                $value = Carbon::now()->getTimestamp(),
                $expected = $value,
            ],
            'uuid' => [
                $key = 'uuid',
                $value = $this->faker->uuid,
                $expected = $value,
            ],
        ];
    }

    /**
     * Tests the the expected values are returned after being cast or not.
     *
     * @param string $key
     * @param $value
     * @param $expected
     *
     * @dataProvider providerAttributes
     */
    public function testGetAttribute(string $key, $value, $expected)
    {
        $model = new ExampleModel([
            $key => $value,
        ]);

        $this->assertEquals($expected, $model->getAttribute($key));
    }

    /**
     * Tests that the expected value is returned.
     */
    public function testGetAttributes()
    {
        $key = 'id';
        $value = $this->faker->randomNumber();
        $attributes = [
            $key => $value,
        ];

        $model = new ExampleModel($attributes);

        $this->assertEquals($attributes, $model->getAttributes());
    }

    /**
     * Tests that only the attributes which are changed are returned.
     */
    public function testGetChangedAttributes()
    {
        $attributes = [
            'boolean' => $this->faker->numberBetween(0, 1),
            'integer' => $this->faker->randomNumber(),
            'relation' => [],
        ];

        $model = new ExampleModel($attributes);

        $model->fill([
            'integer' => $this->faker->randomNumber(),
        ]);

        $result = $model->getChangedAttributes();

        $this->assertArrayHasKey('integer', $result);
        $this->assertArrayNotHasKey('boolean', $result);
        $this->assertArrayNotHasKey('relation', $result);
    }

    /**
     * Tests that the primary key value can be returned.
     */
    public function testGetKey()
    {
        $id = $this->faker->randomNumber();
        $model = new ExampleModel(compact('id'));

        $result = $model->getKey();

        $this->assertEquals($id, $result);
    }

    /**
     * Tests that the primary key name can be returned.
     */
    public function testGetKeyName()
    {
        $result = $this->model->getKeyName();

        $this->assertEquals('id', $result);
    }

    /**
     * Tests that the original (unchanged) attribute is returned.
     */
    public function testGetOriginalAttribute()
    {
        $attributes = [
            'integer' => $this->faker->randomNumber(),
        ];

        $model = new ExampleModel($attributes);

        $model->fill([
            'integer' => $this->faker->randomNumber(),
        ]);

        $result = $model->getOriginalAttribute('integer');

        $this->assertEquals($attributes['integer'], $result);
    }

    /**
     * Tests that the original (unchanged) attributes are returned.
     */
    public function testGetOriginalAttributes()
    {
        $attributes = [
            'integer' => $this->faker->randomNumber(),
        ];

        $model = new ExampleModel($attributes);

        $model->fill([
            'integer' => $this->faker->randomNumber(),
        ]);

        $result = $model->getOriginalAttributes();

        $this->assertEquals($attributes, $result);
    }

    /**
     * Tests that the route key value can be returned.
     */
    public function testGetRouteKey()
    {
        $id = $this->faker->randomNumber();
        $model = new ExampleModel(compact('id'));

        $result = $model->getRouteKey();

        $this->assertEquals($id, $result);
    }

    /**
     * Tests that the route key name can be returned.
     */
    public function testGetRouteKeyName()
    {
        $result = $this->model->getRouteKeyName();

        $this->assertEquals('id', $result);
    }

    /**
     * Tests that the model has been changed.
     */
    public function testIsChanged()
    {
        $attributes = [
            'integer' => $this->faker->randomNumber(),
        ];

        $model = new ExampleModel($attributes);

        $model->fill([
            'integer' => $this->faker->randomNumber(),
        ]);

        $this->assertTrue($model->isChanged());
    }

    /**
     * Tests that the attribute has been changed.
     */
    public function testIsChangedAttribute()
    {
        $attributes = [
            'integer' => $this->faker->randomNumber(),
        ];

        $model = new ExampleModel($attributes);

        $model->fill([
            'integer' => $this->faker->randomNumber(),
        ]);

        $this->assertTrue($model->isChangedAttribute('integer'));
    }

    /**
     * Tests that the attribute is set.
     */
    public function testSetAttribute()
    {
        $value = $this->faker->randomNumber();

        $this->model->setAttribute('integer', $value);

        $this->assertEquals($value, $this->model->getAttribute('integer'));
    }

    /**
     * Tests that the attributes are set.
     */
    public function testSetAttributes()
    {
        $attributes = [
            'integer' => $this->faker->randomNumber(),
        ];

        $this->model->setAttributes($attributes);

        $this->assertEquals($attributes, $this->model->getAttributes());
    }

    /**
     * Tests that attributes can be retrieved by magic methods.
     */
    public function testMagicGet()
    {
        $model = new ExampleModel([
            'id' => $this->faker->randomNumber(),
        ]);

        $this->assertEquals($model->getAttribute('id'), $model->id);
    }

    /**
     * Tests that attributes can be set by magic methods.
     */
    public function testMagicSet()
    {
        $id = $this->faker->randomNumber();

        $this->model->id = $id;

        $this->assertEquals($id, $this->model->getAttribute('id'));
    }

    /**
     * Tests that attributes can be checked if set.
     */
    public function testIsset()
    {
        $model = new ExampleModel([
            'id' => $this->faker->randomNumber(),
        ]);

        $this->assertTrue(isset($model->id));
    }

    /**
     * Tests that attributes can be unset.
     */
    public function testUnset()
    {
        $model = new ExampleModel([
            'id' => $this->faker->randomNumber(),
        ]);

        unset($model->id);

        $this->assertArrayNotHasKey('id', $model->getAttributes());
    }
}
