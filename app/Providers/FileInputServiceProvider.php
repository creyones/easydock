<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class FileInputServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     * Move FileInput CSS into public directory
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
                     'vendor/kartik-v/bootstrap-fileinput/css' => public_path('css/vendor/kartik-v/'),
                     'vendor/kartik-v/bootstrap-fileinput/js' => public_path('js/vendor/kartik-v/'),
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
