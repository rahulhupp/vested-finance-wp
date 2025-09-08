
jQuery(document).ready(function ($) {
    gsap.registerPlugin(ScrollTrigger);

    // --- Constants ---
    let allowScroll = true;
    let scrollTimeout = gsap.delayedCall(1, () => (allowScroll = true)).pause();
    const time = 0.5;
    let animating = false;

    // --- Mobile Check Function ---
    function isMobile() {
        return window.innerWidth <= 767;
    }

    // --- Card Stack Animation Setup (Desktop Only) ---
    if (!isMobile()) {
        gsap.set(".card", {
            y: (index) => 20 * index,
            transformOrigin: "center top"
        });

        const tl = gsap.timeline({ paused: true });
        [2, 3, 4, 5].forEach((n, i) => {
            tl.add(`card${n}`);
            tl.to(`.card:nth-child(${i + 1})`, { scale: 0.85 + i * 0.05, duration: time });
            tl.from(
                `.card:nth-child(${i + 2})`,
                { y: () => window.innerHeight, duration: time },
                "<"
            );
        });

        function tweenToLabel(direction, isScrollingDown) {
            if (
                (!tl.nextLabel() && isScrollingDown) ||
                (!tl.previousLabel() && !isScrollingDown)
            ) {
                cardsObserver.disable();
                return;
            }
            if (!animating && direction) {
                animating = true;
                tl.tweenTo(direction, { onComplete: () => (animating = false) });
            }
        }

        // --- Observer Plugin ---
        const cardsObserver = Observer.create({
            wheelSpeed: -1,
            onDown: () => tweenToLabel(tl.previousLabel(), false),
            onUp: () => tweenToLabel(tl.nextLabel(), true),
            tolerance: 10,
            preventDefault: true,
            onEnable(self) {
                allowScroll = false;
                scrollTimeout.restart(true);
                let savedScroll = self.scrollY();
                self._restoreScroll = () => self.scrollY(savedScroll);
                document.addEventListener("scroll", self._restoreScroll, { passive: false });
            },
            onDisable: (self) =>
                document.removeEventListener("scroll", self._restoreScroll)
        });
        cardsObserver.disable();

        // --- ScrollTrigger for Card Stack (Desktop Only) ---
        $('.benefits_service_item img').on('load', ScrollTrigger.refresh);
        ScrollTrigger.create({
            id: "STOP-SCROLL",
            trigger: ".benefits_services",
            pin: true,
            start: "top 10%",
            end: () => "+=" + document.querySelector('.benefits_services').offsetHeight,
            markers: false,
            onEnter: () => { if (!cardsObserver.isEnabled) cardsObserver.enable(); },
            onEnterBack: () => { if (!cardsObserver.isEnabled) cardsObserver.enable(); }
        });
    }

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

    // --- Section Animations ---
    animateSectionItems(".benefits_metrics_item", 40, 0.7, "top 80%", 0.1);
    animateSectionItems(".benefits_features_item", 60, 0.7, "top 85%", 0.1);
    animateSectionItems(".step_item", 40, 0.7, "top 90%", 0.1);
    animateSectionItems(".benefits_employees_item", 50, 0.7, "top 85%", 0.15);
    animateSectionItems(".benefits_why_us_tabs_button", 40, 0.7, "top 85%", 0.1);
    animateSectionItems(".benefits_why_us_tabs_content_item", 40, 0.7, "top 85%", 0.1);
    

    // --- Slick Slider ---
    $(".benefits_investors_slider").slick({
        infinite: true,
        arrows: false,
        dots: false,
        autoplay: true,
        speed: 800,
        slidesToShow: 3,
        slidesToScroll: 1,
        variableWidth: true
    });
    $(".benefits_investor_prev").click(function () {
        $(".benefits_investors_slider").slick("slickPrev");
    });
    $(".benefits_investor_next").click(function () {
        $(".benefits_investors_slider").slick("slickNext");
    });

    // --- Transform Section Animation ---
    gsap.from(".benefits_transform_content h2", {
        scrollTrigger: {
            trigger: ".benefits_transform",
            start: "top 80%",
        },
        y: 50,
        opacity: 0,
        duration: 0.8,
        ease: "power2.out"
    });
    gsap.from(".benefits_transform_content p", {
        scrollTrigger: {
            trigger: ".benefits_transform",
            start: "top 80%",
        },
        y: 40,
        opacity: 0,
        duration: 0.7,
        delay: 0.15,
        ease: "power2.out"
    });
    gsap.from(".benefits_transform_content ul li", {
        scrollTrigger: {
            trigger: ".benefits_transform",
            start: "top 80%",
        },
        x: -30,
        opacity: 0,
        duration: 0.6,
        delay: 0.3,
        stagger: 0.1,
        ease: "power2.out"
    });
    gsap.from(".benefits_transform_image", {
        scrollTrigger: {
            trigger: ".benefits_transform",
            start: "top 80%",
        },
        x: 50,
        opacity: 0,
        duration: 0.8,
        delay: 0.2,
        ease: "power2.out"
    });

    // --- Home Investors Slider Section Animation ---
    gsap.from(".benefits_investors_slider_section h2", {
        scrollTrigger: {
            trigger: ".benefits_investors_slider_section",
            start: "top 80%",
        },
        y: 40,
        opacity: 0,
        duration: 0.7,
        ease: "power2.out"
    });
    gsap.from(".benefits_investors_slider_section > .container > .benefits_investors_slider_wrapper > p", {
        scrollTrigger: {
            trigger: ".benefits_investors_slider_section",
            start: "top 80%",
        },
        y: 40,
        opacity: 0,
        duration: 0.7,
        delay: 0.15,
        ease: "power2.out"
    });
    gsap.from(".benefits_investors_slider", {
        scrollTrigger: {
            trigger: ".benefits_investors_slider_section",
            start: "top 80%",
        },
        y: 60,
        opacity: 0,
        duration: 0.8,
        delay: 0.3,
        ease: "power2.out"
    });
    gsap.utils.toArray(".benefits_investors_slide").forEach(function(slide, i) {
        gsap.from(slide, {
            scrollTrigger: {
                trigger: slide,
                start: "top 90%",
            },
            y: 30,
            opacity: 0,
            duration: 0.6,
            delay: i * 0.1,
            ease: "power2.out"
        });
    });

    // --- Resize Handler for Mobile/Desktop Transition ---
    let currentMobileState = isMobile();
    window.addEventListener("resize", function() {
        const newMobileState = isMobile();
        if (newMobileState !== currentMobileState) {
            currentMobileState = newMobileState;
            ScrollTrigger.refresh();
        }
    });
});

