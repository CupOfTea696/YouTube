<?php namespace CupOfTea\YouTube\Exceptions;

class ResourceNotFoundException extends \Exception
{
    /**
     * Exception message.
     *
     * @var string
     */
    protected $message = 'The Resource {resource} does not exist';
    
    public function __construct($resource, $code = 0, Exception $previous = null)
    {
        parent::__construct(str_replace('{resource}', $resource, $this->message), $code, $previous);
    }
}
