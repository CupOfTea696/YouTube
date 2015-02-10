<?php namespace CupOfTea\YouTube\Socialite\Two;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Laravel\Socialite\Contracts\Provider as ProviderContract;

class YouTubeProvider implements ProviderContract {

	/**
	 * The HTTP request instance.
	 *
	 * @var Request
	 */
	protected $request;

	/**
	 * The API key.
	 *
	 * @var string
	 */
	protected $apiKey;

	/**
	 * The client ID.
	 *
	 * @var string
	 */
	protected $clientId;

	/**
	 * The client secret.
	 *
	 * @var string
	 */
	protected $clientSecret;

	/**
	 * The scopes being requested.
	 *
	 * @var array
	 */
	protected $scopes = [
		'https://www.googleapis.com/auth/plus.me',
		'https://www.googleapis.com/auth/plus.login',
		'https://www.googleapis.com/auth/plus.profile.emails.read',
        'https://www.googleapis.com/auth/youtube',
	];

	/**
	 * The separating character for the requested scopes.
	 *
	 * @var string
	 */
	protected $scopeSeparator = ' ';

	/**
	 * The type of the encoding in the query.
	 *
	 * @var int Can be either PHP_QUERY_RFC3986 or PHP_QUERY_RFC1738.
	 */
	protected $encodingType = PHP_QUERY_RFC1738;

	/**
	 * Create a new provider instance.
	 *
	 * @param  Request  $request
	 * @param  string  $clientId
	 * @param  string  $clientSecret
	 * @param  string  $redirectUrl
	 * @return void
	 */
	public function __construct(Request $request, $apiKey, $clientId, $clientSecret, $redirectUrl)
	{
		$this->request = $request;
		$this->clientId = $clientId;
		$this->redirectUrl = $redirectUrl;
		$this->clientSecret = $clientSecret;
	}

	/**
	 * Get the authentication URL for the provider.
	 *
	 * @param  string  $state
	 * @return string
	 */
	protected function getAuthUrl($state)
	{
		return $this->buildAuthUrlFromBase('https://accounts.google.com/o/oauth2/auth', $state);
	}

	/**
	 * Get the token URL for the provider.
	 *
	 * @return string
	 */
	protected function getTokenUrl()
	{
		return 'https://accounts.google.com/o/oauth2/token';
	}

	/**
	 * Get the raw user for the given access token.
	 *
	 * @param  string  $token
	 * @return array
	 */
	protected function getUserByToken($token)
	{
		$response = $this->getHttpClient()->get('https://www.googleapis.com/plus/v1/people/me?',[
			'query' => [
				'prettyPrint' => 'false',
			],
			'headers' => [
				'Accept' => 'application/json',
				'Authorization' => 'Bearer ' . $token,
			],
		]);

		return json_decode($response->getBody(), true);
	}

	/**
	 * Map the raw user array to a Socialite User instance.
	 *
	 * @param  array  $user
	 * @return \Laravel\Socialite\User
	 */
	protected function mapUserToObject(array $user)
	{
		return (new User)->setRaw($user)->map([
			'id' => $user['id'], 'nickname' => array_get($user, 'nickname'), 'name' => $user['displayName'],
			'email' => $user['emails'][0]['value'], 'avatar' => array_get($user, 'image')['url'],
		]);
	}

	/**
	 * Redirect the user of the application to the provider's authentication screen.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function redirect()
	{
		$this->request->getSession()->set(
			'state', $state = sha1(time().$this->request->getSession()->get('_token'))
		);

		return new RedirectResponse($this->getAuthUrl($state));
	}

	/**
	 * Get the authentication URL for the provider.
	 *
	 * @param  string  $url
	 * @param  string  $state
	 * @return string
	 */
	protected function buildAuthUrlFromBase($url, $state)
	{
		$session = $this->request->getSession();

		return $url.'?'.http_build_query([
			'client_id' => $this->clientId, 'redirect_uri' => $this->redirectUrl,
			'scope' => $this->formatScopes($this->scopes, $this->scopeSeparator), 'state' => $state,
			'response_type' => 'code',
            'access_type' => 'offline',
		], '', '&', $this->encodingType );
	}

	/**
	 * Format the given scopes.
	 *
	 * @param  array  $scopes
	 * @param  string  $scopeSeparator
	 * @return string
	 */
	protected function formatScopes(array $scopes, $scopeSeparator)
	{
		return implode($scopeSeparator, $scopes);
	}

	/**
	 * {@inheritdoc}
	 */
	public function user()
	{
		if ($this->hasInvalidState())
		{
			throw new InvalidStateException;
		}

		$user = $this->mapUserToObject($this->getUserByToken(
			$tokens = $this->getAccessToken($this->getCode())['access_token']
		));

		return $user->setTokens($tokens);
	}

	/**
	 * Determine if the current request / session has a mismatching "state".
	 *
	 * @return bool
	 */
	protected function hasInvalidState()
	{
		$session = $this->request->getSession();

		return ! ($this->request->input('state') === $session->get('state'));
	}

	/**
	 * Get the access and refresh token for the given code.
	 *
	 * @param  string  $code
	 * @return array
	 */
	public function getTokens($code)
	{
		$response = $this->getHttpClient()->post($this->getTokenUrl(), [
			'body' => $this->getTokenFields($code),
		]);

		return $this->parseTokens($response->getBody());
	}

	/**
	 * Get the POST fields for the token request.
	 *
	 * @param  string  $code
	 * @return array
	 */
	protected function getTokenFields($code)
	{
		return array_add(
			parent::getTokenFields($code), 'grant_type', 'authorization_code'
		

	/**
	 * Get the access and refresh token from the token response body.
	 *
	 * @param  string  $body
	 * @return array
	 */
	protected function parseAccessToken($body)
	{
        $json = json_decode($body, true);
		return [
            'access_token' => $json['access_token'],
            'refresh_token' => $json['refresh_token'],
            'expires' => time() + $json['expires_in'] - 5,
        ];
	}

	/**
	 * Get the code from the request.
	 *
	 * @return string
	 */
	protected function getCode()
	{
		return $this->request->input('code');
	}

	/**
	 * Set the scopes of the requested access.
	 *
	 * @param  array  $scopes
	 * @return $this
	 */
	public function scopes(array $scopes)
	{
		$this->scopes = $scopes;

		return $this;
	}

	/**
	 * Get a fresh instance of the Guzzle HTTP client.
	 *
	 * @return \GuzzleHttp\Client
	 */
	protected function getHttpClient()
	{
		return new \GuzzleHttp\Client;
	}

	/**
	 * Set the request instance.
	 *
	 * @param  Request  $request
	 * @return $this
	 */
	public function setRequest(Request $request)
	{
		$this->request = $request;

		return $this;
	}

}
