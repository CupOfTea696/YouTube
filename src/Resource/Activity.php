<?php namespace CupOfTea\YouTube\Resource;

use CupOfTea\YouTube\Abstraction\Resource;
use CupOfTea\YouTube\Traits\ListMethod;
use CupOfTea\YouTube\Traits\InsertMethod;

class Activity extends Resource
{
    use ListMethod, InsertMethod;
    
    /**
     * {@inheritdoc}
     */
    protected $urlSegment = 'activities';
}