// --- ScrollTrigger refresh fixes for layout/animation jumps ---
window.addEventListener("load", ScrollTrigger.refresh);
window.addEventListener("resize", ScrollTrigger.refresh);
if (document.fonts) {
    document.fonts.ready.then(ScrollTrigger.refresh);
}


// Tab functionality for benefits_why_us section
document.addEventListener("DOMContentLoaded", () => {
    const tabsContainer = document.querySelector(".benefits_why_us_tabs_buttons");
    console.log("Tabs container found:", tabsContainer);

    if (tabsContainer) {
        const tabs = tabsContainer.querySelectorAll(".benefits_why_us_tabs_button");
        const contents = document.querySelectorAll(".benefits_why_us_tabs_content_item");

        console.log("Tabs found:", tabs.length);
        console.log("Contents found:", contents.length);

        if (tabs.length > 0 && contents.length > 0) {
            tabs.forEach((tab, index) => {
                tab.addEventListener("click", () => {
                    // Remove active from all tabs
                    tabs.forEach(t => t.classList.remove("active"));
                    contents.forEach(c => c.classList.remove("active"));

                    // Add active to clicked tab + content
                    tab.classList.add("active");
                    if (contents[index]) {
                        contents[index].classList.add("active");
                    }
                });
            });
            console.log("Tab functionality initialized successfully");
        } else {
            console.log("Tab elements not found - skipping tab functionality");
        }
    } else {
        console.log("Tabs container not found - this script should only run on exclusive-benefits pages");
    }
});

// Popup functionality for Start Investing button
document.addEventListener("DOMContentLoaded", function () {
  const overlay = document.getElementById("investPopoverOverlay");
  const investPopoverBox = document.getElementById("investPopoverBox");
  let selectedOption = "new";

  // Bind all "Start Investing" buttons
  document.querySelectorAll(".openInvestPopoverBtn").forEach(button => {
    button.addEventListener("click", () => {
      overlay.style.display = "flex";
      resetOptions();
    });
  });

  function resetOptions() {
    selectedOption = "new";
    document.querySelectorAll(".invest_option").forEach(card => card.classList.remove("selected"));
    document.querySelector('[data-value="new"]').classList.add("selected");
  }

  // ✅ Make these accessible from HTML onclick
  window.closePopover = function () {
    overlay.style.display = "none";
    resetOptions();
  };

  window.selectOption = function (el) {
    document.querySelectorAll(".invest_option").forEach(opt => opt.classList.remove("selected"));
    el.classList.add("selected");
    selectedOption = el.getAttribute("data-value");
  };

  window.handleSubmit = function () {
    if (!selectedOption) {
      alert("Please select an option.");
      return;
    }

    const urls = {
      new: "https://vested.app.link/RWBKECmefOb",
      existing: "https://vestedfinance.typeform.com/to/B1gfXsOZ?utm_source=landing_page"
    };

    window.open(urls[selectedOption], "_blank");
    closePopover();
  };

  overlay.addEventListener("click", function (e) {
    if (!investPopoverBox.contains(e.target)) {
      closePopover();
    }
  });

  // Default select on load
  resetOptions();
});
