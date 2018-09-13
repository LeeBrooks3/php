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
        $headers = $this->processHeadersFromParams($params);
        $query = http_build_query($params);

        return $this->request('GET', "{$uri}?{$query}", compact('headers'));
    }

    /**
     * {@inheritdoc}
     *
     * @param string $uri
     * @param array $data
     * @param array $params
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post(string $uri, array $data = [], array $params = []) : ResponseInterface
    {
        $params['json'] = $data;

        return $this->request('POST', $uri, $params);
    }

    /**
     * {@inheritdoc}
     *
     * @param string $uri
     * @param array $data
     * @param array $params
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function patch(string $uri, array $data = [], array $params = []) : ResponseInterface
    {
        $params['json'] = $data;

        return $this->request('PATCH', $uri, $params);
    }

    /**
     * {@inheritdoc}
     *
     * @param string $uri
     * @param array $data
     * @param array $params
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function put(string $uri, array $data = [], array $params = []) : ResponseInterface
    {
        $params['json'] = $data;

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
        $headers = $this->processHeadersFromParams($params);
        $query = http_build_query($params);

        return $this->request('DELETE', "{$uri}?{$query}", compact('headers'));
    }

    /**
     * Removes and returns any headers from the given parameters.
     *
     * @param array $params
     * @return array
     */
    private function processHeadersFromParams(array &$params) : array
    {
        $headers = $params['headers'] ?? [];

        unset($params['headers']);

        return $headers;
    }
}
