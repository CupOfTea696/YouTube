<?php namespace CupOfTea\YouTube\Resource\Video;

use CupOfTea\YouTube\Abstraction\Resource;
use CupOfTea\YouTube\Traits\ListMethod;

class Category extends Resource
{
    use ListMethod;
    
    /**
     * {@inheritdoc}
     */
    protected $urlSegment = 'videoCategories';
}
