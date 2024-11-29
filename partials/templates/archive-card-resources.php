<?php
$alt_url  = get_post_meta( get_the_ID(), '_resource_url', true ) ?? null;
$link_url = $alt_url ? $alt_url : get_the_permalink();
?>

<article id="<?php echo esc_html( $archive_post_type ); ?>-card-<?php the_ID(); ?>" class="archive-card archive-card-resources position-relative">
	<div class="post-content">   
		<h3 class="title">
			<?php the_title(); ?>
		</h3>

		<div class="entry-content">
			<?php echo wp_kses_post( get_vpfo_excerpt( get_the_ID(), 25 ) ); ?>
		</div>

		<div class="read-more mt-3">
			<?php esc_html_e( 'Read More', 'ubc-vpfo-templates-styles' ); ?>
		</div>
	</div>

	<div class="whole-card-link position-absolute">
		<a href="<?php echo esc_url( $link_url ); ?>" title="<?php the_title(); ?>"></a>
	</div>

</article>