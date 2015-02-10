<?php namespace CupOfTea\YouTube\Socialite\Two;

use Laravel\Socialite\AbstractUser;

class User extends AbstractUser {

	/**
	 * The user's access token.
	 *
	 * @var string
	 */
	public $access_token;
    public $refresh_token;
    public $expires;

	/**
	 * Set the token on the user.
	 *
	 * @param  string  $token
	 * @return $this
	 */
	public function setTokens($tokens)
	{
		$this->access_token = $tokens['access_token'];
        $this->refresh_token = $tokens['refresh_token'];
        $this->expires = $tokens['expires'];

		return $this;
	}

}
