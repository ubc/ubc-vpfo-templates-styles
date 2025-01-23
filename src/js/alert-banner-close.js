document.addEventListener('DOMContentLoaded', function () {
	const closeButtons = document.querySelectorAll('.alert-banner .icon-close');

	closeButtons.forEach(button => {
		button.addEventListener('click', function () {
			const alertBanner = this.closest('.alert-banner');
			
			if (alertBanner) {
				// Get the current page URL (or a unique portion of it)
				const pagePath = window.location.pathname; // e.g., "/about-us/"
				
				// Set a cookie specific to this page
				const cookieName = `alert_closed_${pagePath.replace(/\//g, '_')}`; // e.g., "alert_closed__about_us_"
				document.cookie = `${cookieName}=true; max-age=86400; path=/`;

				// Remove the banner immediately
				alertBanner.remove();
			}
		});
	});
});