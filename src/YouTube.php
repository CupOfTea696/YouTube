<?php namespace CupOfTea\YouTube;

use Auth;
use Serializable;

use Illuminate\Http\Request;

use CupOfTea\Package\Package;
use CupOfTea\YouTube\Models\RefreshToken;
use CupOfTea\YouTube\Exceptions\InvalidStateException;
use CupOfTea\YouTube\Exceptions\UnauthorisedException;
use CupOfTea\YouTube\Exceptions\ResourceNotFoundException;
use CupOfTea\YouTube\Contracts\Provider as ProviderContract;

use Symfony\Component\HttpFoundation\RedirectResponse;

class YouTube implements ProviderContract, Serializable {

    use Package;
    
    const PACKAGE = 'CupOfTea/YouTube';
    const VERSION = '0.5.11-beta';
    
	/**
	 * Available Resources for this API.
	 *
	 * @var array
	 */
	protected $available_resources = ['activity', 'channel', 'guideCategory', 'i18n', 'playlist', 'search', 'subscription', 'thumbnail', 'video', 'watermark'];
    
	/**
	 * The API's base URL.
	 *
	 * @var array
	 */
    protected $base_url = 'https://www.googleapis.com';
    
	/**
	 * Initiated Resources.
	 *
	 * @var array
	 */
    protected $resources = [];
    
	/**
	 * The Session instance.
	 *
	 * @var Session
	 */
    protected $session;
    
    /**
	 * The HTTP request input.
	 *
	 * @var Array
	 */
    protected $input;
    
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
	 * The access and refresh tokens
	 *
	 * @var array
	 */
	protected $tokens;
    
	/**
	 * The access and refresh tokens
	 *
	 * @var \CupOfTea\YouTube\Models\RefreshToken
	 */
    protected $refresh_token;
    
	/**
	 * The type of the encoding in the query.
	 *
	 * @var int Can be either PHP_QUERY_RFC3986 or PHP_QUERY_RFC1738.
	 */
	protected $encodingType = PHP_QUERY_RFC1738;
    
	/**
     * Wether the user will be prompted to grant account access to your application each time they try to complete a particular action.
	 *
	 * @var bool
	 */
	protected $prompt = false;
    
	/**
	 * Create a new provider instance.
	 *
	 * @param  Request  $request
	 * @param  string  $clientId
	 * @param  string  $clientSecret
	 * @param  array   $cfg
	 * @return void
	 */
	public function __construct(Request $request)
	{
        try{
            $this->input = $request->old() + $request->all();
            $this->session = $request->getSession();
        } catch (\Exception $e) {
            $this->input = $request->all();
            $this->session = false;
        }
        
		$this->clientId = config('services.google.client_id');
		$this->clientSecret = config('services.google.client_secret');
        
        if ($this->session)
            $this->tokens = $this->session->get($this->package('dot') . '.tokens', []);
        
        if(config('youtube.integration.enabled') && !$this->tokens && Auth::check())
            $this->getRefreshTokenByUser(Auth::user());
	}
    
    /**
	 * Get this instance.
	 *
	 * @return $this
	 */
    public function instance(){
        return $this;
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
		return '/oauth2/v3/token';
	}
    
	/**
	 * Get the raw user for the given access token.
	 *
	 * @param  string  $token
	 * @return array
	 */
	protected function getUserByToken($token)
	{
		$response = $this->getHttpClient()->get('/plus/v1/people/me?',[
			'query' => [
				'prettyPrint' => 'false',
                'fields' => config('youtube.fields.google'),
			],
			'headers' => [
				'Authorization' => 'Bearer ' . $token,
			],
		]);
        
		return json_decode($response->getBody(), true);
	}
    
    protected function getRefreshTokenByUser($user){
        $this->tokens['refresh_token'] = RefreshToken::where($user->getKeyName(), $user->getKey())->first()->token;
    }
    
