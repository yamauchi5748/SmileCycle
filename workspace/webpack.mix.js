const mix = require('laravel-mix');
require('laravel-mix-sass-resources-loader');
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

/*
# npm run watch-poll

bladeに下記を挿入してください

<script src="{{ mix('js/app.js') }}" defer></script>
<link href="{{ mix('css/app.css') }}" rel="stylesheet">
*/
mix
.sassResources("./resources/sass/_variables.scss")
.browserSync({
    proxy: "nginx",
    port: 3000,
    watchOptions: {
        usePolling: true, 
        interval: 100
    },
    files: [
        "./resources/js/app.js",
        "./resources/js/components/*.vue",
        "./resources/js/components/*/*.vue",
        "./resources/sass/*.scss",
        "./resources/views/*.blade.php",
        "./resources/views/**/*.blade.php",
        "./resources/views/**/**/*.blade.php",
        "./routes/**/*"
    ],
    open: false,
    reloadOnRestart: true
})
    .js("resources/js/app.js", "public/js") 
    .sass("resources/sass/app.scss", "public/css")
    .version();
