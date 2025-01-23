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

	if ( 'vpfo-page.php' === get_page_template_slug() || 'vpfo-page-sidenav.php' === get_page_template_slug() ) {
		wp_enqueue_script(
			'vpfo-survey-feedback-js',
			plugin_dir_url( __DIR__ ) . 'js/survey-feedback.js',
			array(),
			'1.0',
			array( 'strategy' => 'defer' )
		);

		wp_enqueue_script(
			'vpfo-cross-post-listing-js',
			plugin_dir_url( __DIR__ ) . 'js/cross-post-listing.js',
			array(),
			'1.0',
			array( 'strategy' => 'defer' )
		);

		wp_enqueue_script(
			'vpfo-image-cards-js',
			plugin_dir_url( __DIR__ ) . 'js/image-cards.js',
			array(),
			'1.0',
			array( 'strategy' => 'defer' )
		);

		wp_enqueue_script(
			'vpfo-featured-resources-js',
			plugin_dir_url( __DIR__ ) . 'js/featured-resources.js',
			array(),
			'1.0',
			array( 'strategy' => 'defer' )
		);

		wp_enqueue_script(
			'vpfo-alert-banner-close-js',
			plugin_dir_url( __DIR__ ) . 'js/alert-banner-close.js',
			array(),
			'1.0',
			array( 'strategy' => 'defer' )
		);

		wp_enqueue_script(
			'vpfo-aria-labels-js',
			plugin_dir_url( __DIR__ ) . 'js/aria-labels.js',
			array(),
			'1.0',
			array( 'strategy' => 'defer' )
		);
	}

	if ( is_home() || is_post_type_archive( 'resources' ) || is_post_type_archive( 'glossary-terms' ) ) {
		wp_enqueue_script(
			'vpfo-archive-multiselect',
			plugin_dir_url( __DIR__ ) . 'js/archive-multiselect.js',
			array(),
			'1.0',
			array( 'strategy' => 'defer' )
		);

		wp_register_script(
			'vpfo-archive-ajax',
			plugin_dir_url( __DIR__ ) . 'js/archive-ajax.js',
			array( 'jquery' ),
			'1.0',
			array( 'strategy' => 'defer' )
		);

		wp_localize_script(
			'vpfo-archive-ajax',
			'archive_ajax_params',
			array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'_nonce'   => wp_create_nonce( 'vpfo_archive_nonce' ),
			)
		);

		wp_enqueue_script( 'vpfo-archive-ajax' );
	}
}
add_action( 'wp_enqueue_scripts', 'ubc_vpfo_templates_styles_enqueue_styles_scripts' );

function vpfo_enqueue_admin_scripts( $hook_suffix ) {
	// Check if we are on the VPFO Footer settings page
	if ( 'appearance_page_vpfo-footer' === $hook_suffix ) {
		wp_enqueue_script(
			'vpfo-footer-admin-js',
			plugin_dir_url( __DIR__ ) . '/js/vpfo-footer-admin.js',
			array(),
			'1.0',
			array( 'in_footer' => true )
		);

		// Optional: Add some inline JavaScript data if needed
		wp_localize_script(
			'vpfo-footer-admin-js',
			'vpfoFooterAdmin',
			array(
				'linkCount' => count( get_option( 'vpfo_unit_links', array() ) ),
			)
		);
	}
}
add_action( 'admin_enqueue_scripts', 'vpfo_enqueue_admin_scripts' );

// Enqueue block editor assets
function vpfo_enqueue_block_editor_assets() {
	wp_enqueue_script(
		'vpfo-quote-block-expiry-js',
		plugin_dir_url( __DIR__ ) . '/js/quote-block-expiry.js',
		array(
			'wp-blocks',
			'wp-element',
			'wp-editor',
			'wp-components',
			'wp-date',
		),
		'1.0',
		true
	);
}
add_action( 'enqueue_block_editor_assets', 'vpfo_enqueue_block_editor_assets' );
