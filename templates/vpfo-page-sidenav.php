<?php
/* Template Name: VPFO Sidenav Page */

// use the custom override header instead of the default clf header
vpfo_get_custom_header( 'vpfo' );

// include an alert banner if one is set, conditional checks are in the partial
require plugin_dir_path( __DIR__ ) . 'partials/components/alert-banner.php';

// include a hero image banner if its display is set and page has a featured image, conditional checks are in the partial
require plugin_dir_path( __DIR__ ) . 'partials/components/hero-image-banner.php';

// check if this page has children
$children = get_pages(
	array(
		'child_of'    => $post->ID,
		'parent'      => $post->ID,
		'sort_column' => 'menu_order',
	)
);

$has_children = ! empty( $children ) && count( $children ) > 0;

// Check if this page is a top level page
$is_top_level = 0 === $post->post_parent;

// Check if this page is a child
$is_child = $post->post_parent > 0;

// Check if this page is a grandchild
$is_grandchild = $is_child && get_post_field( 'post_parent', $post->post_parent ) > 0;

if ( $is_top_level ) {
	$mobile_menu_toggle_title = get_the_title();
	$mobile_menu_toggle_link  = get_the_permalink();
} elseif ( $is_grandchild ) {
	$grandparent_id           = get_post_field( 'post_parent', $post->post_parent );
	$mobile_menu_toggle_title = get_the_title( $grandparent_id );
	$mobile_menu_toggle_link  = get_the_permalink( $grandparent_id );
} else {
	$mobile_menu_toggle_title = get_the_title( $post->post_parent );
	$mobile_menu_toggle_link  = get_the_permalink( $post->post_parent );
}

// Check if there are any valid sidenav links to show
$show_sidenav = ( $is_top_level && $has_children ) || $is_child;

$main_col_class = $show_sidenav ? 'col-lg-9 ps-lg-7' : 'col-lg-12';
?>

<?php
if ( $show_sidenav ) {
	?>
	<div class="accordion sticky-top sidenav sidenav-sticky-mobile d-lg-none">
		<div class="ac">
			<div class="ac-header ac-header-top d-flex align-items-center">
				<span class="flex-grow-1">
					<?php
					if ( ! $is_top_level ) {
						?>
						<a href="<?php echo esc_url( $mobile_menu_toggle_link ); ?>" rel="bookmark" title="<?php echo esc_html( $mobile_menu_toggle_title ); ?>" class="top-level-link">
						<?php
					}
					echo esc_html( $mobile_menu_toggle_title );
					if ( ! $is_top_level ) {
						?>
						</a>
						<?php
					}
					?>
				</span>
				<button type="button" class="ac-trigger"></button>
			</div>

			<div class="ac-panel">
				<?php
				if ( $is_child ) {
					require plugin_dir_path( __DIR__ ) . 'partials/templates/sidenav-children.php';
				} else {
					require plugin_dir_path( __DIR__ ) . 'partials/templates/sidenav-top-level.php';
				}
				?>
			</div>
		</div>
	</div>
	<?php
}
?>

<div class="container-lg px-lg-0">
<?php
if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		?>
	
		<section class="page-content mt-5 mt-lg-9">
			<div class="row">
				<?php
				if ( $show_sidenav ) {
					?>
					<div class="col-lg-3 d-none d-lg-block">
						<div class="sticky-top sidenav sidenav-sticky-desktop">
							<?php
							if ( $is_child ) {
								require plugin_dir_path( __DIR__ ) . 'partials/templates/sidenav-children.php';
							} else {
								require plugin_dir_path( __DIR__ ) . 'partials/templates/sidenav-top-level.php';
							}
							?>
						</div>
					</div>
					<?php
				}
				?>
				<div class="<?php echo esc_html( $main_col_class ); ?>">
					<h1 class="page-title mb-9">
						<?php the_title(); ?>
					</h1>
					<?php
					the_content();

					// include the survey feedback content if its display is set, conditional checks are in the partial
					require plugin_dir_path( __DIR__ ) . 'partials/components/survey-feedback.php';
					?>
				</div>
			</div>
		</section>
	
		<?php
	endwhile;
endif;
?>
</div>

<?php
// include the pattern slide graphic accent partial
require plugin_dir_path( __DIR__ ) . 'partials/templates/pattern-slice-bottom.php';

$use_footer = get_post_meta( get_the_ID(), '_vpfo_footer_selection', true ) ?? 'vpfo-footer';

if ( 'vpfo-footer' === $use_footer ) {
	vpfo_get_custom_footer( 'vpfo' );
} else {
	get_footer();
}
