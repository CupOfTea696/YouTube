<?php namespace CupOfTea\YouTube;

use Session;

class AuthModelObserver
{
    
    protected $rawData;
    
    protected $isNew;
    
    protected $provider;
    
    public function saving($model)
    {
        Session::put(YouTube::package('dot') . '.auth_model.meta', [
            'is_new' => $model->isNew,
            'raw' => $model->{config('youtube.integration.raw_property')},
        ]);
        
        unset($model->isNew, $model->{config('youtube.integration.raw_property')});
    }
    
    public function saved($model)
    {
        $model->isNew = Session::pull(YouTube::package('dot') . '.auth_model.meta.is_new');
        $model->{config('youtube.integration.raw_property')} = Session::pull(YouTube::package('dot') . '.auth_model.meta.raw');
    }

}
