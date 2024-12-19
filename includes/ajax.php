<?php

function ubc_vpfo_archive_order( $post_type ) {
	return match ( $post_type ) {
		'post'           => 'ASC',
		'glossary-terms' => 'ASC',
		'resources'      => 'ASC',
		default          => '',
	};
}

function ubc_vpfo_archive_order_by( $post_type ) {
	return match ( $post_type ) {
		'post'           => 'date',
		'glossary-terms' => 'title',
		'resources'      => 'title',
		default          => '',
	};
}

// Intercept initial page loads to have an accurate archive ordering.
add_action(
	'pre_get_posts',
	function ( $query ) {
		if ( is_archive() && $query->is_main_query() && in_array( $query->get( 'post_type' ), array( 'post', 'glossary-terms', 'resources' ), true ) ) {
			$query->set( 'order', ubc_vpfo_archive_order( $query->get( 'post_type' ) ) ); //Set the order ASC or DESC
			$query->set( 'orderby', ubc_vpfo_archive_order_by( $query->get( 'post_type' ) ) );
		}
	}
);

add_action( 'wp_ajax_nopriv_ubc_vpfo_get_archive_page', 'ubc_vpfo_get_archive_page_handler' );
add_action( 'wp_ajax_ubc_vpfo_get_archive_page', 'ubc_vpfo_get_archive_page_handler' );

function ubc_vpfo_sanitize_archive_ajax_params() {
	$params = $_REQUEST['params'];

	$unsanitized_categories = $params['category'] ?? array();

	$sanitized = array(
		'page'       => (int) sanitize_text_field( $params['page'] ),
		'post_type'  => sanitize_text_field( $params['post_type'] ),
		'categories' => is_iterable( $unsanitized_categories ) ? array_map( 'sanitize_text_field', $unsanitized_categories ) : array(),
		'search'     => sanitize_text_field( $params['search'] ),
	);

	return $sanitized;
}

function ubc_vpfo_render_archive_cards( $query ) {
	global $post;

	$card_template = match ( $query->get( 'post_type' ) ) {
		'resources'      => 'archive-card-resources',
		'glossary-terms' => 'archive-card-glossary-terms',
		'post'           => 'archive-card-post',
		default          => 'archive-card-post',
	};

	// Variable required in cards.
	$archive_post_type = $query->get( 'post_type' );

	ob_start();
	foreach ( $query->posts as $post ) {
		setup_postdata( $post );
		require plugin_dir_path( __DIR__ ) . 'partials/templates/' . $card_template . '.php';
		wp_reset_postdata();
	}
	$cards_fragment = ob_get_clean();

	return $cards_fragment;
}

function ubc_vpfo_get_archive_page_handler() {
	// Verify nonce based on $_REQUEST['_nonce']
	if ( ! wp_verify_nonce( $_REQUEST['_nonce'], 'vpfo_archive_nonce' ) ) {
		wp_send_json_error( 'Invalid nonce' );
		exit;
	}

	$params = ubc_vpfo_sanitize_archive_ajax_params();

	// Check if this is a valid post type.
	if ( ! in_array( $params['post_type'], array( 'resources', 'glossary-terms', 'post' ), true ) ) {
		wp_send_json_error( 'Invalid post type' );
	}

	$query_args = array(
		'post_type'      => $params['post_type'],
		'posts_per_page' => 10,
		'paged'          => $params['page'],
		'order'          => ubc_vpfo_archive_order( $params['post_type'] ),
		'orderby'        => ubc_vpfo_archive_order_by( $params['post_type'] ),
	);

	if ( ! empty( $params['categories'] ) ) {
		$query_args['tax_query'] = array(
			'relation' => 'OR',
		);

		$taxonomy = match ( $params['post_type'] ) {
			'post'           => 'category',
			'resources'      => 'resources-categories',
			'glossary-terms' => 'glossary-categories',
		};

		foreach ( $params['categories'] as $category_slug ) {
			$query_args['tax_query'][] = array(
				'taxonomy' => $taxonomy,
				'field'    => 'slug',
				'terms'    => $category_slug,
			);
		}
	}

	if ( ! empty( $params['search'] ) ) {
		$query_args['s'] = $params['search'];
		unset( $query_args['order'] );
		unset( $query_args['orderby'] );
	}

	$query = new WP_Query( $query_args );

	// Generate HTML fragments to send back in the AJAX response.

	// First, the pagination fragment.
	ob_start();
	vpfo_numeric_pagination( $query );
	$pagination_fragment = ob_get_clean();

	// Then, the card results.
	$results_fragment = ubc_vpfo_render_archive_cards( $query );

	return wp_send_json_success(
		array(
			'pagination' => $pagination_fragment,
			'results'    => $results_fragment,
		)
	);
}
