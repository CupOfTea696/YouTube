<?php namespace CupOfTea\YouTube\Resource;

use CupOfTea\YouTube\Contracts\Provider;
use CupOfTea\YouTube\Abstraction\Resource;
use CupOfTea\YouTube\Exceptions\UnauthorisedException;

use CupOfTea\YouTube\Traits\SetMethod;

class Thumbnail extends Resource {
    
    use SetMethod;
    
    /**
	 * {@inheritdoc}
	 */
    protected $urlSegment = 'thumbnails';
}
