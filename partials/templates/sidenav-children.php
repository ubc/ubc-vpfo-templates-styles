<?php

$parent_id    = get_post_field( 'post_parent', $post->ID );
$parent_title = get_the_title( $parent_id );
$parent_url   = get_permalink( $parent_id );

$siblings = get_pages(
	array(
		'child_of'    => $parent_id,
		'parent'      => $parent_id,
		'sort_column' => 'menu_order',
	)
);

$has_siblings = ! empty( $siblings ) && count( $siblings ) > 0;

if ( $is_grandchild ) {

	$grandparent_id    = get_post_field( 'post_parent', $parent_id );
	$grandparent_title = get_the_title( $grandparent_id );
	$grandparent_url   = get_permalink( $grandparent_id );

	$parent_siblings = get_pages(
		array(
			'child_of'    => $grandparent_id,
			'parent'      => $grandparent_id,
			'sort_column' => 'menu_order',
		)
	);

	$has_parent_siblings = ! empty( $parent_siblings ) && count( $parent_siblings ) > 0;
}
?>

<div class="top-level-link d-none d-lg-flex align-items-lg-center justify-content-lg-between">
	<?php
	if ( $is_grandchild ) {
		?>
		<?php echo esc_html( $grandparent_title ); ?>
		<a href="<?php echo esc_url( $grandparent_url ); ?>" rel="bookmark" title="<?php echo esc_html( $grandparent_title ); ?>">
			<?php esc_html_e( 'View', 'ubc-vpfo-templates-styles' ); ?>
		</a>
		<?php
	} else {
		?>
		<?php echo esc_html( $parent_title ); ?>
		<a href="<?php echo esc_url( $parent_url ); ?>" rel="bookmark" title="<?php echo esc_html( $parent_title ); ?>">
			<?php esc_html_e( 'View', 'ubc-vpfo-templates-styles' ); ?>
		</a>
		<?php
	}
	?>
</div>

<?php
if ( $is_grandchild ) {
	if ( $has_parent_siblings ) {
		?>
		<div class="sidenav-menu">
			<?php
			foreach ( $parent_siblings as $parent_sibling ) {
				$parent_sibling_id = $parent_sibling->ID;
				$this_page_parent  = $parent_sibling_id === $parent_id;

				if ( $this_page_parent ) {
					?>
					<div class="accordion" data-open-default="true">
						<div class="ac">
							<div class="ac-header d-flex align-items-center justify-content-between">
								<a href="<?php echo esc_url( get_permalink( $parent_sibling_id ) ); ?>" rel="bookmark" title="<?php echo wp_kses_post( get_the_title( $parent_sibling_id ) ); ?>">
									<?php echo wp_kses_post( get_the_title( $parent_sibling_id ) ); ?>
								</a>
								<button type="button" class="ac-trigger"></button>
							</div>
							<?php
							if ( $has_siblings ) {
								?>
								<div class="ac-panel">
									<ul>
										<?php
										foreach ( $siblings as $sibling ) {
											$sibling_id = $sibling->ID;
											$this_page  = $sibling_id === $post->ID;
											?>
											<li
											<?php
											if ( $this_page ) {
												echo ' class="active-page"';
											}
											?>
											>
												<a href="<?php echo esc_url( get_permalink( $sibling->ID ) ); ?>" rel="bookmark" title="<?php echo esc_html( $sibling->post_title ); ?>">
													<?php echo esc_html( $sibling->post_title ); ?>
												</a>
											</li>
											<?php
										}
										?>
									</ul>
								</div>
								<?php
							}
							?>
						</div>
					</div>
					<?php
				} else {
					$parent_sibling_children = get_pages(
						array(
							'child_of'    => $parent_sibling_id,
							'parent'      => $parent_sibling_id,
							'sort_column' => 'menu_order',
						)
					);

					$has_parent_sibling_children = ! empty( $parent_sibling_children ) && count( $parent_sibling_children ) > 0;

					if ( $has_parent_sibling_children ) {
						?>
						<div class="accordion">
							<div class="ac">
								<div class="ac-header d-flex align-items-center justify-content-between">
									<a href="<?php echo esc_url( get_permalink( $parent_sibling->ID ) ); ?>" rel="bookmark" title="<?php echo esc_html( $parent_sibling->post_title ); ?>">
										<?php echo esc_html( $parent_sibling->post_title ); ?>
									</a>
									<button type="button" class="ac-trigger"></button>
								</div>
								<div class="ac-panel">
									<ul>
										<?php
										foreach ( $parent_sibling_children as $parent_sibling_child ) {
											?>
											<li>
												<a href="<?php echo esc_url( get_permalink( $parent_sibling_child->ID ) ); ?>" rel="bookmark" title="<?php echo esc_html( $parent_sibling_child->post_title ); ?>">
													<?php echo esc_html( $parent_sibling_child->post_title ); ?>
												</a>
											</li>
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
							<a href="<?php echo esc_url( get_permalink( $parent_sibling->ID ) ); ?>" rel="bookmark" title="<?php echo esc_html( $parent_sibling->post_title ); ?>">
								<?php echo esc_html( $parent_sibling->post_title ); ?>
							</a>
						</div>
						<?php
					}
					?>
					
					<?php
				}
			}
			?>
		</div>
		<?php
	}
} elseif ( $has_siblings ) {
	?>
	<div class="sidenav-menu">
		<?php
		foreach ( $siblings as $sibling ) {
			$sibling_id = $sibling->ID;
			$this_page  = $sibling_id === $post->ID;

			$sibling_children = get_pages(
				array(
					'child_of'    => $sibling_id,
					'parent'      => $sibling_id,
					'sort_column' => 'menu_order',
				)
			);

			$has_sibling_children = ! empty( $sibling_children ) && count( $sibling_children ) > 0;

			if ( $has_sibling_children ) {
				?>
				<div class="accordion"
				<?php
				if ( $this_page ) {
					echo ' data-open-default="true"';
				}
				?>
				>
					<div class="ac">
						<div class="ac-header d-flex align-items-center justify-content-between
						<?php
						if ( $this_page ) {
							echo ' active-page';
						}
						?>
						">
							<a href="<?php echo esc_url( get_the_permalink( $sibling_id ) ); ?>" rel="bookmark" title="<?php echo wp_kses_post( get_the_title( $sibling_id ) ); ?>">
								<?php echo wp_kses_post( get_the_title( $sibling_id ) ); ?>
							</a>
							<button type="button" class="ac-trigger"></button>
						</div>
						<div class="ac-panel">
							<ul>
								<?php
								foreach ( $sibling_children as $sibling_child ) {
									$sibling_child_id = $sibling_child->ID;
									$this_page_child  = $sibling_child_id === $post->ID;
									?>
									<li>
										<a href="<?php echo esc_url( get_the_permalink( $sibling_child_id ) ); ?>" rel="bookmark" title="<?php echo wp_kses_post( get_the_title( $sibling_child_id ) ); ?>">
											<?php echo wp_kses_post( get_the_title( $sibling_child_id ) ); ?>
										</a>
									</li>
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
				<div class="no-accordion
				<?php
				if ( $this_page ) {
					echo ' active-page';
				}
				?>
				">
					<a href="<?php echo esc_url( get_permalink( $sibling_id ) ); ?>" rel="bookmark" title="<?php echo esc_html( $sibling->post_title ); ?>">
						<?php echo esc_html( $sibling->post_title ); ?>
					</a>
				</div>
				<?php
			}
		}
		?>
	</div>
	<?php
}
