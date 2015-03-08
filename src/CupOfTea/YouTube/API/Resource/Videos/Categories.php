<?php namespace CupOfTea\YouTube\API\Resource\Videos;

use CupOfTea\YouTube\Contracts\Provider;
use CupOfTea\YouTube\Abstraction\Resource;
use CupOfTea\YouTube\Exceptions\UnauthorisedException;

use CupOfTea\YouTube\Traits\GetMethod;

class Catefories extends Resource {
    
    use GetMethod;
    
    /**
	 * {@inheritdoc}
	 */
    protected $urlSegment = 'videoCategories';
    
    
}
