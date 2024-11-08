<?php

function vpfo_register_page_templates( $templates ) {
	// Add custom templates to the list
	$templates['vpfo-page.php']         = 'VPFO Default Page';
	$templates['vpfo-page-sidenav.php'] = 'VPFO Sidenav Page';
	return $templates;
}
add_filter( 'theme_page_templates', 'vpfo_register_page_templates' );

function vpfo_load_custom_template( $template ) {
	global $post;

	// Check if we're working on a page and a custom template is selected
	if ( $post ) {
		$page_template = get_post_meta( $post->ID, '_wp_page_template', true );

		// Define an array of custom templates with their file paths
		$custom_templates = array(
			'vpfo-page.php'         => plugin_dir_path( __DIR__ ) . 'templates/vpfo-page.php',
			'vpfo-page-sidenav.php' => plugin_dir_path( __DIR__ ) . 'templates/vpfo-page-sidenav.php',
		);

		// If the selected template matches one of our custom templates, use its path
		if ( array_key_exists( $page_template, $custom_templates ) && file_exists( $custom_templates[ $page_template ] ) ) {
			return $custom_templates[ $page_template ];
		}
	}

	// Default to the original template if no match
	return $template;
}
add_filter( 'template_include', 'vpfo_load_custom_template' );
