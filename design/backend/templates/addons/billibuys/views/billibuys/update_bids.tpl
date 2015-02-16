{capture name="mainbox"}
	<script src="addons/billibuys/js/update_bids.js" type="text/javascript"></script>
	<div class="right"><a href="{"admin.php?dispatch=billibuys.notify"|fn_url}">{__('create_notification')}</a></div>
	
	{if $bids}
		{__('choose_action')}:
		<form action="{""|fn_url}" method="post" name="category_tree_form" class="{if ""|fn_check_form_permissions}cm-hide-inputs{/if}">

			{capture name=amount_dropdown assign=amount}
				<select name="quantity" id="slct_a_update">
					{section name=quantity start=$bids[0].amount loop=$bids[0].amount+1 step=-1}
						<option value="{$smarty.section.quantity.index}">{$smarty.section.quantity.index}</option>
					{/section}
				</select>
			{/capture}

			{capture name=price_inputbox assign=price}
				<input type="text" value="{$highest_price}" name="price" class="input-text" size="{$highest_price|count_characters}" id="txt_a_update"/>
			{/capture}
			<input type="hidden" name="product_id" value="{$bids[0].product_id}"/>
			<input type="radio" name="update_bid_option" value="auto_update" id="a_update" /><label for="a_update">{__('update_bids_auto_update_option_text')|replace:"[product]":$bids[0].product|replace:"[quantity]":$amount|replace:"[currency]":$currency|replace:"[price]":$price|escape:false}</label> <br/>
			<input type="radio" name="update_bid_option" value="manual_update" id="m_update" /><label for="m_update">{__('update_bids_manual_update_option_text')}</label><br/>
			<input type="radio" name="update_bid_option" value="no_update" id="n_update" /><label for="n_update">{__('update_bids_no_update_option_text')}</label><br/><br/>
			<div class="float-left">
				{include file="buttons/save.tpl" but_name="dispatch[billibuys.update_bids_2]" but_role="button_main"}
			</div>

			<br/>
		</form>
	{else}
		{*assign var="lowercase_here" value=__('here')|lower}
		{assign var="url" value="billibuys.offers"|fn_url}
		{assign var="link" value="<a href='".$url."'>".$lowercase_here."</a>"*}
		{__('no_disabled_bids')|replace:"[here]":"<a href='`$url`'>`__('here')`|lower</a>"}
	{/if}

{/capture}

{include file="common_templates/mainbox.tpl" title=__('update_bids') content=$smarty.capture.mainbox title_extra=$smarty.capture.title_extra tools=$smarty.capture.tools}