jQuery(document).ready(function () {
	jQuery("header .inner-header .site-primary-header-wrap .logo-menu .humburger").click(function () {
		jQuery("body").toggleClass("menu-open");
	});
	jQuery("header .inner-header .site-primary-header-wrap .logo-menu .menu-overlay").click(function () {
		jQuery("body").removeClass("menu-open");
	});
});