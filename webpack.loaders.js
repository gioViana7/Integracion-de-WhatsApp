const mix = require('laravel-mix');

/* eslint class-methods-use-this: ["error", { "exceptMethods": ["webpackRules", "webpackPlugins"] }] */
class Config {
  webpackRules() {
    return {
      enforce: 'pre',
      test: /\.(js|vue)$/,
      loader: 'eslint-loader',
      exclude: /node_modules/,
    };
  }
}

mix.extend('config', new Config());
