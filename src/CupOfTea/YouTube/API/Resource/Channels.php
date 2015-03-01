<?php namespace CupOfTea\YouTube\API\Resource;

use ArrayAccess;
use CupOfTea\YouTube\Contracts\Provider;
use CupOfTea\YouTube\Exceptions\UnauthorisedException;
use CupOfTea\YouTube\Contracts\Resource as ResourceContract;
use CupOfTea\YouTube\Contracts\HasSubResources as HasSubResourcesContract;

use CupOfTea\YouTube\Traits\GetMethod, CupOfTea\YouTube\Traits\UpdateMethod;

class Channels implements ArrayAccess, ResourceContract, HasSubResourcesContract {
    
    use GetMethod, UpdateMethod;
    
    /**
	 * {@inheritdoc}
	 */
	protected $available_subresources = ['banners', 'sections'];
    
    /**
	 * {@inheritdoc}
	 */
    protected $urlSegment = 'channels';
    
    
}
