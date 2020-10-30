const elixir = require('laravel-elixir');

require('laravel-elixir-vue');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(mix => {
        mix.styles([
            'bootstrap.min.css',
            'ct-paper.css',
    		'buttons.bootstrap.min.css',
    		'dataTables.bootstrap.min.css',
    		'dataTables.tableTools.css',
    		'font-awesome.min.css',
            'ionicons.min.css',
    		'pe-icon-7-stroke.css',
    		'responsive.bootstrap.min.css',
            'style.css',
            'custom-theme.css',
            'wizard.css',
            'themify-icons.css',
            'sweetalert.css',
    	], 'public/css/all.css');

        mix.scripts([
             'bootstrap-datepicker.js',
             'bootstrap-select.js',
             'ct-paper.js',
             'ct-paper-checkbox.js',
             'ct-paper-radio.js',
             'sweetalert.min.js',
        ],'public/js/paper.js');
});
