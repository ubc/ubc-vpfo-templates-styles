<?php
/**
 * VPFO 404 Template
 *
 * The 404 template is used when a reader visits an invalid URL on your site and the option for VPFO 404 Template is active.
 */

@header( 'HTTP/1.1 404 Not found', true, 404 );

vpfo_get_custom_header( 'vpfo' ); ?>

<div class="container-lg px-lg-0">
	<section class="page-content mt-5 mt-lg-9">
		<?php if ( is_active_sidebar( 'error-404-template' ) ) : ?>

			<div class="search-template-widget">
				<?php dynamic_sidebar( 'error-404-template' ); ?>
			</div>

		<?php else : ?>
			<div class="vpfo-search">
				<h1 class="page-title mb-9">
					<?php echo esc_html__( '404 - Page Not Found', 'ubc-vpfo-templates-styles' ); ?>
				</h1>

				<p>
					<?php
					echo wp_kses_post( 'The URL you requested does not exist on this site. Please use the navigation menu or the search form below to find the information you are looking for. If you are UBC Staff or Faculty, you may find what you are looking for in the <a href="https://finance.share.ubc.ca/" target="_blank">UBC Finance Portal</a>.', 'ubc-vpfo-templates-styles' );
					?>
				</p>

				<?php get_search_form(); ?>
			</div>

		<?php endif; ?>
	</section>
</div>

<?php
// include the pattern slide graphic accent partial
require plugin_dir_path( __DIR__ ) . 'partials/templates/pattern-slice-bottom.php';

vpfo_get_custom_footer( 'vpfo' ); ?>