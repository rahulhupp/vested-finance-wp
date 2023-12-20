jQuery(document).ready(function () {
	jQuery("header .inner-header .site-primary-header-wrap .logo-menu .humburger").click(function () {
		jQuery("body").toggleClass("menu-open");
	});
});