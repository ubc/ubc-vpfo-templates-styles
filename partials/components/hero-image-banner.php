<?php
$display_hero      = get_post_meta( get_the_ID(), '_vpfo_display_hero', true ) ?? '0';
$horizontal_anchor = get_post_meta( get_the_ID(), '_vpfo_horizontal_anchor', true ) ?? 'center';
$vertical_anchor   = get_post_meta( get_the_ID(), '_vpfo_vertical_anchor', true ) ?? 'center';
$featured_image    = get_the_post_thumbnail( get_the_ID(), 'full', array( 'style' => 'object-position:' . $horizontal_anchor . ' ' . $vertical_anchor ) ) ?? null;

if ( '1' === $display_hero && $featured_image ) {
	?>
	<section class="hero-image-banner position-relative">
		<div class="hero-image-banner--image">
			<?php echo wp_kses_post( $featured_image ); ?>
		</div>

		<div class="hero-image-banner--gradient position-absolute"></div>
		<div class="hero-image-banner--pattern position-absolute"></div>
	</section>
	<?php
}

unset( $display_hero, $featured_image );
?>