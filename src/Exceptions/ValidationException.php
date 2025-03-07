<?php namespace Tr4ctor\Jamef\Exceptions;

/**
 * Class ValidationException
 *
 * @package Jamef\Exceptions
 */
class ValidationException extends RequestException
{
    /**
     * ValidationException constructor.
     *
     * @param int   $status
     * @param mixed $errors
     */
    public function __construct($status, $errors, array $lastOptions = [])
    {
        parent::__construct($status, $errors, $lastOptions);

        $this->message     = "Erros de validação foram encontrados!";
    }
}
