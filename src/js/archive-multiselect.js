document.addEventListener('DOMContentLoaded', function () {
	const selectContainer = document.querySelector('.cat-tax-select');
	const nativeSelect = selectContainer.querySelector('select');
	const options = Array.from(nativeSelect.options);

	// Create custom UI
	const selectedArea = document.createElement('div');
	selectedArea.className = 'cat-tax-selected';
	selectedArea.innerHTML = `
		<span class="cat-tax-placeholder">Select Multiple</span>
		<div class="cat-tax-selected-items"></div>
		<span class="arrow">&#9662;</span>
	`;

	const dropdown = document.createElement('ul');
	dropdown.className = 'cat-tax-options';

	options.forEach(option => {
		if (option.value) {
			const item = document.createElement('li');
			item.dataset.value = option.value;
			item.textContent = option.textContent;
			dropdown.appendChild(item);
		}
	});

	selectContainer.appendChild(selectedArea);
	selectContainer.appendChild(dropdown);

	const selectedItemsContainer = selectedArea.querySelector('.cat-tax-selected-items');
	const placeholder = selectedArea.querySelector('.cat-tax-placeholder');

	// Toggle dropdown visibility
	selectedArea.addEventListener('click', function () {
		selectContainer.classList.toggle('open');
	});

	// Handle option selection
	dropdown.addEventListener('click', function (e) {
		if (e.target.tagName === 'LI') {
			const value = e.target.dataset.value;
			const label = e.target.textContent;

			// Check if already selected
			if (!selectedItemsContainer.querySelector(`[data-value="${value}"]`)) {
				const selectedItem = document.createElement('span');
				selectedItem.className = 'selected-item';
				selectedItem.dataset.value = value;
				selectedItem.innerHTML = `${label} <span class="remove">&times;</span>`;
				selectedItemsContainer.appendChild(selectedItem);

				// Update the native select
				const nativeOption = [...nativeSelect.options].find(option => option.value === value);
				if (nativeOption) {
					nativeOption.selected = true; // Correctly add "selected"
				}

				placeholder.style.display = 'none'; // Hide placeholder
			}
		}
	});

	// Handle removal of selected items
	selectedItemsContainer.addEventListener('click', function (e) {
		// Find the clicked selected item
		const selectedItem = e.target.closest('.selected-item');
		if (selectedItem) {
			const value = selectedItem.dataset.value;
			selectedItem.remove();

			// Update the native select
			const nativeOption = [...nativeSelect.options].find(option => option.value === value);
			if (nativeOption) {
				nativeOption.selected = false; // Correctly remove "selected"
			}

			// Show placeholder if no items are selected
			if (selectedItemsContainer.children.length === 0) {
				placeholder.style.display = 'inline';
			}
		}
	});

	// Close dropdown if clicking outside
	document.addEventListener('click', function (e) {
		if (!selectContainer.contains(e.target)) {
			selectContainer.classList.remove('open');
		}
	});
});

document.addEventListener('DOMContentLoaded', () => {
	const stickToTopElement = document.querySelector('#ubc7-unit-menu');
	const archiveFilters = document.querySelector('.vpfo .archive-filters');

	if (stickToTopElement && archiveFilters) {
		const checkAndAdjust = () => {
			// Only run the logic if the viewport is 980px or larger
			if (window.innerWidth >= 980) {
				if (stickToTopElement.classList.contains('stick-to-top')) {
					archiveFilters.style.top = '61px';
				}
			} else {
				// Reset the style when below 980px to prevent issues
				archiveFilters.style.top = '';
			}
		};

		// Run once on load
		checkAndAdjust();

		// Run again after a short delay to catch delayed class application
		setTimeout(checkAndAdjust, 100);

		// Listen for resize events
		window.addEventListener('resize', checkAndAdjust);
	}
});