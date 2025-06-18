jQuery(document).ready(function () {
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

  jQuery(function ($) {
    $(".faq_que").click(function (j) {
      var dropDown = $(this).closest(".single_faq").find(".faq_content");
      $(this)
        .closest(".faqs_wrapper")
        .find(".faq_content")
        .not(dropDown)
        .slideUp();
      if ($(this).hasClass("active")) {
        $(this).removeClass("active");
      } else {
        $(this)
          .closest(".faqs_wrapper")
          .find(".faq_que.active")
          .removeClass("active");
        $(this).addClass("active");
      }
      dropDown.stop(false, true).slideToggle();
      j.preventDefault();
    });
  });
});

document.addEventListener("DOMContentLoaded", function () {
  console.log("JS New Partner Template Loaded");

  const menuLinks = document.querySelectorAll(".mega-menu a");
  const body = document.body;

  menuLinks.forEach((link) => {
    link.addEventListener("click", () => {
      document.querySelector(".humburger").click();
    });
  });
});
