<?php namespace CupOfTea\YouTube\API\Resource\Videos;

use ArrayAccess;
use CupOfTea\YouTube\Contracts\Provider;
use CupOfTea\YouTube\Exceptions\UnauthorisedException;
use CupOfTea\YouTube\Contracts\Resource as ResourceContract;

use CupOfTea\YouTube\Traits\GetMethod;

class Catefories implements ArrayAccess, ResourceContract {
    
    use GetMethod;
    
    /**
	 * {@inheritdoc}
	 */
    protected $urlSegment = 'videoCategories';
    
    
}