	/**
	 * Map the raw user array to an Auth Model or a YouTube User instance.
	 *
	 * @param  array  $user
	 * @return \CupOfTea\YouTube\User OR \App\User
	 */
	protected function mapUser(array $user, $additionalData = [])
	{
        foreach($user as $key => $value){
            if($key == 'items'){
                $user = array_merge($user, array_dot($user['items'][0], 'youtube.'));
            }elseif(is_array($value)){
                $user = array_merge($user, array_dot($value, 'google.' . $key . '.'));
            }else{
                $user['google.' . $key] = $value;
            }
            
            unset($user[$key]);
        }
        
        if(config('youtube.integration.enabled') && config('youtube.integration.youtube_id_as_primary_key')){
            $model = config('auth.model');
            $key = with(new $model)->getKeyName();
            
            config(['youtube.map.' . $key => 'youtube.id']);
        }
        
        $userData = [];
        foreach(config('youtube.map') as $key => $prop){
            $userData[$key] = array_dot($user)[$prop];
        }
        
        $userData = array_merge($userData, $additionalData);
        
        if(config('youtube.integration.enabled'))
            return $this->mapUserToModel($user, $userData); // auth.model
        
		return with(new User($additionalData))->map($userData)->setRaw($user)->setTokens($this->tokens);
	}
    
	/**
	 * Map the raw user array to an Auth Model instance.
	 *
	 * @param  array  $user
	 * @return \App\User
	 */
    protected function mapUserToModel($rawData, $userData)
    {
        $model = config('auth.model');
        
        if (config('youtube.integration.youtube_id_as_primary_key')) {
            $user = $model::firstOrNew([with(new $model)->getKeyName() => $rawData['youtube.id']]);
            $user->incrementing = false;
        } else {
            $user = $model::firstOrNew([array_search('youtube.id', config('youtube.map')) => $rawData['youtube.id']]);
        }
        
        $new = $user->isDirty();
        $user->fill($userData);
        $dirty = $user->isDirty();
        
        $user->isNew = $new;
        $user->{config('youtube.integration.raw_property')} = $rawData;
        $user->observe(new AuthModelObserver());
        
        $user->setRelation('refresh_token', $this->refreshToken($user));
        if (config('youtube.integration.auto_update') && $dirty) {
            $user->push();
        }
        
        return $user;
    }
    
    protected function refreshToken($user)
    {
        if($this->refresh_token)
            return $this->refresh_token;
        
        $this->refresh_token = RefreshToken::firstOrNew([$user->getKeyName() => $user->getKey()]);
        
        if ($this->tokens['refresh_token'])
            $this->refresh_token->token = $this->tokens['refresh_token'];
        
        return $this->refresh_token;
    }
    
    public function saveRefreshToken($user){
        if (!$this->tokens['refresh_token'])
            return $this;
        
        if ($this->refreshToken($user)->isDirty() && $this->refresh_token->token)
            $this->refresh_token->save();
        
        return $this;
    }
    
    /**
	 * Redirect the user of the application to the provider's authentication screen.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function redirect()
	{
        if (!$this->session)
            throw new \Exception('Method only available on HTTP Requests.');
        
		$this->session->put(
			$this->package('dot') . '.state', $state = sha1(time().$this->session->get('_token'))
		);
        
		return new RedirectResponse($this->getAuthUrl($state));
	}
    
    /**
	 * Process the code after user login.
	 *
	 * @return CupOfTea\YouTube\Contracts\Provider
	 */
    public function login(){
        if(!$this->session)
            throw new \Exception('Method only available on HTTP Requests.');
        
        if($code = $this->getCode()) {
            return $this->getTokensByCode($code);
        }
        
        if(!$this->isAuthenticated())
            return false;
        
        if(!$this->hasValidToken())
            return $this->refresh();
    }
    
    /**
	 * Manually login by a user.
	 *
	 * @return CupOfTea\YouTube\Contracts\Provider
	 */
    public function loginByUser($user){
        $this->getRefreshTokenByUser($user);
        
        return $this;
    }
    
    /**
	 * Prompt the user to grant account access to your application each time they try to complete a particular action.
	 *
	 * @return CupOfTea\YouTube\Contracts\Provider
	 */
    public function prompt(){
        $this->prompt = true;
        return $this;
    }
    
    public function isAuthenticated(){
        return array_key_exists('access_token', $this->tokens) || array_key_exists('refresh_token', $this->tokens);
    }
    
