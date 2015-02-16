$(document).ready(function(){
	$('.root-lvl-cat').click(function(){
		if($(this).nextUntil('.root-lvl-cat').length > 0){
			$(this).nextUntil('.root-lvl-cat').toggle('fast');
			$(this).find('.left-side-nav-img').toggleClass('left-side-nav-image-opened');
		}else{
			var cat_id =+ $(this).attr('cat_id');
			window.location.href = "index.php?dispatch=billibuys.view&category_id="+cat_id;
		}
	});

    var $sidebar   = $(".cat-left-side-nav"), 
        $window    = $(window),
        offset     = $sidebar.offset(),
        topPadding = 15;

    $window.scroll(function() {
        if ($window.scrollTop() > offset.top) {
            $sidebar.stop().animate({
                marginTop: $window.scrollTop() - offset.top + topPadding
            });
        } else {
            $sidebar.stop().animate({
                marginTop: 0
            });
        }
    });
});