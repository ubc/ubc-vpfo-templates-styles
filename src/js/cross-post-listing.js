// Function to handle adding "Read more" links
function addReadMoreLinks() {
	document.querySelectorAll('.vpfo .cross-post-listing li.wp-single-resource').forEach((crosspostItem) => {
		// Step 1: Look for the <a> link with the class .wp-block-post-excerpt__more-link
		const moreLink = crosspostItem.querySelector('.wp-block-post-excerpt__more-link');
		if (moreLink) {
			const href = moreLink.href; // Extract the href URL

			// Remove any existing "Read more" link to avoid duplication
			const existingReadMoreLink = crosspostItem.querySelector('.wp-block-read-more');
			if (existingReadMoreLink) {
				existingReadMoreLink.remove();
			}

			// Step 2: Create a new <a> element with the correct URL
			const readMoreLink = document.createElement('a');
			readMoreLink.className = 'wp-block-read-more';
			readMoreLink.href = href;
			readMoreLink.target = '_blank';
			readMoreLink.textContent = 'Read more';

			// Insert the new <a> element as the last child of the <li>
			crosspostItem.appendChild(readMoreLink);
		}
	});
}

// Function to reset link text
function resetLinkText(selector, newText) {
	// Select all elements matching the selector
	document.querySelectorAll(selector).forEach((link) => {
		// Update the text content of each link
		link.textContent = newText;
	});
}

// Initial call to add "Read more" links and reset link text
addReadMoreLinks();
resetLinkText('.vpfo .cross-post-listing .ubc-api__pagination .prev', 'Previous');
resetLinkText('.vpfo .cross-post-listing .ubc-api__pagination .next', 'Next');

// Function to observe changes to the data-wp-context attribute
function observeDataWpContextChanges() {
	const targetElement = document.querySelector('.vpfo .cross-post-listing .ctlt-rss-block');

	if (!targetElement) {
		return;
	}

	// Create a MutationObserver
	const observer = new MutationObserver((mutationsList) => {
		mutationsList.forEach((mutation) => {
			if (mutation.type === 'attributes' && mutation.attributeName === 'data-wp-context') {
				// Re-run the functions on attribute change
				addReadMoreLinks(); // Ensure URLs are reevaluated
				resetLinkText('.vpfo .cross-post-listing .ubc-api__pagination .prev', 'Previous');
				resetLinkText('.vpfo .cross-post-listing .ubc-api__pagination .next', 'Next');
			}
		});
	});

	// Observe attribute changes on the target element
	observer.observe(targetElement, {
		attributes: true, // Watch for attribute changes
		attributeFilter: ['data-wp-context'], // Only observe this specific attribute
	});
}

// Start observing
observeDataWpContextChanges();