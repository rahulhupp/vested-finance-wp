
jQuery( document ).ready(function() {
  jQuery("#premium_show_btn").click(function () {
		jQuery('.basic-plan').css('display', 'none');
    jQuery('.info.first').css('display', 'none');
    jQuery('.sticky-plan .plan.first').css('display', 'none');
		jQuery('.premium-plan').fadeIn();
    jQuery('.info.second').fadeIn();
    jQuery('.sticky-plan .plan.second').fadeIn();
    jQuery('#basic_show_btn').removeClass('active');
		jQuery('#premium_show_btn').addClass('active');
	});
  jQuery("#basic_show_btn").click(function () {
		jQuery('.premium-plan').css('display', 'none');
    jQuery('.info.second').css('display', 'none');
    jQuery('.sticky-plan .plan.second').css('display', 'none');
		jQuery('.basic-plan').fadeIn();
    jQuery('.info.first').fadeIn();
    jQuery('.sticky-plan .plan.first').fadeIn();
    jQuery('#premium_show_btn').removeClass('active');
		jQuery('#basic_show_btn').addClass('active');

	});

  // Show the first tab and hide the rest
  jQuery('#tabs-nav li:first-child').addClass('active');
  jQuery('.tab-content').hide();
  jQuery('.tab-content:first').show();

  // Click function
  jQuery('.pricing-sticky .sticky-tab ul li a').click(function(){
    var getSitckyHeight = jQuery('.pricing-sticky').outerHeight();
    jQuery('html, body').animate({
        scrollTop: jQuery(".pricing-tab-content").offset().top - getSitckyHeight
    }, 1000);
  });
  jQuery('#tabs-nav li').click(function(){
    
    // jQuery('html, body').animate({
    //     scrollTop: jQuery(".pricing-tab-content").offset().top - getSitckyHeight
    // }, 1000);
    jQuery('#tabs-nav li').removeClass('active');
    jQuery(this).addClass('active');
    jQuery('.tab-content').hide();
    
    var activeTab = jQuery(this).find('a').attr('href');
    jQuery(activeTab).fadeIn();
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
  jQuery(window).scroll(function() {
    if (jQuery(this).scrollTop() > 500){  
      jQuery('.pricing-sticky').addClass("fixed");
      }
      else{
        jQuery('.pricing-sticky').removeClass("fixed");
      }
  });
  jQuery('.pricing-table .pricing-tabs-content .item .heading img.info-icon').click(function(){
    jQuery(this).parent().addClass('active');
  });
  jQuery('button.ok-btn, .tooltip .overlay').click(function(){
    jQuery('.pricing-table .pricing-tabs-content .item .heading .tooltip').removeClass('active');
  });
});


