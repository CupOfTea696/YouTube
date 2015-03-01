<?php namespace CupOfTea\YouTube\Contracts;

interface HasSubResources {

	/**
	 * Available SubResources for this API.
	 *
	 * @var array
	 */
	protected $available_subresources;
    
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
    public __call($resource_method, $a){
        $resource = strtolower($resource_method);
        if(array_get($resource, $this->available_subresources)){
            if($instance = array_get($resource, $this->resources))
                return $instance;
            
            $instance = __CLASS__ . '\\' . ucfirst($resource);
            return $this->subresources[$resource] = new $instance(&$this);
        }
        
        $this->beforeMethod($resource_method);
        return call_user_func_array([$this, '_' . $method], $args);
    }

}
