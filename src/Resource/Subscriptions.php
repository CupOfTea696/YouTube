<?php namespace CupOfTea\YouTube\Resource;

use CupOfTea\YouTube\Contracts\Provider;
use CupOfTea\YouTube\Abstraction\Resource;
use CupOfTea\YouTube\Exceptions\UnauthorisedException;

use CupOfTea\YouTube\Traits\ListMethod, CupOfTea\YouTube\Traits\InsertMethod,
    CupOfTea\YouTube\Traits\DeleteMethod;

class Subscriptions extends Resource {
    
    use ListMethod, InsertMethod, DeleteMethod;
    
    /**
	 * {@inheritdoc}
	 */
    protected $urlSegment = 'subscriptions';
    
    public function mine($parameters = []){
        $this->authenticated();
        $this->parameters = $parameters;
        $this->part(['id', 'snippet']);
        $this->parameters['mine'] = 'true';
        
        return $this->list($this->parameters);
    }
}
