<?php
/* Template Name: VPFO Sidenav Page */

// use the custom override header instead of the default clf header
vpfo_get_custom_header( 'vpfo' );

// include an alert banner if one is set, conditional checks are in the partial
require plugin_dir_path( __DIR__ ) . 'partials/components/alert-banner.php';

// check if this page has children
$children = get_pages( array(
	'child_of'    => $post->ID,
	'parent'      => $post->ID,
	'sort_column' => 'menu_order',
) );

$has_children = ! empty( $children ) && count( $children ) > 0;

// Check if this page is a top level page
$is_top_level = $post->post_parent === 0;

// Check if this page is a child
$is_child = $post->post_parent > 0;

// Check if this page is a grandchild
$is_grandchild = $is_child && get_post_field( 'post_parent', $post->post_parent ) > 0;

if ( $is_top_level ) {
	$mobile_menu_toggle_title = get_the_title();
	$mobile_menu_toggle_link = get_the_permalink();
} else {
	if ( $is_grandchild ) {
		$grandparent_id = get_post_field( 'post_parent', $post->post_parent );
		$mobile_menu_toggle_title = get_the_title( $grandparent_id );
		$mobile_menu_toggle_link = get_the_permalink( $grandparent_id );
	} else {
		$mobile_menu_toggle_title = get_the_title( $post->post_parent );
		$mobile_menu_toggle_link = get_the_permalink( $post->post_parent );
	}
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
			<div class="ac-header d-flex align-items-center">
				<span class="flex-grow-1"><?php esc_html_e( $mobile_menu_toggle_title ); ?></span>
				<a href="<?php echo esc_url( $mobile_menu_toggle_link ); ?>" rel="bookmark" title="<?php esc_html_e( $mobile_menu_toggle_title ); ?>" class="top-level-view-link<?php
				if ( $is_top_level ) {
					echo ' d-none';
				}
				?>">
					<?php esc_html_e( 'View', 'ubc-vpfo-templates-styles' ); ?>
				</a>
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
				<div class="<?php esc_html_e($main_col_class); ?>">
					<h1 class="page-title mb-9"><?php the_title(); ?></h1>
					<?php the_content(); ?>
				</div>
			</div>
		</section>
	
		<?php
	endwhile;
endif;
?>
</div>

<?php
get_footer();
