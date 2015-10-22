<?php namespace CupOfTea\YouTube\Resource;

use CupOfTea\YouTube\Abstraction\Resource;
use CupOfTea\YouTube\Traits\HasSubResources;
use CupOfTea\YouTube\Traits\ListMethod;
use CupOfTea\YouTube\Traits\InsertMethod;
use CupOfTea\YouTube\Traits\UpdateMethod;
use CupOfTea\YouTube\Traits\DeleteMethod;

class Playlist extends Resource
{
    use ListMethod, InsertMethod, UpdateMethod, DeleteMethod,
        HasSubResources;
    
    /**
     * Available SubResources for this API.
     *
     * @var array
     */
    protected $available_subresources = ['item'];
    
    /**
     * {@inheritdoc}
     */
    protected $urlSegment = 'playlists';
}
