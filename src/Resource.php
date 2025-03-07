<?php

namespace Tr4ctor\Jamef;

/**
 * Class Resource
 *
 * @package Tr4ctor\Jamef
 */
abstract class Resource
{
    /**
     * @var \Tr4ctor\Jamef\ApiRequester
     */
    public $apiRequester;

    /**
     * Resource constructor.
     *
     * @param array $arguments
     */
    public function __construct($arguments = [])
    {
        if (key_exists(Jamef::JAMEF_API_USERNAME, $arguments)) {
            Jamef::setApiUsername($arguments[Jamef::JAMEF_API_USERNAME]);
        }

        if (key_exists(Jamef::JAMEF_API_PASSWORD, $arguments)) {
            Jamef::setApiPassword($arguments[Jamef::JAMEF_API_PASSWORD]);
        }

        if (key_exists(Jamef::JAMEF_API_TOKEN, $arguments)) {
            Jamef::setApiToken($arguments[Jamef::JAMEF_API_TOKEN]);
        }

        if (key_exists(Jamef::JAMEF_API_URI, $arguments)) {
            Jamef::setApiUri($arguments[Jamef::JAMEF_API_URI]);
        }
        $this->apiRequester = new ApiRequester;
    }

    /**
     * The endpoint at default state that will hit the API.
     *
     * @return string
     */
    abstract public function endpoint(): string;

    /**
     * Build url that will hit the API.
     *
     * @param int    $id                 The resource's id.
     * @param string $additionalEndpoint Additional endpoint that will be appended to the URL.
     *
     * @return string
     */
    public function url($id = null, $additionalEndpoint = null)
    {
        $endpoint = $this->endpoint();

        if (! is_null($id)) {
            $endpoint .= '/' . $id;
        }
        if (! is_null($additionalEndpoint)) {
            $endpoint .= '/' . $additionalEndpoint;
        }

        return $endpoint;
    }

    /**
     * Retrieve all resources.
     *
     * @param array $params Pagination and Filter parameters.
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Tr4ctor\Jamef\Exceptions\RateLimitException
     * @throws \Tr4ctor\Jamef\Exceptions\RequestException
     */
    public function all(array $params = [])
    {
        return $this->apiRequester->request('GET', $this->url(), ['query' => $params]);
    }

    /**
     * Create a new resource.
     *
     * @param array $form_params The request body.
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Tr4ctor\Jamef\Exceptions\RateLimitException
     * @throws \Tr4ctor\Jamef\Exceptions\RequestException
     */
    public function create(array $form_params = [])
    {
        return $this->apiRequester->request('POST', $this->url(), ['json' => $form_params]);
    }

    /**
     * Retrieve a specific resource.
     *
     * @param int $id The resource's id.
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Tr4ctor\Jamef\Exceptions\RateLimitException
     * @throws \Tr4ctor\Jamef\Exceptions\RequestException
     */
    public function retrieve($id = null)
    {
        return $this->apiRequester->request('GET', $this->url($id));
    }

    /**
     * Update a specific resource.
     *
     * @param int   $id          The resource's id.
     * @param array $form_params The request body.
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Tr4ctor\Jamef\Exceptions\RateLimitException
     * @throws \Tr4ctor\Jamef\Exceptions\RequestException
     */
    public function update($id = null, array $form_params = [])
    {
        return $this->apiRequester->request('PUT', $this->url($id), ['json' => $form_params]);
    }

    /**
     * Delete a specific resource.
     *
     * @param int   $id          The resource's id.
     * @param array $form_params The request body.
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Tr4ctor\Jamef\Exceptions\RateLimitException
     * @throws \Tr4ctor\Jamef\Exceptions\RequestException
     */
    public function delete($id = null, array $form_params = [])
    {
        return $this->apiRequester->request('DELETE', $this->url($id), ['json' => $form_params]);
    }

    /**
     * Make a GET request to an additional endpoint for a specific resource.
     *
     * @param int    $id                 The resource's id.
     * @param string $additionalEndpoint Additional endpoint that will be appended to the URL.
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Tr4ctor\Jamef\Exceptions\RateLimitException
     * @throws \Tr4ctor\Jamef\Exceptions\RequestException
     */
    public function get($id = null, $additionalEndpoint = null)
    {
        return $this->apiRequester->request('GET', $this->url($id, $additionalEndpoint));
    }

    /**
     * Make a POST request to an additional endpoint for a specific resource.
     *
     * @param int    $id                 The resource's id.
     * @param string $additionalEndpoint Additional endpoint that will be appended to the URL.
     * @param array  $form_params        The request body.
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Tr4ctor\Jamef\Exceptions\RateLimitException
     * @throws \Tr4ctor\Jamef\Exceptions\RequestException
     */
    public function post($id = null, $additionalEndpoint = null, array $form_params = [])
    {
        return $this->apiRequester->request('POST', $this->url($id, $additionalEndpoint), ['json' => $form_params]);
    }

    /**
     * Return the last response from a preview request
     *
     * @return mixed
     */
    public function getLastResponse()
    {
        return $this->apiRequester->lastResponse;
    }
}
