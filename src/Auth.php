<?php

namespace Tr4ctor\Jamef;

/**
 * Class Auth
 *
 * @package Tr4ctor\Jamef
 */
class Auth extends Resource
{
    /**
     * The endpoint that will hit the API.
     *
     * @return string
     */
    public function endpoint(): string
    {
        return 'auth/v1';
    }

    /**
     * Make a POST request to auth/v1/login.
     *
     * @param array $form_params
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Tr4ctor\Jamef\Exceptions\RateLimitException
     * @throws \Tr4ctor\Jamef\Exceptions\RequestException
     */
    public function login(array $form_params = [])
    {
        $form_params = array_merge(
            [
                "username" => Jamef::getApiUsername(),
                "password" => Jamef::getApiPassword()
            ],
            $form_params
        );
        return $this->post(null, 'login', $form_params);
    }
}
