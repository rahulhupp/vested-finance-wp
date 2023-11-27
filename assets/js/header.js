jQuery(document).ready(function () {
	jQuery("header .inner-header .site-primary-header-wrap .logo-menu .humburger").click(function () {
		jQuery("body").toggleClass("menu-open");
	});
	jQuery(".geolocation_banner .left .close").click(function () {
		localStorage.setItem('geolocationBanner', 'close');
		jQuery(".geolocation_banner").css("display", "none");
	});
	var geolocationBannerStatus = localStorage.getItem('geolocationBanner');
	// Check if the value is 'close'
	if (geolocationBannerStatus === 'close') {
		// Hide the geolocation_banner
		jQuery(".geolocation_banner").css("display", "none");
	}
});