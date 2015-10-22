<?php namespace CupOfTea\YouTube\Resource;

use CupOfTea\YouTube\Abstraction\Resource;
use CupOfTea\YouTube\Traits\HasSubResources;
use CupOfTea\YouTube\Traits\ListMethod;
use CupOfTea\YouTube\Traits\UpdateMethod;

class Channel extends Resource
{
    use ListMethod, UpdateMethod,
        HasSubResources;
    
    /**
     * Available SubResources for this API.
     *
     * @var array
     */
    protected $available_subresources = ['banner', 'section'];
    
    /**
     * {@inheritdoc}
     */
    protected $urlSegment = 'channels';
    
    public function me($parameters = [])
    {
        $this->authenticated();
        $this->parameters = array_replace($this->parameters, $parameters);
        $this->part(['id', 'snippet']);
        $this->parameters['mine'] = 'true';
        
        return $this->list($this->parameters);
    }
}
