<?php namespace CupOfTea\YouTube\Resource\Video;

use CupOfTea\YouTube\Contracts\Provider;
use CupOfTea\YouTube\Abstraction\Resource;
use CupOfTea\YouTube\Exceptions\UnauthorisedException;

use CupOfTea\YouTube\Traits\ListMethod;

class Catefory extends Resource {
    
    use ListMethod;
    
    /**
	 * {@inheritdoc}
	 */
    protected $urlSegment = 'videoCategories';
    
    
}
