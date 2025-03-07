<?php

namespace Tr4ctor\Jamef;

use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\ClientException;
use Tr4ctor\Jamef\Exceptions\ValidationException;
use Tr4ctor\Jamef\Http\Client;
use Tr4ctor\Jamef\Exceptions\RequestException;
use Tr4ctor\Jamef\Exceptions\RateLimitException;

/**
 * Class ApiRequester
 *
 * @package Jamef
 */
class ApiRequester
{
    /**
     * @var \Tr4ctor\Jamef\Http\Client
     */
    public $client;

    /**
     * @var ResponseInterface
     */
    public $lastResponse;

    /**
     * @var array
     */
    public $lastOptions;

    /**
     * ApiRequester constructor.
     */
    public function __construct()
    {
        $this->client = new Client;
    }

    /**
     * @param string $method   HTTP Method.
     * @param string $endpoint Relative to API base path.
     * @param array  $options  Options for the request.
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Tr4ctor\Jamef\Exceptions\RateLimitException
     * @throws \Tr4ctor\Jamef\Exceptions\RequestException
     */
    public function request($method, $endpoint, array $options = [])
    {
        $this->lastOptions = $options;
        try {
            $response = $this->client->request($method, $endpoint, $options);
        } catch (ClientException $e) {
            $response = $e->getResponse();
        }

        return $this->response($response);
    }

    /**
     * @param ResponseInterface $response
     *
     * @return object
     * @throws RateLimitException
     * @throws \Tr4ctor\Jamef\Exceptions\RequestException
     */
    public function response(ResponseInterface $response)
    {
        $this->lastResponse = $response;

        $content = $response->getBody()->getContents();
        $decoded = json_decode($content); // parse as object
        $data = $decoded;

        $this->checkRateLimit($response)
            ->checkForErrors($response, $data);

        return $data;
    }

    /**
     * @param ResponseInterface $response
     *
     * @return $this
     * @throws RateLimitException
     */
    private function checkRateLimit(ResponseInterface $response)
    {
        if (429 === $response->getStatusCode()) {
            throw new RateLimitException($response);
        }

        return $this;
    }

    /**
     * @param ResponseInterface $response
     * @param mixed             $data
     *
     * @return $this
     * @throws \Tr4ctor\Jamef\Exceptions\RequestException
     */
    private function checkForErrors(ResponseInterface $response, $data)
    {
        $status = $response->getStatusCode();

        $data = (array)$data;

        $statusClass = (int)($status / 100);

        if (($statusClass === 4) || ($statusClass === 5)) {
            switch ($status) {
                case 422:
                    throw new ValidationException($status, $data, $this->lastOptions);
                default:
                    throw new RequestException($status, $data, $this->lastOptions);
            }
        }

        return $this;
    }
}
