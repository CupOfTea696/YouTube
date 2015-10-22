<?php namespace CupOfTea\YouTube\Resource\Channel;

use CupOfTea\YouTube\Abstraction\Resource;
use CupOfTea\YouTube\Traits\InsertMethod;

class Banner extends Resource
{
    use InsertMethod;
    
    /**
     * {@inheritdoc}
     */
    protected $urlSegment = 'channelBanners';
}
