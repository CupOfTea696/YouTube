<?php namespace CupOfTea\YouTube\API\Resource;

use ArrayAccess;
use CupOfTea\YouTube\Contracts\Provider;
use CupOfTea\YouTube\Exceptions\UnauthorisedException;
use CupOfTea\YouTube\Contracts\Resource as ResourceContract;

use CupOfTea\YouTube\Traits\GetMethod;

class GuideCategories implements ArrayAccess, ResourceContract {
    
    use GetMethod;
    
    /**
	 * {@inheritdoc}
	 */
    protected $urlSegment = 'guideCategories';
    
    
}
