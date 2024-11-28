document.addEventListener(
	'DOMContentLoaded',
	function () {
		const container = document.getElementById( 'vpfo-unit-links-container' );
		const addButton = document.getElementById( 'vpfo-add-link' );

		if ( addButton && container ) {
			addButton.addEventListener(
				'click',
				function () {
					// Recalculate the index dynamically
					const index = container.querySelectorAll( '.vpfo-unit-link-item' ).length;

					const linkItem = document.createElement( 'div' );
					linkItem.classList.add( 'vpfo-unit-link-item' );
					linkItem.style.marginBottom = '12px';
					linkItem.innerHTML = `
						<input type="url" name="vpfo_unit_links[${index}][url]" placeholder="Link URL" style="width: 35%; margin-right: 12px;" />
						<input type="text" name="vpfo_unit_links[${index}][label]" placeholder="Link Label" style="width: 35%; margin-right: 12px;" />
						<button type="button" class="button vpfo-remove-link">Remove</button>
					`;
					container.appendChild( linkItem );
				}
			);

			container.addEventListener(
				'click',
				function (e) {
					if ( e.target.classList.contains( 'vpfo-remove-link' ) ) {
						e.target.parentElement.remove();
					}
				}
			);
		}
	}
);