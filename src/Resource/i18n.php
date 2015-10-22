<?php namespace CupOfTea\YouTube\Resource;

use CupOfTea\YouTube\Abstraction\Resource;
use CupOfTea\YouTube\Traits\HasSubResources;

class i18n extends Resource
{
    use HasSubResources;
    
    /**
     * Available SubResources for this API.
     *
     * @var array
     */
    protected $available_subresources = ['language', 'region'];
}
