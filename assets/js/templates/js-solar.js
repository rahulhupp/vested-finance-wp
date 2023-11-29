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

	//solar slider
	$(".solar_slider_image").slick({
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
					asNavFor: ".solar_slider_content",
					vertical: false,
					verticalSwiping: false,
					autoplay: false,
				},
			},
		],
	});
	if ($(window).width() <= 767) {

		$(".solar_slider_content").slick({
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
						asNavFor: ".solar_slider_image",
						vertical: false,
						dots: true,
						speed: 800,
					},
				},
			],
		});

	}
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

	//solar slider controls

	var percentTimeOne;
	var tickOne;
	var timeOne = 0.1;
	var progressBarIndexOne = 0;

	$(".solar_slider_content .progressBar").each(function (index) {
		var progressOne = "<div class='inProgress inProgress" + index + "'></div>";
		$(this).html(progressOne);
	});

	$(".solar_slider_content .slick-dots li").each(function (index) {
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
				'.solar_slider_image .slick-track div[data-slick-index="' +
				progressBarIndexOne +
				'"]'
			).attr("aria-hidden") === "true"
		) {
			progressBarIndexOne = $(
				'.solar_slider_image .slick-track div[aria-hidden="false"]'
			).data("slickIndex");
			startProgressbarOne();
		} else {
			percentTimeOne += 1 / (timeOne + 4);
			var $progressBarOne = $(".solar_slider_content .inProgress" + progressBarIndexOne);
			var $progressbarMobOne = $(".solar_slider_content .slick-dots li .inProgress" + progressBarIndex);
			$progressBarOne.closest(".single_portfolio_slider_content").addClass("slide-current");


			// Check screen width and update width or height accordingly

			$progressBarOne.css({
				height: percentTimeOne + "%",
			});

			$progressbarMobOne.css({
				width: percentTimeOne + "%",
			});

			if (percentTimeOne >= 100) {
				$(".solar-single-item").slick("slickNext");
				progressBarIndexOne++;
				if (progressBarIndexOne > 4) {
					progressBarIndexOne = 0;
				}
				startProgressbarOne();
			}
		}
	}

	function resetProgressbarOne() {
		$(".solar_slider_content .inProgress").css({
			height: 0 + "%",
		});
		$(".solar_slider_content .slick-dots li .inProgress").css({
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

	$(".solar_slider_content .single_portfolio_slider_content").click(function () {
		clearInterval(tickOne);
		var goToThisIndex = $(this).find("span").data("slickIndex");
		goToThisIndex = goToThisIndex - 1;
		$(".solar-single-item").slick("slickGoTo", goToThisIndex, false);
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

	// function checkForVests() {
	// 	var vestsValue = localStorage.getItem("vests");

	// 	if (vestsValue === "true") {
	// 		$(".foundation-list ul").slick({
	// 			slidesToShow: 3,
	// 			slidesToScroll: 1,
	// 			infinite: true,
	// 			autoplay: true,
	// 			autoplaySpeed: 2000,
	// 			dots: false,
	// 			arrows: false,
	// 			responsive: [
	// 				{
	// 					breakpoint: 767,
	// 					settings: {
	// 						infinite: true,
	// 						slidesToShow: 2,
	// 						slidesToScroll: 1,
	// 					},
	// 					breakpoint: 600,
	// 					settings: {
	// 						slidesToShow: 1,
	// 					}
	// 				},
	// 			],
	// 		});
	// 		localStorage.removeItem("vests");
	// 	} else {
	// 		setTimeout(checkForVests, 1000); // Check again in 1 second
	// 	}
	// }

	// if ($(window).width() <= 992) {
	// 	localStorage.removeItem("vests");
	// 	checkForVests();
	// }

	$(".single_portfolio_slider_content[data-slick-index='0']").addClass("slide-active");

	$(".solar_slider_image").on('beforeChange', function (event, slick, currentSlide) {

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
	// $('.stock-info .stock-row .stock-content p b a').click(function () {
	// 	$('.banner_popup_overlay').show();
	// 	$('html').addClass('disclosure-popup-open');
	// });

	// $('.banner_popup_overlay .close_btn').click(function () {
	// 	$('.banner_popup_overlay').hide();
	// 	$('html').removeClass('disclosure-popup-open');
	// });
	// Show the first tab and hide the rest
	if (window.matchMedia('(max-width: 767px)').matches) {
		$('.toggle').click(function(e) {
			e.preventDefault();
		  let $this = $(this);
		  if ($this.next().hasClass('show')) {
			  $this.next().removeClass('show');
			  $this.removeClass('active');
			  $this.next().slideUp(350);
		  } else {
			  $this.parent().parent().find('.content_wrap').removeClass('show');
			  $('.toggle').removeClass('active');
			  $this.parent().parent().find('.content_wrap').slideUp(350);
			  $this.next().toggleClass('show');
			  $this.toggleClass('active');
			  $this.next().slideToggle(350);
		  }
	  });
	}
	else {
		$('.solar_tabs #tabs-nav li:first-child').addClass('active');
		$('.solar_tabs .tab-content').hide();
		$('.solar_tabs .tab-content:first').show();

		// Click function
		$('.solar_tabs #tabs-nav li').click(function(){
		$('.solar_tabs #tabs-nav li').removeClass('active');
		$(this).addClass('active');
		$('.solar_tabs .tab-content').hide();
		
		var activeTab = $(this).find('a').attr('href');
		$(activeTab).fadeIn();
		return false;
		});
	}
});
