<article id="<?php echo esc_html( $archive_post_type ); ?>-card-<?php the_ID(); ?>" class="archive-card archive-card-glossary-terms position-relative">
	<div class="post-content">
		<h3 class="title">
			<?php the_title(); ?>
		</h3>

		<div class="entry-content">
			<?php the_content(); ?>
		</div>
	</div>

</article>