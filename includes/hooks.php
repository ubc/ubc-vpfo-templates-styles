<?php

// set up the default VPFO template as the starting page template for new pages
function vpfo_set_default_template_on_new_page( $post_id, $post, $update ) {
	// Only proceed if it's a page, it's not an update (new page), and it's in the admin area
	if ( 'page' === $post->post_type && ! $update && is_admin() ) {
		$default_template = 'vpfo-page.php'; // Replace with your custom template slug

		// Check if the page has a template assigned; if not, set the default template
		if ( get_post_meta( $post_id, '_wp_page_template', true ) === '' ) {
			$post_id_sanitized          = absint( $post_id );
			$default_template_sanitized = esc_html( $default_template );
			update_post_meta( $post_id_sanitized, '_wp_page_template', $default_template_sanitized );
		}
	}
}
add_action( 'save_post', 'vpfo_set_default_template_on_new_page', 10, 3 );

// set up the alert banner options on the VPFO templates
function vpfo_add_alert_meta_box() {
	$screen = get_current_screen();
	if ( $screen && 'page' === $screen->id ) {
		global $post;
		if ( $post && ( get_page_template_slug( $post->ID ) === 'vpfo-page.php' || get_page_template_slug( $post->ID ) === 'vpfo-page-sidenav.php' ) ) {
			add_meta_box(
				'vpfo_alert_meta_box',
				'Alert Banner',
				'vpfo_render_alert_meta_box',
				'page',
				'side',
				'default'
			);
		}
	}
}
add_action( 'add_meta_boxes', 'vpfo_add_alert_meta_box' );

function vpfo_render_alert_meta_box( $post ) {
	// Use nonce for verification
	wp_nonce_field( 'vpfo_save_alert_meta', 'vpfo_alert_nonce' );

	// Get current values (if any)
	$display_alert = get_post_meta( $post->ID, '_vpfo_display_alert', true );
	$alert_message = get_post_meta( $post->ID, '_vpfo_alert_message', true );
	$alert_expiry  = get_post_meta( $post->ID, '_vpfo_alert_expiry', true );

	// Display the toggle checkbox
	echo '<p>';
	echo '<label for="vpfo_display_alert">';
	echo '<input type="checkbox" id="vpfo_display_alert" name="vpfo_display_alert" value="1"' . checked( $display_alert, '1', false ) . '> Display Alert';
	echo '</label>';
	echo '</p>';

	// Display the textarea field
	echo '<p>';
	echo '<label for="vpfo_alert_message">Alert Message:</label>';
	echo '<textarea id="vpfo_alert_message" name="vpfo_alert_message" rows="4" style="width: 100%;">' . esc_textarea( $alert_message ) . '</textarea>';
	echo '</p>';

	// Display the expiry date field
	echo '<p>';
	echo '<label for="vpfo_alert_expiry">Expiry Date:</label>';
	echo '<input type="date" id="vpfo_alert_expiry" name="vpfo_alert_expiry" value="' . esc_attr( $alert_expiry ) . '" style="width: 100%;">';
	echo '</p>';
}

function vpfo_save_alert_meta( $post_id ) {
	// Check if nonce is set and valid
	if ( ! isset( $_POST['vpfo_alert_nonce'] ) || ! wp_verify_nonce( $_POST['vpfo_alert_nonce'], 'vpfo_save_alert_meta' ) ) {
		return;
	}

	// Check autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check user permissions
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	// Save the 'display alert' checkbox value
	$display_alert           = isset( $_POST['vpfo_display_alert'] ) ? '1' : '0';
	$display_alert_sanitized = esc_html( $display_alert );
	$post_id_sanitized       = absint( $post_id );
	update_post_meta( $post_id_sanitized, '_vpfo_display_alert', $display_alert_sanitized );

	// Save the alert message textarea value
	if ( isset( $_POST['vpfo_alert_message'] ) ) {
		// Allow basic HTML tags like <a>, <strong>, <em>, etc.
		$allowed_html  = array(
			'a'      => array(
				'href'   => array(),
				'title'  => array(),
				'target' => array(),
			),
			'strong' => array(),
			'em'     => array(),
			'p'      => array(),
			'br'     => array(),
		);
		$alert_message = wp_kses( $_POST['vpfo_alert_message'], $allowed_html );
		update_post_meta( $post_id, '_vpfo_alert_message', $alert_message );
	}

	// Save the alert expiry date
	if ( isset( $_POST['vpfo_alert_expiry'] ) ) {
		$alert_expiry = sanitize_text_field( $_POST['vpfo_alert_expiry'] );
		update_post_meta( $post_id, '_vpfo_alert_expiry', $alert_expiry );
	}
}
add_action( 'save_post', 'vpfo_save_alert_meta' );

