<?php namespace CupOfTea\YouTube\API\Resource;

use ArrayAccess;
use CupOfTea\YouTube\Contracts\Provider;
use CupOfTea\YouTube\Exceptions\UnauthorisedException;
use CupOfTea\YouTube\Contracts\HasSubResources as HasSubResourcesContract;

class i18n implements HasSubResourcesContract{
    
    /**
	 * {@inheritdoc}
	 */
	protected $available_subresources = ['languages', 'regions'];
    
}
