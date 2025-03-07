<?php

namespace Tr4ctor\Jamef;

/**
 * Class CalculoFrete
 *
 * @package Tr4ctor\Jamef
 */
class CalculoFrete extends Resource
{
    /**
     * The endpoint that will hit the API.
     *
     * @return string
     */
    public function endpoint(): string
    {
        return 'calculo-frete/v1';
    }

    /**
     * Make a POST request to calculo-frete/v1/cotacao.
     *
     * @param array $form_params
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Vindi\Exceptions\RateLimitException
     * @throws \Vindi\Exceptions\RequestException
     */
    public function cotacao(array $form_params = [])
    {
        return $this->post(null, 'cotacao', $form_params);
    }
}
