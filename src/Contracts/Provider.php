<?php namespace CupOfTea\YouTube\Contracts;

interface Provider
{
    /**
     * Redirect the user to the authentication page for the provider.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function login();
    
    /**
     * Get the User instance for the authenticated user.
     *
     * @return \CupOfTea\YouTube\Contracts\User
     */
    public function user();
}
