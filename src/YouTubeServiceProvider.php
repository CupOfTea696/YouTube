<?php namespace CupOfTea\YouTube;

use CupOfTea\Package\ServiceProvider;

class YouTubeServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;
    
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot(){
        $this->publishes([
            __DIR__.'/../config/youtube.php' => config_path('youtube.php'),
        ], 'config');
        
        $this->publishes([
            __DIR__.'/../database/migrations/' => base_path('/database/migrations')
        ], 'migrations');
    }

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->mergeConfigFrom(
            __DIR__.'/../config/youtube.php', 'youtube'
        );
        
		$this->app->bindShared('CupOfTea\YouTube\Contracts\Factory', function($app)
		{
            $config = $this->app['config']['services.google'];
            $ytConfig = array_add($this->app['config']['youtube'], 'auth_model', $this->app['config']['auth.model']);
            
			return new YouTube($this->app['request']);
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return ['CupOfTea\YouTube\Contracts\Factory'];
	}

}
