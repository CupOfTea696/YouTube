<?php namespace CupOfTea\YouTube\API\Resource;

use ArrayAccess;
use CupOfTea\YouTube\Contracts\Provider;
use CupOfTea\YouTube\Exceptions\UnauthorisedException;
use CupOfTea\YouTube\Contracts\Resource as ResourceContract;

use CupOfTea\YouTube\Traits\GetMethod, CupOfTea\YouTube\Traits\InsertMethod;
    CupOfTea\YouTube\Traits\DeleteMethod

class Activities implements ArrayAccess, ResourceContract {
    
    use GetMethod, InsertMethod, DeleteMethod;
    
    /**
	 * {@inheritdoc}
	 */
    protected $urlSegment = 'subscriptions';
}
