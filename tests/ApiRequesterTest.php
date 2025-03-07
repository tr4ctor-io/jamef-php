<?php

namespace Tr4ctor\Jamef\Test;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Promise\Promise;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Tr4ctor\Jamef\Exceptions\RateLimitException;
use Tr4ctor\Jamef\Exceptions\RequestException;
use Tr4ctor\Jamef\Exceptions\ValidationException;
use Tr4ctor\Jamef\Http\Client;
use Tr4ctor\Jamef\ApiRequester;
use PHPUnit\Framework\TestCase;
use function GuzzleHttp\json_encode;

class ApiRequesterTest extends TestCase
{
    /**
     * @var \Tr4ctor\Jamef\ApiRequester;
     */
    private $apiRequester;

    /**
     * @var string
     */
    private $jsonError = '{"errors": [{"id": "id", "parameter": "parameter", "message": "message"}]}';

    public function setUp(): void
    {
        $this->apiRequester = new ApiRequester;
        $this->apiRequester->client = $this->getMockBuilder(Client::class)->getMock();
    }

    public function tearDown(): void
    {
        $this->apiRequester = null;
    }

    /** @test */
    public function it_should_make_a_request()
    {
        $response = new Response(200, [], '{"test": "ok"}');
        $this->apiRequester->client->method('request')->willReturn($response);

        $response = $this->apiRequester->request('GET', 'test');

        $this->assertSame($response, 'ok');
    }

    /** @test */
    public function it_should_throw_a_request_error()
    {
        $this->expectException(RequestException::class);
        $response = new Response(401, [], $this->jsonError);
        $this->apiRequester->client->method('request')->willReturn($response);

        $this->apiRequester->request('GET', 'test');
    }

    /** @test */
    public function it_should_throw_a_validation_error()
    {
        $this->expectException(ValidationException::class);
        $response = new Response(422, [], $this->jsonError);
        $this->apiRequester->client->method('request')->willReturn($response);

        $this->apiRequester->request('GET', 'test');
    }

    /** @test */
    public function it_should_throw_a_rate_limit_exception()
    {
        $this->expectException(RateLimitException::class);
        $response = new Response(429, ['Rate-Limit-Remaining' => 0], $this->jsonError);
        $this->apiRequester->client->method('request')->willReturn($response);

        $this->apiRequester->request('GET', 'test');
    }

    /** @test */
    public function it_should_catch_a_client_exception()
    {
        $this->expectException(RequestException::class);

        $request = new Request('GET', 'test');
        $response = new Response(500, [], $this->jsonError);
        $clientException = new ClientException('', $request, $response);

        $this->apiRequester->client->method('request')->willThrowException($clientException);

        $this->apiRequester->request('GET', 'test');
    }

     /** @test */
     public function it_should_pass_when_response_has_a_not_empty_body()
     {
         $request = new Request('GET', 'test');

         # json_encode(["test"]) replicates a fake json response received from Tr4ctor\Jamef' API
         $response = new Response(200, [], json_encode(["text"]));
         $clientException = new ClientException('', $request, $response);

         $this->apiRequester->client->method('request')->willThrowException($clientException);
         $this->assertTrue(!empty($this->apiRequester->request('GET', 'test')));
     }

     /** @test */
     public function it_should_pass_when_response_has_a_empty_body()
     {
         $request = new Request('GET', 'test');

         # json_encode(null) replicates the ApiRequester@response method behavior when received a null response for some unmapped reason
         $response = new Response(200, [], json_decode(null));

         $clientException = new ClientException('', $request, $response);

         $this->apiRequester->client->method('request')->willThrowException($clientException);
         $this->assertTrue(empty($this->apiRequester->request('GET', 'test')));
     }
}
