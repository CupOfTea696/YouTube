<?php namespace CupOfTea\YouTube\API\Resource;

use CupOfTea\YouTube\Contracts\Provider;
use CupOfTea\YouTube\Abstraction\Resource;
use CupOfTea\YouTube\Exceptions\UnauthorisedException;

use CupOfTea\YouTube\Traits\ListMethod;

class Search extends Resource {
    
    use ListMethod;
    
    /**
	 * {@inheritdoc}
	 */
    protected $urlSegment = 'search';
}
