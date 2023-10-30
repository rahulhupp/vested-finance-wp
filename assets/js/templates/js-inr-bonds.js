document.addEventListener("DOMContentLoaded", function () {
  sliderSlide();
});
function sliderSlide() {
  var slider = document.getElementById("unit_range");
  var sliderVal = document.getElementById("units");
  var color =
    "linear-gradient(90deg, rgba(0, 40, 52, 1) 10%, rgba(229, 231, 235, 1) 10%)";
  slider.style.background = color;
  var minValue = 1;
  var maxValue = 1000;
  var x = parseFloat(sliderVal.value); // Parse the slider value to a floating-point
  var newValue = ((x - minValue) / (maxValue - minValue)) * 99 + 1; // Map the value
  var color =
    "linear-gradient(90deg, rgba(0, 40, 52, 1)" +
    newValue +
    "%, rgba(229, 231, 235, 1)" +
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
  $(".bond_portfolio_slider").each(function () {
    var $tabContainer = $(this).closest(".tab");
    var $singleSlides = $tabContainer.find(".single_portfolio_slide");

    if ($singleSlides.length < 3) {
      $(this).addClass("slide_wo_shadow");
    } else {
      $(this).removeClass("slide_wo_shadow");
    }
  });

  var activeTab = null;

  // Initialize Slick slider for the active tab
  function initializeSlickSlider(tabId) {
    $("#" + tabId + " .bond_portfolio_slider").slick({
      infinite: false,
      arrows: true,
      dots: false,
      autoplay: false,
      speed: 800,
      slidesToShow: 2,
      slidesToScroll: 1,
      nextArrow:
        '<div class="bond_next"><i class="fa fa-caret-right"></i></div>',
      prevArrow:
        '<div class="bond_prev"><i class="fa fa-caret-left"></i></div>',
      responsive: [
        {
          breakpoint: 767,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
          },
        },
      ],
    });
  }

  // Function to handle tab click
  function handleTabClick(clickedTab) {
    $(".tab").removeClass("tab-active");
    $(".tab[data-id='" + clickedTab.attr("data-id") + "']").addClass(
      "tab-active"
    );
    $(".tab-a").removeClass("active-a");
    clickedTab.addClass("active-a");

    if (activeTab !== null) {
      $("#" + activeTab + " .bond_portfolio_slider").slick("unslick");
    }

    var tabId = clickedTab.data("id");
    activeTab = tabId;

    initializeSlickSlider(tabId);
  }

  $(".tab-a").click(function () {
    handleTabClick($(this));
  });

  initializeSlickSlider($(".tab-a.active-a").data("id"));

  $(".tab-active .bond_slider_wrap .bond_portfolio_slider").slick({
    infinite: true,
    arrows: true,
    dots: false,
    autoplay: false,
    speed: 800,
    slidesToShow: 2,
    slidesToScroll: 1,
    nextArrow: '<div class="bond_next"><i class="fa fa-caret-right"></i></div>',
    prevArrow: '<div class="bond_prev"><i class="fa fa-caret-left"></i></div>',
    responsive: [
      {
        breakpoint: 767,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
        },
      },
    ],
  });

  $(".bond_prev").click(function () {
    $(".bond_portfolio_slider").slick("slickPrev");
  });

  $(".bond_next").click(function () {
    $(".bond_portfolio_slider").slick("slickNext");
  });
  $(".bond_prev").addClass("slick-disabled");
  $(".bond_portfolio_slider").on("afterChange", function () {
    if ($(".slick-prev").hasClass("slick-disabled")) {
      $(".bond_prev").addClass("slick-disabled");
    } else {
      $(".bond_prev").removeClass("slick-disabled");
    }
    if ($(".slick-next").hasClass("slick-disabled")) {
      $(".bond_next").addClass("slick-disabled");
    } else {
      $(".bond_next").removeClass("slick-disabled");
    }
  });

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

  $(".minus_qty").click(function () {
    let $input = $("#units");
    var val = parseInt($input.val());
    if (val > 0) {
      $input.val(val - 1).change();
    }
  });
  $(".plus_qty").click(function () {
    let $input = $("#units");
    var val = parseInt($input.val());
    $input.val(val + 1).change();
  });
});

