<?php namespace CupOfTea\YouTube\Contracts;

interface Resource {
    
    protected function getHttpClient();
    
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
        
        array_unshift($args, $this->getHttpClient(), '/' . $this->segment);
        return call_user_func_array([$this, '_' . $method], $args);
    }
    
    /**
     * Runs before exectuing a Resource Method.
	 *
	 * @var string
	 */
    protected function beforeMethod($method);
    
}
