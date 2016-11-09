<?php

return [
    
    /*
     *--------------------------------------------------------------------------
     * YouTube API key
     *--------------------------------------------------------------------------
     *
     * Your API key for unauthorised API requests.
     *
     * @required
     * @default ''
     *
     */
    'api_key' => 'YOUR_KEY_HERE',
    
    /*
     *--------------------------------------------------------------------------
     * Redirect URL
     *--------------------------------------------------------------------------
     *
     * URL the Google User login & consent screen should redirect to.
     *
     * @required
     * @default ''
     *
     */
    'redirect_url' => 'YOUR_REDIRECT_URL_HERE',
    
    /*
     *--------------------------------------------------------------------------
     * @TODO Automatic Login
     *--------------------------------------------------------------------------
     *
     * Wether or not this Package should try and login the user when he isn't authenticated.
     * This happens by first checking if an authentication token is set, and automatically request the additional permissions nessesary to proceed.
     * Next it will check if there is a code available in the request to obtain an authentication token.
     * If not, the Package will redirect the user to the Google Authentication screen.
     * The Package will do its best to land the user back on the page of origin.
     * Please note that this may not always be the shortest route to retrieve proper authentication,
     *  so if you are at any point in your application sure that the user isn't authenticated or needs additional permissions,
     *  please use the provider methods to achieve this.
     *
     * @default false
     *
     */
    'auto_login' => false,
    
    /*
     *--------------------------------------------------------------------------
     * Scopes
     *--------------------------------------------------------------------------
     *
     * The scopes being requested.
     * @default [
     *    'https://www.googleapis.com/auth/plus.me',
     *    'https://www.googleapis.com/auth/plus.login',
     *    'https://www.googleapis.com/auth/plus.profile.emails.read',
     *    'https://www.googleapis.com/auth/youtube',
     * ]
     *
     */
    
    'scopes' => [
        'https://www.googleapis.com/auth/plus.me',
        'https://www.googleapis.com/auth/plus.login',
        'https://www.googleapis.com/auth/plus.profile.emails.read',
        'https://www.googleapis.com/auth/youtube',
    ],
    
    /*
     *--------------------------------------------------------------------------
     * Access Type
     *--------------------------------------------------------------------------
     *
     * The access type being requested.
     * @default 'Offline'
     *
     */
    
    'access_type' => 'offline',
    
    /*
     *--------------------------------------------------------------------------
     * Fields
     *--------------------------------------------------------------------------
     *
     * Fields that should be retrieved for the YouTube::user() method.
     *
     */
    
    'fields' => [
        /*
         *--------------------------------------------------------------------------
         * Google
         *--------------------------------------------------------------------------
         *
         * Fields from the Google Account. (Plus/Person Resource)
         * Set to false if you don't want to retrieve any user info from the Google Account.
         * Note that the data returned from this API is unpredictable, since the user may
         *  not have connected their YouTube account to their Google+ account yet. If the YouTube
         *  account is connected to a Google+ Page rather than a Profile, certain data will not be present
         *  either. If you do need certain data that may otherwise not be present, you may choose to ask the
         *  user for additional permissions using only the scopes for accessing their Google+ data or YouTube data.
         *  @see https://developers.google.com/+/web/signin/incremental-auth for more info on Incremental Authorisation.
         *
         * @default  false
         * @link     https://developers.google.com/+/api/v1/people/get
         *
         */
        'google' => false,
        
        /*
         *--------------------------------------------------------------------------
         * YouTube
         *--------------------------------------------------------------------------
         *
         * Fields from the YouTube Account (YouTube/Channel Resource)
         * Set to false if you don't want to retrieve any user info from the YouTube Account.
         * The items field will automatically be resolved, since for this action only one user (the authenticated user) is returned.
         * The snippet.thumbnails will automatically fall back to Default if High and Medium are not set.
         *
         * @default  'items(id,snippet(title,thumbnails(default,medium)))'
         * @link     https://developers.google.com/youtube/v3/docs/channels/list
         *
         */
        'youtube' => 'items(id,snippet(title,thumbnails(default,medium)))',
    ],
    
    /*
     *--------------------------------------------------------------------------
     * Map
     *--------------------------------------------------------------------------
     *
     * How the API data will be mapped to the User Model or User Object
     * Will map to User Model when Integration is Enabled (see below)
     * If Use YouTube ID as Primary Key is Enabled below, you don't need to map the youtube.id value
     * @TODO: The property youtube.snippet.thumbnails will automatically fall back a to smaller size if the size requested isn't present.
     * Please note that all properties are prefixed by their respective API source.
     *
     * @default [
     *     'youtubeId' => 'youtube.id',
     *     'username' => 'youtube.snippet.title',
     *     'email' => 'google.emails.0.value',
     *     'avatar' => 'youtube.snippet.thumbnails.medium.url',
     * ]
     *
     */
    
    'map' => [
        'youtubeId' => 'youtube.id',
        'username' => 'youtube.snippet.title',
        'avatar' => 'youtube.snippet.thumbnails.medium.url',
    ],
    
    /*
     *--------------------------------------------------------------------------
     * Table
     *--------------------------------------------------------------------------
     *
     * Database table name to store refresh tokens.
     *
     * @default 'RefreshTokens'
     *
     */
    
    'table' => 'RefreshTokens',
    
    /*
     *--------------------------------------------------------------------------
     * Integration Settings
     *--------------------------------------------------------------------------
     *
     * Settings for auth integration
     *
     */
    
    'integration' => [
        /*
         *--------------------------------------------------------------------------
         * Enable Integration
         *--------------------------------------------------------------------------
         *
         * Integrate the authentication functionality with your own User model.
         * This will allow you to make authorised requests for a user without having to go throught the full login process.
         * User data retrieved from the API can also be stored in your User Table (if the nessesary fields are present).
         *
         * @default true
         *
         */
        'enabled' => true,
        
        /*
         *--------------------------------------------------------------------------
         * Raw Property
         *--------------------------------------------------------------------------
         *
         * Property that will contain the Raw Data retrieved from the API with the YouTube::user() method.
         *
         * @default 'raw_data'
         *
         */
        'raw_property' => 'raw_data',
        
        /*
         *--------------------------------------------------------------------------
         * Use YouTube ID as Primary Key
         *--------------------------------------------------------------------------
         *
         * Use the YouTube user ID as your Primary Key in your User Table.
         * Please note that your primary key must be a VARCHAR(24) in order for this to work.
         *
         * @default false
         *
         */
        'youtube_id_as_primary_key' => false,
        
        /*
         *--------------------------------------------------------------------------
         * Automatic Update
         *--------------------------------------------------------------------------
         *
         * Automatically update the User Table if data retrieved from the API has changed.
         *
         * @default false
         *
         */
        'auto_update' => false,
    ],
    
];
