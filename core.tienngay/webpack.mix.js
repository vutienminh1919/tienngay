let mix = require('laravel-mix');

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


mix.copy('modules/ViewCpanel/Resources/assets/js/switchery.js', 'public/viewcpanel/js/');
mix.copy('modules/ViewCpanel/Resources/assets/js/bootstrap.min.js', 'public/viewcpanel/js/');
mix.copy('modules/ViewCpanel/Resources/assets/js/bootstrap-multiselect.js', 'public/viewcpanel/js/');
mix.copy('modules/ViewCpanel/Resources/assets/css/switchery.css', 'public/viewcpanel/css/');
mix.postCss('modules/ViewCpanel/Resources/assets/css/teacup.css', 'public/viewcpanel/css/');
mix.copy('modules/ViewCpanel/Resources/assets/css/bootstrap-multiselect.css', 'public/viewcpanel/css/');
mix.js('modules/ViewCpanel/Resources/assets/js/paymentgateway/transactions.js', 'public/viewcpanel/js/paymentgateway/');
mix.postCss('modules/ViewCpanel/Resources/assets/css/paymentgateway/transactions.css', 'public/viewcpanel/css/paymentgateway/');
mix.postCss('modules/ViewCpanel/Resources/assets/css/paymentgateway/detail.css', 'public/viewcpanel/css/paymentgateway/');
mix.js('modules/ViewCpanel/Resources/assets/js/paymentgateway/reconciliation-details.js', 'public/viewcpanel/js/paymentgateway/');
mix.postCss('modules/ViewCpanel/Resources/assets/css/paymentgateway/reconciliation-details.css', 'public/viewcpanel/css/paymentgateway/');
mix.js('modules/ViewCpanel/Resources/assets/js/paymentgateway/reconciliation-index.js', 'public/viewcpanel/js/paymentgateway/');
mix.postCss('modules/ViewCpanel/Resources/assets/css/paymentgateway/reconciliation-index.css', 'public/viewcpanel/css/paymentgateway/');
mix.js('modules/ViewCpanel/Resources/assets/js/vpbank/transactions.js', 'public/viewcpanel/js/vpbank/');
mix.postCss('modules/ViewCpanel/Resources/assets/css/vpbank/transactions.css', 'public/viewcpanel/css/vpbank/');
mix.postCss('modules/ViewCpanel/Resources/assets/css/vpbank/detail.css', 'public/viewcpanel/css/vpbank/');
mix.js('modules/ViewCpanel/Resources/assets/js/vpbank/storeCodes.js', 'public/viewcpanel/js/vpbank/');
mix.postCss('modules/ViewCpanel/Resources/assets/css/vpbank/storeCodes.css', 'public/viewcpanel/css/vpbank/');
mix.js('modules/ViewCpanel/Resources/assets/js/reportForm3/report.js', 'public/viewcpanel/js/reportForm3/');
mix.js('modules/ViewCpanel/Resources/assets/js/reportForm2/report.js', 'public/viewcpanel/js/reportForm2/');
mix.postCss('modules/ViewCpanel/Resources/assets/css/reportForm3/report.css', 'public/viewcpanel/css/reportForm3/');
mix.js('modules/ViewCpanel/Resources/assets/js/exportExcel/export.js', 'public/viewcpanel/js/exportExcel/');
mix.js('modules/ViewCpanel/Resources/assets/js/exportExcel/exportBaoHiem.js', 'public/viewcpanel/js/exportExcel/');
mix.postCss('modules/ViewCpanel/Resources/assets/css/exportExcel/export.css', 'public/viewcpanel/css/exportExcel/');
mix.copy('modules/ViewCpanel/Resources/assets/js/helper.js', 'public/viewcpanel/js/');
mix.postCss('modules/ViewCpanel/Resources/assets/css/reportsKsnb/index.css', 'public/viewcpanel/css/reportsKsnb/');
mix.js('modules/ViewCpanel/Resources/assets/js/pti/index.js', 'public/viewcpanel/js/pti/');
mix.js('modules/ViewCpanel/Resources/assets/js/pti/bhtn.js', 'public/viewcpanel/js/pti/');
mix.js('modules/ViewCpanel/Resources/assets/js/misstakenVPBTransaction/report.js', 'public/viewcpanel/js/misstakenVPBTransaction/');
mix.postCss('modules/ViewCpanel/Resources/assets/css/reportLogTransaction/report.css', 'public/viewcpanel/css/reportLogTransaction/');
mix.js('modules/ViewCpanel/Resources/assets/js/reportLogTransaction/report.js', 'public/viewcpanel/js/reportLogTransaction/');

// Full API
// mix.js(src, output);
// mix.react(src, output); <-- Identical to mix.js(), but registers React Babel compilation.
// mix.preact(src, output); <-- Identical to mix.js(), but registers Preact compilation.
// mix.coffee(src, output); <-- Identical to mix.js(), but registers CoffeeScript compilation.
// mix.ts(src, output); <-- TypeScript support. Requires tsconfig.json to exist in the same folder as webpack.mix.js
// mix.extract(vendorLibs);
// mix.sass(src, output);
// mix.less(src, output);
// mix.stylus(src, output);
// mix.postCss(src, output, [require('postcss-some-plugin')()]);
// mix.browserSync('my-site.test');
// mix.combine(files, destination);
// mix.babel(files, destination); <-- Identical to mix.combine(), but also includes Babel compilation.
// mix.copy(from, to);
// mix.copyDirectory(fromDir, toDir);
// mix.minify(file);
// mix.sourceMaps(); // Enable sourcemaps
// mix.version(); // Enable versioning.
// mix.disableNotifications();
// mix.setPublicPath('path/to/public');
// mix.setResourceRoot('prefix/for/resource/locators');
// mix.autoload({}); <-- Will be passed to Webpack's ProvidePlugin.
// mix.webpackConfig({}); <-- Override webpack.config.js, without editing the file directly.
// mix.babelConfig({}); <-- Merge extra Babel configuration (plugins, etc.) with Mix's default.
// mix.then(function () {}) <-- Will be triggered each time Webpack finishes building.
// mix.when(condition, function (mix) {}) <-- Call function if condition is true.
// mix.override(function (webpackConfig) {}) <-- Will be triggered once the webpack config object has been fully generated by Mix.
// mix.dump(); <-- Dump the generated webpack config object to the console.
// mix.extend(name, handler) <-- Extend Mix's API with your own components.
// mix.options({
//   extractVueStyles: false, // Extract .vue component styling to file, rather than inline.
//   globalVueStyles: file, // Variables file to be imported in every component.
//   processCssUrls: true, // Process/optimize relative stylesheet url()'s. Set to false, if you don't want them touched.
//   purifyCss: false, // Remove unused CSS selectors.
//   terser: {}, // Terser-specific options. https://github.com/webpack-contrib/terser-webpack-plugin#options
//   postCss: [] // Post-CSS options: https://github.com/postcss/postcss/blob/master/docs/plugins.md
// });
