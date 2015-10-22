<?php namespace CupOfTea\YouTube\Resource;

use CupOfTea\YouTube\Abstraction\Resource;
use CupOfTea\YouTube\Traits\HasSubResources;
use CupOfTea\YouTube\Traits\ListMethod;
use CupOfTea\YouTube\Traits\InsertMethod;
use CupOfTea\YouTube\Traits\UpdateMethod;
use CupOfTea\YouTube\Traits\DeleteMethod;
use CupOfTea\YouTube\Traits\RateMethod;
use CupOfTea\YouTube\Traits\GetRatingMethod;

class Video extends Resource
{
    use ListMethod, InsertMethod, UpdateMethod, DeleteMethod, RateMethod, GetRatingMethod,
        HasSubResources;
    
    /**
     * Available SubResources for this API.
     *
     * @var array
     */
    protected $available_subresources = ['category'];
    
    /**
     * {@inheritdoc}
     */
    protected $urlSegment = 'videos';
}
