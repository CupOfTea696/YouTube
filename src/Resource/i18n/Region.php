<?php namespace CupOfTea\YouTube\Resource\i18n;

use CupOfTea\YouTube\Abstraction\Resource;
use CupOfTea\YouTube\Traits\ListMethod;

class Region extends Resource
{
    use ListMethod;
    
    /**
     * {@inheritdoc}
     */
    protected $urlSegment = 'i18nRegion ';
}
