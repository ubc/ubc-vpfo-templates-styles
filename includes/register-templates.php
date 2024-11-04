<?php

function vpfo_register_page_templates( $templates ) {
	// Add vpfo-page.php template to the list
	$templates['vpfo-page.php'] = 'VPFO Custom Page';
	return $templates;
}
add_filter( 'theme_page_templates', 'vpfo_register_page_templates' );

function vpfo_load_custom_template( $template ) {
	global $post;

	// Ensure we're working on a page with the custom template selected
	if ( $post && get_post_meta( $post->ID, '_wp_page_template', true ) === 'vpfo-page.php' ) {
		// Set the path to your plugin’s custom template
		$custom_template = plugin_dir_path( __DIR__ ) . 'templates/vpfo-page.php';

		// If the custom template file exists, return its path
		if ( file_exists( $custom_template ) ) {
			return $custom_template;
		}
	}

	// Default to the original template if no match
	return $template;
}
add_filter( 'template_include', 'vpfo_load_custom_template' );
