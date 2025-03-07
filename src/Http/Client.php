<?php

namespace Tr4ctor\Jamef\Http;

use GuzzleHttp\Client as Guzzle;
use Tr4ctor\Jamef\Jamef;

/**
 * Class Client
 *
 * @package Tr4ctor\Jamef\Http
 */
class Client extends Guzzle
{
    /**
     * Client constructor.
     */
    public function __construct(array $config = [])
    {
        $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';

        $config = array_merge(
            [
                'base_uri' => Jamef::getApiUri(),
                'headers' => [
                    'Content-Type' => 'application/json',
                    'User-Agent' => trim('Tr4ctor\Jamef-PHP/' . Jamef::$sdkVersion . "; {$host}"),
                    'Authorization' => 'Bearer '.Jamef::getApiToken()
                ],
                // 'verify' => Jamef::getCertPath(),
                'timeout' => Jamef::getApiTimeOut(),
                // 'curl.options' => [
                //     'CURLOPT_SSLVERSION' => 'CURL_SSLVERSION_TLSv1_2',
                // ]
            ],
            $config
        );

        parent::__construct($config);
    }
}
