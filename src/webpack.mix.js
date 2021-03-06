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

mix.setPublicPath('public')
    .version()
    .js('resources/js/rolevue.js', 'public/js/rolevue.js')
    .vue()
    .postCss('resources/css/rolevue.css', 'public/css/rolevue.css', [
        require('postcss-import'),
        require('tailwindcss'),
        require('autoprefixer'),
    ]).vue();
