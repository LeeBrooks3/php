<?php

namespace LeeBrooks3\Tests\Examples\Models;

use LeeBrooks3\Models\Api\Model;

class ExampleApiModel extends Model
{
    /**
     * Defines that it has one example model.
     */
    protected function example()
    {
        return $this->one(ExampleModel::class);
    }

    /**
     * Defines that it has many example modes.
     */
    protected function examples()
    {
        return $this->many(ExampleModel::class);
    }
}
