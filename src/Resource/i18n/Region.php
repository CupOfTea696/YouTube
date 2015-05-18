<?php namespace CupOfTea\YouTube\Resource\i18n;

use CupOfTea\YouTube\Contracts\Provider;
use CupOfTea\YouTube\Abstraction\Resource;
use CupOfTea\YouTube\Exceptions\UnauthorisedException;

use CupOfTea\YouTube\Traits\ListMethod, CupOfTea\YouTube\Traits\InsertMethod;

class Region extends Resource {
    
    use ListMethod;
    
    /**
	 * {@inheritdoc}
	 */
    protected $urlSegment = 'i18nRegion ';
}
