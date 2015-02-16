$(window).ready(function(){
  $('.abt_panel').height($(window).height());
  var buyertop = $('.buyer-panel').offset().top;  
  $('.abt_panel .learn-more').click(function(){
    $('html, body').animate({scrollTop: buyertop - $('#ci_top_wrapper').height()},1000,function(){return false});
  });

  $('#search-submit').click(function(){
    $(this).parent().submit();
  });

  if(navigator.userAgent.match(/android 2.3/i)){
    $("meta[name=viewport]").attr('content','user-scalable=yes','minimum-value=1.0','maximum-value=1.0');
  }else if(navigator.userAgent.match(/android 4/i)){
      $("meta[name=viewport]").attr('content','width=620','user-scalable=no');
  }
});

$(function() {
    // our function that decides weather the navigation bar should have "fixed" css position or not.
    var sticky_navigation = function(){
      
        var scroll_top = $(window).scrollTop(); // our current vertical position from the top

        var top_menu_items = $('#ci_top_wrapper, .top-nav-submenu');
        var submenu_triangle = $('.top-nav-triangle');

        if (scroll_top > $('.buyer-panel').offset().top - $('#ci_top_wrapper').height()){
         top_menu_items.addClass('header-solid');
         submenu_triangle.css('border-color','transparent transparent #1e90bd transparent');
         top_menu_items.removeClass('header-transparent');
        }else{
          top_menu_items.removeClass('header-solid');
          submenu_triangle.css('border-color','transparent transparent rgba(0,104,133,0.38) transparent');
          top_menu_items.addClass('header-transparent');
        }
    };
     
    // run our function on load
    sticky_navigation();
     
    // and run it again every time you scroll
    $(window).scroll(function() {
         sticky_navigation();
    });
});