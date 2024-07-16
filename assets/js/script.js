
jQuery(document).ready(function ($) {
	$(".investors_slider").slick({
		infinite: true,
		arrows: false,
		dots: false,
		autoplay: true,
		speed: 800,
		slidesToShow: 4,
		slidesToScroll: 1,
		responsive: [
			{
				breakpoint: 992,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 1,
				},
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
				},
			},
			{
				breakpoint: 601,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
				},
			},
		],
	});

	$(".investor_prev").click(function () {
		$(".investors_slider").slick("slickPrev");
	});

	$(".investor_next").click(function () {
		$(".investors_slider").slick("slickNext");
	});
	$(".investor_prev").addClass("slick-disabled");
	$(".investors_slider").on("afterChange", function () {
		if ($(".slick-prev").hasClass("slick-disabled")) {
			$(".investor_prev").addClass("slick-disabled");
		} else {
			$(".investor_prev").removeClass("slick-disabled");
		}
		if ($(".slick-next").hasClass("slick-disabled")) {
			$(".investor_next").addClass("slick-disabled");
		} else {
			$(".investor_next").removeClass("slick-disabled");
		}
	});
});

jQuery(document).ready(function() {
    jQuery("a.ez-toc-link").click(function(event) {
        // Check if the clicked link is not a comment reply link
        if (!jQuery(this).hasClass('comment-reply-link')) {
            let t = jQuery(this).attr("href"),
                e = jQuery("#wpadminbar"),
                i = jQuery("header"),
                o = 0;
            if (eztoc_smooth_local.scroll_offset > 30) {
                o = eztoc_smooth_local.scroll_offset;
            }
            if (e.length) {
                o += e.height();
            }
            if ((i.length && "fixed" == i.css("position")) || "sticky" == i.css("position")) {
                o += i.height();
            }
            if (jQuery('[ez-toc-data-id="' + decodeURI(t) + '"]').length > 0) {
                o = jQuery('[ez-toc-data-id="' + decodeURI(t) + '"]').offset().top - o;
            }
            jQuery("html, body").animate({scrollTop: o}, 500);
            event.preventDefault();
        }
    });
});
