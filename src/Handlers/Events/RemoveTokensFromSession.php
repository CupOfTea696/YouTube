<?php namespace CupOfTea\YouTube\Handlers\Events;

use Session;
use CupOfTea\YouTube\YouTube;

class RemoveTokensFromSession
{
    /**
     * Create the event handler.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    
    /**
     * Handle the event.
     *
     * @param  UserWasActive  $event
     * @return void
     */
    public function handle($event)
    {
        if (config('youtube.integration.enabled')) {
            Session::forget(YouTube::package('dot'));
        }
    }
}
