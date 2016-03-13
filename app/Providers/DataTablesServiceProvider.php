<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class DataTablesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     * Move DataTables CSS into public directory
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
                     'vendor/datatables/datatables/media/css' => public_path('css/vendor/datatables/'),
                     'vendor/datatables/datatables/media/js' => public_path('js/vendor/datatables/'),
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
