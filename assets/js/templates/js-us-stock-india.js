jQuery(document).ready(function ($) {
	$("#us-stock-why-choose-slider").slick({
		infinite: false,
		arrows: true,
		dots: false,
		autoplay: false,
		autoplaySpeed: 6000,
		speed: 800,
		slidesToShow: 2,
		slidesToScroll: 1,
		prevArrow: $('.us-stock-why-choose-slider-button-prev'),
		nextArrow: $('.us-stock-why-choose-slider-button-next'),
		responsive: [
			{
				breakpoint: 1199,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 1,
				},
				breakpoint: 767,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
				},
			},
		],
	});

	$("#us-stock-investors-slider").slick({
		infinite: true,
		arrows: true,
		dots: false,
		autoplay: false,
		speed: 800,
		slidesToShow: 3,
		slidesToScroll: 1,
		prevArrow: $('.us-stock-investors-slider-button-prev'),
		nextArrow: $('.us-stock-investors-slider-button-next'),
		responsive: [
			{
				breakpoint: 991,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
				},
				breakpoint: 767,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
				},
			},
		],
	});

	// Read More / Read Less toggle functionality
	function initializeReadMore() {
		var $content = $('#learnMoreContent');
		var $h3Elements = $content.find('h3');
		
		// Hide sections after the second h3 when collapsed
		if ($h3Elements.length > 2) {
			$h3Elements.each(function(index) {
				if (index >= 2) {
					// Hide this h3 and all following content until next h3 or end
					var $currentH3 = $(this);
					var $nextH3 = $h3Elements.eq(index + 1);
					
					if ($nextH3.length) {
						// Hide everything from this h3 until (but not including) the next h3
						$currentH3.nextUntil($nextH3).addBack().addClass('learn-more-hidden');
					} else {
						// This is the last h3 - hide it and everything after it
						$currentH3.nextAll().addBack().addClass('learn-more-hidden');
					}
				}
			});
		}
	}
	
	// Initialize on page load
	initializeReadMore();
	
	$('#readMoreBtn').on('click', function(e) {
		e.preventDefault();
		var $content = $('#learnMoreContent');
		var $btn = $(this);
		
		if ($content.hasClass('collapsed')) {
			$content.removeClass('collapsed').addClass('expanded');
			$btn.text('Read Less');
		} else {
			$content.removeClass('expanded').addClass('collapsed');
			$btn.text('Read More');
			// Scroll to top of section when collapsing
			$('html, body').animate({
				scrollTop: $content.offset().top - 100
			}, 300);
		}
	});

	// FAQ Item toggle functionality (accordion - only one open at a time)
	$('.us-stock-faq-question').on('click', function(e) {
		e.preventDefault();
		var $faqItem = $(this).closest('.us-stock-faq-item');
		var isActive = $faqItem.hasClass('active');
		
		// Close all FAQ items first
		$('.us-stock-faq-item').removeClass('active');
		
		// If the clicked item was not active, open it; otherwise keep it closed
		if (!isActive) {
			$faqItem.addClass('active');
		}
	});

	$('.us-stock-banner-content p a').click(function () {
		$('.us-stock-popup-overlay').show();
		$('html').addClass('disclosure-popup-open');
	});
	
	$('.us-stock-popup-overlay .close-btn').click(function () {
		$('.us-stock-popup-overlay').hide();
		$('html').removeClass('disclosure-popup-open');
	});

	// --- GSAP Animations ---
	if (typeof gsap !== 'undefined') {
		gsap.registerPlugin(ScrollTrigger);

		// --- Utility: Animate Section Items ---
		function animateSectionItems(selector, yVal, duration, start, delayStep) {
			gsap.utils.toArray(selector).forEach(function(item, i) {
				gsap.fromTo(item,
					{ y: yVal, opacity: 0 },
					{
						scrollTrigger: {
							trigger: item,
							start: start,
							end: "bottom 60%",
						},
						y: 0,
						opacity: 1,
						duration: duration,
						delay: i * delayStep,
						ease: "power2.out"
					}
				);
			});
		}

		// --- Banner Section Animation ---
		gsap.from(".us-stock-banner-content h1", {
			scrollTrigger: {
				trigger: ".us-stock-banner",
				start: "top 80%",
			},
			y: 40,
			opacity: 0,
			duration: 0.7,
			ease: "power2.out"
		});
		gsap.from(".us-stock-banner-content p", {
			scrollTrigger: {
				trigger: ".us-stock-banner",
				start: "top 80%",
			},
			y: 40,
			opacity: 0,
			duration: 0.7,
			delay: 0.15,
			ease: "power2.out"
		});
		gsap.from(".us-stock-banner-buttons", {
			scrollTrigger: {
				trigger: ".us-stock-banner",
				start: "top 80%",
			},
			y: 40,
			opacity: 0,
			duration: 0.7,
			delay: 0.3,
			ease: "power2.out"
		});
		gsap.from(".us-stock-banner-image", {
			scrollTrigger: {
				trigger: ".us-stock-banner",
				start: "top 80%",
			},
			x: 50,
			opacity: 0,
			duration: 0.8,
			delay: 0.2,
			ease: "power2.out"
		});

		// --- Stocks Section Animation ---
		gsap.from(".us-stock-stocks-section h2", {
			scrollTrigger: {
				trigger: ".us-stock-stocks-section",
				start: "top 80%",
			},
			y: 40,
			opacity: 0,
			duration: 0.7,
			ease: "power2.out"
		});
		gsap.from(".us-stock-stocks-section > .container > p", {
			scrollTrigger: {
				trigger: ".us-stock-stocks-section",
				start: "top 80%",
			},
			y: 40,
			opacity: 0,
			duration: 0.7,
			delay: 0.15,
			ease: "power2.out"
		});
		gsap.from(".us-stock-stocks-search", {
			scrollTrigger: {
				trigger: ".us-stock-stocks-section",
				start: "top 80%",
			},
			y: 60,
			opacity: 0,
			duration: 0.8,
			delay: 0.3,
			ease: "power2.out"
		});

		// --- Collections Section Animation ---
		gsap.from(".us-stock-collection-section h2", {
			scrollTrigger: {
				trigger: ".us-stock-collection-section",
				start: "top 80%",
			},
			y: 40,
			opacity: 0,
			duration: 0.7,
			ease: "power2.out"
		});
		gsap.from(".us-stock-collection-section > .container > p", {
			scrollTrigger: {
				trigger: ".us-stock-collection-section",
				start: "top 80%",
			},
			y: 40,
			opacity: 0,
			duration: 0.7,
			delay: 0.15,
			ease: "power2.out"
		});
		animateSectionItems(".us-stock-collection-item", 40, 0.7, "top 85%", 0.1);

		// --- Why Invest Section Animation ---
		gsap.from(".us-stock-why-invest-section h2", {
			scrollTrigger: {
				trigger: ".us-stock-why-invest-section",
				start: "top 80%",
			},
			y: 40,
			opacity: 0,
			duration: 0.7,
			ease: "power2.out"
		});
		gsap.from(".us-stock-why-invest-section > .container > p", {
			scrollTrigger: {
				trigger: ".us-stock-why-invest-section",
				start: "top 80%",
			},
			y: 40,
			opacity: 0,
			duration: 0.7,
			delay: 0.15,
			ease: "power2.out"
		});
		animateSectionItems(".us-stock-why-invest-item", 40, 0.7, "top 90%", 0.15);

		// --- Why Choose Section Animation ---
		gsap.from(".us-stock-why-choose-section h2", {
			scrollTrigger: {
				trigger: ".us-stock-why-choose-section",
				start: "top 80%",
			},
			y: 40,
			opacity: 0,
			duration: 0.7,
			ease: "power2.out"
		});
		gsap.from(".us-stock-why-choose-section > .container > p", {
			scrollTrigger: {
				trigger: ".us-stock-why-choose-section",
				start: "top 80%",
			},
			y: 40,
			opacity: 0,
			duration: 0.7,
			delay: 0.15,
			ease: "power2.out"
		});
		gsap.from("#us-stock-why-choose-slider", {
			scrollTrigger: {
				trigger: ".us-stock-why-choose-section",
				start: "top 80%",
			},
			y: 60,
			opacity: 0,
			duration: 0.8,
			delay: 0.3,
			ease: "power2.out"
		});

		// --- Return Calculator Section Animation ---
		gsap.from(".us-stock-return-calculator-section h2", {
			scrollTrigger: {
				trigger: ".us-stock-return-calculator-section",
				start: "top 80%",
			},
			y: 40,
			opacity: 0,
			duration: 0.7,
			ease: "power2.out"
		});
		gsap.from(".us-stock-return-calculator-section > .container > p", {
			scrollTrigger: {
				trigger: ".us-stock-return-calculator-section",
				start: "top 80%",
			},
			y: 40,
			opacity: 0,
			duration: 0.7,
			delay: 0.15,
			ease: "power2.out"
		});

		// --- Steps Section Animation ---
		gsap.from(".us-stocks-steps-section h2", {
			scrollTrigger: {
				trigger: ".us-stocks-steps-section",
				start: "top 80%",
			},
			y: 40,
			opacity: 0,
			duration: 0.7,
			ease: "power2.out"
		});
		animateSectionItems(".us-stocks-step-item", 40, 0.7, "top 90%", 0.15);

		// --- Investors Section Animation ---
		gsap.from(".us-stock-investors-section h2", {
			scrollTrigger: {
				trigger: ".us-stock-investors-section",
				start: "top 80%",
			},
			y: 40,
			opacity: 0,
			duration: 0.7,
			ease: "power2.out"
		});
		gsap.from(".us-stock-investors-section > .container > p", {
			scrollTrigger: {
				trigger: ".us-stock-investors-section",
				start: "top 80%",
			},
			y: 40,
			opacity: 0,
			duration: 0.7,
			delay: 0.15,
			ease: "power2.out"
		});
		gsap.from("#us-stock-investors-slider", {
			scrollTrigger: {
				trigger: ".us-stock-investors-section",
				start: "top 80%",
			},
			y: 60,
			opacity: 0,
			duration: 0.8,
			delay: 0.3,
			ease: "power2.out"
		});

		// --- Blogs Section Animation ---
		gsap.from(".us-stock-blogs-section h2", {
			scrollTrigger: {
				trigger: ".us-stock-blogs-section",
				start: "top 80%",
			},
			y: 40,
			opacity: 0,
			duration: 0.7,
			ease: "power2.out"
		});
		animateSectionItems(".us-stock-blog-item", 30, 0.6, "top 90%", 0.1);

		// --- Partners Section Animation ---
		gsap.from(".us-stock-partners-section h2", {
			scrollTrigger: {
				trigger: ".us-stock-partners-section",
				start: "top 80%",
			},
			y: 40,
			opacity: 0,
			duration: 0.7,
			ease: "power2.out"
		});
		gsap.from(".us-stock-partners-section > .container > p", {
			scrollTrigger: {
				trigger: ".us-stock-partners-section",
				start: "top 80%",
			},
			y: 40,
			opacity: 0,
			duration: 0.7,
			delay: 0.15,
			ease: "power2.out"
		});
		animateSectionItems(".us-stock-partner-item", 30, 0.6, "top 90%", 0.1);

		// --- Learn More Section Animation ---
		gsap.from(".us-stock-learn-more-section h2", {
			scrollTrigger: {
				trigger: ".us-stock-learn-more-section",
				start: "top 80%",
			},
			y: 40,
			opacity: 0,
			duration: 0.7,
			ease: "power2.out"
		});
		gsap.from("#learnMoreContent", {
			scrollTrigger: {
				trigger: ".us-stock-learn-more-section",
				start: "top 80%",
			},
			y: 40,
			opacity: 0,
			duration: 0.7,
			delay: 0.15,
			ease: "power2.out"
		});

		// --- FAQs Section Animation ---
		gsap.from(".us-stock-faqs-section h2", {
			scrollTrigger: {
				trigger: ".us-stock-faqs-section",
				start: "top 80%",
			},
			y: 40,
			opacity: 0,
			duration: 0.7,
			ease: "power2.out"
		});
		animateSectionItems(".us-stock-faq-item", 30, 0.6, "top 90%", 0.1);

		// --- ScrollTrigger refresh fixes for layout/animation jumps ---
		window.addEventListener("load", ScrollTrigger.refresh);
		window.addEventListener("resize", ScrollTrigger.refresh);
		if (document.fonts) {
			document.fonts.ready.then(ScrollTrigger.refresh);
		}
	}
});