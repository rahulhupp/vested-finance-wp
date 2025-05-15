jQuery(document).ready(function($) {
    // Add class to first tab heading
    $('.single_tab_wrap:nth-child(1) .single_tab_heading').addClass('collapsed');

    // Click handler for tab headings
    $(".single_tab_heading").click(function () {
        if (!$(this).hasClass("collapsed")) {
            $(".single_tab_heading.collapsed").removeClass("collapsed");
            $(this).addClass("collapsed");
        } else {
            $(".single_tab_heading.collapsed").removeClass("collapsed");
        }

        // Only run height adjustment on desktop
        if (window.innerWidth > 767) {
            adjustTabHeights();
        }
    });

    // Run height adjustment on page load for desktop
    if (window.innerWidth > 767) {
        adjustTabHeights();
    }

    // Click handler for read more
    $('.read_more_link').click(function(){
        $(this).hide();
        $('.read_less_link').show();
        $('.read_more_content').slideDown();
    });

    // Click handler for read less
    $('.read_less_link').click(function(){
        $(this).hide();
        $('.read_more_link').show();
        $('.read_more_content').slideUp();
    });

    // Function to adjust tab heights
    function adjustTabHeights() {
        $('.single_tab_wrap .tab_links_wrap').each(function() {
            var tabHeight = $(this).height();
            var finaHeight = tabHeight - 17;
            var parentElement = $(this).closest('.single_tab_content');
            console.log('tabHeight', tabHeight);
            parentElement.css('margin-bottom', finaHeight + 'px');
        });
    }
});
