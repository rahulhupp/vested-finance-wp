document.addEventListener("DOMContentLoaded", function () {
	sliderSlide();
});
function sliderSlide() {
	var slider = document.getElementById("investment_range");
	var sliderVal = document.getElementById("investment_amt");
	var color =
		"linear-gradient(90deg, rgb(12, 199, 134) 10%, rgb(217, 228, 238) 10%)";
	slider.style.background = color;
	var minValue = 10000;
	var maxValue = 5000000;
	var x = parseFloat(sliderVal.value); // Parse the slider value to a floating-point
	var newValue = ((x - minValue) / (maxValue - minValue)) * 99 + 1; // Map the value
	var color =
		"linear-gradient(90deg, rgba(12, 199, 134, 1)" +
		newValue +
		"%, rgba(217, 228, 238, 1)" +
		newValue +
		"%)";
	slider.style.background = color;
	if (newValue > 40 && newValue <= 85) {
		slider.classList.add("ahead");
	} else if (newValue > 85) {
		slider.classList.remove("ahead");
		slider.classList.add("end");
	} else {
		slider.classList.remove("ahead");
		slider.classList.remove("end");
	}
}

jQuery(document).ready(function ($) {
	var bar = new ProgressBar.Circle(fd_results, {
		strokeWidth: 11,
		easing: 'easeInOut',
		duration: 1400,
		color: '#0cc786',
		trailColor: '#eef5fc',
		trailWidth: 7,
		svgStyle: null
	});
	bar.animate(0.5);
	$(".portfolio_slider").slick({
		infinite: true,
		arrows: false,
		dots: false,
		autoplay: true,
		autoplaySpeed: 6000, 
		speed: 600,
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
		autoplay: true,
		autoplaySpeed: 6000, 
		speed: 600,
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

	//ticking machine
	var percentTime;
	var tick;
	var time = 0.1;
	var progressBarIndex = 0;

	$(".portfolio_slider_content .progressBar").each(function (index) {
		var progress = "<div class='inProgress inProgress" + index + "'></div>";
		$(this).html(progress);
	});
	$(".slick-dots li").each(function (index) {
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
			var $progressBar = $(".inProgress" + progressBarIndex);
			var $progressbarMob = $(".slick-dots li .inProgress" + progressBarIndex);

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
				if (progressBarIndex > 2) {
					progressBarIndex = 0;
				}
				startProgressbar();
			}
		}
	}

	function resetProgressbar() {
		$(".inProgress").css({
			height: 0 + "%",
		});
		$(".slick-dots li .inProgress").css({
			width: 0 + "%",
		});
		clearInterval(tick);
	}
	startProgressbar();
	// End ticking machine

	$(".single_portfolio_slider_content").click(function () {
		clearInterval(tick);
		var goToThisIndex = $(this).find("span").data("slickIndex");
		goToThisIndex = goToThisIndex - 1;
		$(".single-item").slick("slickGoTo", goToThisIndex, false);
		startProgressbar();
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
	if ($(window).width() <= 767) {
		$(".module_chapter_list").slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			infinite: true,
			autoplay: true,
			autoplaySpeed: 2000,
			arrows: true,
			centerMode: true,
		});
	}

	// calc

	var fdRate = 0.06;
	var monthSelected = parseFloat(
		$('input[name="tenure-selection"]:checked').val()
	);

	let selectedPlan =
		parseFloat($('input[name="plan-selection"]:checked').val()) / 100;

	let selectedId = $('input[name="plan-selection"]:checked').attr('id');
	$('input[name="plan-selection"]').click(function () {
		selectedPlan = parseFloat($(this).val()) / 100;
		selectedId = $('input[name="plan-selection"]:checked').attr('id');
		fdcalc();
	});

	$('input[name="tenure-selection"]').click(function () {
		monthSelected = parseFloat($(this).val());
		fdcalc();
	});

	function formatCurrency(number) {
		return "₹" + number.toLocaleString('en-IN');
	}
	var pnr;
	function fdcalc() {
		if (selectedId === 'fixed-term') {
			if (monthSelected === 3) {
				selectedPlan = parseFloat(10) / 100;
			}
			if (monthSelected === 6) {
				selectedPlan = parseFloat(10.75) / 100;
			}
			if (monthSelected === 12) {
				selectedPlan = parseFloat(11.5) / 100;
			}
			if (monthSelected === 24) {
				selectedPlan = parseFloat(11.5) / 100;
			}
			if (monthSelected === 36) {
				selectedPlan = parseFloat(11.5) / 100;
			}
		}
		var inputVal = $("#investment_amt")
			.val()
			.replace(/[^0-9.]/g, "");
		var investmentVal = parseFloat(inputVal);

		var fdInterest = investmentVal * fdRate * (monthSelected / 12);

		var liquidInterest = investmentVal * selectedPlan * (monthSelected / 12);

		fdInterest = Math.round(fdInterest);
		liquidInterest = Math.round(liquidInterest);

		pnr = (liquidInterest / (investmentVal + liquidInterest)) * 100;


		pnr = pnr / 100;

		bar.animate(pnr);

		var extraInterest = liquidInterest - fdInterest;


		$(".fd_result_wrap").css(
			"background",
			"radial-gradient( circle closest-side, white 0, white 80%, transparent 0, transparent 100%, white 0 ), conic-gradient( from 0deg, #0CC786 " +
			pnr +
			"%, transparent 0%, transparent 0, transparent 0 )"
		);

		$("#investment_amt").val(formatCurrency(investmentVal));
		$(".fd_interest").text(fdInterest.toLocaleString('en-IN'));
		$(".liquid_interest").text(liquidInterest.toLocaleString('en-IN'));
		$(".extra_interest").text(extraInterest.toLocaleString('en-IN'));
		$("#plan-selected").text((selectedPlan * 100).toLocaleString());
	}

	$("#investment_amt").on("input change", function () {
		var latestAmt = $("#investment_amt")
			.val()
			.replace(/[^0-9.]/g, "");
		$("#investment_range").val(latestAmt);
		fdcalc();

		var slider = document.getElementById("investment_range");
		var sliderVal = document.getElementById("investment_amt");
		slider.style.background = color;
		var minValue = 10000;
		var maxValue = 5000000;
		var x = parseFloat(latestAmt); // Parse the slider value to a floating-point
		var newValue = ((x - minValue) / (maxValue - minValue)) * 99 + 1; // Map the value
		var color =
			"linear-gradient(90deg, rgba(12, 199, 134, 1)" +
			newValue +
			"%, rgba(217, 228, 238, 1)" +
			newValue +
			"%)";
		slider.style.background = color;
		if (newValue > 40 && newValue <= 85) {
			slider.classList.add("ahead");
		} else if (newValue > 85) {
			slider.classList.remove("ahead");
			slider.classList.add("end");
		} else {
			slider.classList.remove("ahead");
			slider.classList.remove("end");
		}
	});
	$("#investment_range").on("input change", function () {
		var latestAmt = $("#investment_amt")
			.val()
			.replace(/[^0-9.]/g, "");
		$("#investment_range").val(latestAmt);
		fdcalc();
		var slider = document.getElementById("investment_range");
		var sliderVal = document.getElementById("investment_amt");
		slider.style.background = color;
		var minValue = 10000;
		var maxValue = 5000000;
		var x = parseFloat(latestAmt); // Parse the slider value to a floating-point
		var newValue = ((x - minValue) / (maxValue - minValue)) * 99 + 1; // Map the value
		var color =
			"linear-gradient(90deg, rgba(12, 199, 134, 1)" +
			newValue +
			"%, rgba(217, 228, 238, 1)" +
			newValue +
			"%)";
		slider.style.background = color;
		if (newValue > 40 && newValue <= 85) {
			slider.classList.add("ahead");
		} else if (newValue > 85) {
			slider.classList.remove("ahead");
			slider.classList.add("end");
		} else {
			slider.classList.remove("ahead");
			slider.classList.remove("end");
		}
	});

	fdcalc();

	$(".investors_slider").slick({
		infinite: true,
		arrows: false,
		dots: false,
		autoplay: true,
        autoplaySpeed: 6000, 
		speed: 600,
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
