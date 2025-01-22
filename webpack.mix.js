// webpack.mix.js

let mix = require( 'laravel-mix' );
let url = 'https://vpfo.ubccms.test';

mix
	.disableSuccessNotifications()
	.js( 'src/js/sidenav.js', 'js/sidenav.js' )
	.js( 'src/js/archive-multiselect.js', 'js/archive-multiselect.js' )
	.js( 'src/js/vpfo-footer-admin.js', 'js/vpfo-footer-admin.js' )
	.js( 'src/js/archive-ajax.js', 'js/archive-ajax.js' )
	.js( 'src/js/survey-feedback.js', 'js/survey-feedback.js' )
	.js( 'src/js/cross-post-listing.js', 'js/cross-post-listing.js' )
	.js( 'src/js/image-cards.js', 'js/image-cards.js' )
	.js( 'src/js/featured-resources.js', 'js/featured-resources.js' )
	.js( 'src/js/quote-block-expiry.js', 'js/quote-block-expiry.js' )
	.js( 'src/js/alert-banner-close.js', 'js/alert-banner-close.js' )
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