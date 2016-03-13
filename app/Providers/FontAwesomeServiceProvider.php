<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class FontAwesomeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     * Move FontAwesome CSS into public directory
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
                     'vendor/components/font-awesome/css' => public_path('css/vendor/font-awesome'),
                     'vendor/components/font-awesome/fonts' => public_path('fonts/vendor/'),
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
