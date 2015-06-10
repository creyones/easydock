var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.less('app.less')
    .styles([
      'vendor/bootstrap-datepicker3.css',
      'vendor/font-awesome.css',
      'vendor/dataTables.bootstrap.css',
      'vendor/dataTables.fontAwesome.css',
      '../../vendor/kartik-v/bootstrap-fileinput/css/fileinput.css',
      'app.css'
    ], null, 'public/css')
    .scripts([
      'vendor/bootstrap-datepicker.js',
      'vendor/locales/bootstrap-datepicker.es.js',
      'vendor/jquery.dataTables.js',
      'vendor/dataTables.bootstrap.js',
      '../../vendor/kartik-v/bootstrap-fileinput/js/fileinput.js'
    ], null, 'public/js')
});
