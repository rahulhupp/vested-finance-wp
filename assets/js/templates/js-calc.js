function updateTextView(_obj) {
  var num = getNumber(_obj.val());
  if (num == 0) {
    _obj.val("");
  } else {
    _obj.val(num.toLocaleString());
  }
}
function getNumber(_str) {
  var arr = _str.split("");
  var out = new Array();
  for (var cnt = 0; cnt < arr.length; cnt++) {
    if (isNaN(arr[cnt]) == false) {
      out.push(arr[cnt]);
    }
  }
  return Number(out.join(""));
}
jQuery(document).ready(function ($) {
  $("#invest_val").on("keyup", function () {
    updateTextView($(this));
  });
});

jQuery(document).ready(function ($) {
  // var bar = new ProgressBar.Circle(fd_results, {
  //   strokeWidth: 11,
  //   easing: "easeInOut",
  //   duration: 1400,
  //   color: "#002852",
  //   trailColor: "#B3D2F1",
  //   trailWidth: 7,
  //   svgStyle: null,
  // });
  // bar.animate(0.5);

  jQuery(function ($) {
    $(".faq_que").click(function (j) {
      var dropDown = $(this).closest(".single_faq").find(".faq_content");
      $(this).closest(".faq_wrap").find(".faq_content").not(dropDown).slideUp();
      if ($(this).hasClass("active")) {
        $(this).removeClass("active");
      } else {
        $(this)
          .closest(".faq_wrap")
          .find(".faq_que.active")
          .removeClass("active");
        $(this).addClass("active");
      }
      dropDown.stop(false, true).slideToggle();
      j.preventDefault();
    });
  });
  
});
