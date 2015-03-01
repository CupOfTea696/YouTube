<?php namespace CupOfTea\YouTube\API\Resource;

use ArrayAccess;
use CupOfTea\YouTube\Contracts\Provider;
use CupOfTea\YouTube\Exceptions\UnauthorisedException;
use CupOfTea\YouTube\Contracts\Resource as ResourceContract;

use CupOfTea\YouTube\Traits\ListMethod;

class Search implements ArrayAccess, ResourceContract {
    
    use ListMethod;
    
    /**
	 * {@inheritdoc}
	 */
    protected $urlSegment = 'search';
}
