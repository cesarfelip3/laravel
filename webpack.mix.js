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

mix.options({
    processCssUrls: true
});

mix.styles([
    'node_modules/animate.css/animate.min.css',
], 'public/css/vendor.css').version();

mix
    .js('resources/assets/js/app.js', 'public/js')
    .sourceMaps()
    .sass('resources/assets/sass/app.scss', 'public/css')
    .sourceMaps()
    .version();
