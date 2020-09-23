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
    .sass('resources/sass/app.scss', 'public/css')
    .scripts([
        'resources/js/spa/common.js',
        'resources/js/spa/index.js',
        'resources/js/spa/cart.js',
        'resources/js/spa/login.js',
        'resources/js/spa/product.js',
        'resources/js/spa/products.js',
        'resources/js/spa/orders.js',
        'resources/js/spa/order.js',
        'resources/js/spa/router.js'
    ], 'public/js/spa.js');