// Set up the hero banner options on the VPFO templates
function vpfo_add_hero_meta_box() {
	$screen = get_current_screen();
	if ( $screen && 'page' === $screen->id ) {
		global $post;
		if ( $post && ( get_page_template_slug( $post->ID ) === 'vpfo-page.php' || get_page_template_slug( $post->ID ) === 'vpfo-page-sidenav.php' ) ) {
			add_meta_box(
				'vpfo_hero_meta_box',
				'Hero Image Banner',
				'vpfo_render_hero_meta_box',
				'page',
				'side',
				'default'
			);
		}
	}
}
add_action( 'add_meta_boxes', 'vpfo_add_hero_meta_box' );

function vpfo_render_hero_meta_box( $post ) {
	// Use nonce for verification
	wp_nonce_field( 'vpfo_save_hero_meta', 'vpfo_hero_nonce' );

	// Get current values (if any)
	$display_hero      = get_post_meta( $post->ID, '_vpfo_display_hero', true );
	$horizontal_anchor = get_post_meta( $post->ID, '_vpfo_horizontal_anchor', true ) ?? 'center';
	$vertical_anchor   = get_post_meta( $post->ID, '_vpfo_vertical_anchor', true ) ?? 'center';

	// Display the toggle checkbox
	echo '<p>';
	echo '<label for="vpfo_display_hero">';
	echo '<input type="checkbox" id="vpfo_display_hero" name="vpfo_display_hero" value="1"' . checked( $display_hero, '1', false ) . '> Display Hero Image Banner';
	echo '</label>';
	echo '</p>';
	echo '<p style="font-size:90%;font-style:italic">';
	echo 'Please note that the Hero Image Banner will use this page\'s Featured Image and will only display if the page has a Featured image Set.';
	echo '</p>';

	// Horizontal Anchor Point dropdown
	echo '<p>';
	echo '<label for="vpfo_horizontal_anchor"><strong>Horizontal Anchor Point:</strong></label><br>';
	echo '<select id="vpfo_horizontal_anchor" name="vpfo_horizontal_anchor">';
	echo '<option value="left"' . selected( $horizontal_anchor, 'left', false ) . '>Left</option>';
	echo '<option value="center"' . selected( $horizontal_anchor, 'center', false ) . '>Center</option>';
	echo '<option value="right"' . selected( $horizontal_anchor, 'right', false ) . '>Right</option>';
	echo '</select>';
	echo '</p>';

	// Vertical Anchor Point dropdown
	echo '<p>';
	echo '<label for="vpfo_vertical_anchor"><strong>Vertical Anchor Point:</strong></label><br>';
	echo '<select id="vpfo_vertical_anchor" name="vpfo_vertical_anchor">';
	echo '<option value="top"' . selected( $vertical_anchor, 'top', false ) . '>Top</option>';
	echo '<option value="center"' . selected( $vertical_anchor, 'center', false ) . '>Center</option>';
	echo '<option value="bottom"' . selected( $vertical_anchor, 'bottom', false ) . '>Bottom</option>';
	echo '</select>';
	echo '</p>';
}

function vpfo_save_hero_meta( $post_id ) {
	// Check if nonce is set and valid
	if ( ! isset( $_POST['vpfo_hero_nonce'] ) || ! wp_verify_nonce( $_POST['vpfo_hero_nonce'], 'vpfo_save_hero_meta' ) ) {
		return;
	}

	// Check autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check user permissions
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	// sanitize post id for db insertion
	$post_id_sanitized = absint( $post_id );

	// Save the 'display hero' checkbox value
	$display_hero = isset( $_POST['vpfo_display_hero'] ) ? '1' : '0';
	update_post_meta( $post_id_sanitized, '_vpfo_display_hero', esc_html( $display_hero ) );

	// Save the Horizontal Anchor Point dropdown value
	if ( isset( $_POST['vpfo_horizontal_anchor'] ) ) {
		$horizontal_anchor = sanitize_text_field( $_POST['vpfo_horizontal_anchor'] );
		update_post_meta( $post_id_sanitized, '_vpfo_horizontal_anchor', $horizontal_anchor );
	}

	// Save the Vertical Anchor Point dropdown value
	if ( isset( $_POST['vpfo_vertical_anchor'] ) ) {
		$vertical_anchor = sanitize_text_field( $_POST['vpfo_vertical_anchor'] );
		update_post_meta( $post_id_sanitized, '_vpfo_vertical_anchor', $vertical_anchor );
	}
}
add_action( 'save_post', 'vpfo_save_hero_meta' );

