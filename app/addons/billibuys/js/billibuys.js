$(document).ready(function(){

	// Top nav menu items

	if($('#second-top-nav').length != 0){
		 $('#second-top-nav').css('margin-left','-' + $('#second-top-nav').offset().left + 'px');
	}

	// Search box functions

	if($('#input-search').length > 0){
		var search_default_text = $('#input-search').val();

		$('#input-search').click(function(){
			if($(this).val() == search_default_text){
				$(this).val('');
			}
		});

		$('#input-search').blur(function(){
			if($(this).val() == ''){
				$(this).val(search_default_text);
			}
		});

		// TODO: Add a function to put text back into place if focus is lost and text in field == ''
	}

	// $('.submenu_item').click(function(){
	// 	$(this).find('a').click();
	// });
	// 
	
	$('.submenu-wrapper').each(function(){
		$(this).css({
			"width": $(this).next('.top-nav-submenu').width(),
			"height": $(this).next('.top-nav-submenu').height(),
		});
	});

	$('.top_menu_item, .submenu-wrapper').hover(function(){
		$(this).find('.submenu-wrapper').css('visibility','visible');
		$(this).find('.top-nav-submenu').css('visibility','visible');
	},function(){
		$(this).find('.submenu-wrapper').css('visibility','hidden');
		$(this).find('.top-nav-submenu').css('visibility','hidden');
	});

});