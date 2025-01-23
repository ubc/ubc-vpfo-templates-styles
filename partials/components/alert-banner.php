<?php
$display_alert = get_post_meta( get_the_ID(), '_vpfo_display_alert', true ) ?? '0';
$alert_message = get_post_meta( get_the_ID(), '_vpfo_alert_message', true ) ?? null;
$expiry_date   = get_post_meta( get_the_ID(), '_vpfo_alert_expiry', true ) ?? null;

$expiry_date_passed = false;

if ( $expiry_date ) {
	// Get current date as 'Y-m-d' string
	$now = current_time( 'Y-m-d' );

	// Compare the current date with the expiry date
	if ( $now > $expiry_date ) {
		$expiry_date_passed = true;
	}
}

$page_path   = $_SERVER['REQUEST_URI'];
$cookie_name = 'alert_closed_' . str_replace( '/', '_', $page_path );

if ( '1' === $display_alert && $alert_message && ! $expiry_date_passed && ( ! isset( $_COOKIE[ $cookie_name ] ) || 'true' !== $_COOKIE[ $cookie_name ] ) ) {
	?>
	<section class="alert-banner p-5">
		<div class="container-lg px-0">
			<div class="alert-banner-inner d-flex flex-column flex-sm-row align-items-start position-relative pe-12">
				<div class="alert-banner-message">
					<?php echo wp_kses_post( $alert_message ); ?>
				</div>

				<div class="position-absolute close">
					<button type="button" class="icon-close">
						<i class="far fa-circle-xmark"></i>
					</button>
				</div>
			</div>
		</div>
	</section>
	<?php
}

unset( $display_alert, $alert_message );
?>