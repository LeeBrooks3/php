<?php

namespace LeeBrooks3\Http\Clients;

use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\ResponseInterface;

abstract class Client extends GuzzleClient implements ClientInterface
{
    /**
     * {@inheritdoc}
     *
     * @param string $uri
     * @param array $params
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(string $uri, array $params = []) : ResponseInterface
    {
        $query = http_build_query($params);

        return $this->request('GET', "{$uri}?{$query}");
    }

    /**
     * {@inheritdoc}
     *
     * @param string $uri
     * @param array $params
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post(string $uri, array $params = []) : ResponseInterface
    {
        return $this->request('POST', $uri, $params);
    }

    /**
     * {@inheritdoc}
     *
     * @param string $uri
     * @param array $params
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function patch(string $uri, array $params = []) : ResponseInterface
    {
        return $this->request('PATCH', $uri, $params);
    }

    /**
     * {@inheritdoc}
     *
     * @param string $uri
     * @param array $params
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function put(string $uri, array $params = []) : ResponseInterface
    {
        return $this->request('PUT', $uri, $params);
    }

    /**
     * {@inheritdoc}
     *
     * @param string $uri
     * @param array $params
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete(string $uri, array $params = []) : ResponseInterface
    {
        $query = http_build_query($params);

        return $this->request('DELETE', "{$uri}?{$query}");
    }
}
