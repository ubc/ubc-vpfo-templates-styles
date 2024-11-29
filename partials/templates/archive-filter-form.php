<?php
// used in templates/vpfo-archive.php
if ( 'resources' === $post_type ) {
	$cat_tax = 'resources-categories';
} elseif ( 'glossary-terms' === $post_type ) {
	$cat_tax = 'glossary-categories';
} else {
	$cat_tax = 'category';
}
?>

<div class="archive-filters">
	<div class="pattern position-absolute w-100 h-100"></div>
	<div class="gradient-overlay position-absolute w-100 h-100"></div>

	<form id="<?php echo esc_html( $post_type . '-filters' ); ?>" class="archive-filter-form position-relative">
		<div class="text-search">
			<label class="input-label d-block" for="<?php echo esc_html( $post_type . '-search' ); ?>">
				<?php esc_html_e( 'Search', 'ubc-vpfo-templates-styles' ); ?>
			</label>
			<div class="search-input">
				<input type="search" id="<?php echo esc_html( $post_type . '-search' ); ?>" name="s" placeholder="<?php esc_html_e( 'Search', 'ubc-vpfo-templates-styles' ); ?>" value="" />
			</div>
		</div>

		<div class="cat-tax mt-9">
			<h3 class="mb-4">
				<?php esc_html_e( 'Filter Results', 'ubc-vpfo-templates-styles' ); ?>
			</h3>

			<label class="input-label d-block mb-3" for="<?php echo esc_html( $post_type . '-category' ); ?>">
				<?php esc_html_e( 'Category', 'ubc-vpfo-templates-styles' ); ?>
			</label>
			<div class="cat-tax-select">
				<select id="<?php echo esc_html( $post_type . '-category' ); ?>" 
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
		</div>

		<div class="submit-button mt-7">
			<button type="submit" class="btn btn-secondary">
				<?php esc_html_e( 'Submit Filters', 'ubc-vpfo-templates-styles' ); ?>
			</button>
		</div>

	</form>
</div>