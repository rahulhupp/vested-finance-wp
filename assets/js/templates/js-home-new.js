
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
        $('.home_service_item img').on('load', ScrollTrigger.refresh);
        ScrollTrigger.create({
            id: "STOP-SCROLL",
            trigger: ".cards-section",
            pin: true,
            start: "top 10%",
            end: () => "+=" + document.querySelector('.cards-section').offsetHeight,
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
    animateSectionItems(".home_metrics_item", 40, 0.7, "top 80%", 0.1);
    animateSectionItems(".home_features_item", 60, 0.7, "top 85%", 0.1);
    animateSectionItems(".home_diversify_item", 40, 0.7, "top 90%", 0.1);
    animateSectionItems(".step_item", 40, 0.7, "top 90%", 0.1);
    animateSectionItems(".home_security_item", 40, 0.7, "top 90%", 0.1);
    animateSectionItems(".home_quick_links_item", 30, 0.6, "top 95%", 0.1);

    // --- Slick Slider ---
    $(".home_investors_slider").slick({
        infinite: true,
        arrows: false,
        dots: false,
        autoplay: true,
        speed: 800,
        slidesToShow: 3,
        slidesToScroll: 1,
        variableWidth: true
    });
    $(".home_investor_prev").click(function () {
        $(".home_investors_slider").slick("slickPrev");
    });
    $(".home_investor_next").click(function () {
        $(".home_investors_slider").slick("slickNext");
    });

    // --- Home Investors Slider Section Animation ---
    gsap.from(".home_investors_slider_section h2", {
        scrollTrigger: {
            trigger: ".home_investors_slider_section",
            start: "top 80%",
        },
        y: 40,
        opacity: 0,
        duration: 0.7,
        ease: "power2.out"
    });
    gsap.from(".home_investors_slider_section > .container > .home_investors_slider_wrapper > p", {
        scrollTrigger: {
            trigger: ".home_investors_slider_section",
            start: "top 80%",
        },
        y: 40,
        opacity: 0,
        duration: 0.7,
        delay: 0.15,
        ease: "power2.out"
    });
    gsap.from(".home_investors_slider", {
        scrollTrigger: {
            trigger: ".home_investors_slider_section",
            start: "top 80%",
        },
        y: 60,
        opacity: 0,
        duration: 0.8,
        delay: 0.3,
        ease: "power2.out"
    });
    gsap.utils.toArray(".home_investors_slide").forEach(function(slide, i) {
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
