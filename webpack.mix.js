const mix = require('laravel-mix');
require('mix-env-file');
require('./webpack.loaders');

const tailwindcss = require('tailwindcss');

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
  .env(process.env.ENV_FILE)
  .config()
  .options({
    processCssUrls: false,
    postCss: [tailwindcss('./tailwind.config.js')],
  });

if (process.env.NODE_ENV === 'development') mix.sourceMaps();
