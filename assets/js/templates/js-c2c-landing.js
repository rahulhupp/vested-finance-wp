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

  $(".terms-link  b a").click(function () {
    $(".banner_popup_overlay").show();
    $("html").addClass("disclosure-popup-open");
  });
  
  $(".banner_popup_overlay .close_btn").click(function () {
    $(".banner_popup_overlay").hide();
    $("html").removeClass("disclosure-popup-open");
  });
});
