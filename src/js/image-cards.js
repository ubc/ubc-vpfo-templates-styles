function adjustImageCardHeight() {
	// Select all elements with class .vpfo .image-card
	const imageCards = document.querySelectorAll('.vpfo .image-card');

	imageCards.forEach((card) => {
		// Declare .vpfo .image-card-inner
		const cardInner = card.querySelector('.image-card-inner');

		// Reset the padding of .vpfo .image-card-inner
		cardInner.style.paddingBottom = '0';

		// Get the height of the .vpfo .image-card .view-link a
		const viewLink = card.querySelector('.view-link a');

		// Reset height of .vpfo .image-card .view-link a
		if (viewLink) {
			viewLink.style.height = 'auto';
			viewLink.style.visibility = 'hidden';
		}

		// Get the height of the .vpfo .image-card .view-link a
		const viewLinkHeight = viewLink ? viewLink.offsetHeight : 0;

		// Calculate the bottom padding of cardInner
		const cardInnerPadding = viewLinkHeight + 16;

		// Assign the new padding to the .vpfo .image-card-inner
		if (cardInner && cardInnerPadding) {
			cardInner.style.paddingBottom = `${cardInnerPadding}px`;
		}

		// Get the height of the .vpfo .image-card
		const cardHeight = card.offsetHeight;

		// Set the new height of the .vpfo .image-card .view-link a
		if (viewLink) {
			viewLink.style.height = `${cardHeight}px`;
			viewLink.style.visibility = 'visible';
		}
	});
}

// Run the function on initial page load
document.addEventListener('DOMContentLoaded', adjustImageCardHeight);

// Re-run the function on window resize
window.addEventListener('resize', adjustImageCardHeight);