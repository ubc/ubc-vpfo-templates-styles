<?php
/**
* VPFO Footer Template
*/

// get the options settings specific to this partial

$land_acknowledgement = get_option( 'vpfo_land_acknowledgement', null );

$okan_campus_url   = get_option( 'vpfo_okan_campus_link_url', 'https://ok.ubc.ca/' );
$okan_campus_label = get_option( 'vpfo_okan_campus_link_label', __( 'Visit UBC Okanagan', 'ubc-vpfo-templates-styles' ) );
$okan_campus_link  = '<a href="' . $okan_campus_url . '" target="_blank" rel="external" title="' . $okan_campus_label . '">' . $okan_campus_label . '</a>';

$vpfo_message = get_option( 'vpfo_message', null );
$unit_links   = get_option( 'vpfo_unit_links', array() );
?>

		<?php do_atomic( 'after_container' ); // hybrid_after_container ?>

	</div><!-- #container -->

	<?php
	if ( UBC_Collab_CLF::is_full_width() ) {
		echo '</div>';
	}
	?>

	<?php do_atomic( 'before_footer' ); // hybrid_before_footer ?>

	<footer id="ubc7-footer" class="expand vpfo-footer" role="contentinfo">
		<section class="vpfo-pre-footer ubc-blue utility-white-bg">
			<div class="d-lg-none mb-5">
				<?php UBC_Collab_CLF::back_to_top(); ?>
			</div>

			<div class="container-lg px-lg-0">
				<div class="row">
					<div class="col-lg-5">
						<?php
						if ( $land_acknowledgement ) {
							?>
							<p class="land-acknowledgement">
								<?php echo esc_html( $land_acknowledgement ); ?>
							</p>
							<?php
						}
						?>

						<p class="okan-campus-link">
							<?php echo wp_kses_post( $okan_campus_link ); ?>
						</p>
					</div>

					<div class="col-lg-4 offset-lg-3">
						<?php
						if ( $vpfo_message ) {
							?>
							<div class="vpfo-message">
								<?php echo wp_kses_post( $vpfo_message ); ?>
							</div>
							<?php
						}

						if ( ! empty( $unit_links ) ) {
							?>
							<div class="unit-links d-flex align-items-center flex-wrap">
								<?php
								foreach ( $unit_links as $unit_link ) {
									$unit_link_url   = $unit_link['url'] ?? null;
									$unit_link_label = $unit_link['label'] ?? null;

									$unit_link_valid = $unit_link_url && $unit_link_label;

									if ( $unit_link_valid ) {
										?>
										<div class="unit-link">
											<a href="<?php echo esc_url( $unit_link_url ); ?>" class="unit-link" target="_blank" rel="external" title="<?php echo esc_html( $unit_link_label ); ?>">
												<?php echo esc_html( $unit_link_label ); ?>
											</a>
										</div>
										<?php
									}
									?>
									<?php
								}
								?>
							</div>
							<?php
						}
						?>
					</div>
				</div>
			</div>

			<div class="d-none d-lg-block mt-5">
				<?php UBC_Collab_CLF::back_to_top(); ?>
			</div>
		</section>

		<?php UBC_Collab_CLF::global_utility_footer(); ?>
	</footer>

	<?php do_atomic( 'after_footer' ); // hybrid_after_footer ?>
</div><!-- #body-container -->

<?php do_atomic( 'after_html' ); // hybrid_after_html ?>
<?php wp_footer(); // wp_footer ?>

</body>
</html>