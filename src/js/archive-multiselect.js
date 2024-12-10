document.addEventListener('DOMContentLoaded', function () {
	const selectContainer = document.querySelector('.cat-tax-select');
	const nativeSelect = selectContainer.querySelector('select');
	const options = Array.from(nativeSelect.options);

	// Create custom UI
	const selectedArea = document.createElement('div');
	selectedArea.className = 'cat-tax-selected';
	selectedArea.setAttribute('role', 'combobox');
	selectedArea.setAttribute('aria-expanded', 'false');
	selectedArea.setAttribute('aria-haspopup', 'listbox');
	selectedArea.setAttribute('tabindex', '0');

	const placeholder = document.createElement('span');
	placeholder.className = 'cat-tax-placeholder';
	placeholder.textContent = 'Select Multiple';
	placeholder.setAttribute('aria-hidden', 'true');

	const selectedItemsContainer = document.createElement('div');
	selectedItemsContainer.className = 'cat-tax-selected-items';

	const arrow = document.createElement('span');
	arrow.className = 'arrow';
	arrow.innerHTML = '&#9662;';

	selectedArea.append(placeholder, selectedItemsContainer, arrow);

	const dropdown = document.createElement('ul');
	dropdown.className = 'cat-tax-options';
	dropdown.setAttribute('role', 'listbox');
	dropdown.setAttribute('aria-multiselectable', 'true');

	options.forEach(option => {
		if (option.value) {
			const item = document.createElement('li');
			item.dataset.value = option.value;
			item.textContent = option.textContent;
			item.setAttribute('role', 'option');
			item.setAttribute('tabindex', '-1');
			dropdown.appendChild(item);
		}
	});

	selectContainer.appendChild(selectedArea);
	selectContainer.appendChild(dropdown);

	// Accessibility state management
	function toggleDropdown(show) {
		const isOpen = selectContainer.classList.contains('open');
		const shouldOpen = show !== undefined ? show : !isOpen;
		selectContainer.classList.toggle('open', shouldOpen);
		selectedArea.setAttribute('aria-expanded', String(shouldOpen));

		if (shouldOpen) {
			// Focus the first option in the dropdown when opening
			const firstOption = dropdown.querySelector('[role="option"]');
			if (firstOption) firstOption.focus();
		}
	}

	function createSelectedItem(value, label) {
		const selectedItem = document.createElement('span');
		selectedItem.className = 'selected-item';
		selectedItem.dataset.value = value;
		selectedItem.setAttribute('tabindex', '0'); // Make focusable
		selectedItem.setAttribute('role', 'button'); // Indicate it's interactive
		selectedItem.setAttribute('aria-label', `Remove ${label}`);
		selectedItem.innerHTML = `${label} <span class="remove">&times;</span>`;
		return selectedItem;
	}

	function removeSelectedItem(value) {
		const selectedItem = selectedItemsContainer.querySelector(`[data-value="${value}"]`);
		if (selectedItem) {
			selectedItem.remove();

			// Update the native select
			const nativeOption = [...nativeSelect.options].find(opt => opt.value === value);
			if (nativeOption) {
				nativeOption.selected = false;
			}

			// Show placeholder if no items are selected
			if (selectedItemsContainer.children.length === 0) {
				placeholder.style.display = 'inline';
			}
		}
	}

	// Open/close dropdown on selected area click or Enter key
	selectedArea.addEventListener('click', (e) => {
		e.stopPropagation(); // Prevent document click listener from triggering
		toggleDropdown();
	});

	selectedArea.addEventListener('keydown', (e) => {
		if (e.key === 'Enter' || e.key === ' ') {
			e.preventDefault();
			toggleDropdown(true);
		} else if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
			e.preventDefault();
			toggleDropdown(true);
		} else if (e.key === 'Escape') {
			toggleDropdown(false);
		}
	});

	// Focus management to close dropdown when tabbing away
	selectContainer.addEventListener('focusout', (e) => {
		setTimeout(() => {
			if (!selectContainer.contains(document.activeElement)) {
				toggleDropdown(false);
			}
		}, 0);
	});

	// Select/deselect options in dropdown
	dropdown.addEventListener('click', (e) => {
		if (e.target.tagName === 'LI') {
			const value = e.target.dataset.value;
			const label = e.target.textContent;

			// Check if the item is already selected
			if (!selectedItemsContainer.querySelector(`[data-value="${value}"]`)) {
				const selectedItem = createSelectedItem(value, label);
				selectedItemsContainer.appendChild(selectedItem);

				// Update the native select
				const nativeOption = [...nativeSelect.options].find(opt => opt.value === value);
				if (nativeOption) {
					nativeOption.selected = true;
				}

				placeholder.style.display = 'none'; // Hide placeholder
			}
		}
	});

	// Handle keyboard removal of selected items
	selectedItemsContainer.addEventListener('keydown', (e) => {
		if (
			(e.key === 'Backspace' || e.key === 'Delete' || e.key === 'Enter' || e.key === ' ') &&
			e.target.classList.contains('selected-item')
		) {
			const value = e.target.dataset.value;
			removeSelectedItem(value);
		}
	});

	// Handle mouse removal of selected items
	selectedItemsContainer.addEventListener('click', (e) => {
		const selectedItem = e.target.closest('.selected-item');
		if (selectedItem) {
			const value = selectedItem.dataset.value;
			removeSelectedItem(value);
		}
	});

	// Close dropdown on outside click
	document.addEventListener('click', (e) => {
		if (!selectContainer.contains(e.target)) {
			toggleDropdown(false);
		}
	});

	// Keyboard navigation inside dropdown
	dropdown.addEventListener('keydown', (e) => {
		const focused = document.activeElement;
		if (e.key === 'ArrowDown') {
			e.preventDefault();
			const next = focused.nextElementSibling;
			if (next) next.focus();
		} else if (e.key === 'ArrowUp') {
			e.preventDefault();
			const prev = focused.previousElementSibling;
			if (prev) prev.focus();
		} else if (e.key === 'Enter' || e.key === ' ') {
			e.preventDefault();
			focused.click();
		} else if (e.key === 'Escape') {
			toggleDropdown(false);
			selectedArea.focus();
		}
	});
});