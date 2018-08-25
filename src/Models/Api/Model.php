<?php

namespace LeeBrooks3\Models\Api;

use LeeBrooks3\Models\Model as BaseModel;
use LeeBrooks3\Models\ModelInterface;

abstract class Model extends BaseModel
{
    /**
     * The models relations.
     *
     * @var array
     */
    private $relations = [];

    /**
     * {@inheritdoc}
     * This also loads any relations and returns them as the attribute values.
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
     * Defines a relationship to a single item.
     *
     * @param string $class
     * @return string
     */
    protected function one(string $class)
    {
        return $class;
    }

    /**
     * Defines a relationship to multiple items.
     *
     * @param string $class
     * @return string[]
     */
    protected function many(string $class)
    {
        return [$class];
    }

    /**
     * Returns the relation.
     *
     * @param string $key
     * @return ModelInterface|ModelInterface[]
     */
    private function getRelation(string $key)
    {
        return $this->relations[$key];
    }

    /**
     * Returns a relations value.
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
     * Returns whether the given attribute is a relation.
     *
     * @param string $key
     * @return bool
     */
    private function isRelation(string $key) : bool
    {
        return method_exists($this, $key);
    }

    /**
     * Returns whether the given relation is loaded.
     *
     * @param string $key
     * @return bool
     */
    private function isRelationLoaded(string $key) : bool
    {
        return array_key_exists($key, $this->relations);
    }

    /**
     * Loads a relation value from it defining method.
     * This takes the raw data from the attribute value and turns it into the model or array of models as appropriate.
     * This is then set in the relations array so that new instances aren't created every time the relation is accessed.
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
