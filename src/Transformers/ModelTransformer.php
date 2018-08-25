<?php

namespace LeeBrooks3\Transformers;

use LeeBrooks3\Models\ModelInterface;

abstract class ModelTransformer implements TransformerInterface
{
    /**
     * Transforms the given model.
     *
     * @param ModelInterface|ModelInterface[] $value
     * @return array
     */
    public function transform($value)
    {
        if ($value instanceof ModelInterface) {
            return $this->transformItem($value);
        }

        return $this->transformCollection($value);
    }

    /**
     * Transforms a single item.
     *
     * @param ModelInterface $model
     * @return array
     */
    protected function transformItem(ModelInterface $model) : array
    {
        return $model->getAttributes();
    }

    /**
     * Transforms a collection.
     *
     * @param ModelInterface[] $models
     * @return array
     */
    protected function transformCollection(array $models) : array
    {
        return array_map(function (ModelInterface $model) {
            return $this->transform($model);
        }, $models);
    }
}
