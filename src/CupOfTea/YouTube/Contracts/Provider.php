<?php namespace CupOfTea\YouTube\Contracts;

interface Provider {
    
	/**
	 * Redirect the user to the authentication page for the provider.
	 *
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 */
	public function login();
    
	/**
	 * Refresh the auth token. [handle this automatically? DB('Tokens', ['tokenId', 'token', 'key', 'userId']) key to encrypt session auth_token, use global key was well. re_token encrypted with global key]
	 *
	 * @return CupOfTea\YouTube\Contracts\Provider
	 */
	public function refresh();
    
	/**
	 * Get the User instance for the authenticated user.
	 *
	 * @return \CupOfTea\YouTube\Contracts\User
	 */
	public function user();

}
