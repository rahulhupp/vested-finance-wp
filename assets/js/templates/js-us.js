document.addEventListener("DOMContentLoaded", () => {
  gsap.to("#circle1", {
    motionPath: "#animationPath",
    duration: 3.5,
    ease: "none",
    delay: 0,
    repeat: -1,
  });
  gsap.to("#circle2", {
    motionPath: "#animationPath",
    duration: 3.5,
    ease: "none",
    delay: 1,
    repeat: -1,
  });
  let posts = document.querySelectorAll(".post-type-list .post");
  let loadMoreBtn = document.getElementById("loadMorePost");
  let postsPerClick = 4;
  let hiddenPosts = Array.from(posts).filter((post) =>
    post.classList.contains("hidden")
  );
  loadMoreBtn.addEventListener("click", function () {
    let toShow = hiddenPosts.splice(0, postsPerClick);
    toShow.forEach((post) => post.classList.remove("hidden"));
    if (hiddenPosts.length === 0) {
      loadMoreBtn.style.display = "none";
    }
  });
});
jQuery(document).ready(function () {
  jQuery(".testimonials-slider").slick({
    slidesToShow: 6,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 3500,
    spaceBetween: 24,
    dots: false,
    arrows: false,
    variableWidth: true,
    responsive: [
      {
        breakpoint: 1440,
        settings: {
          slidesToShow: 5,
          slidesToScroll: 1,
        },
      },
      {
        breakpoint: 1250,
        settings: {
          slidesToShow: 4,
          slidesToScroll: 1,
        },
      },
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1,
        },
      },
      {
        breakpoint: 767,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1,
          autoplaySpeed: 2800,
        },
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
        },
      },
    ],
  });

  jQuery("#accredited-investors-btn").click(function () {
    jQuery("#accredited-investors-popover").addClass("active");
  });

  jQuery(".popover-wrapper .popover-close-btn, .popover-wrapper .overly").click(
    function () {
      jQuery("#accredited-investors-popover").removeClass("active");
    }
  );
});
