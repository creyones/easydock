<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class FullCalendarServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     * Move FullCalendar CSS into public directory
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
                     'vendor/fullcalendar/dist/css' => public_path('css/vendor/fullcalendar'),
                     'vendor/fullcalendar/dist/js' => public_path('js/vendor/fullcalendar'),
                     'vendor/moment/min' => public_path('js/vendor/moment'),
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
