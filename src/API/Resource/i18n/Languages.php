<?php namespace CupOfTea\YouTube\API\Resource\i18n;

use CupOfTea\YouTube\Contracts\Provider;
use CupOfTea\YouTube\Abstraction\Resource;
use CupOfTea\YouTube\Exceptions\UnauthorisedException;

use CupOfTea\YouTube\Traits\GetMethod, CupOfTea\YouTube\Traits\InsertMethod;

class Languages extends Resource {
    
    use GetMethod;
    
    /**
	 * {@inheritdoc}
	 */
    protected $urlSegment = 'i18nLanguages';
}
