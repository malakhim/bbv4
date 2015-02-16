$(document).ready(function(){

	// Set up countdown
	$('.bb-time-remaining').each(function(){
		var date = new Date($(this).attr('expiry') * 1000);
		var expiry_date = new Date(date.getFullYear(), date.getMonth(), date.getDate(), date.getHours(), date.getMinutes(), date.getSeconds());
		$(this).countdown({
			until:expiry_date,
			compact: true,
			compactLabels: ['y','m','w','d','h','m','s'],
			layout: '{d<}{dn}{dl}{d>} {h<}{hn}{hl}{h>} {m<}{mn}{ml}{m>} {sn}{sl}',
			onTick: highlightLastHour,
			expiryText: '<div class="countdown-expired">Auction finished</div>',
		});
	});

	// Submit functionality for accept button
	$('.view-offer-btn').click(function(e){
		$(this).parent().submit();
		e.preventDefault();
	});

	// Edit link ajax functionality
	$('.request-page-edit').click(function(e){
		var price_text = $(this).siblings('.bb-list-price').children('.bid-price');
		var price_input_box = $(this).siblings('.bid-price-inputbox');
		var edit_link = $(this);
		var error_msg = $(this).siblings('.error-message');
		edit_link.parent().siblings('.error-message').hide();
		if(price_text.data('hidden') !== 1){
			price_input_box.val(price_text.html().replace(edit_link.data('currency'),'').trim());
			price_text.hide();
			price_input_box.show();
			price_text.data('hidden',1);
			edit_link.html(edit_link.data('save-text'));
		}else{
			var new_price = price_input_box.val();
			// Ajax call to save the price
			$.ajax({
				url: $(this).data('href'),
				type: 'POST',
				data: {'bid_id':$(this).data('id'),'price':price_input_box.val().trim()},
				success: function(response){
					var response = $.parseJSON(response);
					if(response['success']){
						price_text.html(edit_link.data('currency') + new_price); 
						price_input_box.hide();
						price_text.show();
						price_text.data('hidden',0);
						edit_link.html(edit_link.data('edit-text'));
						error_msg.hide();
					}else{
						error_msg.find('p').text(response['message']);
						error_msg.show();
					}
				}
			});
			// Replace the price in input box and text
			// Change to show
			// Save price_text.data('hidden') to 0
		}
		$(this).siblings('.bid-price').hide();
		$(this).siblings('.bid-price-inputbox').show();
		$(this).html('Save');
		return false;
		e.preventDefault();
	});

});

// Set last hour to color:orange for countdown
function highlightLastHour(periods){
	if ($.countdown.periodsToSeconds(periods) <= 3600) { 
        $(this).addClass('countdown-highlight'); 
    } 
}