<?php namespace CupOfTea\YouTube\Resource\Channel;

use CupOfTea\YouTube\Abstraction\Resource;
use CupOfTea\YouTube\Traits\ListMethod;
use CupOfTea\YouTube\Traits\InsertMethod;
use CupOfTea\YouTube\Traits\UpdateMethod;
use CupOfTea\YouTube\Traits\DeleteMethod;

class Section extends Resource
{
    use ListMethod, InsertMethod, UpdateMethod, DeleteMethod;
    
    /**
     * {@inheritdoc}
     */
    protected $urlSegment = 'channelSections';
}
