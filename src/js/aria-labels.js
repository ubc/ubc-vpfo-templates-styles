document.addEventListener('DOMContentLoaded', function () {
	function addAriaLabelsToLinks(parentSelector, titleSelector, linkSelector) {
		// Get all parent elements based on the provided selector
		const parentElements = document.querySelectorAll(parentSelector);

		// Loop through each parent element
		parentElements.forEach(parent => {
			// Find the title element within the parent
			const titleElement = parent.querySelector(titleSelector);
			// Find the link element within the parent
			const linkElement = parent.querySelector(linkSelector);

			// Ensure both title and link elements exist
			if (titleElement && linkElement) {
				// Extract the text content from the title element
				const titleText = titleElement.textContent.trim();

				// Set the aria-label attribute on the link element
				linkElement.setAttribute('aria-label', `Read more about ${titleText}`);
			}
		});
	}

	addAriaLabelsToLinks('.resource-card', '.wp-block-heading', '.view-resource a');
	addAriaLabelsToLinks('.image-card', '.wp-block-heading', '.view-link a');
	addAriaLabelsToLinks('.post-listing', '.wp-block-post-title', '.wp-block-read-more');
	addAriaLabelsToLinks('.cross-post-listing', '.wp-block-ubc-api-title', '.wp-block-read-more');
});