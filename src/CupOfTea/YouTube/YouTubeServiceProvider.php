<?php namespace CupOfTea\YouTube;

use Illuminate\Support\ServiceProvider;

class YouTubeServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;
    
    protected function array_dot_assoc($array, $prepend = ''){
		$results = [];

		foreach ($array as $key => $value)
		{
			if (is_array($value) && count(array_filter(array_keys($value), 'is_string')))
			{
				$results = array_merge($results, $this->array_dot_assoc($value, $prepend.$key.'.'));
			}
			else
			{
				$results[$prepend.$key] = $value;
			}
		}

		return $results;
    }
    
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot(){
        $this->publishes([
            __DIR__.'/../../config/youtube.php' => config_path('youtube.php'),
        ], 'config');
        
        $this->publishes([
            __DIR__.'/../../database/migrations/' => base_path('/database/migrations')
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
            __DIR__.'/../../config/youtube.php', 'youtube'
        );
        
		$this->app->bindShared('CupOfTea\YouTube\Contracts\Factory', function($app)
		{
            $config = $this->app['config']['services.google'];
            $ytConfig = $this->array_dot_assoc(array_add($this->app['config']['youtube'], 'auth_model', $this->app['config']['auth.model']));
            
			return new API\Provider(
                $this->app['request'], $config['client_id'],
                $config['client_secret'], $ytConfig
            );
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
