const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
  .js('resources/js/moment-timezone-with-data.min.js', 'public/js')
  .js('resources/js/moment-with-locales.min.js', 'public/js')
  .js('resources/js/bootstrap-datetimepicker.min.js', 'public/js')
  .vue()
  .sass('resources/sass/app.scss', 'public/css')
  .css('resources/css/elitasoft.css', 'public/css')
  .css('resources/css/bootstrap-datetimepicker.css', 'public/css')
;
