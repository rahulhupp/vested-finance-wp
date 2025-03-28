jQuery(document).ready(function($){
    const firstTabWrap = $('.single_tab_wrap:nth-child(1)');
    firstTabWrap.find('.single_tab_heading').addClass('collapsed');
    const tabLinksWrap = firstTabWrap.find('.tab_links_wrap');
    const defaultHeightFinal = tabLinksWrap.height() - 17;
    tabLinksWrap.closest('.single_tab_content').css('margin-bottom', `${defaultHeightFinal}px`);
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