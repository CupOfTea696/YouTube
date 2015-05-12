<?php namespace CupOfTea\YouTube;

use CupOfTea\YouTube\Absctraction\User as AbstractUser;

class User extends AbstractUser {

	/**
	 * The user's access token.
	 *
	 * @var string
	 */
	public $access_token;
    
    /**
	 * The user's refresh token.
	 *
	 * @var string
	 */
    public $refresh_token;
    
    /**
	 * Access token expire time.
	 *
	 * @var int $time
	 */
    public $expires;

	/**
	 * Set the tokens on the user.
	 *
	 * @param  array  $tokens
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
