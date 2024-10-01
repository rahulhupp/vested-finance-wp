jQuery(document).ready(function () {
	// Show the first tab and hide the rest for both desktop and mobile tabs
	jQuery("#tabs-nav li:first-child").addClass("active");
	jQuery("#mob-tabs li:first-child").addClass("active");
	jQuery(".tab-content").hide();
	jQuery(".tab-content:first").show();

	// Click function for desktop tabs
	jQuery("#tabs-nav li").click(function () {
		jQuery("#tabs-nav li").removeClass("active");
		jQuery("#mob-tabs li").removeClass("active");
		jQuery(this).addClass("active");

		var activeTab = jQuery(this).find("a").attr("href");
		jQuery(".tab-content").hide();
		jQuery(activeTab).fadeIn();
		return false;
	});

	// Click function for mobile tabs
	jQuery("#mob-tabs li").click(function () {
		jQuery("#mob-tabs li").removeClass("active");
		jQuery("#tabs-nav li").removeClass("active");

		var activeTabMobile = jQuery(this).find("a").attr("href");
		var correspondingDeskTab = jQuery("#tabs-nav li").find("a[href='" + activeTabMobile + "']");

		if (correspondingDeskTab.length > 0) {
			correspondingDeskTab.parent().addClass("active");
		}

		jQuery(this).addClass("active");

		jQuery(".tab-content").hide();
		jQuery(activeTabMobile).fadeIn();
		return false;
	});

	jQuery('.vest_about_content').slideUp();
	jQuery('.chart_desc_btn + .chart').slideUp();

	jQuery('#vest_read_more').click(function(){
		jQuery('.vest_about_content').slideToggle();
		jQuery(this).toggleClass('collapsed');
		if(jQuery('#vest_read_more span').text() === 'More') {
			jQuery('#vest_read_more span').text('Less');
			jQuery(this).children('i').css('transform', 'rotate(180deg)');
		}
		else {
			jQuery('#vest_read_more span').text('More');
			jQuery(this).children('i').css('transform', 'rotate(0deg)');
		}
	});

	jQuery('.chart_desc_btn').click(function(){
		jQuery('.chart_desc_btn + .chart').slideToggle();
	});
});


