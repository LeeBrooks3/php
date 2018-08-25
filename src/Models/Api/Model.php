<?php

namespace LeeBrooks3\Models\Api;

use LeeBrooks3\Models\Model as BaseModel;
use LeeBrooks3\Models\ModelInterface;

abstract class Model extends BaseModel
{
    /**
     * Holds the relationship values.
     *
     * @var array
     */
    private $relations = [];

    /**
     * {@inheritdoc}
     * This also loads any relations and adds them as attributes.
     *
     * @param string $key
     * @return mixed
     */
    public function getAttribute(string $key)
    {
        if ($this->isRelation($key)) {
            return $this->getRelationValue($key);
        }

        return parent::getAttribute($key);
    }

    /**
     * Defines a relationship.
     *
     * @param string $class
     * @return string
     */
    protected function one(string $class)
    {
        return $class;
    }

    /**
     * Defines a relationship.
     *
     * @param string $class
     * @return string[]
     */
    protected function many(string $class)
    {
        return [$class];
    }

    /**
     * Gets the loaded relation.
     *
     * @param string $key
     * @return ModelInterface|ModelInterface[]
     */
    private function getRelation(string $key)
    {
        return $this->relations[$key];
    }

    /**
     * Get a relationships value.
     *
     * @param string $key
     * @return ModelInterface|ModelInterface[]
     */
    private function getRelationValue($key)
    {
        if (!$this->isRelationLoaded($key)) {
            $this->loadRelation($key);
        }

        return $this->getRelation($key);
    }

    /**
     * Returns whether the attribute is a relation.
     *
     * @param string $key
     * @return bool
     */
    private function isRelation(string $key) : bool
    {
        return method_exists($this, $key);
    }

    /**
     * Determine if the given relation is loaded.
     *
     * @param string $key
     * @return bool
     */
    private function isRelationLoaded(string $key) : bool
    {
        return array_key_exists($key, $this->relations);
    }

    /**
     * Loads a relationship value from it defining method.
     *
     * @param string $key
     * @return void
     */
    private function loadRelation(string $key)
    {
        $relation = $this->$key();

        $isMany = is_array($relation);

        $class = $isMany ? reset($relation) : $relation;

        $value = $this->attributes[$key];

        if ($isMany) {
            $this->setRelation($key, array_map(
                function (array $attributes) use ($class) {
                    return new $class($attributes);
                },
                $value
            ));
        } else {
            $attributes = $value;

            $this->setRelation($key, new $class($attributes));
        }
    }

    /**
     * Sets the relation.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    private function setRelation(string $key, $value) : void
    {
        $this->relations[$key] = $value;
    }
}
