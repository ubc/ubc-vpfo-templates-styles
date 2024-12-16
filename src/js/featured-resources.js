function adjustResourceCardHeight() {
	// Select all elements with class .vpfo .resource-card
	const resourceCards = document.querySelectorAll('.vpfo .resource-card');

	resourceCards.forEach((card) => {
		// Declare .vpfo .resource-card-inner
		const cardInner = card.querySelector('.resource-card-inner');

		// Reset the padding of .vpfo .resource-card-inner
		cardInner.style.paddingBottom = '0';

		// Get the height of the .vpfo .resource-card .view-resource a
		const viewLink = card.querySelector('.view-resource a');

		// Reset height of .vpfo .resource-card .view-resource a
		if (viewLink) {
			viewLink.style.height = 'auto';
			viewLink.style.visibility = 'hidden';
		}

		// Get the height of the .vpfo .resource-card .view-resource a
		const viewLinkHeight = viewLink ? viewLink.offsetHeight : 0;

		// Calculate the bottom padding of cardInner
		const cardInnerPadding = viewLinkHeight + 16;

		// Assign the new padding to the .vpfo .resource-card-inner
		if (cardInner && cardInnerPadding) {
			cardInner.style.paddingBottom = `${cardInnerPadding}px`;
		}

		// Get the height of the .vpfo .resource-card
		const cardHeight = card.offsetHeight;

		// Set the new height of the .vpfo .resource-card .view-resource a
		if (viewLink) {
			viewLink.style.height = `${cardHeight}px`;
			viewLink.style.visibility = 'visible';
		}
	});
}

// Run the function on initial page load
document.addEventListener('DOMContentLoaded', adjustResourceCardHeight);

// Re-run the function on window resize
window.addEventListener('resize', adjustResourceCardHeight);