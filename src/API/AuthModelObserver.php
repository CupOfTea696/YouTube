<?php namespace CupOfTea\YouTube\API;

class AuthModelObserver {
    
    protected $provider;
    
    public function __construct(Provider $provider)
	{
		$this->provider = $provider;
	}


    public function saved($model)
    {
        $this->provider->saveRefreshToken($model);
    }

}
