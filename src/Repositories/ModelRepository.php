<?php

namespace LeeBrooks3\Repositories;

use LeeBrooks3\Models\ModelInterface;

abstract class ModelRepository implements ModelRepositoryInterface
{
    /**
     * The model class name.
     *
     * @var string
     */
    protected $model;

    /**
     * Returns a new instance of the model.
     *
     * @param array $attributes
     * @return ModelInterface
     */
    protected function model(array $attributes = []) : ModelInterface
    {
        $modelClass = $this->model;

        return new $modelClass($attributes);
    }
}
