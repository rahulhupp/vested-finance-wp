function initializeSlickSlider(tabId) {
	console.log('tabId', tabId);
	console.log('#' + tabId + ' .bonds_slider');
	jQuery('#' + tabId + ' .bonds_slider').slick({
		slidesToShow: 2,
		slidesToScroll: 1,
		autoplay: false,
		autoplaySpeed: 2000,
		dots: false,
		arrows: true,
		centerMode: false,
		infinite: false,
		nextArrow: '<div class="bond_next"><i class="fa fa-caret-right"></i></div>',
		prevArrow: '<div class="bond_prev"><i class="fa fa-caret-left"></i></div>',
		responsive: [{
			breakpoint: 768,
			settings: {
				slidesToShow: 1
			}
		}]
	});
}

function openTab(tabId) {
	var tabContents = document.getElementsByClassName("bonds_tab_content");
	for (var i = 0; i < tabContents.length; i++) {
		tabContents[i].classList.remove("active");
	}

	var tabButtons = document.getElementsByClassName("bonds_tab_button");
	for (var i = 0; i < tabButtons.length; i++) {
		tabButtons[i].classList.remove("active");
	}

	document.getElementById(tabId).classList.add("active");
	event.currentTarget.classList.add("active");

	initializeSlickSlider(tabId);
}

jQuery(document).ready(function ($) {
	initializeSlickSlider('corporate_bonds');
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
					dotsClass: "slider-dots"
				},
			},
		],
	});

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
		if ($('.portfolio_slider .slick-track div[data-slick-index="' + progressBarIndex + '"]').attr("aria-hidden") === "true") {
			progressBarIndex = $('.portfolio_slider .slick-track div[aria-hidden="false"]').data("slickIndex");
			startProgressbar();
		} else {
			percentTime += 1 / (time + 4);
			var $progressBar = $(".inProgress" + progressBarIndex);
			var $progressbarMob = $(".slick-dots li .inProgress" + progressBarIndex);

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
});

document.addEventListener('DOMContentLoaded', (event) => {
	const faqItems = document.querySelectorAll('.faq_item');

	faqItems.forEach(item => {
		const question = item.querySelector('.faq_question');
		const answer = item.querySelector('.faq_answer');
		const icon = item.querySelector('.faq_icon');

		question.addEventListener('click', () => {
			// Toggle active class for answer and icon
			answer.classList.toggle('active');
			icon.classList.toggle('active');

			// Check if answer is active
			if (answer.classList.contains('active')) {
				answer.style.maxHeight = answer.scrollHeight + "px";
			} else {
				answer.style.maxHeight = "0";
			}

			// Collapse other answers
			faqItems.forEach(otherItem => {
				if (otherItem !== item) {
					const otherAnswer = otherItem.querySelector('.faq_answer');
					const otherIcon = otherItem.querySelector('.faq_icon');

					otherAnswer.classList.remove('active');
					otherIcon.classList.remove('active');
					otherAnswer.style.maxHeight = "0";
				}
			});
		});
	});

	document.getElementById('cb_modal_button').addEventListener('click', function () {
		document.getElementById('cb_modal').style.display = 'flex';
	});
	
	document.getElementById('gb_modal_button').addEventListener('click', function () {
		document.getElementById('gb_modal').style.display = 'flex';
	});
	
	document.querySelectorAll('.close').forEach(function (closeBtn) {
		closeBtn.addEventListener('click', function () {
			this.closest('.modal').style.display = 'none';
		});
	});
	
	window.onclick = function (event) {
		if (event.target.classList.contains('modal')) {
			event.target.style.display = 'none';
		}
	};
});


