<?php

// set up the default VPFO template as the starting page template for new pages
function vpfo_set_default_template_on_new_page( $post_id, $post, $update ) {
	// Only proceed if it's a page, it's not an update (new page), and it's in the admin area
	if ( $post->post_type === 'page' && !$update && is_admin() ) {
		$default_template = 'vpfo-page.php'; // Replace with your custom template slug

		// Check if the page has a template assigned; if not, set the default template
		if ( get_post_meta( $post_id, '_wp_page_template', true ) === '' ) {
			update_post_meta( $post_id, '_wp_page_template', $default_template );
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
				'Alert Settings',
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

	// Save the 'display alert' checkbox value
	$display_alert = isset( $_POST['vpfo_display_alert'] ) ? '1' : '0';
	update_post_meta( $post_id, '_vpfo_display_alert', $display_alert );

	// Save the alert message textarea value
	if ( isset( $_POST['vpfo_alert_message'] ) ) {
		update_post_meta( $post_id, '_vpfo_alert_message', sanitize_textarea_field( $_POST['vpfo_alert_message'] ) );
	}
}
add_action( 'save_post', 'vpfo_save_alert_meta' );
