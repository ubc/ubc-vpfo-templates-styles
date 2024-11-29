<?php

add_action( 'wp_ajax_nopriv_ubc_vpfo_get_archive_page', 'ubc_vpfo_get_archive_page_handler' );
add_action( 'wp_ajax_ubc_vpfo_get_archive_page', 'ubc_vpfo_get_archive_page_handler' );

function ubc_vpfo_sanitize_archive_ajax_params() {
	$params = $_REQUEST['params'];

	$unsanitized_categories = $params['category'] ?? array();

	$sanitized = array(
		'page'       => (int) sanitize_text_field( $params['page'] ),
		'post_type'  => sanitize_text_field( $params['post_type'] ),
		'categories' => array_map( 'sanitize_text_field', $unsanitized_categories ),
		'search'     => sanitize_text_field( $params['search'] ) ?? null,
	);

	return $sanitized;
}

function ubc_vpfo_get_archive_page_handler() {
	// Verify nonce based on $_REQUEST['_nonce']
	if ( ! wp_verify_nonce( $_REQUEST['_nonce'], 'vpfo_archive_nonce' ) ) {
		wp_die( 'Invalid nonce' );
	}

	$params = ubc_vpfo_sanitize_archive_ajax_params();

	$query_args = array(
		'post_type'      => $params['post_type'],
		'posts_per_page' => 10,
		'paged'          => $params['page'],
		's'              => $params['search'] ?? null,
		'tax_query'      => array(
			array(
				'taxonomy' => 'category',
				'field'    => 'slug',
				'terms'    => $params['categories'],
			),
		),
	);

	dd( $query_args );

	return wp_send_json_success( 'It works' );
}
