<?php namespace CupOfTea\YouTube\API\Resource;

use ArrayAccess;
use CupOfTea\YouTube\Contracts\Provider;
use CupOfTea\YouTube\Exceptions\UnauthorisedException;
use CupOfTea\YouTube\Contracts\Resource as ResourceContract;
use CupOfTea\YouTube\Contracts\HasSubResources as HasSubResourcesContract;

use CupOfTea\YouTube\Traits\GetMethod, CupOfTea\YouTube\Traits\InsertMethod,
    CupOfTea\YouTube\Traits\UpdateMethod, CupOfTea\YouTube\Traits\DeleteMethod,
    CupOfTea\YouTube\Traits\RateMethod, CupOfTea\YouTube\Traits\GetRatingMethod;

class Videos implements ArrayAccess, ResourceContract, HasSubResourcesContract {
    
    use GetMethod, InsertMethod, UpdateMethod, DeleteMethod, RateMethod, GetRatingMethod;
    
    /**
	 * {@inheritdoc}
	 */
	protected $available_subresources = ['categories'];
    
    /**
	 * {@inheritdoc}
	 */
    protected $urlSegment = 'videos';
    
    
}
