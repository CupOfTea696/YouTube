<?php namespace CupOfTea\YouTube\Abstraction;

use CupOfTea\YouTube\Contracts\Provider;
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
	 * This package's configuration
	 *
	 * @var string
	 */
	protected $cfg;

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
    public function __construct(Provider &$Provider, $session, $cfg){
        $this->Provider = $Provider;
        
        $this->cfg = $cfg;
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
        $this->parameters['part'] = is_array($part) ? implode(',', $part) : (string) $part;
        
        return $this;
    }
    
    public function fields($fields){
        // @TODO: Allow complex arrays as parameter and convert them to a correct fields string.
        $this->parameters['fields'] = $fields;
        
        return $this;
    }
    
    protected function getAllParameters($parameters){
        $params = array_replace($this->parameters, $parameters);
        if(!$this->authorised)
            $params['key'] = $this->cfg['api_key'];
        
        return $params;
    }
    
    /**
	 * Call a Resource Method
	 *
	 * @param    string  $method
	 * @param    array   $properties
	 * @return   \CupOfTea\YouTube\Contracts\Resource
	 * @throws   UnauthorisedException if the method needs user authentication.
	 * @triggers E_USER_ERROR if the method doesn't exist for this Resource.
	 */
	public function __call($method, $args){
        $this->beforeMethod($method);
        $parameters = &$args[0];
        
        $parameters = $this->getAllParameters($parameters);
        array_unshift($args, $this->getHttpClient(), $this->urlSegment, $this->authorised ? $this->tokens['access_token'] : '');
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

}
