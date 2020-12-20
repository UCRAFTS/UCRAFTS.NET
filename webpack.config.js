const Encore = require('@symfony/webpack-encore');
const CopyWebpackPlugin = require('copy-webpack-plugin');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    // Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('public', './assets/public/js/public.js')
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning()
    .configureBabel(() => {
    }, {
        useBuiltIns: 'usage',
        corejs: 3
    })
    .enableSassLoader()
    .enablePostCssLoader((options) => {
        options.config = {
            path: './postcss.config.js'
        };
    })
    .addPlugin(new CopyWebpackPlugin([
        {from: './assets/public/img', to: 'img'},
        {from: './assets/public/fonts', to: 'fonts'}
    ]))
    .autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
