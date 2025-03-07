<?php

namespace Tr4ctor\Jamef\Test;

use stdClass;
use Tr4ctor\Jamef\ApiRequester;
use Tr4ctor\Jamef\CalculoFrete;
use Tr4ctor\Jamef\Subscription;

class CalculoFreteTest extends ResourceTest
{
    public function setUp(): void
    {
        $this->resource = $this->getMockForAbstractClass(CalculoFrete::class);
        $this->resource->apiRequester = $this->getMockBuilder(ApiRequester::class)->getMock();
    }

    /** @test */
    public function it_should_have_an_endpoint()
    {
        $this->assertSame($this->resource->endpoint(), 'calculo-frete/v1/');
    }

    /** @test */
    public function it_should_return_a_quote()
    {
        $stdClass = new stdClass;
        $this->resource->apiRequester->method('request')->willReturn($stdClass);
        $response = $this->resource->cotacao([]);
        $this->assertSame($response, $stdClass);
    }
}