    public function revokeToken($token = false){
        if(!$this->tokenAvailable() && !$token)
            return $this;
        
        $response = $this->getHttpClient()->get('https://accounts.google.com/o/oauth2/revoke', [
			'query' => ['token' => $token ? $token : $this->hasValidToken() ? $this->tokens['access_token'] : array_get($this->tokens, 'refresh_token')],
		]);
        
        return $this;
    }
    
    /**
	 * Refresh the auth token. [handle this automatically? DB('Tokens', ['tokenId', 'token', 'key', 'userId']) key to encrypt session auth_token, use global key was well. re_token encrypted with global key]
	 *
	 * @return CupOfTea\YouTube\Contracts\Provider
	 */
    protected function refresh(){
        if(array_get($this->tokens, 'refresh_token'))
            return $this->getTokensByRefresh();
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
        $query = [
			'client_id' => $this->clientId, 'redirect_uri' => config('youtube.redirect_url'),
			'scope' => $this->formatScopes(config('youtube.scopes')), 'state' => $state,
			'response_type' => 'code',
            'access_type' => 'offline',
		];
        if($this->prompt)
            $query['approval_prompt'] = 'force';
        
		return $url.'?'.http_build_query($query, '', '&', $this->encodingType );
	}
    
	/**
	 * Format the given scopes.
	 *
	 * @param  array  $scopes
	 * @return string
	 */
	protected function formatScopes(array $scopes)
	{
		return implode(' ', $scopes);
	}
    
	/**
	 * {@inheritdoc}
	 */
	public function user($additionalData = [])
	{
        if (!$this->hasValidToken())
            if (!$this->login())
                throw new UnauthorisedException();
        
        $user = config('youtube.fields.google') ? $this->getUserByToken($this->tokens['access_token']) : [];
        if (config('youtube.fields.youtube'))
            $user = array_replace_recursive($user, $this->channel()->me(['fields' => config('youtube.fields.youtube')]));
        
        $user = $this->mapUser($user, $additionalData);
        
        if (config('youtube.integration.enabled') && $user->exists && !Auth::check())
            Auth::login($user, true);
        
        // Auth::login resets session, so store this again.
        if ($this->session)
            $this->session->put($this->package('dot') . '.tokens', $this->tokens);
        
        return $user;
	}
    
	/**
	 * Determine if the current request / session has a mismatching "state".
	 *
	 * @return bool
	 */
	protected function hasInvalidState()
	{
        $state = array_get($this->input, 'state');
        
		return ! ($state === $this->session->get($this->package('dot') . '.state'));
	}
    
	/**
	 * Get the access and refresh token for the given code.
	 *
	 * @param  string  $code
	 * @return array
	 */
	protected function getTokensByCode($code)
	{
        if($this->hasInvalidState())
			throw new InvalidStateException;
        
		$response = $this->getHttpClient()->post($this->getTokenUrl(), [
			'body' => $this->getTokenFields($code),
		]);
        $this->tokens = $this->parseTokens($response->getBody());
        $this->session->put($this->package('dot') . '.tokens', $this->tokens);
        
        return $this;
	}
    
    /**
	 * Get the POST fields for the token request.
	 *
	 * @param  string  $code
	 * @return array
	 */
	protected function getTokenFields($code)
	{
		return [
			'client_id' => $this->clientId, 'client_secret' => $this->clientSecret,
			'code' => $code, 'redirect_uri' => config('youtube.redirect_url'),
            'grant_type' => 'authorization_code',
		];
	}
    
	/**
	 * Get the access and refresh token for the given code.
	 *
	 * @param  string  $code
	 * @return array
	 */
	protected function getTokensByRefresh()
	{
        $response = $this->getHttpClient()->post($this->getTokenUrl(), [
			'body' => $this->getRefreshFields(),
		]);
        $this->tokens = $this->parseTokens($response->getBody());
        
        if($this->session)
            $this->session->put($this->package('dot') . '.tokens', $this->tokens);
        
        return $this;
	}
    
    /**
	 * Get the POST fields for the refresh request.
	 *
	 * @return array
	 */
	protected function getRefreshFields()
	{
		return [
			'client_id' => $this->clientId, 'client_secret' => $this->clientSecret,
			'refresh_token' => $this->tokens['refresh_token'], 'redirect_uri' => config('youtube.redirect_url'),
            'grant_type' => 'refresh_token',
		];
	}
    
