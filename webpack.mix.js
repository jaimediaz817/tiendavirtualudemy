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

/**
 *     'resources/vendor/js/jquery3.5.1.js',
    'resources/vendor/js/bootstrap.min.js',
 */

mix.styles([
    'resources/vendor/css/all.min.css',
    'resources/vendor/css/adminlte.min.css',
    'resources/vendor/css/adminlte.min.css',
    'resources/vendor/css/config.css'
], 'public/css/plantilla.css')
.js('resources/js/app.js', 'public/js') // jquery, bootstrap, Vuejs
.scripts([
    'resources/vendor/js/adminlte.min.js',
    'resources/vendor/js/demo.js'
], 'public/js/plantilla.js')
.copy('resources/vendor/fontawesome/webfonts', 'public/webfonts')
.copy('resources/vendor/img', 'public/img');