<?php namespace CupOfTea\YouTube\API\Resource;

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
    
    public function me(){
        $this->authenticated();
        
        return $this->list(['mine' => 'true']);
    }
    
    
}
