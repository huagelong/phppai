const Encore = require('@symfony/webpack-encore');
const path = require('path');
const glob = require('glob');

const buildPath = __dirname+'/public/static/dist';
const resourcePath = __dirname+'/resources';
const publicPath = '/static/dist';
const manifestKeyPrefix = '/static/dist';

const config = {
    buildPath: path.resolve(buildPath),
    entryPath:path.resolve(resourcePath+"/assets/static/bundle/entry"),
    mapPath: path.resolve(buildPath + '/manifest.json')
};

Encore
    .setOutputPath(buildPath)
    .setPublicPath(publicPath)
    .enableSassLoader()
    .autoProvidejQuery()
    .autoProvideVariables({
        '$': 'jquery',
        'jQuery': 'jquery',
        "window.jQuery": "jquery",
        _: 'underscore'
    })
    .enableSourceMaps(!Encore.isProduction())
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableVersioning(true).setManifestKeyPrefix(manifestKeyPrefix);

if (!Encore.isProduction()) {
    Encore.enableVersioning(false);
}

function findEntries(entryPath){
    const entries = {};
    const srcDirName = entryPath + '/**/*.main.js';
    glob.sync(srcDirName).forEach(function (filepath) {
        const name = filepath.substring(entryPath.length + 1, filepath.lastIndexOf('.')-5);
        entries[name] = filepath;
    });
    // console.log(entries);
    return entries;
}

function findScssEntries(entryPath){
    const entries = {};
    const srcCssDirName = entryPath + '/**/*.main.scss';
    glob.sync(srcCssDirName).forEach(function (filepath) {
        const name = filepath.substring(entryPath.length + 1, filepath.lastIndexOf('.')-5);
        entries[name] = filepath;
    });
    return entries;
}

const foundEntries = findEntries(config.entryPath);
for (const entryName in foundEntries) {
    Encore.addEntry(entryName, foundEntries[entryName]);
}

const foundScssEntries = findScssEntries(config.entryPath);
for (const entryName in foundScssEntries) {
    Encore.addStyleEntry(entryName, foundScssEntries[entryName]);
}

Encore.createSharedEntry('bundle',resourcePath+"/assets/static/bundle/entry/share.js");

const webpackConfig = Encore.getWebpackConfig();
webpackConfig.watchOptions = {
    poll: true,
    ignored: /node_modules/
};
// export the final configuration
module.exports = webpackConfig;