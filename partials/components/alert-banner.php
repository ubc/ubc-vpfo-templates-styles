<?php
$display_alert = get_post_meta( get_the_ID(), '_vpfo_display_alert', true ) ?? '0';
$alert_message = get_post_meta( get_the_ID(), '_vpfo_alert_message', true ) ?? null;

if ( '1' === $display_alert && $alert_message ) {
	?>
	<section class="alert-banner p-5">
		<div class="container-lg px-0">
			<div class="alert-banner-inner d-flex flex-column flex-sm-row align-items-start">
				<?php echo wp_kses_post( $alert_message ); ?>
			</div>
		</div>
	</section>
	<?php
}

unset( $display_alert, $alert_message );
?>