<?php
/* Template Name: VPFO Default Page */

// use the custom override header instead of the default clf header
vpfo_get_custom_header( 'vpfo' );

// include an alert banner if one is set, conditional checks are in the partial
require plugin_dir_path( __DIR__ ) . 'partials/components/alert-banner.php';
?>

<div class="container-lg px-lg-0">
<?php
if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		?>
	
		<section class="page-content mt-5 mt-lg-9">
			<h1 class="page-title mb-9"><?php the_title(); ?></h1>
			<?php the_content(); ?>
		</section>
	
		<?php
	endwhile;
endif;
?>
</div>

<?php
get_footer();
