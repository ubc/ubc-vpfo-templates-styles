<?php
$archive_object    = get_queried_object();
$archive_post_type = $archive_object->name ?? null;
$archive_post_type = is_home() ? 'post' : $archive_post_type;

if ( 'post' === $archive_post_type ) {
	$archive_title = get_the_title( get_option( 'page_for_posts' ) );
	$intro         = get_option( 'vpfo_announcements_archive_intro', null );
	$card          = 'archive-card-post';
} elseif ( 'glossary-terms' === $archive_post_type ) {
	$archive_title = __( 'Glossary of Terms', 'ubc-vpfo-templates-styles' );
	$intro         = get_option( 'vpfo_glossary_terms_archive_intro', null );
	$card          = 'archive-card-glossary-terms';
} else {
	$archive_title = $archive_object->labels->name . ' ' . __( 'Archive', 'ubc-vpfo-templates-styles' );
	$intro         = get_option( 'vpfo_' . $archive_post_type . '_archive_intro', null );
	$card          = 'archive-card-' . $archive_post_type;
}

// use the custom override header instead of the default clf header
vpfo_get_custom_header( 'vpfo' );
?>

<div class="container-lg px-lg-0">
	<section class="page-content resource-content mt-5 mt-lg-9">
		<h1 class="page-title mb-9">
			<?php echo esc_html( $archive_title ); ?>
		</h1>

		<?php
		if ( $intro ) {
			?>
			<div class="archive-intro my-9">
				<?php echo wp_kses_post( $intro ); ?>
			</div>
			<?php
		}
		?>
	</section>
<?php
if ( have_posts() ) :
	?>
	<section class="archive mb-9">
		<div class="row">
			<div class="col-lg-4 col-xl-3 pe-lg-5 mb-5 mb-lg-0">
				<?php require plugin_dir_path( __DIR__ ) . 'partials/templates/archive-filter-form.php'; ?>
			</div>

			<div class="col-lg-8 col-xl-9 ps-lg-5 card-container">
			<?php
			while ( have_posts() ) :
				the_post();
				require plugin_dir_path( __DIR__ ) . 'partials/templates/' . $card . '.php';
			endwhile;
			vpfo_numeric_pagination();
			?>
			</div>
		</div>
	</section>
	<?php
endif;
?>
</div>

<?php
vpfo_get_custom_footer( 'vpfo' );
