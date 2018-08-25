<?php

namespace LeeBrooks3\Tests\Examples\Models;

use LeeBrooks3\Models\Model;

class ExampleModel extends Model
{
    /**
     * {@inheritDoc}
     *
     * @var array
     */
    protected $casts = [
        'boolean' => 'boolean',
        'float' => 'float',
        'integer' => 'integer',
        'string' => 'string',
        'date' => 'date',
        'datetime' => 'datetime',
        'timestamp' => 'timestamp',
        'other' => 'other',
    ];

    /**
     * {@inheritDoc}
     *
     * @var array
     */
    protected $fillable = [
        'boolean',
        'float',
        'integer',
        'string',
        'date',
        'datetime',
        'timestamp',
        'other',
    ];

    /**
     * {@inheritDoc}
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];
}
