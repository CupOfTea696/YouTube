<?php namespace CupOfTea\YouTube\Resource;

use CupOfTea\YouTube\Contracts\Provider;
use CupOfTea\YouTube\Abstraction\Resource;
use CupOfTea\YouTube\Exceptions\UnauthorisedException;

use CupOfTea\YouTube\Traits\GetMethod, CupOfTea\YouTube\Traits\InsertMethod;

class Activities extends Resource {
    
    use GetMethod, InsertMethod;
    
    /**
	 * {@inheritdoc}
	 */
    protected $urlSegment = 'activities';
}