// set up the survey options on the VPFO templates
function vpfo_add_survey_meta_box() {
	$screen = get_current_screen();
	if ( $screen && 'page' === $screen->id ) {
		global $post;
		if ( $post && ( get_page_template_slug( $post->ID ) === 'vpfo-page.php' || get_page_template_slug( $post->ID ) === 'vpfo-page-sidenav.php' ) ) {
			add_meta_box(
				'vpfo_survey_meta_box',
				'Survey Feedback',
				'vpfo_render_survey_meta_box',
				'page',
				'side',
				'default'
			);
		}
	}
}
add_action( 'add_meta_boxes', 'vpfo_add_survey_meta_box' );

function vpfo_render_survey_meta_box( $post ) {
	// Use nonce for verification
	wp_nonce_field( 'vpfo_save_survey_meta', 'vpfo_survey_nonce' );

	// Get current values (if any)
	$display_survey = get_post_meta( $post->ID, '_vpfo_display_survey', true );

	// Display the toggle checkbox
	echo '<p>';
	echo '<label for="vpfo_display_survey">';
	echo '<input type="checkbox" id="vpfo_display_survey" name="vpfo_display_survey" value="1"' . checked( $display_survey, '1', false ) . '> Append Survey Feedback callout to the end of page content';
	echo '</label>';
	echo '</p>';
}

