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
     * The Environment variable name or argument for API Username.
     *
     * @var string
     */
    const JAMEF_API_USERNAME = 'JAMEF_API_USERNAME';

    /**
     * The Environment variable name or argument for API Password.
     *
     * @var string
     */
    const JAMEF_API_PASSWORD = 'JAMEF_API_PASSWORD';

    /**
     * The Environment variable name or argument for API Password.
     *
     * @var string
     */
    const JAMEF_API_TOKEN = 'JAMEF_API_TOKEN';

    /**
     * API USERNAME to be set on instances
     *
     * @var string
     */
    private static $jamef_api_username;

    /**
     * API PASSWORD to be set on instances
     *
     * @var string
     */
    private static $jamef_api_password;

    /**
     * API TOKEN to be set on instances
     *
     * @var string
     */
    private static $jamef_api_token;

    /**
     * URI to be set on instances
     * Ex.: https://api-qa.jamef.com.br/
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
     * Set API USERNAME
     *
     * @param $jamef_api_username
     */
    public static function setApiUsername($jamef_api_username)
    {
        if (null === self::$jamef_api_username) {
            self::$jamef_api_username = $jamef_api_username;
        }
    }

    /**
     * Set API PASSWORD
     *
     * @param $jamef_api_password
     */
    public static function setApiPassword($jamef_api_password)
    {
        if (null === self::$jamef_api_password) {
            self::$jamef_api_password = $jamef_api_password;
        }
    }

    /**
     * Set API TOKEN
     *
     * @param $jamef_api_password
     */
    public static function setApiToken($jamef_api_token)
    {
        if (null === self::$jamef_api_token) {
            self::$jamef_api_token = $jamef_api_token;
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

        return 'https://api.jamef.com.br/';
    }

    /**
     * Get Jamef API Username from environment.
     *
     * @return string
     */
    public static function getApiUsername()
    {
        if (null !== self::$jamef_api_username) {
            return self::$jamef_api_username;
        }

        return getenv(static::JAMEF_API_USERNAME);
    }

    /**
     * Get Jamef API Password from environment.
     *
     * @return string
     */
    public static function getApiPassword()
    {
        if (null !== self::$jamef_api_password) {
            return self::$jamef_api_password;
        }

        return getenv(static::JAMEF_API_PASSWORD);
    }

    /**
     * Get Jamef API Token from environment.
     *
     * @return string
     */
    public static function getApiToken()
    {
        if (null !== self::$jamef_api_token) {
            return self::$jamef_api_token;
        }

        return getenv(static::JAMEF_API_TOKEN);
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
