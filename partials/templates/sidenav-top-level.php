<?php
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

// append additional archive links if required, conditionals are in partial
require plugin_dir_path( __DIR__ ) . 'templates/sidenav-add-archive-links.php';