function restrictAlphabets(e) {
  var x = e.which || e.keycode;
  if ((x >= 48 && x <= 57))
      return true;
  else
      return false;
}

jQuery(document).ready(function($){
  $("#units").on("input change", function (event) {
    var latestAmt = $("#units").val();
    $("#unit_range").val(latestAmt);

    var investmentAmount = $('#investment_amount').attr('newPrice');
    var periodInYears = $('#bank_fixed_deposit').attr('maturity_months');
    var bankFixedDeposit = investmentAmount * Math.pow(1.06, periodInYears);
    var totalCashFlow = $('#selected_bond').attr('sum_cash_flow');
    // var selectedBonds = totalCashFlow * minimumQuantity;

    var slider = document.getElementById("unit_range");
    var sliderVal = document.getElementById("units");
    slider.style.background = color;
    var minValue = 1;
    var maxValue = 1000;
    var x = parseFloat(latestAmt);
    var newValue = ((x - minValue) / (maxValue - minValue)) * 99 + 1; // Map the value
    var color =
      "linear-gradient(90deg, rgba(0, 40, 52, 1)" +
      newValue +
      "%, rgba(229, 231, 235, 1)" +
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

    var newinvestmentAmount = investmentAmount * newValue;
    var newbankFixedDeposit = bankFixedDeposit * newValue;
    var newselectedBonds = totalCashFlow * newValue;
    var extraAmount = newselectedBonds - newbankFixedDeposit;

    document.querySelector('.qty_btn').setAttribute("input_value", newValue);
    document.getElementById('investment_amount').textContent = newinvestmentAmount.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 });
    document.getElementById('result_note_investment_amount').textContent = newinvestmentAmount.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 });
    document.getElementById('bank_fixed_deposit').textContent = newbankFixedDeposit.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 });
    document.getElementById('selected_bond').textContent = newselectedBonds.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 });
    document.getElementById('extra_amount').textContent = extraAmount.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 });

  });
  
  $("#unit_range").on("input change", function () {
    
    var slider = document.getElementById("unit_range");
    var sliderVal = document.getElementById("units");
    $("#units").val(slider.value);

    var investmentAmount = $('#investment_amount').attr('newPrice');
    var periodInYears = $('#bank_fixed_deposit').attr('maturity_months');
    var bankFixedDeposit = investmentAmount * Math.pow(1.06, periodInYears);
    var totalCashFlow = $('#selected_bond').attr('sum_cash_flow');
    // var selectedBonds = totalCashFlow * minimumQuantity;

    var color =
      "linear-gradient(90deg, rgba(0, 40, 52, 1) 10%, rgba(229, 231, 235, 1) 10%)";
    slider.style.background = color;
    var minValue = 1;
    var maxValue = 1000;
    var x = parseFloat(sliderVal.value); // Parse the slider value to a floating-point
    var newValue = ((x - minValue) / (maxValue - minValue)) * 99 + 1; // Map the value
    console.log ('newValue', newValue);
    var color =
      "linear-gradient(90deg, rgba(0, 40, 52, 1)" +
      newValue +
      "%, rgba(229, 231, 235, 1)" +
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
    
    var newinvestmentAmount = investmentAmount * newValue;
    var newbankFixedDeposit = bankFixedDeposit * newValue;
    var newselectedBonds = totalCashFlow * newValue;
    var extraAmount = newselectedBonds - newbankFixedDeposit;

    document.querySelector('.qty_btn').setAttribute("input_value", newValue);
    document.getElementById('investment_amount').textContent = newinvestmentAmount.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 });
    document.getElementById('result_note_investment_amount').textContent = newinvestmentAmount.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 });
    document.getElementById('bank_fixed_deposit').textContent = newbankFixedDeposit.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 });
    document.getElementById('selected_bond').textContent = newselectedBonds.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 });
    document.getElementById('extra_amount').textContent = extraAmount.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 });

  });

});
