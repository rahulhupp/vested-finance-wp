<script>
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    anchorLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            anchorLinks.forEach(function(anchor) {
                anchor.classList.remove('active');
            });
            link.classList.add('active');
            const targetId = link.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });

    
    const faqItems = document.querySelectorAll('.faq_item');
    faqItems.forEach(item => {
        const question = item.querySelector('.faq_question');
        const answer = item.nextElementSibling;
        const icon = item.querySelector('i');

        item.addEventListener('click', () => {
            faqItems.forEach(otherItem => {
            if (otherItem !== item) {
                const otherAnswer = otherItem.nextElementSibling;
                const otherIcon = otherItem.querySelector('i');

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
        console.log('copyLink');
        var inputElement = document.createElement("input");
        inputElement.value = "<?php echo esc_url(get_stylesheet_directory_uri()) ?>/assets/images/share-icon.svg";
        document.body.appendChild(inputElement);
        inputElement.select();
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
    function addClassOnScroll() {
      var scrollPosition = window.scrollY;
      if (scrollPosition >= stockTabsMenu.offsetTop && scrollPosition >= 100) {
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

    function showMore(data) {
        setTextContent('stock_about_description', data);
    }
</script>