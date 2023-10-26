
jQuery(document).ready(function () {
	jQuery("#premium_show_btn").click(function () {
		jQuery('.basic-plan').css('display', 'none');
		jQuery('.info.first').css('display', 'none');
		jQuery('.sticky-plan .plan.first').css('display', 'none');
		jQuery('.premium-plan').show();
		jQuery('.info.second').show();
		jQuery('.sticky-plan .plan.second').show();
		jQuery('#basic_show_btn').removeClass('active');
		jQuery('#premium_show_btn').addClass('active');
		jQuery('.info.quarterly.second').css('display', 'none');
		var getQuarterly = jQuery('[name="plan-selection"]:checked').attr('id');
		if (getQuarterly == 'quarterly-plan') {
			jQuery('.info.quarterly.second').css('display', 'block');
			jQuery('.info.second.annual').css('display', 'none');
		}
	});
	jQuery("#basic_show_btn").click(function () {
		jQuery('.premium-plan').css('display', 'none');
		jQuery('.info.second').css('display', 'none');
		jQuery('.sticky-plan .plan.second').css('display', 'none');
		jQuery('.basic-plan').show();
		jQuery('.info.first').show();
		jQuery('.sticky-plan .plan.first').show();
		jQuery('#premium_show_btn').removeClass('active');
		jQuery('#basic_show_btn').addClass('active');
		jQuery('.info.quarterly').css('display', 'none');
	});

	jQuery('input[type=radio][name=plan-selection]').change(function () {
		var getID = jQuery(this).attr('id');
		if (getID == 'quarterly-plan') {
			if (window.matchMedia('(min-width: 991px)').matches) {
				jQuery('.info.quarterly').css('display', 'block');
			}

			jQuery('.info.annual').css('display', 'none');
			jQuery('.pricing-info .plan-box .box span.annual').css('display', 'none');
			jQuery('.pricing-info .plan-box .box span.quarterly').css('display', 'block');
			jQuery('.pricing-sticky .sticky-plan .plan span.annual').css('display', 'none');
			jQuery('.pricing-sticky .sticky-plan .plan span.quarterly').css('display', 'block');

			if (window.matchMedia('(max-width: 991px)').matches) {
				jQuery('.info.quarterly.second').css('display', 'block');
			}

		}
		else {
			if (window.matchMedia('(min-width: 991px)').matches) {
				jQuery('.info.annual').css('display', 'block');
			}

			jQuery('.info.quarterly').css('display', 'none');
			jQuery('.pricing-info .plan-box .box span.annual').css('display', 'block');
			jQuery('.pricing-info .plan-box .box span.quarterly').css('display', 'none');
			jQuery('.pricing-sticky .sticky-plan .plan span.annual').css('display', 'block');
			jQuery('.pricing-sticky .sticky-plan .plan span.quarterly').css('display', 'none');

			if (window.matchMedia('(max-width: 991px)').matches) {
				jQuery('.info.annual.second').css('display', 'block');
			}
		}
	});

	// Show the first tab and hide the rest
	jQuery('#tabs-nav li:first-child').addClass('active');
	jQuery('.pricing-sticky .sticky-tab ul li:first-child').addClass('active');
	jQuery('.tab-content').hide();
	jQuery('.tab-content:first').show();

	// Click function
	jQuery('.pricing-sticky .sticky-tab ul li').click(function () {

		jQuery('.sticky-tab li').removeClass('active');
		jQuery(this).addClass('active');
		jQuery('.tab-content').hide();


		var activeTab = jQuery(this).find('a').attr('href');
		jQuery(activeTab).fadeIn();

		jQuery('#tabs-nav li').removeClass('active');
		jQuery('a[href="' + activeTab + '"]').parent('li').addClass("active")

		var getSitckyHeight = jQuery('.pricing-sticky').outerHeight();
		jQuery('html, body').animate({
			scrollTop: jQuery(".pricing-table").offset().top - getSitckyHeight
		}, 1000);

		return false;
	});

	jQuery('#tabs-nav li').click(function () {
		jQuery('#tabs-nav li').removeClass('active');
		jQuery(this).addClass('active');
		jQuery('.tab-content').hide();

		var activeTab = jQuery(this).find('a').attr('href');
		jQuery(activeTab).fadeIn();

		jQuery('.sticky-tab ul li').removeClass('active');
		jQuery('a[href="' + activeTab + '"]').parent('li').addClass("active")

		return false;
	});

	jQuery(function ($) {
		$(".faq_que").click(function (j) {
			var dropDown = $(this).closest(".single_faq").find(".faq_content");
			$(this)
				.closest(".pricing_page_faq_wrap")
				.find(".faq_content")
				.not(dropDown)
				.slideUp();
			if ($(this).hasClass("active")) {
				$(this).removeClass("active");
			} else {
				$(this)
					.closest(".pricing_page_faq_wrap")
					.find(".faq_que.active")
					.removeClass("active");
				$(this).addClass("active");
			}
			dropDown.stop(false, true).slideToggle();
			j.preventDefault();
		});
	});
	jQuery(window).scroll(function () {
		if (jQuery(this).scrollTop() > 600) {
			jQuery('.pricing-sticky').addClass("fixed");
		}
		else {
			jQuery('.pricing-sticky').removeClass("fixed");
		}
	});
	jQuery('.pricing-table .pricing-tabs-content .item .heading img.info-icon').click(function () {
		jQuery(this).parent().addClass('active');
		jQuery('body').addClass('tooltip-open');
	});
	jQuery('button.ok-btn, .tooltip .overlay').click(function () {
		jQuery('.pricing-table .pricing-tabs-content .item .heading .tooltip').removeClass('active');
		jQuery('body').removeClass('tooltip-open');
	});
});


