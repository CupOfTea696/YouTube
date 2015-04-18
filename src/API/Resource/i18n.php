<?php namespace CupOfTea\YouTube\API\Resource;

use CupOfTea\YouTube\Contracts\Provider;
use CupOfTea\YouTube\Abstraction\Resource;
use CupOfTea\YouTube\Exceptions\UnauthorisedException;
use CupOfTea\YouTube\Traits\HasSubResources;

class i18n extends Resource{
    
    use HasSubResources;
    
    /**
	 * Available SubResources for this API.
	 *
	 * @var array
	 */
	protected $available_subresources = ['languages', 'regions'];
    
}
