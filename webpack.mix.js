let mix = require('laravel-mix');

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

mix.js(['resources/assets/js/bootstrap.bundle.js',], 'public/js')
   .sass('resources/assets/sass/bootstrap.scss', 'public/css')
    .copy('resources/assets/js/jquery.min.js', 'public/js/jquery.js');