<?php

namespace LeeBrooks3\Http\Clients;

use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use Psr\Http\Message\ResponseInterface;

interface ClientInterface extends GuzzleClientInterface
{
    /**
     * Makes a GET request.
     *
     * @param string $uri
     * @param array $params
     * @return ResponseInterface
     */
    public function get(string $uri, array $params = []) : ResponseInterface;

    /**
     * Makes a POST request.
     *
     * @param string $uri
     * @param array $data
     * @param array $params
     * @return ResponseInterface
     */
    public function post(string $uri, array $data = [], array $params = []) : ResponseInterface;

    /**
     * Makes a PATCH request.
     *
     * @param string $uri
     * @param array $data
     * @param array $params
     * @return ResponseInterface
     */
    public function patch(string $uri, array $data = [], array $params = []) : ResponseInterface;

    /**
     * Makes a PUT request.
     *
     * @param string $uri
     * @param array $data
     * @param array $params
     * @return ResponseInterface
     */
    public function put(string $uri, array $data = [], array $params = []) : ResponseInterface;

    /**
     * Makes a DELETE request.
     *
     * @param string $uri
     * @param array $params
     * @return ResponseInterface
     */
    public function delete(string $uri, array $params = []) : ResponseInterface;
}
