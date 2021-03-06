<?php namespace CupOfTea\YouTube\Resource;

use CupOfTea\YouTube\Abstraction\Resource;
use CupOfTea\YouTube\Traits\ListMethod;

class Search extends Resource
{
    use ListMethod;
    
    /**
     * {@inheritdoc}
     */
    protected $urlSegment = 'search';
}
