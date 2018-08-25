<?php

namespace LeeBrooks3\Tests\Unit\Http\Clients;

use GuzzleHttp\Psr7\Response;
use LeeBrooks3\Tests\Examples\Http\Clients\ExampleClient;
use LeeBrooks3\Tests\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class ClientTest extends TestCase
{
    /**
     * The partially mocked client instance.
     *
     * @var ExampleClient|MockObject
     */
    protected $client;

    /**
     * Creates a partially mocked client instance.
     */
    public function setUp()
    {
        parent::setUp();

        $this->client = $this->createPartialMock(ExampleClient::class, ['request']);
    }

    /**
     * Tests that a GET request can be made.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGet()
    {
        $fakeUri = $this->faker->url;
        $fakeParams = [];

        $this->client->expects($this->once())
            ->method('request')
            ->with('GET', $fakeUri .'?'. http_build_query($fakeParams))
            ->willReturn(new Response());

        $this->client->get($fakeUri, $fakeParams);
    }

    /**
     * Tests that a POST request can be made.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testPost()
    {
        $fakeUri = $this->faker->url;
        $fakeParams = [];

        $this->client->expects($this->once())
            ->method('request')
            ->with('POST', $fakeUri, $fakeParams)
            ->willReturn(new Response());

        $this->client->post($fakeUri, $fakeParams);
    }

    /**
     * Tests that a PATCH request can be made.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testPatch()
    {
        $fakeUri = $this->faker->url;
        $fakeParams = [];

        $this->client->expects($this->once())
            ->method('request')
            ->with('PATCH', $fakeUri, $fakeParams)
            ->willReturn(new Response());

        $this->client->patch($fakeUri, $fakeParams);
    }

    /**
     * Tests that a PUT request can be made.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testPut()
    {
        $fakeUri = $this->faker->url;
        $fakeParams = [];

        $this->client->expects($this->once())
            ->method('request')
            ->with('PUT', $fakeUri, $fakeParams)
            ->willReturn(new Response());

        $this->client->put($fakeUri, $fakeParams);
    }

    /**
     * Tests that a DELETE request can be made.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testDelete()
    {
        $fakeUri = $this->faker->url;
        $fakeParams = [];

        $this->client->expects($this->once())
            ->method('request')
            ->with('DELETE', $fakeUri .'?'. http_build_query($fakeParams))
            ->willReturn(new Response());

        $this->client->delete($fakeUri, $fakeParams);
    }
}
