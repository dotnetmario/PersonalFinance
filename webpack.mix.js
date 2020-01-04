const mix = require('laravel-mix');

// define @ as /resources folder entry point
mix.webpackConfig({
   resolve: {
      extensions: ['.js', '.vue'],
      alias: {
         '@': __dirname + '/resources'
      }
   }
});


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

// // 1. A single src and output path.
// mix.js('src/app.js', 'dist/app.js');

// // 2. For additional src files that should be
// // bundled together:
// mix.js([
//     'src/app.js',
//     'src/another.js'
// ], 'dist/app.js');

// // 3. For multiple entry/output points:
// mix.js('src/app.js', 'dist/')
//    .js('src/forum.js', 'dist/');

mix.js([
      'resources/js/app.js',
      'public/js/sb-admin-2.js',
   ], 'public/js')
   .sass('resources/sass/app.scss', 'public/css');


// mix.js('resources/js/app.js', 'public/js')
//    // .js('public/js/sb_main.min.js', 'public/js')
//    .sass('resources/sass/app.scss', 'public/css');
