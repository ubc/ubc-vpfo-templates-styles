<?php
// Get this page's slug (used in archive links workaround)
$page_slug = $post->post_name;

// set up our child level menu pages
foreach ( $children as $child ) {
	$child_id    = $child->ID;
	$child_title = $child->post_title;
	$child_url   = get_permalink( $child_id );

	$grandchildren = get_pages(
		array(
			'child_of'    => $child_id,
			'parent'      => $child_id,
			'sort_column' => 'menu_order',
		)
	);

	$has_grandchildren = ! empty( $grandchildren ) && count( $grandchildren ) > 0 ? true : false;

	if ( $has_grandchildren ) {
		?>
		<div class="accordion">
			<div class="ac">
				<div class="ac-header d-flex align-items-center justify-content-between">
					<a href="<?php echo esc_url( $child_url ); ?>" rel="bookmark" title="<?php echo esc_html( $child_title ); ?>">
						<?php echo esc_html( $child_title ); ?>
					</a>
					<button type="button" class="ac-trigger"></button>
				</div>
				<div class="ac-panel">
					<ul>
						<?php
						foreach ( $grandchildren as $grandchild ) {
							?>
							<li>
								<a href="<?php echo esc_url( get_permalink( $grandchild->ID ) ); ?>" rel="bookmark" title="<?php echo esc_html( $grandchild->post_title ); ?>">
									<?php echo esc_html( $grandchild->post_title ); ?>
								</a>
							<?php
						}
						?>
					</ul>
				</div>
			</div>
		</div>
		<?php
	} else {
		?>
		<div class="no-accordion">
			<a href="<?php echo esc_url( $child_url ); ?>" rel="bookmark" title="<?php echo esc_html( $child_title ); ?>">
				<?php echo esc_html( $child_title ); ?>
			</a>
		</div>
		<?php
	}
}

if ( 'doing-business-with-ubc' === $page_slug ) {
	$glossary_archive_link = get_post_type_archive_link( 'glossary-terms' );
	?>
	<div class="no-accordion">
		<a href="<?php echo esc_url( $glossary_archive_link ); ?>" rel="bookmark" title="<?php esc_html_e( 'Glossary of Terms', 'ubc-vpfo-templates-styles' ); ?>">
			<?php esc_html_e( 'Glossary of Terms', 'ubc-vpfo-templates-styles' ); ?>
		</a>
	</div>
	<?php
}
