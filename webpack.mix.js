const mix = require('laravel-mix');
let theme = process.env.npm_config_theme;
require('laravel-mix-merge-manifest');

const src = {
    admin: {
        js: 'resources/js/console/console.js',
        sass: 'resources/sass/console/console.scss'
    }
}

const dest = {
    js: 'public/js',
    sass: 'public/css'
}
mix.js(src.admin.js, dest.js) // Output: public/js/admin.js
    .sass(src.admin.sass, dest.sass)
    .mergeManifest(); // Output: public/css/admin.css
