<?php namespace CupOfTea\YouTube\Resource\Playlists;

use CupOfTea\YouTube\Contracts\Provider;
use CupOfTea\YouTube\Abstraction\Resource;
use CupOfTea\YouTube\Exceptions\UnauthorisedException;

use CupOfTea\YouTube\Traits\ListMethod, CupOfTea\YouTube\Traits\InsertMethod,
    CupOfTea\YouTube\Traits\UpdateMethod, CupOfTea\YouTube\Traits\DeleteMethod;

class Items extends Resource {
    
    use ListMethod, InsertMethod, UpdateMethod, DeleteMethod;
    
    /**
	 * {@inheritdoc}
	 */
    protected $urlSegment = 'playlistItems';
    
    
}
