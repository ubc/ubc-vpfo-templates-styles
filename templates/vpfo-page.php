<?php
/* Template Name: VPFO Default Page */

// use the custom override header instead of the default clf header
vpfo_get_custom_header( 'vpfo' );

// include an alert banner if one is set, conditional checks are in the partial
require plugin_dir_path( __DIR__ ) . 'partials/components/alert-banner.php';

// include a hero image banner if its display is set and page has a featured image, conditional checks are in the partial
require plugin_dir_path( __DIR__ ) . 'partials/components/hero-image-banner.php';
?>

<div class="container-lg px-lg-0">
<?php
if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		?>
	
		<section class="page-content mt-5 mt-lg-9">
			<h1 class="page-title mb-9">
				<?php
				if ( is_front_page() ) {
					esc_html_e( 'Welcome to UBC Finance', 'ubc-vpfo-templates-styles' );
				} else {
					the_title();
				}
				?>
			</h1>
			<?php
			the_content(); ?>
		</section>
	
		<?php
	endwhile;
endif;
?>
</div>

<?php
// include the pattern slide graphic accent partial
require plugin_dir_path( __DIR__ ) . 'partials/templates/pattern-slice-bottom.php';

get_footer();
