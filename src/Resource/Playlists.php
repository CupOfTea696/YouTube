<?php namespace CupOfTea\YouTube\Resource;

use CupOfTea\YouTube\Contracts\Provider;
use CupOfTea\YouTube\Abstraction\Resource;
use CupOfTea\YouTube\Exceptions\UnauthorisedException;
use CupOfTea\YouTube\Traits\HasSubResources;

use CupOfTea\YouTube\Traits\GetMethod, CupOfTea\YouTube\Traits\InsertMethod,
    CupOfTea\YouTube\Traits\UpdateMethod, CupOfTea\YouTube\Traits\DeleteMethod;

class Playlists extends Resource {
    
    use GetMethod, InsertMethod, UpdateMethod, DeleteMethod,
        HasSubResources;
    
    /**
	 * Available SubResources for this API.
	 *
	 * @var array
	 */
	protected $available_subresources = ['items'];
    
    /**
	 * {@inheritdoc}
	 */
    protected $urlSegment = 'playlists';
    
    
}
