<script defer>
    document.addEventListener("DOMContentLoaded", () => {
        const allImages = document.querySelectorAll("img");
        allImages.forEach((img) => {
            const setDimensions = () => {
            if (!img.hasAttribute("width") && !img.hasAttribute("height")) {
                const naturalWidth = img.naturalWidth;
                const naturalHeight = img.naturalHeight;
                if (naturalWidth && naturalHeight) {
                img.setAttribute("width", naturalWidth);
                img.setAttribute("height", naturalHeight);
                }
            }
            };
            if (img.complete) {
            setDimensions();
            } else {
            img.addEventListener("load", setDimensions);
            }
            if (!img.hasAttribute("alt") || img.getAttribute("alt").trim() === "") {
            const src = img.getAttribute("src");
            if (src) {
                const filename = src.split("/").pop().split(".")[0];
                img.setAttribute("alt", filename.replace(/[-_]/g, " "));
            }
            }
        });
    });

    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    anchorLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = link.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            if (targetElement) {
                anchorLinks.forEach(function(anchor) {
                    anchor.classList.remove('active');
                });
                link.classList.add('active');
                targetElement.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
    

    const faqItems = document.querySelectorAll('.faq_item');
    faqItems.forEach(item => {
        const question = item.querySelector('.faq_question');
        const answer = item.nextElementSibling;
        const icon = item.querySelector('.faq_icon');

        item.addEventListener('click', () => {
            faqItems.forEach(otherItem => {
            if (otherItem !== item) {
                const otherAnswer = otherItem.nextElementSibling;
                const otherIcon = otherItem.querySelector('.faq_icon');

                otherAnswer.classList.remove('active');
                otherIcon.classList.remove('active');
                otherAnswer.style.maxHeight = "0";
            }
            });
            answer.classList.toggle('active');
            icon.classList.toggle('active');
            if (answer.classList.contains('active')) {
                answer.style.maxHeight = answer.scrollHeight + "px";
            } else {
                answer.style.maxHeight = "0";
            }
        });
    });

    function copyLink() {
        var inputElement = document.createElement("input");
        inputElement.value = window.location.href;
        document.body.appendChild(inputElement);
        inputElement.select();
        document.execCommand("copy"); // This command copies the selected text
        document.body.removeChild(inputElement);

        for (var i = 0; i < 5; i++) {
            displayMessage();
        }
    }

    function displayMessage() {
        var copyMessage = document.getElementById("copy_link_message");
        copyMessage.classList.add('active');
        setTimeout(function () {
            copyMessage.classList.remove('active');
        }, 2000);
    }


    document.addEventListener("DOMContentLoaded", function () {
        var symbol = "<?php echo $symbol; ?>";
        var stockBoxes = document.querySelectorAll('.box_warrp');
        var hideLastDiv = true;
        stockBoxes.forEach(function (box) {
            if (box.getAttribute('data-symbol') === symbol) {
                hideLastDiv = false;
                box.style.display = 'none';
            }
        });
        if (hideLastDiv) {
            var lastDiv = stockBoxes[stockBoxes.length - 1];
            lastDiv.style.display = 'none';
        }
    });

    var stockTabsMenu = document.querySelector('.stock_tabs_menu');
    var stockTabsMenuPosition = document.querySelector('.stock_tabs_menu_position');
    function addClassOnScroll() {
      var scrollPosition = window.scrollY;
      if (scrollPosition >= stockTabsMenuPosition.offsetTop && scrollPosition >= 100) {
        stockTabsMenu.classList.add('highlighted');
      } else {
        stockTabsMenu.classList.remove('highlighted');
      }
    }

    window.addEventListener('scroll', addClassOnScroll);

    function moveElements() {
        // Get the elements to be moved
        var tabsMenu = document.querySelector('.stock_tabs_menu');
        var searchContainer = document.querySelector('.stocks_search_container');
        var forecastContainer = document.querySelector('.stock_forecast_container');
        var metricsContainer = document.querySelector('.stock_metrics_container');
        var windowWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
        if (windowWidth < 1024) {
            searchContainer.parentNode.insertBefore(tabsMenu, searchContainer.nextSibling);
            metricsContainer.parentNode.insertBefore(forecastContainer, metricsContainer.nextSibling);
        }
    }

    // Call the function on page load and window resize
    document.addEventListener('DOMContentLoaded', moveElements);
    window.addEventListener('resize', moveElements);

    function changeStockBoxTab(sectionId, tabId, clickedTab) {
        var tabs = document.getElementById(sectionId).getElementsByClassName('stock_box_tab_content');
        for (var i = 0; i < tabs.length; i++) {
            tabs[i].classList.add('hidden');
        }
        var allTabs = document.getElementById(sectionId).getElementsByClassName('stock_box_tab_button');
        for (var i = 0; i < allTabs.length; i++) {
            allTabs[i].classList.remove('active');
        }
        document.getElementById(tabId).classList.remove('hidden');
        clickedTab.classList.add('active');
    }

    function setTextContent(elementId, text) {
        var element = document.getElementById(elementId);
        if (element) {
            element.textContent = text;
        } else {
            console.error('Element with id ' + elementId + ' not found.');
        }
    }

    document.addEventListener("DOMContentLoaded", function(){
        var singleTabHeadings = document.querySelectorAll('.single_tab_wrap:nth-child(1) .single_tab_heading');
        singleTabHeadings.forEach(function(singleTabHeading) {
            singleTabHeading.classList.add('collapsed');
        });

        var singleTabHeadingsAll = document.querySelectorAll(".single_tab_heading");
        singleTabHeadingsAll.forEach(function(singleTabHeadingAll) {
            singleTabHeadingAll.addEventListener("click", function() {
                if (!this.classList.contains("collapsed")) {
                    var collapsedHeadings = document.querySelectorAll(".single_tab_heading.collapsed");
                    collapsedHeadings.forEach(function(collapsedHeading) {
                        collapsedHeading.classList.remove("collapsed");
                    });
                    this.classList.add("collapsed");
                } else {
                    var collapsedHeadings = document.querySelectorAll(".single_tab_heading.collapsed");
                    collapsedHeadings.forEach(function(collapsedHeading) {
                        collapsedHeading.classList.remove("collapsed");
                    });
                }
                if (window.innerWidth > 767) {
                    var tabLinksWraps = document.querySelectorAll('.single_tab_wrap .tab_links_wrap');
                    tabLinksWraps.forEach(function(tabLinksWrap) {
                        var tabHeight = tabLinksWrap.offsetHeight;
                        var finaHeight = tabHeight - 17;
                        var parentElement = tabLinksWrap.closest('.single_tab_content');
                        parentElement.style.marginBottom = finaHeight + 'px';
                    });
                }
            });
        });

        var readMoreLinks = document.querySelectorAll('.read_more_link');
        readMoreLinks.forEach(function(readMoreLink) {
            readMoreLink.addEventListener("click", function() {
                var disclosure = document.querySelector('.read_more_content');
                readMoreLink.style.display = "none";
                var readLessLink = document.querySelector('.read_less_link');
                readLessLink.style.display = "block";
                disclosure.style.display = "block";
            });
        });

        var readLessLinks = document.querySelectorAll('.read_less_link');
        readLessLinks.forEach(function(readLessLink) {
            readLessLink.addEventListener("click", function() {
                var disclosure = document.querySelector('.read_more_content');
                readLessLink.style.display = "none";
                var readMoreLink = document.querySelector('.read_more_link');
                readMoreLink.style.display = "block";
                disclosure.style.display = "none";
            });
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        var humburger = document.querySelector("header .inner-header .site-primary-header-wrap .logo-menu .humburger");
        if (humburger) {
            humburger.addEventListener("click", function() {
                document.body.classList.toggle("menu-open");
            });
        } else {
            console.error("Hamburger element not found!");
        }
    });

    document.addEventListener("DOMContentLoaded", function () {
        var content = document.getElementById("stock_about_description");
        var showMoreBtn = document.getElementById("show_more");
        var originalText = content.textContent;

        if (originalText.length > 255) {
            content.textContent = originalText.slice(0, 255) + " ...";
            showMoreBtn.style.display = "inline-block";
        }

        showMoreBtn.addEventListener("click", function () {
            content.textContent = originalText;
            showMoreBtn.style.display = "none";
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        var images = document.getElementsByClassName("holdings_image");

        // Check if there are images with the class "image"
        if (images.length > 0) {
            for (var i = 0; i < images.length; i++) {
                images[i].onerror = function() {
                    // If the image fails to load (i.e., returns 404), replace it with a default image
                    this.src = "https://vestedfinance.com/wp-content/uploads/2024/03/holdings-defult.svg";
                };
            }
        }
    });

</script>