// webpack.mix.js

let mix = require( 'laravel-mix' );
let url = 'https://vpfo.ubccms.test';

mix
	.disableSuccessNotifications()
	.js( 'src/js/sidenav.js', 'js/sidenav.js' )
	.js( 'src/js/archive-multiselect.js', 'js/archive-multiselect.js' )
	.js( 'src/js/vpfo-footer-admin.js', 'js/vpfo-footer-admin.js' )
  .js( 'src/js/archive-ajax.js', 'js/archive-ajax.js' )
	.sass(
		'src/style.scss',
		'style.css',
		{
			sassOptions: {
				outputStyle: 'compressed'
			}
		}
	)
	.options(
		{
			processCssUrls: false
		}
	)
	.setPublicPath( '/' )
	.browserSync( url )
	.copy( 'src/images/svg', 'images/svg' );