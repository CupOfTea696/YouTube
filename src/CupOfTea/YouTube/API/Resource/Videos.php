<?php namespace CupOfTea\YouTube\API\Resource;

use CupOfTea\YouTube\Contracts\Provider;
use CupOfTea\YouTube\Abstraction\Resource;
use CupOfTea\YouTube\Traits\HasSubResources;
use CupOfTea\YouTube\Exceptions\UnauthorisedException;

use CupOfTea\YouTube\Traits\GetMethod, CupOfTea\YouTube\Traits\InsertMethod,
    CupOfTea\YouTube\Traits\UpdateMethod, CupOfTea\YouTube\Traits\DeleteMethod,
    CupOfTea\YouTube\Traits\RateMethod, CupOfTea\YouTube\Traits\GetRatingMethod;

class Videos extends Resource {
    
    use GetMethod, InsertMethod, UpdateMethod, DeleteMethod, RateMethod, GetRatingMethod,
        HasSubResources;
    
    /**
	 * Available SubResources for this API.
	 *
	 * @var array
	 */
	protected $available_subresources = ['categories'];
    
    /**
	 * {@inheritdoc}
	 */
    protected $urlSegment = 'videos';
    
    
}
