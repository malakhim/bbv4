$(document).ready(function(){
	$('#slct_a_update').click(function(){
		$(this).parent().prev().attr('checked','checked');
	});

	$('#txt_a_update').click(function(){
		$(this).parent().prev().attr('checked','checked');
	});
});