<?php

// Resources post type
function resources_cpt() {
	$labels = array(
		'name'               => 'Resources',
		'singular_name'      => 'Resource',
		'menu_name'          => 'Resources',
		'name_admin_bar'     => 'Resource',
		'add_new'            => 'Add New',
		'add_new_item'       => 'Add New Resource',
		'new_item'           => 'New Resource',
		'edit_item'          => 'Edit Resource',
		'view_item'          => 'View Resource',
		'all_items'          => 'All Resources',
		'search_items'       => 'Search Resources',
		'not_found'          => 'No Resources found',
		'not_found_in_trash' => 'No Resources found in trash',
	);

	$args = array(
		'labels'              => $labels,
		'description'         => 'Description',
		'public'              => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'show_in_nav_menus'   => true,
		'has_archive'         => true,
		'menu_icon'           => 'dashicons-archive',
		'show_in_rest'        => true,
		'rewrite'             => array(
			'with_front' => false,
		),
		'supports'            => array(
			'title',
			'editor',
			'excerpt',
			'custom-fields',
			'revisions',
		),
	);

	register_post_type( 'resources', $args );
}
add_action( 'init', 'resources_cpt' );

// Resources Categories taxonomy
function resources_categories() {

	$labels = array(
		'name'          => 'Resources Categories',
		'singular_name' => 'Resources Category',
		'search_items'  => 'Search Resources Categories',
		'all_items'     => 'All Resources Categories',
		'edit_item'     => 'Edit Resources Category',
		'update_item'   => 'Update Resources Category',
		'add_new_item'  => 'Add New Resources Category',
		'new_item_name' => 'New Resources Category Name',
		'menu_name'     => 'Resources Categories',
	);

	$rewrite = array(
		'slug'       => 'resources-categories',
		'with_front' => false,
	);

	$args = array(
		'labels'            => $labels,
		'rewrite'           => $rewrite,
		'show_admin_column' => true,
		'hierarchical'      => true,
	);

	register_taxonomy( 'resources-categories', 'resources', $args );
}
add_action( 'init', 'resources_categories' );

// Resources custom fields

// Add the meta box for the "Resource URL" field
function resources_add_meta_box() {
	add_meta_box(
		'resource_url_meta_box', // Unique ID for the meta box
		'Resource URL',          // Title of the meta box
		'resources_render_meta_box', // Callback to render the field
		'resources',             // Custom post type slug
		'normal',                  // Context (e.g., side, advanced)
		'default'                // Priority
	);
}
add_action( 'add_meta_boxes', 'resources_add_meta_box' );

// Render the "Resource URL" meta box
function resources_render_meta_box( $post ) {
	// Use nonce for security
	wp_nonce_field( 'resources_save_meta', 'resources_meta_nonce' );

	// Retrieve the current value of the field
	$resource_url = get_post_meta( $post->ID, '_resource_url', true ) ?? null;

	// Display the input field
	echo '<p>Add the URL you want this resource to link to. If you add a URL here, the resource archive entry will link to this URL instead of the resource page itself. You can link to an external website or a media resource on this site (i.e. a PDF file).</p>';
	echo '<input type="url" name="resource_url" value="' . esc_url( $resource_url ) . '" style="width: 100%;" placeholder="https://example.com" />';
}

// Save the "Resource URL" meta box value
function resources_save_meta_box( $post_id ) {
	// Verify the nonce for security
	if ( ! isset( $_POST['resources_meta_nonce'] ) || ! wp_verify_nonce( $_POST['resources_meta_nonce'], 'resources_save_meta' ) ) {
		return;
	}

	// Prevent saving during autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check user permissions
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	// Save the "Resource URL" value
	if ( isset( $_POST['resource_url'] ) ) {
		$sanitized_url = esc_url_raw( $_POST['resource_url'] );
		update_post_meta( $post_id, '_resource_url', $sanitized_url );
	} else {
		// If the field is empty, delete the meta value
		delete_post_meta( $post_id, '_resource_url' );
	}
}
add_action( 'save_post', 'resources_save_meta_box' );

