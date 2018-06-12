let mix = require('laravel-mix');

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
 mix.js('resources/assets/js/app.js', 'public/js')
 .sass('resources/assets/sass/app.scss', 'public/css');
 */

mix.copy('node_modules/font-awesome/fonts', 'public/fonts')
        .copy('node_modules/chosen-js/chosen-sprite.png', 'public/css')
        .copy('node_modules/chosen-js/chosen-sprite@2x.png', 'public/css')
        .copy('resources/assets/img/loading-2.gif', 'public/img')
        .copy('node_modules/bootstrap/dist/fonts', 'public/fonts')
        .copy('resources/assets/_js/users.js', 'public/js/users.js');
/*
 mix.styles([
 'node_modules/font-awesome/css/font-awesome.min.css',
 'node_modules/bootstrap/dist/css/bootstrap.min.css',
 'node_modules/datatables.net/css/dataTables.bootstrap.css',
 'node_modules/chosen-noterik/public/chosen.min.css',
 'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css'
 ],'public/css/plugins.css');
 
 
 mix.scripts([
 'node_modules/jquery/dist/jquery.min.js',
 'node_modules/bootstrap/dist/js/bootstrap.min.js',
 'node_modules/datatables.net/js/jquery.dataTables.js',
 'node_modules/datatables.net-bs/js/dataTables.bootstrap.js',
 'node_modules/chosen-noterik/public/chosen.jquery.min.js',
 'node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
 'node_modules/bootstrap-datepicker/dist/locales/bootstrap-datepicker.pt-BR.min.js',
 'node_modules/jquery-mask-plugin/dist/jquery.mask.min.js',
 'node_modules/jquery-validation/dist/jquery.validate.min.js',
 ],'public/js/plugins.js');
 */

mix.styles([
    'resources/assets/css/app.css'

], 'public/css/app.css');

mix.styles([
    'node_modules/font-awesome/css/font-awesome.min.css',
    'node_modules/bootstrap/dist/css/bootstrap.min.css',
    'resources/assets/plugins/datatables/datatables.min.css',
    'resources/assets/plugins/chosen/bootstrap-chosen.css',
    'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css'
], 'public/css/plugins.css');

mix.scripts([
    'node_modules/jquery/dist/jquery.min.js',
    'node_modules/bootstrap/dist/js/bootstrap.min.js',
    'resources/assets/js/jquery.confirm.js',
    'resources/assets/plugins/datatables/datatables.min.js',
    // 'resources/assets/plugins/chosen/chosen.jquery.js',
    'node_modules/chosen-js/chosen.jquery.js',
    'node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
    'node_modules/bootstrap-datepicker/dist/locales/bootstrap-datepicker.pt-BR.min.js',
    'node_modules/jquery-mask-plugin/dist/jquery.mask.min.js',
    'node_modules/jquery-validation/dist/jquery.validate.min.js',
], 'public/js/plugins.js');
mix.scripts([
    'resources/assets/_js/app.js',
    'resources/assets/_js/tabela.js'
], 'public/js/app.js');