function vpfo_save_survey_meta( $post_id ) {
	if ( ! isset( $_POST['vpfo_survey_nonce'] ) || ! wp_verify_nonce( $_POST['vpfo_survey_nonce'], 'vpfo_save_survey_meta' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check user permissions
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	// sanitize post id for db insertion
	$post_id_sanitized = absint( $post_id );

	// Save the 'display survey' checkbox value
	$display_survey           = isset( $_POST['vpfo_display_survey'] ) ? '1' : '0';
	$display_survey_sanitized = esc_html( $display_survey );
	update_post_meta( $post_id_sanitized, '_vpfo_display_survey', $display_survey_sanitized );
}
add_action( 'save_post', 'vpfo_save_survey_meta' );

// Set up ability to append archive links to the sidenav on sidenav template pages
function vpfo_add_archive_links_meta_box() {
	// Check if the custom post types are activated
	if ( ! get_option( 'vpfo_activate_finance_cpt', false ) ) {
		return; // Exit if the post type are not activated
	}

	$screen = get_current_screen();
	if ( $screen && 'page' === $screen->id ) {
		global $post;
		if ( $post && get_page_template_slug( $post->ID ) === 'vpfo-page-sidenav.php' ) {
			add_meta_box(
				'vpfo_archive_links_meta_box',
				'Archive Links in Sidenav',
				'vpfo_render_archive_links_meta_box',
				'page',
				'side',
				'default'
			);
		}
	}
}
add_action( 'add_meta_boxes', 'vpfo_add_archive_links_meta_box' );

function vpfo_render_archive_links_meta_box( $post ) {
	// Use nonce for verification
	wp_nonce_field( 'vpfo_save_archive_links_meta', 'vpfo_archive_links_nonce' );

	// Get current values (if any)
	$archive_links = get_post_meta( $post->ID, '_vpfo_archive_links', true );
	$archive_links = is_array( $archive_links ) ? $archive_links : array();

	// Display checkboxes
	echo '<p>';
	echo '<label>';
	echo '<input type="checkbox" name="vpfo_archive_links[]" value="resources"' . checked( in_array( 'resources', $archive_links, true ), true, false ) . '> Resources';
	echo '</label>';
	echo '</p>';

	echo '<p>';
	echo '<label>';
	echo '<input type="checkbox" name="vpfo_archive_links[]" value="glossary-terms"' . checked( in_array( 'glossary-terms', $archive_links, true ), true, false ) . '> Glossary of Terms';
	echo '</label>';
	echo '</p>';
}

function vpfo_save_archive_links_meta( $post_id ) {
	// Check if nonce is set and valid
	if ( ! isset( $_POST['vpfo_archive_links_nonce'] ) || ! wp_verify_nonce( $_POST['vpfo_archive_links_nonce'], 'vpfo_save_archive_links_meta' ) ) {
		return;
	}

	// Check autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check user permissions
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	// Sanitize post ID for db insertion
	$post_id_sanitized = absint( $post_id );

	// Save the archive links as an array
	$archive_links = isset( $_POST['vpfo_archive_links'] ) && is_array( $_POST['vpfo_archive_links'] )
		? array_map( 'sanitize_text_field', $_POST['vpfo_archive_links'] )
		: array();

	update_post_meta( $post_id_sanitized, '_vpfo_archive_links', $archive_links );
}
add_action( 'save_post', 'vpfo_save_archive_links_meta' );

// Set up the footer selection options on the VPFO templates
function vpfo_add_footer_meta_box() {
	$screen = get_current_screen();
	if ( $screen && 'page' === $screen->id ) {
		global $post;
		if ( $post && ( get_page_template_slug( $post->ID ) === 'vpfo-page.php' || get_page_template_slug( $post->ID ) === 'vpfo-page-sidenav.php' ) ) {
			add_meta_box(
				'vpfo_footer_meta_box',
				'Footer Selection',
				'vpfo_render_footer_meta_box',
				'page',
				'side',
				'default'
			);
		}
	}
}
add_action( 'add_meta_boxes', 'vpfo_add_footer_meta_box' );

function vpfo_render_footer_meta_box( $post ) {
	// Use nonce for verification
	wp_nonce_field( 'vpfo_save_footer_meta', 'vpfo_footer_nonce' );

	// Get the current value (if any) or set the default to 'vpfo-footer'
	$footer_selection = get_post_meta( $post->ID, '_vpfo_footer_selection', true );
	if ( empty( $footer_selection ) ) {
		$footer_selection = 'vpfo-footer';
	}

	// Display the radio buttons
	echo '<p>';
	echo '<label>';
	echo '<input type="radio" name="vpfo_footer_selection" value="vpfo-footer"' . checked( $footer_selection, 'vpfo-footer', false ) . '> VPFO Footer';
	echo '</label>';
	echo '</p>';

	echo '<p>';
	echo '<label>';
	echo '<input type="radio" name="vpfo_footer_selection" value="default-footer"' . checked( $footer_selection, 'default-footer', false ) . '> Default Footer';
	echo '</label>';
	echo '</p>';
}

function vpfo_save_footer_meta( $post_id ) {
	if ( ! isset( $_POST['vpfo_footer_nonce'] ) || ! wp_verify_nonce( $_POST['vpfo_footer_nonce'], 'vpfo_save_footer_meta' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['vpfo_footer_selection'] ) ) {
		$footer_selection_sanitized = sanitize_text_field( $_POST['vpfo_footer_selection'] );
		update_post_meta( $post_id, '_vpfo_footer_selection', $footer_selection_sanitized );
	}
}
add_action( 'save_post', 'vpfo_save_footer_meta' );

// Create the VPFO Footer settings area under Appearance
function vpfo_footer_admin_menu() {
	add_theme_page(
		'VPFO Footer',              // Page title
		'VPFO Footer',              // Menu title
		'manage_options',           // Capability
		'vpfo-footer',              // Menu slug
		'vpfo_footer_settings_page' // Callback function
	);
}
add_action( 'admin_menu', 'vpfo_footer_admin_menu' );

function vpfo_footer_settings_init() {
	// Register a new setting for the Land Acknowledgement
	register_setting(
		'vpfo_footer',
		'vpfo_land_acknowledgement',
		array(
			'type'              => 'string',
			'sanitize_callback' => function ( $value ) {
				return wp_kses_post( wpautop( $value ) );
			},
			'show_in_rest'      => true,
		)
	);

	// Register a new setting for Okan Campus Link URL
	register_setting(
		'vpfo_footer',
		'vpfo_okan_campus_link_url',
		array(
			'type'              => 'string',
			'sanitize_callback' => 'esc_url_raw',
			'show_in_rest'      => true,
		)
	);

	// Register a new setting for Okan Campus Link Label
	register_setting(
		'vpfo_footer',
		'vpfo_okan_campus_link_label',
		array(
			'type'              => 'string',
			'sanitize_callback' => 'sanitize_text_field',
			'show_in_rest'      => true,
		)
	);

	// Register a new setting for VPFO Message
	register_setting(
		'vpfo_footer',
		'vpfo_message',
		array(
			'type'              => 'string',
			'sanitize_callback' => function ( $value ) {
				return wp_kses_post( wpautop( $value ) );
			},
			'show_in_rest'      => true,
		)
	);

	// Register Unit Links (stored as a serialized array)
	register_setting(
		'vpfo_footer',
		'vpfo_unit_links',
		array(
			'type'              => 'array',
			'sanitize_callback' => 'vpfo_sanitize_unit_links',
			'show_in_rest'      => false,
		)
	);

	// Add a settings section
	add_settings_section(
		'vpfo_footer_section',
		'Settings',
		'vpfo_footer_section_callback',
		'vpfo_footer'
	);

	// Add the Land Acknowledgement textarea field
	add_settings_field(
		'vpfo_land_acknowledgement',
		'Land Acknowledgement',
		'vpfo_land_acknowledgement_callback',
		'vpfo_footer',
		'vpfo_footer_section'
	);

	// Add the Okan Campus Link URL field
	add_settings_field(
		'vpfo_okan_campus_link_url',
		'Okan Campus Link URL',
		'vpfo_okan_campus_link_url_callback',
		'vpfo_footer',
		'vpfo_footer_section'
	);

	// Add the Okan Campus Link Label field
	add_settings_field(
		'vpfo_okan_campus_link_label',
		'Okan Campus Link Label',
		'vpfo_okan_campus_link_label_callback',
		'vpfo_footer',
		'vpfo_footer_section'
	);

	// Add the VPFO Message (WYSIWYG) field
	add_settings_field(
		'vpfo_message',
		'VPFO Message',
		'vpfo_message_callback',
		'vpfo_footer',
		'vpfo_footer_section'
	);

	// Add the Unit Links field
	add_settings_field(
		'vpfo_unit_links',
		'Unit Links',
		'vpfo_unit_links_callback',
		'vpfo_footer',
		'vpfo_footer_section'
	);
}
add_action( 'admin_init', 'vpfo_footer_settings_init' );

// Sanitize callback for Unit Links
function vpfo_sanitize_unit_links( $input ) {
	if ( is_array( $input ) ) {
		foreach ( $input as $key => $link ) {
			$input[ $key ]['url']   = isset( $link['url'] ) ? esc_url_raw( $link['url'] ) : '';
			$input[ $key ]['label'] = isset( $link['label'] ) ? sanitize_text_field( $link['label'] ) : '';
		}
	}
	return $input;
}

// Section description callback
function vpfo_footer_section_callback() {
	echo '<p>Customize the VPFO Footer settings below.</p>';
}

// Field rendering callback for Land Acknowledgement
function vpfo_land_acknowledgement_callback() {
	$value = get_option( 'vpfo_land_acknowledgement', '' );
	wp_editor(
		$value,
		'vpfo_land_acknowledgement',
		array(
			'textarea_name' => 'vpfo_land_acknowledgement',
			'textarea_rows' => 8,
			'media_buttons' => false,
		)
	);
}

// Field rendering callback for Okan Campus Link URL
function vpfo_okan_campus_link_url_callback() {
	$value = get_option( 'vpfo_okan_campus_link_url', '' );
	echo '<input type="url" name="vpfo_okan_campus_link_url" value="' . esc_url( $value ) . '" style="width: 100%;" />';
}

// Field rendering callback for Okan Campus Link Label
function vpfo_okan_campus_link_label_callback() {
	$value = get_option( 'vpfo_okan_campus_link_label', '' );
	echo '<input type="text" name="vpfo_okan_campus_link_label" value="' . esc_attr( $value ) . '" style="width: 100%;" />';
}

// Field rendering callback for VPFO Message (WYSIWYG)
function vpfo_message_callback() {
	$value = get_option( 'vpfo_message', '' );
	wp_editor(
		$value,
		'vpfo_message',
		array(
			'textarea_name' => 'vpfo_message',
			'textarea_rows' => 2,
			'media_buttons' => false,
		)
	);
}

function vpfo_unit_links_callback() {
	// Retrieve existing links
	$unit_links = get_option( 'vpfo_unit_links', array() );

	// Output the container for dynamic fields
	echo '<div id="vpfo-unit-links-container">';

	if ( ! empty( $unit_links ) ) {
		foreach ( $unit_links as $index => $link ) {
			echo '<div class="vpfo-unit-link-item" style="margin-bottom: 12px">';
			echo '<input type="url" name="vpfo_unit_links[' . esc_html( $index ) . '][url]" placeholder="Link URL" value="' . esc_url( $link['url'] ) . '" style="width: 35%; margin-right: 12px;" />';
			echo '<input type="text" name="vpfo_unit_links[' . esc_html( $index ) . '][label]" placeholder="Link Label" value="' . esc_attr( $link['label'] ) . '" style="width: 35%; margin-right: 12px;" />';
			echo '<button type="button" class="button vpfo-remove-link">Remove</button>';
			echo '</div>';
		}
	}

	echo '</div>';

	// Add button to append new links
	echo '<button type="button" class="button" id="vpfo-add-link">Add Link</button>';
}

function vpfo_footer_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	echo '<div class="wrap">';
	echo '<h1>VPFO Footer</h1>';
	echo '<form method="post" action="options.php">';

	// Output settings fields and sections
	settings_fields( 'vpfo_footer' );
	do_settings_sections( 'vpfo_footer' );
	submit_button();

	echo '</form>';
	echo '</div>';
}

// Create Settings area for activating the VPFO Finance custom post types and taxonomies
function vpfo_add_settings_page() {
	add_options_page(
		'VPFO Templates & Styles',
		'VPFO Templates & Styles',
		'manage_options',
		'vpfo-templates-styles',
		'vpfo_render_settings_page',
	);
}
add_action( 'admin_menu', 'vpfo_add_settings_page' );

function vpfo_register_settings() {
	register_setting(
		'vpfo_templates_styles',
		'vpfo_activate_finance_cpt',
		array(
			'type'              => 'boolean',
			'description'       => 'Activate VPFO Finance custom post types and taxonomies',
			'sanitize_callback' => 'rest_sanitize_boolean',
			'default'           => false,
		)
	);

	register_setting(
		'vpfo_templates_styles',
		'vpfo_posts_use_vpfo_archive',
		array(
			'type'              => 'boolean',
			'description'       => 'For the posts (announcements) archive, use the VPFO template instead of the CLF default',
			'sanitize_callback' => 'rest_sanitize_boolean',
			'default'           => false,
		)
	);

	register_setting(
		'vpfo_templates_styles',
		'vpfo_posts_use_vpfo_single',
		array(
			'type'              => 'boolean',
			'description'       => 'For single posts (announcements), use the VPFO template instead of the CLF default',
			'sanitize_callback' => 'rest_sanitize_boolean',
			'default'           => false,
		)
	);

	register_setting(
		'vpfo_templates_styles',
		'vpfo_announcements_archive_intro',
		array(
			'type'              => 'string',
			'sanitize_callback' => function ( $value ) {
				return wp_kses_post( wpautop( $value ) );
			},
			'show_in_rest'      => true,
		)
	);

	register_setting(
		'vpfo_templates_styles',
		'vpfo_resources_archive_intro',
		array(
			'type'              => 'string',
			'sanitize_callback' => function ( $value ) {
				return wp_kses_post( wpautop( $value ) );
			},
			'show_in_rest'      => true,
		)
	);

	register_setting(
		'vpfo_templates_styles',
		'vpfo_glossary_terms_archive_intro',
		array(
			'type'              => 'string',
			'sanitize_callback' => function ( $value ) {
				return wp_kses_post( wpautop( $value ) );
			},
			'show_in_rest'      => true,
		)
	);

	register_setting(
		'vpfo_templates_styles',
		'vpfo_survey_heading',
		array(
			'type'              => 'string',
			'sanitize_callback' => 'sanitize_text_field',
			'show_in_rest'      => true,
		)
	);

	register_setting(
		'vpfo_templates_styles',
		'vpfo_survey_yes',
		array(
			'type'              => 'string',
			'sanitize_callback' => function ( $value ) {
				return wp_kses_post( wpautop( $value ) );
			},
			'show_in_rest'      => true,
		)
	);

	register_setting(
		'vpfo_templates_styles',
		'vpfo_survey_no',
		array(
			'type'              => 'string',
			'sanitize_callback' => function ( $value ) {
				return wp_kses_post( wpautop( $value ) );
			},
			'show_in_rest'      => true,
		)
	);
}
add_action( 'admin_init', 'vpfo_register_settings' );

function vpfo_render_settings_page() {
	?>
	<div class="wrap">
		<h1>VPFO Templates &amp; Styles</h1>
		<form method="post" action="options.php">
			<?php
			settings_fields( 'vpfo_templates_styles' );
			do_settings_sections( 'vpfo_templates_styles' );
			submit_button();
			?>
		</form>
	</div>
	<?php
}

function vpfo_add_settings_field() {
	add_settings_section(
		'vpfo_templates_styles_section',
		'Settings',
		'vpfo_settings_section_description',
		'vpfo_templates_styles',
	);

	add_settings_field(
		'vpfo_activate_finance_cpt',
		'Activate Custom Post Types',
		'vpfo_render_finance_cpt_checkbox',
		'vpfo_templates_styles',
		'vpfo_templates_styles_section',
	);

	add_settings_field(
		'vpfo_posts_use_vpfo_single',
		'Use VPFO Template for Single Posts (Announcements)',
		'vpfo_render_use_vpfo_single_checkbox',
		'vpfo_templates_styles',
		'vpfo_templates_styles_section',
	);

	add_settings_field(
		'vpfo_posts_use_vpfo_archive',
		'Use VPFO Template for Posts (Announcements) Archive',
		'vpfo_render_use_vpfo_archive_checkbox',
		'vpfo_templates_styles',
		'vpfo_templates_styles_section',
	);

	add_settings_field(
		'vpfo_announcements_archive_intro',
		'Announcements Archive Intro',
		'vpfo_render_announcements_archive_intro',
		'vpfo_templates_styles',
		'vpfo_templates_styles_section',
	);

	add_settings_field(
		'vpfo_resources_archive_intro',
		'Resources Archive Intro',
		'vpfo_render_resources_archive_intro',
		'vpfo_templates_styles',
		'vpfo_templates_styles_section',
	);

	add_settings_field(
		'vpfo_glossary_terms_archive_intro',
		'Glossary of Terms Archive Intro',
		'vpfo_render_glossary_terms_archive_intro',
		'vpfo_templates_styles',
		'vpfo_templates_styles_section',
	);

	add_settings_field(
		'vpfo_survey_heading',
		'Survey Feedback Heading',
		'vpfo_render_survey_heading',
		'vpfo_templates_styles',
		'vpfo_templates_styles_section',
	);

	add_settings_field(
		'vpfo_survey_yes',
		'Survey Message (Yes)',
		'vpfo_render_survey_yes',
		'vpfo_templates_styles',
		'vpfo_templates_styles_section',
	);

	add_settings_field(
		'vpfo_survey_no',
		'Survey Message (No)',
		'vpfo_render_survey_no',
		'vpfo_templates_styles',
		'vpfo_templates_styles_section',
	);
}
add_action( 'admin_init', 'vpfo_add_settings_field' );

function vpfo_settings_section_description() {
	echo '<p>Manage activation and display of custom post types (Resources and Glossary Terms) specific to the VPFO Finance unit, including archive display options.</p>';
}

function vpfo_render_finance_cpt_checkbox() {
	$option = get_option( 'vpfo_activate_finance_cpt', false );
	?>
	<label>
		<input type="checkbox" name="vpfo_activate_finance_cpt" value="1" <?php checked( $option, true ); ?>>
		Activate custom post types (Resources and Glossary Terms) and their associated taxonomies.
	</label>
	<?php
}

function vpfo_render_use_vpfo_single_checkbox() {
	$option = get_option( 'vpfo_posts_use_vpfo_single', false );
	?>
	<label>
		<input type="checkbox" name="vpfo_posts_use_vpfo_single" value="1" <?php checked( $option, true ); ?>>
		Use the VPFO template for single posts (announcements) instead of the default CLF template.
	</label>
	<?php
}

function vpfo_render_use_vpfo_archive_checkbox() {
	$option = get_option( 'vpfo_posts_use_vpfo_archive', false );
	?>
	<label>
		<input type="checkbox" name="vpfo_posts_use_vpfo_archive" value="1" <?php checked( $option, true ); ?>>
		Use the VPFO template for posts (announcements) archive instead of the default CLF template.
	</label>
	<?php
}

function vpfo_render_announcements_archive_intro() {
	$value = get_option( 'vpfo_announcements_archive_intro', '' );
	wp_editor(
		$value,
		'vpfo_announcements_archive_intro',
		array(
			'textarea_name' => 'vpfo_announcements_archive_intro',
			'textarea_rows' => 8,
			'media_buttons' => false,
		)
	);
}

function vpfo_render_resources_archive_intro() {
	$value = get_option( 'vpfo_resources_archive_intro', '' );
	wp_editor(
		$value,
		'vpfo_resources_archive_intro',
		array(
			'textarea_name' => 'vpfo_resources_archive_intro',
			'textarea_rows' => 8,
			'media_buttons' => false,
		)
	);
}

function vpfo_render_glossary_terms_archive_intro() {
	$value = get_option( 'vpfo_glossary_terms_archive_intro', '' );
	wp_editor(
		$value,
		'vpfo_glossary_terms_archive_intro',
		array(
			'textarea_name' => 'vpfo_glossary_terms_archive_intro',
			'textarea_rows' => 8,
			'media_buttons' => false,
		)
	);
}

function vpfo_render_survey_heading() {
	$value = get_option( 'vpfo_survey_heading', '' );
	echo '<input type="text" name="vpfo_survey_heading" value="' . esc_attr( $value ) . '" style="width: 100%;" />';
}

function vpfo_render_survey_yes() {
	$value = get_option( 'vpfo_survey_yes', '' );
	wp_editor(
		$value,
		'vpfo_survey_yes',
		array(
			'textarea_name' => 'vpfo_survey_yes',
			'textarea_rows' => 4,
			'media_buttons' => false,
		)
	);
}

function vpfo_render_survey_no() {
	$value = get_option( 'vpfo_survey_no', '' );
	wp_editor(
		$value,
		'vpfo_survey_no',
		array(
			'textarea_name' => 'vpfo_survey_no',
			'textarea_rows' => 4,
			'media_buttons' => false,
		)
	);
}

// use the VPFO single template for posts if this option is activated
function vpfo_single_post_template( $template ) {
	if ( is_singular( 'post' ) ) {
		if ( get_option( 'vpfo_posts_use_vpfo_single', false ) ) {
			// Path to your custom template in the plugin
			$plugin_template = plugin_dir_path( __DIR__ ) . 'templates/vpfo-single.php';

			// Check if the plugin template exists
			if ( file_exists( $plugin_template ) ) {
				return $plugin_template;
			}
		}
	}

	return $template; // Return the default template if conditions are not met
}
add_filter( 'template_include', 'vpfo_single_post_template' );

// use the VPFO archive template for posts if this option is activated
function vpfo_archive_post_template( $template ) {
	if ( is_home() ) {
		if ( get_option( 'vpfo_posts_use_vpfo_archive', false ) ) {
			// Path to your custom template in the plugin
			$plugin_template = plugin_dir_path( __DIR__ ) . 'templates/vpfo-archive.php';

			// Check if the plugin template exists
			if ( file_exists( $plugin_template ) ) {
				return $plugin_template;
			}
		}
	}

	return $template; // Return the default template if conditions are not met
}
add_filter( 'template_include', 'vpfo_archive_post_template' );

// Filter quote block rendering to check expiry date and "Never Expire" setting.
function vpfo_stop_quote_render_expiry_date( $block_content, $block ) {
	// Target the core/quote block.
	if ( 'core/quote' === $block['blockName'] && isset( $block['attrs'] ) ) {
		$attrs = $block['attrs'];

		// Sanitize the attributes.
		$expiry_date  = isset( $attrs['expiryDate'] ) ? sanitize_text_field( $attrs['expiryDate'] ) : null;
		$never_expire = isset( $attrs['neverExpire'] ) ? filter_var( $attrs['neverExpire'], FILTER_VALIDATE_BOOLEAN ) : true;

		// If "Never Expire" is checked, always render the block.
		if ( $never_expire ) {
			return $block_content;
		}

		// Check expiry date if set.
		if ( ! empty( $expiry_date ) ) {
			// Convert expiry date to WordPress timezone.
			$wp_timezone = wp_timezone(); // Get WordPress timezone as a DateTimeZone object.
			try {
				$expiry_datetime = new DateTime( $expiry_date, new DateTimeZone( 'UTC' ) );
				$expiry_datetime->setTimezone( $wp_timezone );

				// Get the current time in WordPress timezone.
				$current_datetime = new DateTime( 'now', $wp_timezone );

				// Render the block if the expiry date is today or later.
				if ( $expiry_datetime->format( 'Y-m-d' ) >= $current_datetime->format( 'Y-m-d' ) ) {
					return $block_content;
				}
			} catch ( Exception $e ) {
				// If the expiry date is invalid, prevent rendering.
				return '';
			}
		}

		// If no expiry date or expired, prevent rendering.
		return '';
	}

	return $block_content;
}
add_filter( 'render_block', 'vpfo_stop_quote_render_expiry_date', 10, 2 );
