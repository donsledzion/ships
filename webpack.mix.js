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
    .js('resources/js/edit-board.js', 'public/js')
    .js('resources/js/create-game.js', 'public/js')
    .js('resources/js/game-board.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sourceMaps();
