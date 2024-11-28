<?php
/* Template Name: VPFO Resources */

// use the custom override header instead of the default clf header
vpfo_get_custom_header( 'vpfo' );
?>

<div class="container-lg px-lg-0">
<?php
if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		?>
	
		<section class="page-content resource-content mt-5 mt-lg-9">
			<h1 class="page-title mb-9">
				<?php the_title(); ?>
			</h1>
			<?php the_content(); ?>
		</section>
	
		<?php
	endwhile;
endif;
?>
</div>

<?php
// include the pattern slide graphic accent partial
require plugin_dir_path( __DIR__ ) . 'partials/templates/pattern-slice-bottom.php';

vpfo_get_custom_footer( 'vpfo' );
