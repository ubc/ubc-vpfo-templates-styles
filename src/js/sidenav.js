import Accordion from 'accordion-js';

// Loop through each accordion element and initialize separately
document.querySelectorAll( '.accordion' ).forEach(
	( accordionElement ) =>
	{
		const openOnInit = accordionElement.hasAttribute( 'data-open-default' ) ? [0] : []; // Open first item if data attribute is present

		// Initialize Accordion instance for each element with openOnInit option
		new Accordion(
			accordionElement,
			{
				duration: 250,
				openOnInit: openOnInit,
			}
		);
	}
);

document.addEventListener(
	'DOMContentLoaded',
	() =>
	{
		const stickToTopElement = document.querySelector( '#ubc7-unit-menu' );
		const sidenav           = document.querySelector( '.vpfo .sidenav.sidenav-sticky-desktop' );

		if (stickToTopElement && sidenav) {
			const checkAndAdjust = () => {
				if ( stickToTopElement.classList.contains( 'stick-to-top' ) ) {
					sidenav.style.top = '61px';
				}
			};

			// Run once on load
			checkAndAdjust();

			// Run again after a short delay to catch delayed class application
			setTimeout( checkAndAdjust, 100 );
		}
	}
);