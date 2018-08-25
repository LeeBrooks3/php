<?php

namespace LeeBrooks3\Models;

interface ModelInterface
{
    /**
     * Fill the model with an array of attributes.
     *
     * @param array $attributes
     * @return $this
     */
    public function fill(array $attributes);

    /**
     * Get an attribute from the model.
     *
     * @param string $key
     * @return mixed
     */
    public function getAttribute(string $key);

    /**
     * Get all of the current attributes on the model.
     *
     * @return array
     */
    public function getAttributes() : array;

    /**
     * Get the attributes that have been changed.
     *
     * @return array
     */
    public function getChangedAttributes() : array;

    /**
     * Get the value of the model's primary key.
     *
     * @return mixed
     */
    public function getKey();

    /**
     * Get the primary key for the model.
     *
     * @return string
     */
    public function getKeyName() : string;

    /**
     * Get the model's original attribute value.
     *
     * @param string $key
     * @return mixed
     */
    public function getOriginalAttribute(string $key);

    /**
     * Get the model's original attribute values.
     *
     * @return array
     */
    public function getOriginalAttributes() : array;

    /**
     * Get the value of the model's route key.
     *
     * @return mixed
     */
    public function getRouteKey();

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName() : string;

    /**
     * Determine if the model has been modified.
     *
     * @return bool
     */
    public function isChanged() : bool;

    /**
     * Determine if the given attribute has been modified.
     *
     * @param string $key
     * @return bool
     */
    public function isChangedAttribute(string $key) : bool;

    /**
     * Set a given attribute on the model.
     *
     * @param string $key
     * @param mixed $value
     * @param bool $isOriginal
     * @return $this
     */
    public function setAttribute(string $key, $value, bool $isOriginal = false);

    /**
     * Set the array of model attributes. No checking is done.
     *
     * @param array $attributes
     * @param bool $isOriginal
     * @return $this
     */
    public function setAttributes(array $attributes, bool $isOriginal = false);
}
