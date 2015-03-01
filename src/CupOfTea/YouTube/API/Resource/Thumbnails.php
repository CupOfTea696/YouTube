<?php namespace CupOfTea\YouTube\API\Resource;

use ArrayAccess;
use CupOfTea\YouTube\Contracts\Provider;
use CupOfTea\YouTube\Exceptions\UnauthorisedException;
use CupOfTea\YouTube\Contracts\Resource as ResourceContract;

use CupOfTea\YouTube\Traits\SetMethod;

class Activities implements ArrayAccess, ResourceContract {
    
    use SetMethod;
    
    /**
	 * {@inheritdoc}
	 */
    protected $urlSegment = 'thumbnails';
}
