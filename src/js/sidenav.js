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
