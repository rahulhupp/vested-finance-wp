jQuery(document).ready(function ($) {
	$(".portfolio_slider").slick({
		infinite: true,
		arrows: false,
		dots: false,
		autoplay: false,
		speed: 800,
		slidesToShow: 1,
		slidesToScroll: 1,
		vertical: true,
		verticalSwiping: true,
		responsive: [
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					asNavFor: ".portfolio_slider_content",
					vertical: false,
					verticalSwiping: false,
				},
			},
		],
	});

	$(".portfolio_slider_content").slick({
		infinite: true,
		arrows: false,
		dots: false,
		autoplay: false,
		speed: 800,
		slidesToShow: 3,
		slidesToScroll: 1,
		vertical: true,
		responsive: [
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					asNavFor: ".portfolio_slider",
					vertical: false,
					dots: true,
				},
			},
		],
	});

    $(".advantages-slider").slick({
		infinite: false,
		arrows: false,
		dots: false,
		autoplay: true,
		autoplaySpeed: 6000,
		speed: 600,
		slidesToShow: 4,
		slidesToScroll: 1,
        centerMode: false,
        adaptiveHeight: false,
		responsive: [
			{
				breakpoint: 1240,
				settings: {
					slidesToShow: 3,
				},
			},
			{
				breakpoint: 991,
				settings: {
					slidesToShow: 2,
				},
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
				},
			},
		],
	});

	$(".testimonials-slider").slick({
		slidesToShow: 3,
		slidesToScroll: 1,
		infinite: true,
		arrows: true,
		dots: false,
		autoplay: true,
		speed: 800,
		adaptiveHeight: true,
		prevArrow: $(".testimonial-prev"),
    	nextArrow: $(".testimonial-next"),
		responsive: [
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					adaptiveHeight: false,
				},
			},
		],
	});

	jQuery(function ($) {
		$(".faq_que").click(function (j) {
			var dropDown = $(this).closest(".single_faq").find(".faq_content");
			$(this)
				.closest(".home_page_faq_wrap")
				.find(".faq_content")
				.not(dropDown)
				.slideUp();
			if ($(this).hasClass("active")) {
				$(this).removeClass("active");
			} else {
				$(this)
					.closest(".home_page_faq_wrap")
					.find(".faq_que.active")
					.removeClass("active");
				$(this).addClass("active");
			}
			dropDown.stop(false, true).slideToggle();
			j.preventDefault();
		});
	});

	var percentTime;
	var tick;
	var time = 0.1;
	var progressBarIndex = 0;

	$(".portfolio_slider_content .progressBar").each(function (index) {
		var progress = "<div class='inProgress inProgress" + index + "'></div>";
		$(this).html(progress);
	});
	$(".portfolio_slider_content .slick-dots li").each(function (index) {
		var progress = "<div class='inProgress inProgress" + index + "'></div>";
		$(this).html(progress);
	});

	function startProgressbar() {
		resetProgressbar();
		percentTime = 0;
		tick = setInterval(interval, 10);
	}

	function interval() {
		if (
			$(
				'.portfolio_slider .slick-track div[data-slick-index="' +
				progressBarIndex +
				'"]'
			).attr("aria-hidden") === "true"
		) {
			progressBarIndex = $(
				'.portfolio_slider .slick-track div[aria-hidden="false"]'
			).data("slickIndex");
			startProgressbar();
		} else {
			percentTime += 1 / (time + 4);
			var $progressBar = $(
				".portfolio_slider_content .inProgress" + progressBarIndex
			);
			var $progressbarMob = $(
				".portfolio_slider_content .slick-dots li .inProgress" +
				progressBarIndex
			);

			// Check screen width and update width or height accordingly

			$progressBar.css({
				height: percentTime + "%",
			});
			$progressbarMob.css({
				width: percentTime + "%",
			});

			if (progressBarIndex === 1) {
				$(".how_it_works_disclosure").show();
			} else {
				$(".how_it_works_disclosure").hide();
			}

			if (percentTime >= 100) {
				$(".single-item").slick("slickNext");
				progressBarIndex++;
				if (progressBarIndex > 3) {
					progressBarIndex = 0;
				}
				startProgressbar();
			}
		}
	}

	function resetProgressbar() {
		$(".portfolio_slider_content .inProgress").css({
			height: 0 + "%",
		});
		$(".portfolio_slider_content .slick-dots li .inProgress").css({
			width: 0 + "%",
		});
		clearInterval(tick);
	}
	startProgressbar();

	$(".single_portfolio_slider_content").click(function () {
		clearInterval(tick);
		var goToThisIndex = $(this).find("span").data("slickIndex");
		goToThisIndex = goToThisIndex - 1;
		$(".single-item").slick("slickGoTo", goToThisIndex, false);
		startProgressbar();
	});

	$(".single_portfolio_slider_content[data-slick-index='0']").addClass("slide-active");


	$('.funds-content .small-desc a').click(function () {
		$('.banner_popup_overlay').show();
		$('html').addClass('disclosure-popup-open');
	});

	$('.banner_popup_overlay .close_btn').click(function () {
		$('.banner_popup_overlay').hide();
		$('html').removeClass('disclosure-popup-open');
	});
});