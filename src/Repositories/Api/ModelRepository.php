<?php

namespace LeeBrooks3\Repositories\Api;

use LeeBrooks3\Http\Clients\ClientInterface;
use LeeBrooks3\Models\ModelInterface;
use LeeBrooks3\Repositories\ModelRepository as BaseModelRepository;
use Psr\Http\Message\ResponseInterface;

abstract class ModelRepository extends BaseModelRepository
{
    /**
     * A client instance.
     *
     * @var ClientInterface
     */
    protected $client;

    /**
     * The restful API endpoint for this model.
     *
     * @var string
     */
    protected $endpoint;

    /**
     * The enveloper or key used to wrap the main data of the payload.
     *
     * @var string|null
     */
    protected $envelope = null;

    /**
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Returns the resources matching the given parameters.
     *
     * @param array $params
     * @return ModelInterface[]
     */
    public function get(array $params = []) : array
    {
        $client = $this->getClient();
        $endpoint = $this->getEndpoint();

        $response = $client->get($endpoint, $params);
        $data = $this->getResponseData($response);

        return array_map(
            function (array $attributes) {
                return $this->makeModel($attributes);
            },
            $data ?? []
        );
    }

    /**
     * Creates a new resource.
     *
     * @param array $attributes
     * @return ModelInterface
     */
    public function create(array $attributes = []) : ModelInterface
    {
        $client = $this->getClient();
        $endpoint = $this->getEndpoint();

        $response = $client->post($endpoint, ['json' => $attributes]);
        $data = $this->getResponseData($response);

        return $this->makeModel($data);
    }

    /**
     * Returns the resource with the given route key value.
     *
     * @param int|string $id
     * @param array $params
     * @return ModelInterface
     */
    public function find($id, array $params = []) : ModelInterface
    {
        $client = $this->getClient();
        $endpoint = $this->getEndpoint();
        $query = http_build_query($params);

        $response = $client->get("{$endpoint}/{$id}?{$query}");
        $data = $this->getResponseData($response);

        return $this->makeModel($data);
    }

    /**
     * Updates the resource.
     *
     * @param ModelInterface $model
     * @param array $attributes
     * @return ModelInterface
     */
    public function update(ModelInterface $model, array $attributes = []) : ModelInterface
    {
        $model->fill($attributes);

        $client = $this->getClient();
        $endpoint = $this->getEndpoint();
        $primary = $model->getRouteKey();

        $response = $client->patch("{$endpoint}/{$primary}", ['json' => $model->getChangedAttributes()]);
        $data = $this->getResponseData($response);

        return $model->setAttributes($data);
    }

    /**
     * Deletes the resource.
     *
     * @param ModelInterface $model
     * @return void
     */
    public function delete(ModelInterface $model) : void
    {
        $client = $this->getClient();
        $endpoint = $this->getEndpoint();
        $primary = $model->getRouteKey();

        $client->delete("{$endpoint}/{$primary}");
    }

    /**
     * Returns the endpoint.
     *
     * @return ClientInterface
     */
    protected function getClient() : ClientInterface
    {
        return $this->client;
    }

    /**
     * Returns the endpoint.
     *
     * @return string
     */
    protected function getEndpoint() : string
    {
        return $this->endpoint;
    }

    /**
     * Returns the envelope.
     *
     * @return string|null
     */
    protected function getEnvelope()
    {
        return $this->envelope;
    }

    /**
     * Returns the unwrapped main data from the response payload.
     *
     * @param ResponseInterface $response
     * @return array
     */
    private function getResponseData(ResponseInterface $response) : array
    {
        $payload = $response->getBody()->getContents();
        $content = \GuzzleHttp\json_decode($payload, true);

        $envelope = $this->getEnvelope();

        return $envelope ? $content[$envelope] : $content;
    }
}
