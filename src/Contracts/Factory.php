<?php namespace CupOfTea\YouTube\Contracts;

interface Factory
{
    /**
     * Get an OAuth provider implementation.
     *
     * @param  string  $driver
     * @return \CupOfTea\YouTube\Contracts\Provider
     */
    public function driver($driver = null);
}
