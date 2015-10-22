<?php namespace CupOfTea\YouTube\Resource;

use CupOfTea\YouTube\Abstraction\Resource;
use CupOfTea\YouTube\Traits\ListMethod;
use CupOfTea\YouTube\Traits\InsertMethod;
use CupOfTea\YouTube\Traits\DeleteMethod;

class Subscription extends Resource
{
    use ListMethod, InsertMethod, DeleteMethod;
    
    /**
     * {@inheritdoc}
     */
    protected $urlSegment = 'subscriptions';
    
    public function mine($parameters = [])
    {
        $this->authenticated();
        $this->parameters = array_replace($this->parameters, $parameters);
        $this->part(['id', 'snippet']);
        $this->parameters['mine'] = 'true';
        
        return $this->list($this->parameters);
    }
}
