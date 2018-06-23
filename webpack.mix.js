let mix = require('laravel-mix');

mix.js(
    ['resources/assets/js/bootstrap.bundle.js',
    ],
    'public/js/app.js')
    .scripts('resources/assets/js/aos.js', 'public/js/aos.js')
    .styles('resources/assets/css/aos.css', 'public/css/aos.css')
    .sass('resources/assets/sass/bootstrap.scss', 'public/css/app.css')
    .copy('resources/assets/js/jquery.min.js', 'public/js/jquery.js')
    .copyDirectory('resources/assets/img', 'public/img');