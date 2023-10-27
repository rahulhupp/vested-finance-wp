
jQuery( document ).ready(function() {
    jQuery(".leadership ul.list li .content .bio img.info").click(function(){
        jQuery(this).parent().parent().parent().parent().addClass("open");
        jQuery('body').addClass("leadership-modal-open");
    });
    jQuery(".leadership ul.list li .modal .modal-content .head-part img.close, .modal-overlay").click(function(){
      jQuery('.leadership ul.list li').removeClass("open");
      jQuery('body').removeClass("leadership-modal-open");
  });
});


