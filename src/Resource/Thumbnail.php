<?php namespace CupOfTea\YouTube\Resource;

use CupOfTea\YouTube\Abstraction\Resource;
use CupOfTea\YouTube\Traits\SetMethod;

class Thumbnail extends Resource
{
    use SetMethod;
    
    /**
     * {@inheritdoc}
     */
    protected $urlSegment = 'thumbnails';
}
