<?php
// used in templates/vpfo-archive.php
if ( 'resources' === $post_type ) {
	$cat_tax = 'resources-categories';
} elseif ( 'glossary-terms' === $post_type ) {
	$cat_tax = 'glossary-terms-categories';
} else {
	$cat_tax = 'category';
}
?>

<div class="archive-filters">
	<form id="<?php echo esc_html( $post_type . '-filters' ); ?>" class="archive-filter-form">
		<div class="text-search">
			<label class="input-label d-block" for="<?php echo esc_html( $post_type . '-search' ); ?>">
				<?php esc_html_e( 'Search', 'ubc-vpfo-templates-styles' ); ?>
			</label>
			<input type="search" id="<?php echo esc_html( $post_type . '-search' ); ?>" class="input-text d-block" name="s" value="" />
		</div>

		<div class="cat-tax">
			<h3 class="h5">
				<?php esc_html_e( 'Filter Results', 'ubc-vpfo-templates-styles' ); ?>
			</h3>

			<label class="input-label d-block" for="<?php echo esc_html( $post_type . '-category' ); ?>">
				<?php esc_html_e( 'Category', 'ubc-vpfo-templates-styles' ); ?>
			</label>
			<select id="<?php echo esc_html( $post_type . '-category' ); ?>" 
					class="input-select d-block" 
					name="<?php echo esc_html( $cat_tax ); ?>[]" 
					multiple>
				<option value=""><?php esc_html_e( 'Select Multiple', 'ubc-vpfo-templates-styles' ); ?></option>
				<?php
				$terms = get_terms(
					array(
						'taxonomy'   => $cat_tax,
						'hide_empty' => true,
					)
				);

				foreach ( $terms as $term ) {
					?>
					<option value="<?php echo esc_html( $term->slug ); ?>">
						<?php echo esc_html( $term->name ); ?>
					</option>
					<?php
				}
				?>
			</select>
		</div>

		<div class="submit-button">
			<button type="submit" class="btn btn-secondary">
				<?php esc_html_e( 'Submit Filters', 'ubc-vpfo-templates-styles' ); ?>
			</button>
		</div>

	</form>
</div>