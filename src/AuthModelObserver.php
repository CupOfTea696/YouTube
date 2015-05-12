<?php namespace CupOfTea\YouTube;
use Log;
class AuthModelObserver
{
    
    protected $rawData;
    
    protected $isNew;
    
    protected $provider;
    
    public function __construct(YouTube $provider)
	{
		$this->provider = $provider;
        Log::debug('savo');
	}
    
    public function saving($model)
    {
        $this->isNew = $model->isNew;
        $this->rawData = $model->{config('integration.raw_property')};
        
        unset($model->isNew, $model->{config('integration.raw_property')});
    }
    
    public function saved($model)
    {
        $model->isNew = $this->isNew;
        $model->{config('integration.raw_property')} = $this->rawData;
        
        $this->provider->saveRefreshToken($model);
    }

}
