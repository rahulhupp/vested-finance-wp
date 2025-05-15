jQuery(document).ready(function($){
    $('.single_tab_wrap:nth-child(1) .single_tab_heading').addClass('collapsed');
    $(".single_tab_heading").click(function () {
        if (!$(this).hasClass("collapsed")) {
            $(".single_tab_heading.collapsed").removeClass("collapsed");
            $(this).addClass("collapsed");
        } else {
            $(".single_tab_heading.collapsed").removeClass("collapsed");
        }
        if (window.innerWidth > 767) {
            $('.single_tab_wrap .tab_links_wrap').each(function() {
                var tabHeight = $(this).height();
                var finaHeight = tabHeight - 17;
                var parentElement = $(this).closest('.single_tab_content');
                console.log('tabHeight', tabHeight);
                parentElement.css('margin-bottom', finaHeight + 'px');
            });
        }
    });
    $('.read_more_link').click(function(){
        var disclosure = $('.read_more_content');
        $(this).hide();
        $('.read_less_link').show();
        disclosure.slideDown();
    });
    $('.read_less_link').click(function(){
        var disclosure = $('.read_more_content');
        $(this).hide();
        $('.read_more_link').show();
        disclosure.slideUp();
    });
    
})