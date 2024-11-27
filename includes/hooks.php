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

	// sanitize post id for db insertion
	$post_id_sanitized = absint( $post_id );

	// Save the 'display alert' checkbox value
	$display_alert           = isset( $_POST['vpfo_display_alert'] ) ? '1' : '0';
	$display_alert_sanitized = esc_html( $display_alert );
	update_post_meta( $post_id_sanitized, '_vpfo_display_alert', $display_alert_sanitized );

	// Save the alert message textarea value
	if ( isset( $_POST['vpfo_alert_message'] ) ) {
		update_post_meta( $post_id_sanitized, '_vpfo_alert_message', sanitize_textarea_field( $_POST['vpfo_alert_message'] ) );
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
