$(document).ready(function(){
	$('.ratings-star').click(function(){
		// clear existing stars
		$(this).siblings().removeClass('star-selected');
		// flip class of star to selected
		$(this).toggleClass('star-selected');
		// store value into rating-star-value
		$(this).siblings('.star-hidden-value').val($(this).attr('data-num'));
	});
});