<?php namespace CupOfTea\YouTube\API\Resource;

use CupOfTea\YouTube\Contracts\Provider;
use CupOfTea\YouTube\Abstraction\Resource;
use CupOfTea\YouTube\Exceptions\UnauthorisedException;

use CupOfTea\YouTube\Traits\GetMethod;

class GuideCategories extends Resource {
    
    use GetMethod;
    
    /**
	 * {@inheritdoc}
	 */
    protected $urlSegment = 'guideCategories';
    
    
}
