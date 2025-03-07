<?php

namespace Tr4ctor\Jamef;

/**
 * Class Jamef
 *
 * @package Jamef
 */
class Jamef
{
    /**
     * The Environment variable name or argument for API URI.
     *
     * @var string
     */
    const JAMEF_API_URI = 'JAMEF_API_URI';

    /**
     * The Environment variable name or argument for API Key.
     *
     * @var string
     */
    const JAMEF_API_KEY = 'JAMEF_API_KEY';

    /**
     * API KEY to be set on instances
     *
     * @var string
     */
    private static $jamef_api_key;

    /**
     * URI to be set on instances
     * Ex.: https://sandbox-app.jamef.com.br/api/v1/
     *
     * @var string;
     */
    private static $jamef_api_uri;

    /**
     * This Package SDK Version.
     *
     * @var string
     */
    public static $sdkVersion = '0.1.0';

    /**
     * The Environment variable name for API Time Out.
     *
     * @var string
     */
    public static $apiTimeOutEnvVar = 'JAMEF_API_TIME_OUT';

    /**
     * Jamef constructor.
     */
    private function __construct()
    {
    }

    /**
     * Set API KEY
     *
     * @param $jamef_api_key
     */
    public static function setApiKey($jamef_api_key)
    {
        if (null === self::$jamef_api_key) {
            self::$jamef_api_key = $jamef_api_key;
        }
    }

    /**
     * Set API URI
     *
     * @param $jamef_api_uri
     */
    public static function setApiUri($jamef_api_uri)
    {
        if (null === self::$jamef_api_uri) {
            self::$jamef_api_uri = $jamef_api_uri;
        }
    }

    /**
     * Get Jamef API URI from environment.
     *
     * @return string
     */
    public static function getApiUri()
    {
        if (null !== self::$jamef_api_uri) {
            return self::$jamef_api_uri;
        }

        if (!empty(getenv(static::JAMEF_API_URI))) {
            return getenv(static::JAMEF_API_URI);
        }

        return 'https://app.jamef.com.br/api/v1/';
    }

    /**
     * Get Jamef API Key from environment.
     *
     * @return string
     */
    public static function getApiKey()
    {
        if (null !== self::$jamef_api_key) {
            return self::$jamef_api_key;
        }

        return getenv(static::JAMEF_API_KEY);
    }

    /**
     * Get Jamef API Time Out from environment.
     *
     * @return string
     */
    public static function getApiTimeOut()
    {
        if (empty(getenv(static::$apiTimeOutEnvVar))) {
            return 60;
        }
        return getenv(static::$apiTimeOutEnvVar);
    }

    /**
     * Get CA Bundle Path.
     *
     * @return string
     */
    public static function getCertPath()
    {
        return realpath(sprintf('%s/%s', dirname(__FILE__), '/../data/ssl/ca-bundle.crt'));
    }
}
