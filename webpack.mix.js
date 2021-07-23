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

mix.sass('./resources/sass/stisla/components.scss', 'public/assets/css')
    .sass('./resources/sass/stisla/style.scss', 'public/assets/css')
    .sass('./resources/sass/guest/style.scss', 'public/assets/guest/css')
    .js('./resources/js/stisla/app.js', 'public/assets/js');

