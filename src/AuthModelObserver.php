<?php namespace CupOfTea\YouTube;
use Log;
class AuthModelObserver
{
    
    protected $rawData;
    
    protected $isNew;
    
    protected $provider;
    
    public function saving($model)
    {
        $this->isNew = $model->isNew;
        unset($model->isNew);
        
        $this->rawData = $model->{config('youtube.integration.raw_property')};
        unset($model->{config('youtube.integration.raw_property')});
    }
    
    public function saved($model)
    {
        $model->isNew = $this->isNew;
        $model->{config('integration.raw_property')} = $this->rawData;
    }

}
