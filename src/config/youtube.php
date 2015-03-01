<?php

return [
    
	/*
	|--------------------------------------------------------------------------
	| YouTube API key
	|--------------------------------------------------------------------------
	|
	| Your API key for unauthorised API requests.
    |
    | @required
    | @default ''
	|
	*/
	'api_key' => 'YOUR_KEY_HERE',
    
	/*
	|--------------------------------------------------------------------------
	| Redirect URL
	|--------------------------------------------------------------------------
	|
	| URL the Google User login & consent screen should redirect to.
    |
    | @required
    | @default ''
	|
	*/
    'redirect_url' => 'YOUR_REDIRECT_URL_HERE',
    
	/*
	|--------------------------------------------------------------------------
	| Automatic Login
	|--------------------------------------------------------------------------
	|
	| Wether or not this Package should try and login the user when he isn't authenticated.
    | This happens by first checking if an authentication token is set, and automatically request the additional permissions nessesary to proceed.
    | Next it will check if there is a code available in the request to obtain an authentication token.
    | If not, the Package will redirect the user to the Google Authentication screen.
    | The Package will do its best to land the user back on the page of origin.
    | Please note that this may not always be the shortest route to retrieve proper authentication,
    |  so if you are at any point in your application sure that the user isn't authenticated or needs additional permissions,
    |  please use the provider methods to achieve this.
    |
    | @default false
	|
	*/
    'auto_login' => false,
    
	/*
	|--------------------------------------------------------------------------
	| Scopes
	|--------------------------------------------------------------------------
	|
	| The scopes being requested.
	|
	*/
    
    'scopes' => [
        'https://www.googleapis.com/auth/plus.me',
		'https://www.googleapis.com/auth/plus.login',
		'https://www.googleapis.com/auth/plus.profile.emails.read',
        'https://www.googleapis.com/auth/youtube',
    ],
    
	/*
	|--------------------------------------------------------------------------
	| Access Type
	|--------------------------------------------------------------------------
	|
	| The access type being requested.
	|
	*/
    
    'access_type' => 'offline',
    
	/*
	|--------------------------------------------------------------------------
	| Fields
	|--------------------------------------------------------------------------
	|
	| Fields that should be retrieved for the YouTube::user() method.
	|
	*/
    
    'fields' => [
        /*
        |--------------------------------------------------------------------------
        | Google
        |--------------------------------------------------------------------------
        |
        | Fields from the Google Account.
        | Set to false if you don't want to retrieve any user info from the Google Account.
        |
        | @default 'name(familyName,givenName),emails/value,id'
        |
        */
        'google' => 'name(familyName,givenName),emails/value,id',
        
        /*
        |--------------------------------------------------------------------------
        | YouTube
        |--------------------------------------------------------------------------
        |
        | Fields from the YouTube Account.
        | Set to false if you don't want to retrieve any user info from the YouTube Account.
        | The items field will automatically be resolved, since for this action only one user (the authenticated user) is returned.
        | The snippet.thumbnails will automatically fall back to Default if High and Medium are not set.
        |
        | @default 'items(id,snippet(title,thumbnails(default/url,medium/url))'
        |
        */
        'youtube' => 'items(id,snippet(title,thumbnails(default/url,medium/url))',
    ],
    
	/*
	|--------------------------------------------------------------------------
	| Map
	|--------------------------------------------------------------------------
	|
	| How the API data will be mapped to the User Model or User Object
    | Will map to User Model when Integration is Enabled (see below)
    | If Integration is enabled below, you don't need to map the id value
	|
	*/
    
    'map' => [
        'youtubeId' => 'id',
        'username' => 'snippet.title',
        'name' => 'name.givenName',
        'surname' => 'name.familyName',
        'email' => 'emails.0.value',
        'avatar' => 'snippet.thumbnails.medium.url', // Automatically falls back to Default if Medium is not set.
    ]
    
	/*
	|--------------------------------------------------------------------------
	| Table
	|--------------------------------------------------------------------------
	|
	| Database table name to store refresh tokens.
    |
    | @default 'RefreshTokens'
	|
	*/
    
    'table' => 'RefreshTokens',
    
    /*
	|--------------------------------------------------------------------------
	| Integration Settings
	|--------------------------------------------------------------------------
	|
	| Settings for integration
	|
	*/
    
    'integration' => [
        /*
        |--------------------------------------------------------------------------
        | Enable Integration
        |--------------------------------------------------------------------------
        |
        | Integrate the authentication functionality with your own User model.
        | This will allow you to make authorised requests for a user without having to go throught the full login process.
        | User data retrieved from the API can also be stored in your User Table (if the nessesary fields are present).
        |
        | @default true
        |
        */
        'enabled' => true,
        
        /*
        |--------------------------------------------------------------------------
        | Raw Property
        |--------------------------------------------------------------------------
        |
        | Property that will contain the Raw Data retrieved from the API with the YouTube::user() method.
        |
        | @default 'raw_data'
        |
        */
        'raw_property' => 'raw_data',
        
        /*
        |--------------------------------------------------------------------------
        | Use YouTube ID as Primary Key
        |--------------------------------------------------------------------------
        |
        | Use the YouTube user ID as your Primary Key in your User Table.
        | Please note that your primary key must be a VARCHAR(24) in order for this to work.
        |
        | @default false
        |
        */
        'youtube_id_as_primary_key' => false,
        
        /*
        |--------------------------------------------------------------------------
        | Automatic Update
        |--------------------------------------------------------------------------
        |
        | Automatically update the User Table if data retrieved from the API has changed.
        |
        | @default false
        |
        */
        'auto_update' => false,
    ],
    
];
