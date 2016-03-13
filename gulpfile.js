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
      'vendor/bootstrap-datepicker/bootstrap-datepicker3.css',
      'vendor/font-awesome/font-awesome.css',
      'vendor/datatables/dataTables.bootstrap.css',
      'vendor/kartik-v/fileinput.css',
      'app.css'
    ], null, 'public/css')
    .scripts([
      'vendor/bootstrap-datepicker/bootstrap-datepicker.js',
      'vendor/bootstrap-datepicker/bootstrap-datepicker.es.js',
      'vendor/datatables/jquery.dataTables.js',
      'vendor/datatables/dataTables.bootstrap.js',
      'vendor/kartik-v/fileinput.js',
      'vendor/kartik-v/fileinput_locale_es.js'
    ], null, 'public/js')
});
