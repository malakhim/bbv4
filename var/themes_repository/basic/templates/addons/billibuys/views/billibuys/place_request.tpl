{*
This template is for /place_request, which is a SEO-cleaned equivalent of /index.php?dispatch=billibuys.place_request. 

Any url in CS-Cart uses the format dispatch=[controller].[mode], with the [mode] also doubling as the name of the template file. Therefore, the location of any mode template can be found in a similar folder as this one, where the controller name is one level up from the template file - Eg, the template file for billibuys.requests for the customer side is found in /skins/basic/customer/addons/billibuys/views/billibuys/requests.tpl.*}


{*Datepicker external js, for the "Expiry Date" field - Loaded at beginning as common practice.*}
<script type="text/javascript" src="js/datepicker.js"></script>
<script type="text/javascript" src="addons/billibuys/js/moment-locales.min.js"></script>
<script type="text/javascript" src="addons/billibuys/js/place_request.js"></script>
{*
Form wrapper for the entire thing, so that all data is sent back to server in one group. Parameters:

	name: This follows "snake" formatting, and is completely arbitrary

	action: This calls the fn_url php function (from /core/fn.common.php) on the string "billibuys.view". Any controller/standard php function can be called in Smarty using this format, although try to limit the usage of such to display ones only, for security reasons. This particular function cleans it up for SEO purposes.
	The action parameter dictates where to send the form, although we've overridden this a bit further down the page so you don't really need this. Not that I suggest replacing it with goatse.

	method: POST should always be used whenever possible. GET messes with the routing in CS-Cart, and it's ugly anyway.

	enctype: This is standard for any forms that require file uploading.
*}
<form name="bb_request_form" action="{"billibuys.view"|fn_url}" method="post" enctype="multipart/form-data" id="bb_request_form">

	{*All forms in CS-Cart should be wrapped with "form-field", for clean CSS.*}
	<div class="form-field">
		{*Label tag's "for" parameter should refer to the id of the tag it's targetting, so when someone clicks on the Label tag then the browser will automatically focus on the targeted id's tag.

		Language variables are in the format {__('[variable')]}. These are stored in the cscart_language_values table. You'll also need to add them to /addons/billibuys/addon.xml under the section labelled "Language variables". That part should be fairly understandable, but let me know if you need help with that.

		The cm-required tag means it's required, trim deletes trailing whitespace. More info as well as what's available can be found here: http://docs.cs-cart.com/4.1.x/core/front-end/microformats.html
		*}
		<label for="bb_request_title" class="cm-required cm-trim">{__('bb_request_title')}</label>

		{*Few parameters to note here:
			name: Form data should be sent as an array, so this sends the data back as an array with name "request" and key "title". 

			value: All forms should re-input data if user submits and something goes wrong and they have to click back. This smarty value basically says to input the "title" value of the "request" array from the REQUEST array (http://php.net/manual/en/reserved.variables.request.php) into here so user won't have to type it again. It'll be blank if there is no REQUEST value matching it.
		*}
		<input id="bb_request_title" type="text" name="request[title]" size="50" maxlength="50" value="{if $smarty.request.request.title}{$smarty.request.request.title}{/if}" title="{__('title_description')}" class="cm-hint input-text" />
	</div>

	<div class="form-field">
		<label for="bb_request_desc" class="cm-required cm-trim">{__('description')}</label>
		<textarea id="bb_request_desc" name="request[description]" size="500" maxlength="500" value="{if $smarty.request.request.desc}{$smarty.request.request.desc}{/if}" title="{__('desc_description')}" class="input-textarea cm-hint">{if $smarty.request.request.desc}{$smarty.request.request.desc}{else}{__('desc_description')}{/if}</textarea>
	</div>

	<div class="form-field">
		<label for="bb_max_price" class="cm-trim cm-regexp">{__('max_price')}</label>
		<input id="bb_max_price" type="text" name="request[max_price]" size="32" maxlength="32" value="{if $smarty.request.request.max_price}{$smarty.request.request.max_price}{/if}" title="{__('maxprice_description')}" class="input-text cm-hint" />
		
		<input type="checkbox" id="bb_over_max_price" name="allow_over_max_price" value="N" title="{__('bb_allow_over_max_price')}" class="checkbox cm-check-items" {if ($smarty.request.request.allow_over_max_price == 1)} checked="checked"{/if}/>
		
		<label for="bb_over_max_price" class="label-inline">{__('bb_allow_over_max_price')}&nbsp;(<a class="cm-tooltip" title="{__('max_price_within')|replace:'[max_price_variation]':$max_price_variation}">?</a>)</label>
	</div>

	<div class="form-field">
		<label for="bb_desired_qty" class="cm-trim cm-required cm-custom (check_positive)">{__('desired_amount')}</label>
		<input id="bb_desired_qty" type="number" id="bb_desired_qty" name="request[quantity]" size="32" maxlength="32" value="{if $smarty.request.request.max_price}{$smarty.request.request.max_price}{/if}" title="{__('desired_quantity_description')}" class="input-text" min="0" maxlength="11" cm-value-integer/>
	</div>

	<div class="form-field">
	{*Haven't gotten around to auto-selecting this in case user comes back to this page. Feel free. *}
		<label for="bb_expiry_date" class="cm-trim cm-required cm-regexp">{__('bb_select_expiry_date')}</label>
		<input type="text" id="bb_expiry_date" class="cm-hint" value="{if $smarty.request.request.expiry_date}{$smarty.request.request.expiry_date}{/if}" title="{__('expiry_description')}"/>
		<div class="hidden date-text" id="date-expiry-msg"></div>
		<input type="hidden" name="request[expiry_date]" id="expiry_date_val" value=""/>
	</div>

	<div class="form-field">
		<label for="bb_category" class="cm-trim cm-required">{__('category')}</label>

		{*This basically loops through the $categories array, passed from the controller (http://www.smarty.net/docsv2/en/language.function.foreach). Let me know if you have any questions.*}

		<select name="category" id="bb_category">
			{foreach from=$categories item='cat'}
				<option value="{$cat.bb_request_category_id}">{$cat.category_name}</option>
			{/foreach}
		</select>
	</div>	

	<div class="form-field">
		<label>{__('image')}</label>
		{include file="../admin/common_templates/attach_images.tpl" image_name="request_main" image_object_type="request" hide_server=true no_thumbnail=true hide_images=true hide_alt=true hide_titles=true}
	</div>


	<div class="buttons-container">
		{*As mentioned before, this overrides the "action" of this form and makes that obselete. I've kept it there as fallback in case this fails, but the submit button's but_name parameter is key to this form working.*}
		{include file="buttons/button.tpl" but_text=__('submit') but_name="dispatch[billibuys.view]" but_id="but_submit_request" }
	</div>
</form>

{*Regex for the cm-regexp microformat in the price field. Checks format is an accurate price format.*}
<script type="text/javascript">
//<![CDATA[
{literal}
regexp['bb_max_price'] = {
	regexp: /^(([1-9][0-9]{0,2}(,[0-9]{3})*)|[0-9]+)(\.[0-9]{1,2})?$/{/literal}, message: "{__('bb_error_validator_price_format')|escape:'javascript'}"
{literal}
};

regexp['bb_expiry_date'] = {
	regexp: /^(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d$/{/literal}, message: "{__('twg_msg_date_invalid')|escape:'javascript'}"
{literal}
};
{/literal}
{literal}
function fn_check_positive(id){
	var elm = $('#' + id);

	if(elm.val() < 0){
		return lang.error_validator_integer;
	}else{
		return true;
	}
}
{/literal}
//]]>
</script>

{*Headings always go in this smarty tag. <h1> tags won't work here.*}
{capture name="mainbox_title"}{__('place_request')}{/capture}
