<?php
// Get this page's archive links post meta (used for optional archive links appended to sidenav)
$archive_links = get_post_meta( $post->ID, '_vpfo_archive_links', true ) ?? array();

if ( ! empty( $archive_links ) && get_option( 'vpfo_activate_finance_cpt', false ) ) {
	foreach ( $archive_links as $archive_link ) {
		$archive_link_url = get_post_type_archive_link( $archive_link );

		if ( 'resources' === $archive_link ) {
			$archive_link_label = __( 'Resources', 'ubc-vpfo-templates-styles' );
		} elseif ( 'glossary-terms' === $archive_link ) {
			$archive_link_label = __( 'Glossary of Terms', 'ubc-vpfo-templates-styles' );
		}
		?>
		<div class="no-accordion">
			<a href="<?php echo esc_url( $archive_link_url ); ?>" rel="bookmark">
				<?php echo esc_html( $archive_link_label ); ?>
			</a>
		</div>
		<?php
	}
	?>
	<?php
}
