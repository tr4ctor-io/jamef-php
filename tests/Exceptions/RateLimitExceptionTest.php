<?php

namespace Tr4ctor\Jamef\Test\Exceptions;

use GuzzleHttp\Psr7\Response;
use Tr4ctor\Jamef\Exceptions\RateLimitException;
use PHPUnit\Framework\TestCase;

class RateLimitExceptionTest extends TestCase
{
    /** @test */
    public function it_should_access_exception_getters()
    {
        $rateLimit = [
            'Rate-Limit-Limit'     => rand(),
            'Rate-Limit-Reset'     => rand(),
            'Rate-Limit-Remaining' => rand(),
            'Retry-After'          => rand(),
        ];

        $response = new Response(429, $rateLimit);
        $exception = new RateLimitException($response);

        $this->assertSame($rateLimit['Rate-Limit-Limit'], $exception->getLimit());
        $this->assertSame($rateLimit['Rate-Limit-Reset'], $exception->getReset());
        $this->assertSame($rateLimit['Rate-Limit-Remaining'], $exception->getRemaining());
        $this->assertSame($rateLimit['Retry-After'], $exception->getRetryAfter());
    }
}
