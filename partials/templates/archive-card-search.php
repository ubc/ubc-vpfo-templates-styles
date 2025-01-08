<?php
$featured_image = get_the_post_thumbnail( get_the_ID(), 'large' ) ?? null;
$card_classes   = $featured_image ? 'archive-card archive-card-search position-relative has-featured-image' : 'archive-card archive-card-search position-relative';
?>

<article id="search-results-card-<?php the_ID(); ?>" class="<?php echo esc_html( $card_classes ); ?>">
	<div class="d-sm-flex">
		<?php
		if ( $featured_image ) {
			?>
			<div class="featured-image">
				<?php echo wp_kses_post( $featured_image ); ?>
			</div>
			<?php
		}
		?>

		<div class="post-content d-sm-flex flex-sm-column justify-content-sm-center">
			<h3 class="title">
				<?php the_title(); ?>
			</h3>

			<div class="entry-content">
				<?php echo wp_kses_post( get_vpfo_excerpt( get_the_ID(), 50 ) ); ?>
			</div>

			<div class="read-more mt-3">
				<?php esc_html_e( 'Read More', 'ubc-vpfo-templates-styles' ); ?>
			</div>
		</div>
	</div>

	<div class="whole-card-link position-absolute">
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"></a>
	</div>

</article>