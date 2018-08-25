<?php

namespace LeeBrooks3\Repositories;

use LeeBrooks3\Models\ModelInterface;

interface ModelRepositoryInterface
{
    /**
     * Display a listing of the resource.
     *
     * @param array $params
     * @return ModelInterface[]
     */
    public function get(array $params = []) : array;

    /**
     * Creates a new resource.
     *
     * @param array $attributes
     * @return ModelInterface
     */
    public function create(array $attributes = []) : ModelInterface;

    /**
     * Display the specified resource.
     *
     * @param int|string $id
     * @param array $params
     * @return ModelInterface
     */
    public function find($id, array $params = []) : ModelInterface;

    /**
     * Update the specified resource.
     *
     * @param ModelInterface $model
     * @param array $attributes
     * @return ModelInterface
     */
    public function update(ModelInterface $model, array $attributes = []) : ModelInterface;

    /**
     * Remove the specified resource.
     *
     * @param ModelInterface $model
     * @return void
     */
    public function delete(ModelInterface $model) : void;
}
