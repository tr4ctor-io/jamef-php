<?php namespace Tr4ctor\Jamef\Test\Http;

use Tr4ctor\Jamef\Http\Client;
use PHPUnit\Framework\TestCase;
use Tr4ctor\Jamef\Jamef;

class ClientTest extends TestCase
{
    /**
     * @var \Tr4ctor\Jamef\Http\Client
     */
    private $client;

    public function setUp(): void
    {
        $this->client = new Client();
    }

    public function tearDown(): void
    {
        $this->client = null;
    }

    /** @test */
    public function it_should_call_request()
    {
        $response = $this->client->request('GET', 'http://google.com');

        $this->assertNotNull($response);
    }

    /** @test */
    public function it_should_have_correct_headers()
    {
        $version = Jamef::$sdkVersion;
        $headers = $this->client->getConfig()['headers'];

        $this->assertEquals($headers['Content-Type'], 'application/json');
        $this->assertEquals(preg_split('/\;/', $headers['User-Agent'])[0], "Tr4ctor\Jamef-PHP/{$version}");
    }
}
