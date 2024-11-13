// webpack.mix.js

let mix = require( 'laravel-mix' );
let url = 'https://vpfo.ubccms.test';

mix
	.disableSuccessNotifications()
	.js( 'src/js/sidenav.js', 'js/sidenav.js' )
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