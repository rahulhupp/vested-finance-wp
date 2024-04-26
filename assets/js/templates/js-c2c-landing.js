jQuery(document).ready(function ($) {
	$('.earn-block-grid').slick({
		slidesToShow: 4,
		infinite: false,
		responsive: [
			{
				breakpoint: 1024,
				settings: {
					slidesToShow: 3,
					dots: true,
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 1,
					dots: true,
				}
			}
		]
	});
});
