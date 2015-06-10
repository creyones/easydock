<?php namespace App\Providers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Parse\ParseClient;
use Parse\ParseUser;

class ParseServiceProvider extends ServiceProvider {

	/**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupConfig();
        $this->setupParse($this->app);
    }
    /**
     * Setup the config.
     *
     * @return void
     */
    protected function setupConfig()
    {
        $source = app_path() .'/../config/parse.php';
        $this->publishes([$source => config_path('parse.php')]);
        $this->mergeConfigFrom($source, 'parse');
    }
    /**
     * Setup parse.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    protected function setupParse(Application $app)
    {
        $config = $app->config->get('parse');
        ParseClient::initialize($config['app_id'], $config['rest_key'], $config['master_key']);

				try {
					$user = ParseUser::logIn(env('DB_ADMIN'), env('DB_ADMIN_PASSWORD'));
					// Do stuff after successful login.

				} catch (ParseException $error) {
					// The login failed. Check error to see why.
				}
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return [
            //
        ];
    }

}
