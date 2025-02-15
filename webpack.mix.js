const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

// Configuración para eliminar los comentarios
/*if (mix.inProduction()) {
  mix.options({
    terser: {
      extractComments: false, // Elimina los comentarios (incluyendo JSDoc)
      terserOptions: {
        output: {
          comments: false, // Asegura que los comentarios no se mantengan
        },
      },
    },
  });
}*/

/*mix.js('resources/js/app.js', 'public/js');
	.js('resources/js/pages/ptoventa/venta/shop.js', 'public/js')
	.js('resources/js/pages/inventario/reposicion/reponer.js', 'public/js');*/
mix.js('resources/js/app.js', 'public/js');
/*mix.sass("resources/sass/theme.scss", "public/css")
	//.sass("resources/sass/pages/auth/access.scss", "public/css")
	//.sass("resources/sass/pages/ptoventa/venta/shop.scss", "public/css")
	.options({postCss: [require("autoprefixer")] });*/