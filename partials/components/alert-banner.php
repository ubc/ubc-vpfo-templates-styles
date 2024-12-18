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

if ( '1' === $display_alert && $alert_message && ! $expiry_date_passed ) {
	?>
	<section class="alert-banner p-5">
		<div class="container-lg px-0">
			<div class="alert-banner-inner d-flex flex-column flex-sm-row align-items-start">
				<div class="alert-banner-message">
					<?php echo wp_kses_post( $alert_message ); ?>
				</div>
			</div>
		</div>
	</section>
	<?php
}

unset( $display_alert, $alert_message );
?>