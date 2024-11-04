<?php

function vpfo_get_custom_header( $name = '' ) {
	// Define the path to the headers directory in your plugin
	$custom_header_path = plugin_dir_path( __DIR__ ) . 'partials/headers/';

	// Construct the exact file path based on the provided name
	$header_file = $custom_header_path . 'header-' . $name . '.php';

	// Check if the specified custom header file exists
	if ( file_exists( $header_file ) ) {
		include $header_file;
	} else {
		// Fall back to the theme’s default header if the custom file is not found
		get_template_part( 'header', $name );
	}
}
