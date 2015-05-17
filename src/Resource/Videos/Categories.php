<?php namespace CupOfTea\YouTube\Resource\Videos;

use CupOfTea\YouTube\Contracts\Provider;
use CupOfTea\YouTube\Abstraction\Resource;
use CupOfTea\YouTube\Exceptions\UnauthorisedException;

use CupOfTea\YouTube\Traits\ListMethod;

class Catefories extends Resource {
    
    use ListMethod;
    
    /**
	 * {@inheritdoc}
	 */
    protected $urlSegment = 'videoCategories';
    
    
}
