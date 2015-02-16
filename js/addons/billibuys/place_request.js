$(document).ready(function(){



	// DEPCRECATED: This hid the hint text within the fields upon clicking, but turns out cm-hint class does the same thing
	// // 
	// $('#bb_request_form').find('.input-text, .input-textarea').each(function(){
	// 	if($(this).length > 0){
	// 		var search_default_text = $(this).val();

	// 		$(this).click(function(){
	// 			if($(this).val() == search_default_text){
	// 				$(this).val('');
	// 			}
	// 		});

	// 		$(this).blur(function(){
	// 			if($(this).val() == ''){
	// 				$(this).val(search_default_text);
	// 			}
	// 		});
		
	// 		// TODO: Add a function to put text back into place if focus is lost and text in field == ''
	// 	}
	// });

	// Display expiry date value
	$('#bb_expiry_date').change(function(){
		// Regex the date to make sure we're not trying to read gibberish
		var date_regex = /^(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d$/;
		if(date_regex.test($(this).val())){
			// Initialise moment.js with current time
			var now = moment();

			// Initialise another moment.js with the value in the date field
			var dat = moment($(this).val(),"DD-MM-YYYY");

			// Add current time to value in date field
			dat.set('hour',now.get('hour'));
			dat.set('minute',now.get('minute'));
			dat.set('second',now.get('second'));
	
			// Show user when request will end
			$(this).next('.date-text').show();
			$(this).next('.date-text').html("Your request will expire at <strong>" + dat.format('LL') + ' ' + dat.format('LTS') + "</strong>");

			// Prep for sending back to controller
			$('#expiry_date_val').val(dat.unix());
		}else{
			$('#expiry_date_val').val('');
			$(this).next('.date-text').hide();
		}
	});
	
});