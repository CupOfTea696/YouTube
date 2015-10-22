<?php namespace CupOfTea\YouTube\Exceptions;

class MethodNotFoundException extends \Exception
{
    /**
     * Exception message.
     *
     * @var string
     */
    protected $message = 'The Resource {resource} has no method {method}()';
    
    public function __construct($resource, $method, $code = 0, Exception $previous = null)
    {
        parent::__construct(str_replace(['{resource}', '{method}'], [$resource, $method], $this->message), $code, $previous);
    }
}
