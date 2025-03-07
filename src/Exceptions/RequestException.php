<?php namespace Tr4ctor\Jamef\Exceptions;

use Exception;

/**
 * Class RequestException
 *
 * @package Jamef\Exceptions
 */
class RequestException extends Exception
{
    /**
     * @var mixed
     */
    protected $errors;

    /**
     * @var array
     */
    protected $ids;

    /**
     * @var array
     */
    protected $parameters;

    /**
     * @var array
     */
    protected $messages;

    /**
     * @var array
     **/
    private $lastOptions;

    /**
     * ValidationException constructor.
     *
     * @param int   $status
     * @param mixed $errors
     */
    public function __construct($status, $errors, array $lastOptions = [])
    {
        $this->lastOptions = $lastOptions;
        $this->errors      = $errors;
        $this->code        = $status;

        $this->ids        = [];
        $this->parameters = [];
        $this->messages   = [];

        foreach ($errors as $error) {
            $this->ids[] = !empty($error->id) ? $error->id : null;
            $this->parameters[] = !empty($error->parameter) ? $error->parameter : null;
            $this->messages[] = !empty($error->message) ? $error->message : $error;
        }

        $this->message = trim(join('. ', $this->messages));
    }

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return array
     */
    public function getIds()
    {
        return $this->ids;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @return array
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Return the last request body
     * @return string
     **/
    public function getRequestBody()
    {
        return json_encode($this->lastOptions['json']);
    }
}
