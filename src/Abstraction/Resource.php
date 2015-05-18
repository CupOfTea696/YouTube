<?php namespace CupOfTea\YouTube\Abstraction;

use CupOfTea\YouTube\Contracts\Provider;
use CupOfTea\YouTube\Exceptions\ApiErrorException;
use CupOfTea\YouTube\Exceptions\UnauthorisedException;
use CupOfTea\YouTube\Exceptions\MethodNotFoundException;

abstract class Resource {
    
	/**
	 * The provider this Resource belongs to
	 *
	 * @var CupOfTea\YouTube\Contracts\Provider
	 */
	protected $Provider;

	/**
	 * The Session instance.
	 *
	 * @var Session
	 */
    protected $session;

	/**
	 * The access and refresh tokens
	 *
	 * @var array
	 */
	protected $tokens;

	/**
	 * API key for this API
	 *
	 * @var string
	 */
	protected $api_key;
    
	/**
	 * Base URL for this API
	 *
	 * @var string
	 */
    protected $base_url = 'https://www.googleapis.com/youtube/{version}/';
    
	/**
	 * This API's version
	 *
	 * @var string
	 */
    protected $version = 'v3';
    
	/**
	 * URL segment for this Resource
	 *
	 * @var string
	 */
    protected $urlSegment = '';
    
	/**
	 * Parameters that will be sent along with the request.
	 *
	 * @var array
	 */
    protected $parameters = ['prettyPrint' => 'false'];

	/**
	 * Whether or not this is an authorised request.
	 *
	 * @var bool
	 */
	protected $authorised = false;
    
	/**
     * Metadata on all existing methods in this API
	 *
	 * @var array
	 */
    protected $authMethods = ['insert', 'update', 'rate', 'delete', 'set', 'unset'];
    
    /**
	 * Create a new Resource instance.
	 *
	 * @param  Provider    $Provider
	 * @return void
	 */
    public function __construct(Provider &$Provider, $session){
        $this->Provider = $Provider;
        
        $this->session = $session;
        $this->tokens = $this->session->get('cupoftea.youtube.tokens', []);
    }
    
    protected function getHttpClient(){
        return $this->Provider->getHttpClient([$this->base_url, ['version' => $this->version]]);
    }
    
    public function authenticated(){
        $this->authorised = true;
        
        return $this;
    }
    
    public function part($part){
        $add_parts = is_array($part) ? $part : explode(',', str_replace(' ', '', $part));
        $this->parameters['part'] = array_key_exists('part', $this->parameters) ? array_merge($this->parameters['part'], $add_parts) : $add_parts;
        
        return $this;
    }
    
    public function fields($fields){
        // @TODO: Allow complex arrays as parameter and convert them to a correct fields string.
        $this->parameters['fields'] = $fields;
        
        return $this;
    }
    
    protected function getAllParameters($parameters){
        $parameters = array_replace($this->parameters, $parameters);
        if(!$this->authorised)
            $parameters['key'] = config('youtube.api_key');
        
        $parts = [];
        if (array_key_exists('fields', $parameters)) {
            preg_match_all('/(?:\(|,)([a-zA-Z]+)[^\(,]*(?:\(.*?\))?/', $parameters['fields'], $parts);
            $parts = $parts[1];
        }
        
        $parts = array_key_exists('part', $parameters) ? array_merge($parameters['part'], $parts) : $parts;
        if(count($parts))
            $parameters['part'] = implode(',', $parts);
        
        return $parameters;
    }
    
    /**
	 * Call a Resource Method
	 *
	 * @param    string  $method
	 * @param    array   $properties
	 * @return   \CupOfTea\YouTube\Contracts\Resource
	 * @throws   UnauthorisedException if the method needs user authentication.
	 * @throws   MethodNotFoundException if the method doesn't exist for this Resource.
	 * @throws   ApiErrorException if an API error occured.
	 */
	public function __call($method, $args){
        $this->beforeMethod($method);
        
        $args[0] = $this->getAllParameters($args[0]);
        array_unshift(
            $args,
            $this->getHttpClient(),
            $this->urlSegment,
            $this->authorised ? $this->tokens['access_token'] : '',
            [$this, 'apiErrorHandler']
        );
        
        return call_user_func_array([$this, '_' . $method], $args);
    }
    
    /**
     * Runs before exectuing a Resource Method.
	 *
	 * @var string
	 */
    protected function beforeMethod($method){
        $this->methodCheck($method);
        $this->authCheck($method);
    }
    
	/**
     * Checks if the user is authenticated.
	 *
	 * @var string
	 * @throws CupOfTea\YouTube\Exceptions\UnauthorisedException
	 */
    protected function authCheck($method){
        if(in_array($method, $this->authMethods) || $this->authorised){
            if(!$this->Provider->isAuthenticated())
                throw new UnauthorisedException;
            
            $this->Provider->authenticatedMethodCalled();
            $this->authorised = true;
        }
    }
    
	/**
     * Check if the Resource has the called method.
	 *
	 * @var string
	 * @throws CupOfTea\YouTube\Exceptions\MethodNotFoundException
	 */
    protected function methodCheck($method){
        if(!in_array('CupOfTea\\YouTube\\Traits\\' . ucwords($method) . 'Method', class_uses($this)))
            throw new MethodNotFoundException(__CLASS__, $method);
    }
    
    public function apiErrorHandler($e){
        if($e->hasResponse()){
            $response = $e->getResponse();
            $body = json_decode($response->getBody(), true);
            $code = $response->getStatusCode();
            
            $msg  = 'API Error response:' . PHP_EOL;
            $msg .= PHP_EOL;
            $msg .= '  [message] ' . $body['error']['message'] . PHP_EOL;
            $msg .= '  [url] ' . $e->getRequest()->getUrl() . PHP_EOL;
            $msg .= '  [status code] ' . $code . PHP_EOL;
            $msg .= '  [reason phrase] ' . $response->getReasonPhrase() . PHP_EOL;
            
            throw new ApiErrorException($msg, $code);
        }
        
        throw $e;
    }

}
