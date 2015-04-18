<?php namespace CupOfTea\YouTube\API\Resource\Channels;

use CupOfTea\YouTube\Contracts\Provider;
use CupOfTea\YouTube\Abstraction\Resource;
use CupOfTea\YouTube\Exceptions\UnauthorisedException;

use CupOfTea\YouTube\Traits\InsertMethod;

class Banners extends Resource {
    
    use InsertMethod;
    
    /**
	 * {@inheritdoc}
	 */
    protected $urlSegment = 'channelBanners';
    
    
}