// Glossary Terms post type
function glossary_terms_cpt() {
	$labels = array(
		'name'               => 'Glossary of Terms',
		'singular_name'      => 'Glossary Term',
		'menu_name'          => 'Glossary Terms',
		'name_admin_bar'     => 'Glossary Term',
		'add_new'            => 'Add New',
		'add_new_item'       => 'Add New Glossary Term',
		'new_item'           => 'New Glossary Term',
		'edit_item'          => 'Edit Glossary Term',
		'view_item'          => 'View Glossary Term',
		'all_items'          => 'All Glossary Terms',
		'search_items'       => 'Search Glossary Terms',
		'not_found'          => 'No Glossary Terms found',
		'not_found_in_trash' => 'No Glossary Terms found in trash',
	);

	$args = array(
		'labels'              => $labels,
		'description'         => 'Description',
		'public'              => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'show_in_nav_menus'   => true,
		'has_archive'         => true,
		'menu_icon'           => 'dashicons-book-alt',
		'rewrite'             => array(
			'with_front' => false,
		),
		'supports'            => array(
			'title',
			'editor',
			'revisions',
		),
	);

	register_post_type( 'glossary-terms', $args );
}
add_action( 'init', 'glossary_terms_cpt' );

// Glossary Categories taxonomy
function glossary_categories() {

	$labels = array(
		'name'          => 'Glossary Categories',
		'singular_name' => 'Glossary Category',
		'search_items'  => 'Search Glossary Categories',
		'all_items'     => 'All Glossary Categories',
		'edit_item'     => 'Edit Glossary Category',
		'update_item'   => 'Update Glossary Category',
		'add_new_item'  => 'Add New Glossary Category',
		'new_item_name' => 'New Glossary Category Name',
		'menu_name'     => 'Glossary Categories',
	);

	$rewrite = array(
		'slug'       => 'glossary-categories',
		'with_front' => false,
	);

	$args = array(
		'labels'            => $labels,
		'rewrite'           => $rewrite,
		'show_admin_column' => true,
		'hierarchical'      => true,
	);

	register_taxonomy( 'glossary-categories', 'glossary-terms', $args );
}
add_action( 'init', 'glossary_categories' );

// redirect single glossary term pages to the archive
function redirect_single_glossary_terms() {
	if ( is_singular( 'glossary-terms' ) ) {
		wp_safe_redirect( get_post_type_archive_link( 'glossary-terms' ), 301 );
		exit;
	}
}
add_action( 'template_redirect', 'redirect_single_glossary_terms' );

// Set up the VPFO custom post type archive and single templates
function vpfo_cpt_templates( $template ) {
	if ( is_singular( 'resources' ) ) {
		$plugin_template = plugin_dir_path( __DIR__ ) . 'templates/vpfo-single.php';
		if ( file_exists( $plugin_template ) ) {
			return $plugin_template;
		}
	} elseif ( is_post_type_archive( 'resources' ) || is_post_type_archive( 'glossary-terms' ) ) {
		$plugin_template = plugin_dir_path( __DIR__ ) . 'templates/vpfo-archive.php';
		if ( file_exists( $plugin_template ) ) {
			return $plugin_template;
		}
	}

	return $template;
}
add_filter( 'template_include', 'vpfo_cpt_templates' );

function vpfo_order_glossary_terms_archive( $query ) {
	// Ensure we are modifying the main query and it's not in the admin area
	if ( ! is_admin() && $query->is_main_query() ) {
		// Check if it's the archive page for the custom post type 'glossary-terms'
		if ( is_post_type_archive( 'glossary-terms' ) ) {
			$query->set( 'orderby', 'title' );
			$query->set( 'order', 'ASC' );
		}
	}
}
add_action( 'pre_get_posts', 'vpfo_order_glossary_terms_archive' );