    public function getTokens(){
        return $this->tokens;
    }
    
    public function setTokens($tokens)
    {
        if ($refresh_token = array_get($tokens, 'refresh_token')) {
            $this->tokens['refresh_token'] = $refresh_token;
        }
        
        if ($access_token = array_get($tokens, 'access_token')) {
            $this->tokens['access_token'] = $access_token;
        }
        
        if ($expires_in = array_get($tokens, 'expires_in') || $expires = array_get($tokens, 'expires')) {
            if ($expires_in) {
                $this->tokens['expires_in'] = $expires_in;
            }
            if (!$expires) {
                $this->tokens['expires'] = time() + $this->tokens['expires_in'] - 5;
            } else {
                $this->tokens['expires'] = $expires;
            }
        }
        
        return $this;
    }
    
	/**
	 * Get the access and refresh token from the token response body.
	 *
	 * @param  string  $body
	 * @return array
	 */
	protected function parseTokens($body)
	{
        $json = json_decode($body, true);
		return [
            'expires_in' => $json['expires_in'],
            'access_token' => $json['access_token'],
            'refresh_token' => array_get($json, 'refresh_token', array_get($this->tokens, 'refresh_token', false)),
            'expires' => time() + $json['expires_in'] - 5,
        ];
	}
    
    protected function hasValidToken(){
        return array_get($this->tokens, 'access_token') && $this->tokens['expires'] > time();
    }
    
    public function authenticatedMethodCalled(){
        if(!$this->hasValidToken())
            $this->refresh();
    }
    
	/**
	 * Get the code from the request.
	 *
	 * @return string
	 */
	protected function getCode()
	{
        return array_get($this->input, 'code');
	}
    
	/**
	 * Get a fresh instance of the Guzzle HTTP client.
	 *
	 * @return \GuzzleHttp\Client
	 */
	public function getHttpClient($base_url = false){
        $base_url = $base_url ? $base_url : $this->base_url;
        
        $defaultAgent = $this->package('v');
        $defaultAgent .= ' Guzzle/' . \GuzzleHttp\ClientInterface::VERSION;
        if(extension_loaded('curl'))
            $defaultAgent .= ' curl/' . curl_version()['version'];
        $defaultAgent .= ' PHP/' . PHP_VERSION;
        $defaultAgent .= ' (gzip)';
        
        return new \GuzzleHttp\Client([
            'base_url' => $base_url,
            'defaults' => [
                'headers' => [
                    'Accept' => 'application/json',
                    'Accept-Encoding' => 'gzip',
                    'User-Agent' => $defaultAgent,
                ],
            ],
        ]);
	}
    
	/**
	 * Set the request instance.
	 *
	 * @param  Request  $request
	 * @return $this
	 */
	public function setRequest(Request $request)
	{
        $this->input = $request->old() + $request->all();
        $this->session = $request->getSession();
        
		return $this;
	}
    
    /**
	 * Get a Resource.
	 *
	 * @param  string  $resource
	 * @return CupOfTea\YouTube\Contracts\Resource
	 */
    public function __call($resource, $a){
        $resource = strtolower($resource);
        if(!in_array($resource, $this->available_resources))
            throw new ResourceNotFoundException(ucfirst($resource));
        
        if($instance = in_array($resource, $this->resources))
            return $instance;
        
        $instance = __NAMESPACE__ . '\\Resource\\' . ucfirst($resource);
        return $this->resources[$resource] = new $instance($this, $this->session);
    }
    
    public function serialize(){
        return serialize([
            'tokens' => $this->tokens,
        ]);
    }
    
    public function unserialize($data){
        $array = unserialize($data);
        
        $this->clientId = config('services.google.client_id');
        $this->clientSecret = config('services.google.client_secret');
        $this->tokens = $array['tokens'];
    }
    
    /**
     * Aliases
     *
     */
    
    /**
     * Me
     *
     * @alias this.user
     */
    public function me(){
        return $this->user();
    }
    
    /**
     * Avatar
     *
     * @alias this.channels.my.avatar
     */
    public function avatar($size, $fallback = true){
        return $this->channel()->my()->avatar($size, $fallback);
    }

}
