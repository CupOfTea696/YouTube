<?php namespace CupOfTea\YouTube\Resource;

use CupOfTea\YouTube\Contracts\Provider;
use CupOfTea\YouTube\Abstraction\Resource;
use CupOfTea\YouTube\Exceptions\UnauthorisedException;

use CupOfTea\YouTube\Traits\GetMethod, CupOfTea\YouTube\Traits\InsertMethod;
    CupOfTea\YouTube\Traits\DeleteMethod

class Subscriptions extends Resource {
    
    use GetMethod, InsertMethod, DeleteMethod;
    
    /**
	 * {@inheritdoc}
	 */
    protected $urlSegment = 'subscriptions';
}
