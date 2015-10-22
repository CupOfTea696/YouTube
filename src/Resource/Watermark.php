<?php namespace CupOfTea\YouTube\Resource;

use CupOfTea\YouTube\Abstraction\Resource;
use CupOfTea\YouTube\Traits\SetMethod;
use CupOfTea\YouTube\Traits\UnsetMethod;

class Watermark extends Resource
{
    use SetMethod, UnsetMethod;
    
    /**
     * {@inheritdoc}
     */
    protected $urlSegment = 'watermarks';
}
