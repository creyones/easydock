<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BootstrapServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     * Move Bootstrap CSS into public directory
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
                     'components/font-awesome/css' => public_path('css/vendor/font-awesome'),
        ], 'public');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

}
