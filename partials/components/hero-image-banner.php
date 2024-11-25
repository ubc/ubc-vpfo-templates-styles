<?php
$display_hero   = get_post_meta( get_the_ID(), '_vpfo_display_hero', true ) ?? '0';
$featured_image = get_the_post_thumbnail( get_the_ID(), 'full' ) ?? null;

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