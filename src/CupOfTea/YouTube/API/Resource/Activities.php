<?php namespace CupOfTea\YouTube\API\Resource;

use ArrayAccess;
use CupOfTea\YouTube\Contracts\Provider;
use CupOfTea\YouTube\Exceptions\UnauthorisedException;
use CupOfTea\YouTube\Contracts\Resource as ResourceContract;

use CupOfTea\YouTube\Traits\GetMethod, CupOfTea\YouTube\Traits\InsertMethod;

class Activities implements ArrayAccess, ResourceContract {
    
    use GetMethod, InsertMethod;
    
    /**
	 * {@inheritdoc}
	 */
    protected $urlSegment = 'activities';
}
