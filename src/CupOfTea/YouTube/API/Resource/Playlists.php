<?php namespace CupOfTea\YouTube\API\Resource;

use ArrayAccess;
use CupOfTea\YouTube\Contracts\Provider;
use CupOfTea\YouTube\Exceptions\UnauthorisedException;
use CupOfTea\YouTube\Contracts\Resource as ResourceContract;
use CupOfTea\YouTube\Contracts\HasSubResources as HasSubResourcesContract;

use CupOfTea\YouTube\Traits\GetMethod, CupOfTea\YouTube\Traits\InsertMethod,
    CupOfTea\YouTube\Traits\UpdateMethod, CupOfTea\YouTube\Traits\DeleteMethod;

class Playlists implements ArrayAccess, ResourceContract, HasSubResourcesContract {
    
    use GetMethod, InsertMethod, UpdateMethod, DeleteMethod;
    
    /**
	 * {@inheritdoc}
	 */
	protected $available_subresources = ['items'];
    
    /**
	 * {@inheritdoc}
	 */
    protected $urlSegment = 'playlists';
    
    
}
