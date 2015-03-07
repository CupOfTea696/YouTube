<?php namespace CupOfTea\YouTube\Abstraction;

use ArrayAccess;
use CupOfTea\YouTube\Contracts\Provider;
use CupOfTea\YouTube\Exceptions\UnauthorisedException;
use CupOfTea\YouTube\Contracts\Resource as ResourceContract;

abstract class Resource implements ArrayAccess, ResourceContract {
    
	/**
	 * The provider this Resource belongs to
	 *
	 * @var CupOfTea\YouTube\Contracts\Provider
	 */
	protected $Provider;
    
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
    protected $parameters = ['prettyPrint' => false];
    
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
    public function __contruct(Provider &$Provider){
        $this->Provider = $Provider;
    }
    
    protected function getHttpClient(){
        return $this->Provider->getHttpClient([$this->base_url, ['version', $this->version]]);
    }
    
    public function authenticated(){
        // @TODO: implement --> use auth token instead of api key
        
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
        return array_replace($this->parameters, $parameters);
    }
    
    /**
	 * {@inheritdoc}
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
        if(in_array($method, $this->authMethods)){
            if(!$this->Provider->isAuthenticated())
                throw new UnauthorisedException;
            
            $this->Provider->authenticatedMethodCalled();
        }
    }
    
	/**
     * Check if the Resource has the called method.
	 *
	 * @var string
	 * @throws CupOfTea\YouTube\Exceptions\MethodNotFoundException
	 */
    protected function methodCheck($method){
        if(!in_array(ucwords($method) . 'Method', class_uses($this)))
            throw new MethodNotFoundException(__CLASS__, $method);
    }

}
