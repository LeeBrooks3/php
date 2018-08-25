<?php

namespace LeeBrooks3\Tests\Unit\Repositories;

use LeeBrooks3\Tests\Examples\Http\Clients\ExampleClient;
use LeeBrooks3\Tests\Examples\Models\ExampleModel;
use LeeBrooks3\Tests\Examples\Repositories\ExampleApiModelRepository;
use LeeBrooks3\Tests\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ApiModelRepositoryTest extends TestCase
{
    /**
     * A mocked client instance.
     *
     * @var ExampleClient|MockObject
     */
    protected $mockClient;

    /**
     * A mocked response instance.
     *
     * @var ResponseInterface|MockObject
     */
    protected $mockResponse;

    /**
     * A mocked stream instance.
     *
     * @var StreamInterface|MockObject
     */
    protected $mockStream;

    /**
     * The repository instance.
     *
     * @var ExampleApiModelRepository
     */
    protected $repository;

    /**
     * Creates a mock client instance and an instance of the repository.
     */
    public function setUp()
    {
        parent::setUp();

        $this->mockClient = $this->createMock(ExampleClient::class);
        $this->mockResponse = $this->createMock(ResponseInterface::class);
        $this->mockStream = $this->createMock(StreamInterface::class);

        $this->repository = new ExampleApiModelRepository($this->mockClient);
    }

    /**
     * Tests that the resources matching the given parameters can be returned.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGet()
    {
        $fakeParams = [];
        $fakePayload = [
            'data' => [
                [
                    'id' => $this->faker->randomNumber(),
                ],
            ],
        ];

        $this->mockClient->expects($this->once())
            ->method('get')
            ->with('example', $fakeParams)
            ->willReturn($this->mockResponse);

        $this->mockResponse->expects($this->once())
            ->method('getBody')
            ->willReturn($this->mockStream);

        $this->mockStream->expects($this->once())
            ->method('getContents')
            ->willReturn(\GuzzleHttp\json_encode($fakePayload));

        $result = $this->repository->get($fakeParams);

        $this->assertInstanceOf(ExampleModel::class, reset($result));
    }

    /**
     * Tests that a new resource can be created.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testCreate()
    {
        $fakeAttributes = [];
        $fakePayload = [
            'data' => [
                'id' => $this->faker->randomNumber(),
            ],
        ];

        $this->mockClient->expects($this->once())
            ->method('post')
            ->with('example', ['json' => $fakeAttributes])
            ->willReturn($this->mockResponse);

        $this->mockResponse->expects($this->once())
            ->method('getBody')
            ->willReturn($this->mockStream);

        $this->mockStream->expects($this->once())
            ->method('getContents')
            ->willReturn(\GuzzleHttp\json_encode($fakePayload));

        $result = $this->repository->create($fakeAttributes);

        $this->assertInstanceOf(ExampleModel::class, $result);
    }

    /**
     * Tests that the resources matching the given parameters can be returned.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testFind()
    {
        $fakeId = $this->faker->randomNumber();
        $fakeParams = [];
        $fakePayload = [
            'data' => [
                'id' => $fakeId,
            ],
        ];

        $this->mockClient->expects($this->once())
            ->method('get')
            ->with("example/{$fakeId}?". http_build_query($fakeParams))
            ->willReturn($this->mockResponse);

        $this->mockResponse->expects($this->once())
            ->method('getBody')
            ->willReturn($this->mockStream);

        $this->mockStream->expects($this->once())
            ->method('getContents')
            ->willReturn(\GuzzleHttp\json_encode($fakePayload));

        $result = $this->repository->find($fakeId, $fakeParams);

        $this->assertInstanceOf(ExampleModel::class, $result);
    }

    /**
     * Tests that a resource can be updated.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testUpdate()
    {
        $fakeId = $this->faker->randomNumber();
        $fakeModel = new ExampleModel([
            'id' => $fakeId,
            'integer' => null,
        ]);
        $fakeAttributes = [
            'integer' => $this->faker->randomNumber(),
        ];
        $fakePayload = [
            'data' => [
                'id' => $fakeId,
                'integer' => $fakeAttributes['integer'],
            ],
        ];

        $this->mockClient->expects($this->once())
            ->method('patch')
            ->with("example/{$fakeId}", ['json' => $fakeAttributes])
            ->willReturn($this->mockResponse);

        $this->mockResponse->expects($this->once())
            ->method('getBody')
            ->willReturn($this->mockStream);

        $this->mockStream->expects($this->once())
            ->method('getContents')
            ->willReturn(\GuzzleHttp\json_encode($fakePayload));

        $result = $this->repository->update($fakeModel, $fakeAttributes);

        $this->assertInstanceOf(ExampleModel::class, $result);
    }

    /**
     * Tests that a resource can be deleted.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testDelete()
    {
        $fakeId = $this->faker->randomNumber();
        $fakeModel = new ExampleModel([
            'id' => $fakeId,
        ]);

        $this->mockClient->expects($this->once())
            ->method('delete')
            ->with("example/{$fakeId}")
            ->willReturn($this->mockResponse);

        $this->repository->delete($fakeModel);
    }
}
