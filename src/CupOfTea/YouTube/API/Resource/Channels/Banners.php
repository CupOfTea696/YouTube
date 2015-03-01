<?php namespace CupOfTea\YouTube\API\Resource\Channels;

use ArrayAccess;
use CupOfTea\YouTube\Contracts\Provider;
use CupOfTea\YouTube\Exceptions\UnauthorisedException;
use CupOfTea\YouTube\Contracts\Resource as ResourceContract;

use CupOfTea\YouTube\Traits\InsertMethod;

class Banners implements ArrayAccess, ResourceContract {
    
    use InsertMethod;
    
    /**
	 * {@inheritdoc}
	 */
    protected $urlSegment = 'channelBanners';
    
    
}
