<?php

namespace LeeBrooks3\Transformers;

interface TransformerInterface
{
    /**
     * Transforms the given value.
     *
     * @param mixed $value
     * @return mixed
     */
    public function transform($value);
}
