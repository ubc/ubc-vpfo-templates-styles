<?php
/**
 * Enqueue styles and scripts for the plugin.
 *
 * @since 1.0.0
 */

// Front-end enqueue
function ubc_vpfo_templates_styles_enqueue_styles_scripts() {
	wp_enqueue_style(
		'ubc-vpfo-templates-styles-style',
		plugin_dir_url( __DIR__ ) . 'style.css',
		array(), // Dependencies
		'1.0.0'
	);

	wp_enqueue_style(
		'font-whitney',
		plugin_dir_url( __DIR__ ) . 'fonts/whitney/font-whitney.css',
		array(), // Dependencies
		'1.0.0'
	);

	wp_enqueue_style(
		'font-fontawesome-6-pro',
		plugin_dir_url( __DIR__ ) . 'fonts/fontawesome/css/all.min.css',
		array(), // Dependencies
		'6.6.0'
	);

	if ( 'vpfo-page-sidenav.php' === get_page_template_slug() ) {
		wp_enqueue_script(
			'vpfo-sidenav-js',
			plugin_dir_url( __DIR__ ) . 'js/sidenav.js',
			array(),
			'1.0',
			array( 'strategy' => 'defer' )
		);
	}
}
add_action( 'wp_enqueue_scripts', 'ubc_vpfo_templates_styles_enqueue_styles_scripts' );
