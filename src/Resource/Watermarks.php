<?php namespace CupOfTea\YouTube\Resource;

use CupOfTea\YouTube\Contracts\Provider;
use CupOfTea\YouTube\Abstraction\Resource;
use CupOfTea\YouTube\Exceptions\UnauthorisedException;

use CupOfTea\YouTube\Traits\SetMethod, CupOfTea\YouTube\Traits\UnsetMethod;

class Watermarks extends Resource {
    
    use SetMethod, UnsetMethod;
    
    /**
	 * {@inheritdoc}
	 */
    protected $urlSegment = 'watermarks';
}
