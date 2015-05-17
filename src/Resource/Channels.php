<?php namespace CupOfTea\YouTube\Resource;

use CupOfTea\YouTube\Contracts\Provider;
use CupOfTea\YouTube\Abstraction\Resource;
use CupOfTea\YouTube\Traits\HasSubResources;
use CupOfTea\YouTube\Exceptions\UnauthorisedException;

use CupOfTea\YouTube\Traits\ListMethod, CupOfTea\YouTube\Traits\UpdateMethod;

class Channels extends Resource{
    
    use ListMethod, UpdateMethod,
        HasSubResources;
    
    /**
	 * Available SubResources for this API.
	 *
	 * @var array
	 */
	protected $available_subresources = ['banners', 'sections'];
    
    /**
	 * {@inheritdoc}
	 */
    protected $urlSegment = 'channels';
    
    public function me($parameters = []){
        $this->authenticated();
        $this->parameters = $parameters;
        $this->part(['id', 'snippet']);
        $this->parameters['mine'] = 'true';
        
        return $this->list($this->parameters);
    }
    
}
