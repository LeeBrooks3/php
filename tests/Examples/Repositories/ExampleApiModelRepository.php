<?php

namespace LeeBrooks3\Tests\Examples\Repositories;

use LeeBrooks3\Repositories\Api\ModelRepository as ApiModelRepository;
use LeeBrooks3\Tests\Examples\Http\Clients\ExampleClient;
use LeeBrooks3\Tests\Examples\Models\ExampleModel;

class ExampleApiModelRepository extends ApiModelRepository
{
    /** @var string */
    protected $endpoint = 'example';

    /** @var string */
    protected $model = ExampleModel::class;

    /**
     * @param ExampleClient $client
     */
    public function __construct(ExampleClient $client)
    {
        parent::__construct($client);
    }
}
