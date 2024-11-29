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

function vpfo_get_custom_footer( $name = '' ) {
	// Define the path to the footers directory in your plugin
	$custom_footer_path = plugin_dir_path( __DIR__ ) . 'partials/footers/';

	// Construct the exact file path based on the provided name
	$footer_file = $custom_footer_path . 'footer-' . $name . '.php';

	// Check if the specified custom footer file exists
	if ( file_exists( $footer_file ) ) {
		include $footer_file;
	} else {
		// Fall back to the theme’s default footer if the custom file is not found
		get_template_part( 'footer', $name );
	}
}

// numeric page navigtion

function vpfo_numeric_pagination() {
	// Only show pagination if there's more than one page
	if ( $GLOBALS['wp_query']->max_num_pages <= 1 ) {
		return;
	}

	$current_page = max( 1, get_query_var( 'paged' ) ); // Get the current page number
	$total_pages  = $GLOBALS['wp_query']->max_num_pages; // Get the total number of pages

	// Output the pagination
	$paginate_links = paginate_links(
		array(
			'base'      => get_pagenum_link( 1 ) . '%_%',
			'format'    => 'page/%#%/',
			'current'   => $current_page,
			'total'     => $total_pages,
			'mid_size'  => 2,
			'prev_text' => 'Previous',
			'next_text' => 'Next',
		)
	);
	echo '<nav class="pagination" role="navigation">';
	echo wp_kses_post( $paginate_links );
	echo '</nav>';
}

function get_vpfo_excerpt( $post_id = null, $word_limit = 55 ) {
	// Get the excerpt or generate one from the content
	$excerpt = get_the_excerpt( $post_id );

	// Trim the excerpt to the desired word limit
	$excerpt = wp_trim_words( $excerpt, $word_limit );

	return $excerpt;
}
