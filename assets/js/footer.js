jQuery(document).ready(function ($) {
  $(".single_tab_wrap:nth-child(1) .single_tab_heading").addClass("collapsed");
  $(".single_tab_heading").click(function () {
    if (!$(this).hasClass("collapsed")) {
      $(".single_tab_heading.collapsed").removeClass("collapsed");
      $(this).addClass("collapsed");
    } else {
      $(".single_tab_heading.collapsed").removeClass("collapsed");
    }
  });
  $(".read_more_link").click(function () {
    var disclosure = $(this).prev(".disclosure_content");

    disclosure.toggleClass("collapsed");
    if ($(this).text() == "Read more") {
      $(this).text("Read less");
    } else {
      $(this).text("Read more");
    }
  });
});
