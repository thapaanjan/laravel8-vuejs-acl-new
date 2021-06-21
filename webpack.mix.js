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

mix.scripts([
    'node_modules/jquery/dist/jquery.js',
    'resources/js/design_scripts/pooper.min.js',
    "node_modules/bootstrap/dist/js/bootstrap.js",
    'resources/js/design_scripts/toastr.min.js',
], 'public/js/auth.js');

mix.scripts([
    'resources/js/design_scripts/custom.min.js',
    'resources/js/design_scripts/toastr.min.js',
], 'public/js/custom.js');

mix.scripts([
    'node_modules/jquery/dist/jquery.js',
    'resources/js/design_scripts/pooper.min.js',
    "node_modules/bootstrap/dist/js/bootstrap.js",
    "node_modules/vue/dist/vue.min.js",
    "node_modules/axios/dist/axios.js",
    'node_modules/sweetalert2/dist/sweetalert2.min.js',
    "node_modules/vue-multiselect/dist/vue-multiselect.min.js",
    "node_modules/moment/min/moment.min.js",
    "node_modules/moment-timezone/builds/moment-timezone-with-data.min.js",
    "node_modules/underscore/underscore.js",
], 'public/js/front.js');

mix.js("resources/js/main.js", "public/js/main.js").vue();


// Main CSS file
mix.styles([
    "resources/css/style.min.css",
    "node_modules/vue-multiselect/dist/vue-multiselect.min.css",
    "resources/css/toastr.min.css",
], "public/css/admin.css");

//Auth CSS file
mix.styles([
    "resources/css/auth.css",
], "public/css/auth.css");