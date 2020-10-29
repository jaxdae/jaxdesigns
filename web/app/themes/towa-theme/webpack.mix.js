const mix = require('laravel-mix');
const path = require('path');
const dotenv = require('dotenv');

dotenv.config({ path: './../../../../.env' });

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 */

mix
  .setPublicPath('dist')

  .copyDirectory('resources/assets/static', 'dist/static')
  .copyDirectory('resources/assets/fonts', 'dist/fonts')

  .js('resources/main.js', 'dist/js')
  .sass('resources/styles/main.scss', 'dist/css')

  .options({
    processCssUrls: false,

    cssNano: {
      colormin: false,
    },
  })

  .webpackConfig({
    resolve: {
      extensions: ['*', '.js', '.vue', '.json', '.scss', '.css'],
      alias: {
        '@': path.resolve(__dirname),
        '@resources': path.resolve(__dirname, 'resources'),
        '@assets': path.resolve(__dirname, 'resources', 'assets'),
        '@components': path.resolve(__dirname, 'resources', 'components'),
        '@styles': path.resolve(__dirname, 'resources', 'styles'),
        '@store': path.resolve(__dirname, 'resources', 'store'),
      },
    },

    module: {
      rules: [
        {
          test: /node_modules\/(swiper|dom7)\/.+\.js$/,
          use: [
            {
              loader: 'babel-loader',
              options: mix.config.babel(),
            },
          ],
        },
      ],
    },

    output: {
      // The public path needs to be set to the root of the site so
      // Webpack can locate chunks at runtime.
      publicPath: '/app/themes/towa-theme/dist/',

      // We'll place all chunks in the `js` folder by default so we don't
      // need to worry about ignoring them in our version control system.
      chunkFilename: 'js/[name]-[hash].js',
    },
  })

  .browserSync({
    proxy: process.env.WP_HOME,
    files: [
      'lib/**/*.php',
      'resources/**/*.{php,twig}',
      'views/**/*.{php,twig}',
      'dist/js/**/*.js',
      'dist/css/**/*.css',
    ],
  });

if (process.env.npm_lifecycle_event !== 'hot') {
  mix.version();
}
