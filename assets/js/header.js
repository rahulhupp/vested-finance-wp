jQuery(document).ready(function () {
	jQuery("header .inner-header .site-primary-header-wrap .logo-menu .humburger").click(function () {
		jQuery("body").toggleClass("menu-open");
	});
	jQuery(".geolocation_banner .left .close").click(function () {
		jQuery(".geolocation_banner").css("display", "none");
	});
});