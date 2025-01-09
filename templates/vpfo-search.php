<?php
/**
 * VPFO Search Template
 *
 * The search template is loaded when a visitor uses the search form to search for something
 * on the site and the option for VPFO 404 Template is active.
 *
 *
 */

vpfo_get_custom_header( 'vpfo' ); ?>

<div class="container-lg px-lg-0">
	<section class="page-content mt-5 mt-lg-9">
		<h1 class="page-title mb-9">
			<?php echo wp_kses_post( __( 'Search Results for', 'ubc-vpfo-templates-styles' ) ) . ' &quot;' . esc_attr( get_search_query() ) . '&quot;'; ?>
		</h1>

		<?php
		if ( have_posts() ) {
			echo '<div class="archive">';
			while (
				have_posts()
			) :
				the_post();
				require plugin_dir_path( __DIR__ ) . 'partials/templates/archive-card-search.php';
			endwhile;
			vpfo_numeric_pagination();
			echo '</div>';
		} else {
			$no_results_message = get_option( 'vpfo_search_no_results', null );
			if ( $no_results_message ) {
				echo wp_kses_post( $no_results_message );
			} else {
				echo '<p>';
				echo wp_kses_post( 'No results were found for your search query. Please try a different search query, or use the navigation menu to find the information you are looking for. If you are UBC Staff or Faculty, you may find what you are looking for in the <a href="https://finance.share.ubc.ca/" target="_blank">UBC Finance Portal</a>.', 'ubc-vpfo-templates-styles' );
				echo '</p>';
			}

			echo '<div class="vpfo-search">';
			get_search_form();
			echo '</div>';
		}
		?>
	</section>
</div>

<?php
// include the pattern slide graphic accent partial
require plugin_dir_path( __DIR__ ) . 'partials/templates/pattern-slice-bottom.php';

vpfo_get_custom_footer( 'vpfo' ); ?>
