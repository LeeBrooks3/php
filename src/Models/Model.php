<?php

namespace LeeBrooks3\Models;

use LeeBrooks3\Utilities\Dates;

abstract class Model implements ModelInterface
{
    use Dates;

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['*'];

    /**
     * The model attribute's original state.
     *
     * @var array
     */
    protected $original = [];

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->setAttributes($attributes, true);
    }

    /**
     * Dynamically retrieve attributes on the model.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function __get(string $key)
    {
        return $this->getAttribute($key);
    }

    /**
     * Dynamically set attributes on the model.
     *
     * @param string $key
     * @param mixed $value
     *
     * @return void
     */
    public function __set(string $key, $value) : void
    {
        $this->setAttribute($key, $value);
    }

    /**
     * Determine if an attribute exists on the model.
     *
     * @param string $key
     *
     * @return bool
     */
    public function __isset(string $key) : bool
    {
        return array_key_exists($key, $this->attributes);
    }

    /**
     * Unset an attribute on the model.
     *
     * @param string $key
     *
     * @return void
     */
    public function __unset(string $key) : void
    {
        unset($this->attributes[$key]);
    }

    /**
     * {@inheritdoc}
     *
     * @param array $attributes
     * @return Model
     */
    public function fill(array $attributes) : self
    {
        foreach ($attributes as $key => $value) {
            if ($this->isFillable($key)) {
                $this->setAttribute($key, $value);
            }
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @param string $key
     * @return mixed
     */
    public function getAttribute(string $key)
    {
        $value = $this->attributes[$key];

        if ($this->hasCast($key)) {
            return $this->castAttribute($key, $value);
        }

        return $value;
    }

    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public function getAttributes() : array
    {
        $attributes = [];

        foreach (array_keys($this->attributes) as $key) {
            $attributes[$key] = $this->getAttribute($key);
        }

        return $attributes;
    }

    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public function getChangedAttributes() : array
    {
        $attributes = $this->getAttributes();

        return array_filter($attributes, function (string $key) {
            return $this->isChangedAttribute($key);
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * {@inheritdoc}
     *
     * @return mixed
     */
    public function getKey()
    {
        $key = $this->getKeyName();

        return $this->getAttribute($key);
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getKeyName() : string
    {
        return $this->primaryKey;
    }

    /**
     * {@inheritdoc}
     *
     * @param string $key
     * @return mixed
     */
    public function getOriginalAttribute(string $key)
    {
        return $this->original[$key];
    }

    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public function getOriginalAttributes() : array
    {
        return $this->original;
    }

    /**
     * {@inheritdoc}
     *
     * @return mixed
     */
    public function getRouteKey()
    {
        return $this->getAttribute($this->getRouteKeyName());
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getRouteKeyName() : string
    {
        return $this->getKeyName();
    }

    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function isChanged() : bool
    {
        return !empty($this->getChangedAttributes());
    }

    /**
     * {@inheritdoc}
     *
     * @param string $key
     * @return bool
     */
    public function isChangedAttribute(string $key) : bool
    {
        $original = $this->getOriginalAttribute($key);
        $current = $this->getAttribute($key);

        if ($this->hasCast($key)) {
            return $this->castAttribute($key, $current) !== $this->castAttribute($key, $original);
        }

        return $current !== $original;
    }

    /**
     * {@inheritdoc}
     *
     * @param string $key
     * @param mixed $value
     * @param bool $isOriginal
     * @return $this
     */
    public function setAttribute(string $key, $value, bool $isOriginal = false)
    {
        $this->attributes[$key] = $value;

        if ($isOriginal) {
            $this->original[$key] = $value;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @param array $attributes
     * @param bool $isOriginal
     * @return $this
     */
    public function setAttributes(array $attributes, bool $isOriginal = false) : self
    {
        foreach ($attributes as $key => $value) {
            $this->setAttribute($key, $value, $isOriginal);
        }

        return $this;
    }

    /**
     * Cast an attribute to a native PHP type.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    protected function castAttribute($key, $value)
    {
        if (is_null($value)) {
            return $value;
        }

        $casts = $this->getCasts();

        switch ($casts[$key]) {
            case 'int':
            case 'integer':
                return (int) $value;
            case 'real':
            case 'float':
            case 'double':
                return (float) $value;
            case 'string':
                return (string) $value;
            case 'bool':
            case 'boolean':
                return (bool) $value;
            case 'date':
                return $this->asDate($value);
            case 'datetime':
                return $this->asDateTime($value);
            case 'timestamp':
                return $this->asTimestamp($value);
            default:
                return $value;
        }
    }

    /**
     * Get the casts array.
     *
     * @return string[]
     */
    protected function getCasts() : array
    {
        return $this->casts;
    }

    /**
     * Get the fillable attributes for the model.
     *
     * @return string[]
     */
    protected function getFillable() : array
    {
        return $this->fillable;
    }

    /**
     * Get the guarded attributes for the model.
     *
     * @return string[]
     */
    protected function getGuarded() : array
    {
        return $this->guarded;
    }

    /**
     * Determine whether an attribute should be cast to a native type.
     *
     * @param string $key
     * @param array|string|null $types
     * @return bool
     */
    protected function hasCast(string $key, $types = null) : bool
    {
        $casts = $this->getCasts();

        if (array_key_exists($key, $casts)) {
            return $types ? in_array($casts[$key], (array) $types, true) : true;
        }

        return false;
    }

    /**
     * Determine if the given attribute may be mass assigned.
     *
     * @param string $key
     * @return bool
     */
    protected function isFillable(string $key) : bool
    {
        return in_array($key, $this->getFillable()) && !in_array($key, $this->getGuarded());
    }
}
