<?php namespace CupOfTea\YouTube\Traits;

trait HasSubResources {
    
	/**
	 * Initiated SubResources.
	 *
	 * @var array
	 */
    protected $subresources = [];
    
    /**
	 * Get a SubResource.
	 *
	 * @param  string  $resource
	 * @return CupOfTea\YouTube\Contracts\Resource
	 *
	 * * * *
	 * OR  *
	 * * * *
	 *
	 * Call a Resource Method
	 *
	 * @param    string  $method
	 * @param    array   $properties
	 * @return   \CupOfTea\YouTube\Contracts\Resource
	 * @throws   UnauthorisedException if the method needs user authentication.
	 * @triggers E_USER_ERROR if the method doesn't exist for this Resource.
	 */
    public function __call($resource_method, $args){
        $resource = strtolower($resource_method);
        if(in_array($resource, $this->available_subresources)){
            if($instance = in_array($resource, $this->subresources))
                return $instance;
            
            $instance = __CLASS__ . '\\' . ucfirst($resource);
            return $this->subresources[$resource] = new $instance($this->Provider, $this->session);
        }
        
        $method = $resource_method;
        $this->beforeMethod($method);
        $parameters = &$args[0];
        
        $parameters = $this->getAllParameters($parameters);
        array_unshift(
            $args,
            $this->getHttpClient(),
            $this->urlSegment,
            $this->authorised ? $this->tokens['access_token'] : '',
            [$this, 'apiErrorHandler']
        );
        
        return call_user_func_array([$this, '_' . $method], $args);
    }

}
