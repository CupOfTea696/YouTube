<?php namespace CupOfTea\YouTube\API\Resource;

use CupOfTea\YouTube\Contracts\Provider;
use CupOfTea\YouTube\Abstraction\Resource;
use CupOfTea\YouTube\Exceptions\UnauthorisedException;

use CupOfTea\YouTube\Traits\SetMethod;

class Thumbnails extends Resource {
    
    use SetMethod;
    
    /**
	 * {@inheritdoc}
	 */
    protected $urlSegment = 'thumbnails';
}