// portfolio slider
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
				breakpoint: 767,
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
				breakpoint: 767,
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

	//stocks slider
	$(".us_stocks_slider").slick({
		infinite: true,
		arrows: false,
		dots: false,
		autoplay: false,
		speed: 800,
		slidesToShow: 1,
		slidesToScroll: 1,
		vertical: true,
		verticalSwiping: false,
		responsive: [
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					asNavFor: ".stocks_slider_content",
					vertical: false,
					verticalSwiping: false,
					autoplay: false,
				},
			},
		],
	});
	if ($(window).width() <= 767) {

		$(".stocks_slider_content").slick({
			arrows: false,
			dots: false,
			autoplay: false,
			slidesToShow: 4,
			responsive: [
				{
					breakpoint: 768,
					settings: {
						infinite: true,
						slidesToShow: 1,
						slidesToScroll: 1,
						asNavFor: ".us_stocks_slider",
						vertical: false,
						dots: true,
						speed: 800,
					},
				},
			],
		});

	}

	$("#vestsResultsList").slick({
		infinite: true,
		arrows: false,
		dots: false,
		autoplay: true,
		speed: 800,
		slidesToShow: 4,
		slidesToScroll: 1,
		vertical: true,
		verticalSwiping: true,
	});

	//ticking machine
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
			var $progressBar = $(".portfolio_slider_content .inProgress" + progressBarIndex);
			var $progressbarMob = $(".portfolio_slider_content .slick-dots li .inProgress" + progressBarIndex);

			// Check screen width and update width or height accordingly

			$progressBar.css({
				height: percentTime + "%",
			});
			$progressbarMob.css({
				width: percentTime + "%",
			});

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


	//stock slider controls

	var percentTimeOne;
	var tickOne;
	var timeOne = 0.1;
	var progressBarIndexOne = 0;

	$(".stocks_slider_content .progressBar").each(function (index) {
		var progressOne = "<div class='inProgress inProgress" + index + "'></div>";
		$(this).html(progressOne);
	});
	$(".stocks_slider_content .slick-dots li").each(function (index) {
		var progressOne = "<div class='inProgress inProgress" + index + "'></div>";
		$(this).html(progressOne);
	});

	function startProgressbarOne() {
		resetProgressbarOne();
		percentTimeOne = 0;
		tickOne = setInterval(intervalOne, 10);
	}

	function intervalOne() {
		if (
			$(
				'.us_stocks_slider .slick-track div[data-slick-index="' +
				progressBarIndexOne +
				'"]'
			).attr("aria-hidden") === "true"
		) {
			progressBarIndexOne = $(
				'.us_stocks_slider .slick-track div[aria-hidden="false"]'
			).data("slickIndex");
			startProgressbarOne();
		} else {
			percentTimeOne += 1 / (timeOne + 4);
			var $progressBarOne = $(".stocks_slider_content .inProgress" + progressBarIndexOne);
			var $progressbarMobOne = $(".stocks_slider_content .slick-dots li .inProgress" + progressBarIndexOne);

			$progressBarOne.closest(".single_portfolio_slider_content").addClass("slide-current");
			// Check screen width and update width or height accordingly

			$progressBarOne.css({
				height: percentTimeOne + "%",
			});
			$progressbarMobOne.css({
				width: percentTimeOne + "%",
			});

			if (percentTimeOne >= 100) {
				$(".stock-single-item").slick("slickNext");
				progressBarIndexOne++;
				if (progressBarIndexOne > 4) {
					progressBarIndexOne = 0;
				}
				startProgressbarOne();
			}
		}
	}

	function resetProgressbarOne() {
		$(".stocks_slider_content .inProgress").css({
			height: 0 + "%",
		});
		$(".stocks_slider_content .slick-dots li .inProgress").css({
			width: 0 + "%",
		});
		$(".single_portfolio_slider_content.slide-current").removeClass("slide-current");
		clearInterval(tickOne);
	}
	startProgressbarOne();


	// End ticking machine

	$(".single_portfolio_slider_content").click(function () {
		clearInterval(tick);
		var goToThisIndex = $(this).find("span").data("slickIndex");
		goToThisIndex = goToThisIndex - 1;
		$(".single-item").slick("slickGoTo", goToThisIndex, false);
		startProgressbar();
	});

	$(".stocks_slider_content .single_portfolio_slider_content").click(function () {
		clearInterval(tickOne);
		var goToThisIndex = $(this).find("span").data("slickIndex");
		goToThisIndex = goToThisIndex - 1;
		$(".stock-single-item").slick("slickGoTo", goToThisIndex, false);
		startProgressbarOne();
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

	// mobile slider for vests

	function checkForVests() {
		var vestsValue = localStorage.getItem("vests");

		if (vestsValue === "true") {
			$(".foundation-list ul").slick({
				slidesToShow: 3,
				slidesToScroll: 1,
				infinite: true,
				autoplay: true,
				autoplaySpeed: 2000,
				dots: false,
				arrows: false,
				responsive: [
					{
						breakpoint: 767,
						settings: {
							infinite: true,
							slidesToShow: 2,
							slidesToScroll: 1,
						},
						breakpoint: 600,
						settings: {
							slidesToShow: 1,
						}
					},
				],
			});
			localStorage.removeItem("vests");
		} else {
			setTimeout(checkForVests, 1000); // Check again in 1 second
		}
	}

	if ($(window).width() <= 992) {
		console.log('992px');
		localStorage.removeItem("vests");
		checkForVests();
	}

	if ($(window).width() <= 767) {
		$(".post-listing ul").slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			infinite: true,
			autoplay: true,
			autoplaySpeed: 2000,
			dots: false,
			arrows: false,
		});
	}

	$(".single_portfolio_slider_content[data-slick-index='0']").addClass("slide-active");

	$(".us_stocks_slider").on('beforeChange', function (event, slick, currentSlide) {

		var $activeSinglePortfolioSlider = $(this).find('.single_portfolio_slider.slick-current');
		var currentIndex = $activeSinglePortfolioSlider.data("slick-index");

		$(".single_portfolio_slider_content").each(function () {
			var slideIndex = $(this).data("slick-index");
			if (slideIndex !== 0 && slideIndex === currentIndex + 1) {
				$(this).addClass("slide-active");
			} else {
				$(this).removeClass("slide-active");
			}
		});
	});

	$('.stock-info .stock-row .stock-content p b a').click(function () {
		$('.banner_popup_overlay').show();
		$('html').addClass('disclosure-popup-open');
	});

	$('.banner_popup_overlay .close_btn').click(function () {
		$('.banner_popup_overlay').hide();
		$('html').removeClass('disclosure-popup-open');
	});
});


