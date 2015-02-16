{literal}
<link rel="stylesheet" type="text/css" href="addons/billibuys/js/jquery.countdown/jquery.countdown.css">
<script src="addons/billibuys/js/jquery.countdown/jquery.plugin.min.js" type="text/javascript"></script>
<script src="addons/billibuys/js/jquery.countdown/jquery.countdown.min.js" type="text/javascript"></script>
<script src="addons/billibuys/js/view_request.js" type="text/javascript"></script>
<script src="addons/billibuys/js/hyphenator/Hyphenator.js" type="text/javascript"></script>
{/literal}

<div id="info-box">
	{include file="common_templates/image.tpl" image_width="150" image_height="150" images=$request.image show_thumbnail="N" no_ids=true class="request-item-image"}
	{*<div id="request-infobox-right">*}

	{*</div>*}
	<div id="info-box-text">
		<div id="request-page-title">{$request.title}</div>
		<hr/>
		<div id="max-price">
			{__('max_price')}:
			{if $request.max_price != 0}
				{include file="common_templates/price.tpl" value=$request.max_price is_integer=false}
			{else}
				{__('no_max_price')}
			{/if}
		</div>
		<div id="requested_qty">
			{__('desired_amount')}:&nbsp;{$request.quantity}
		</div>
		{__('time_remaining')}:&nbsp;<span class="bb-time-remaining" expiry="{$request.expiry_date}"></span> ({__('ends')} {$request.expiry_date|date_format:"%e %B %Y %l:%M:%S%p"})
		<br/><br/>
		<div id="description-text">{$request.description}</div>
		<br/><br/>
		<div id="bid_range">{__('current_offers')}:&nbsp;{include file="common_templates/price.tpl" value=$min_bid_amount is_integer=false} - {include file="common_templates/price.tpl" value=$max_bid_amount is_integer=false} [{$num_offers} {if $num_offers == 1}{__('offer')}{else}{__('offers')}{/if}]</div>
		<br/><br/>
		{if $expired == 0}
			{if $request.user_id != $smarty.session.auth.user_id}
				<a href="{"vendor.php?dispatch=billibuys.place_bid&request_id=`$request.bb_request_id`"|@fn_url}" class="request-page-btn" id="place-offer">{__('place_bid')}</a>
			{/if}
			{*{if $request.user_id != $smarty.session.auth.user_id}
				{include file="buttons/button.tpl" but_text="`__('place_bid')`" but_role="action" but_meta="place_offer" but_href="vendor.php?dispatch=billibuys.place_bid&request_id=`$request.bb_request_id`"|@fn_url  but_id="place_offer"}
			{/if}*}
		{else if $expired > 0}
			{__('auction_finished')}. <a href="{"billibuys.view"|fn_url}">{__('click_here_to_return_to_main_page')}</a>
		{/if}
	</div>
</div>

{if $bids != null && isset($bids)}
	{include file="common_templates/pagination.tpl"}
	<div id="bids-list">
	{* To enable sorting, location must be set correctly in sorting.tpl to match the $avail_sorting array*}
		{include file="addons/billibuys/components/sorting.tpl" hide_layouts=true location="request"}

			{foreach from=$bids item=bid}
				{if is_array($bid)}
				<div class="bb-bid-item">
					<div class="bb-list-img">
						{include file="common_templates/image.tpl" image_width="100" image_height="100" images=$bid.image show_thumbnail="Y" no_ids=true class="request-list-image"}
					</div>
					<div class="bb-list-txt">
						<div class="bb-list-field bb-list-title"><a href="{"products.view&product_id=`$bid.product_id`&request_id=`$_REQUEST.request_id`&bid_id=`$bid.bb_bid_id`"|fn_url}">{$bid.product}</a></div>
						<hr/>
						{*<div class="bb-list-rating bb-list-field ratings-star-container">{*Placeholder for rating stars*}{*
							{section name=num start=1 loop=6 step=1}
								<i class="fa ratings-star fa-star-o {if $smarty.section.num.index == $bid.rating_score}star-selected{/if} no-hover" data-num="{$smarty.section.num.index}"></i>
							{/section}
						</div>*}
						<div class="bb-list-field bb-list-qty"><span class="bb-list-txt-title">{__('quantity')}:</span> &nbsp;{$bid.quantity}</div>
							<div class="bb-list-field bb-list-price float-right">{*<span class="bb-list-txt-title">{__('price')}:</span> &nbsp;*}
						<span class="bid-price">
							{include file="common_templates/price.tpl" value=$bid.price"}
						</span>
						</div>
						<div class="error-message float-right"><div class="message"><p></p></div><div class="clearfix"></div></div>
						{assign var="return_current_url" value=$config.current_url|escape:"url"}
						{if $request.user_id == $smarty.session.auth.user_id}
							<form action="{"checkout.add..`$bid.product_id`"|fn_url}" method="POST" name="product_form_275" enctype="multipart/form-data" class="bb-bid-form">
								<input type="hidden" name="product_data[{$bid.product_id}][product_id]" value="{$bid.product_id}"/>
								<input type="hidden" name="product_data[{$bid.product_id}][amount]" value="{$bid.quantity}"/>
								<input type="hidden" name="product_data[{$bid.product_id}][bid_id]" value="{$bid.bb_bid_id}"/>
								<input type="hidden" name="product_data[{$bid.product_id}][request_id]" value="{$bid.request_id}"/>
									<a class="request-page-btn float-right view-offer-btn" href="#">{__('accept')}</a>
							</form>
						{elseif $bid.user_id == $smarty.session.auth.user_id}
							<input type="text" class="bid-price-inputbox float-right"/>
							<a class="request-page-btn delete-offer-btn float-right" href="{"index.php?dispatch=billibuys.withdraw_bid&bid_id=`$bid.bb_bid_id`&return_url=`$return_current_url`"|fn_url}
							">{__('delete')}</a>
							<a href="#!" class="request-page-btn request-page-edit float-right" data-href="{"billibuys.change_price"|fn_url}" data-id="{$bid.bb_bid_id}" data-edit-text="{__('edit')} {__('price')}" data-save-text="{__('save')} {__('price')}" data-currency="{$currencies.$primary_currency.symbol}">{__('edit')} {__('price')}</a>
						{/if}
						<div class="hyphenate bb-list-desc bb-list-field">
							{capture name="prod_descr"}
								{if $bid.short_description}
									{$bid.short_description|unescape}
								{else}
									{$bid.full_description|unescape|strip_tags|truncate:$max_desc_length}{if !$hide_links && $bid.full_description|strlen > 180} <a href="{"products.view?product_id=`$bid.product_id`"|fn_url}" class="lowercase">{__('more')}&nbsp;<i class="text-arrow">&rarr;</i></a>{/if}
								{/if}
							{/capture}

							{if !empty($bid.full_description)}
								<p class="product-description">{$smarty.capture.prod_descr}</p>
							{*/if}
							{if !empty($bid.full_description)}
								{$bid.desc_trunc*}
							{else}
								{__('no_description')}
							{/if}
						</div>
					</div>
				</div>


					{*
					<a class="bb-large-list-href" href="{"products.view&product_id=`$bid.product_id`&request_id=`$_REQUEST.request_id`&bid_id=`$bid.bb_bid_id`"|fn_url}"><span class="bb-large-list">
						<div class="bb-list-img">
						{include file="common_templates/image.tpl" image_width="100" image_height="100" images=$bid.image show_thumbnail="Y" no_ids=true class="request-list-image"}
						</div>
						<div class="bb-list-txt">
							<div class="bb-list-field bb-list-title">{$bid.product}</div>
							{*<div class="bb-list-rating bb-list-field ratings-star-container">{*Placeholder for rating stars*}{*
								{section name=num start=1 loop=6 step=1}
									<i class="fa ratings-star fa-star-o {if $smarty.section.num.index == $bid.rating_score}star-selected{/if} no-hover" data-num="{$smarty.section.num.index}"></i>
								{/section}
							</div>*}{*
							<div class="bb-list-desc bb-list-field">{$bid.full_description}</div>
							<div class="bb-list-field bb-list-price">*}{*<span class="bb-list-txt-title">{__('price')}:</span> &nbsp;*}{*include file="common_templates/price.tpl" value=$bid.price"}</div>*}
							{*<div class="bb-list-field bb-list-price"><span class="bb-list-txt-title">{__('qty')}:</span> &nbsp;{$bid.quantity}</div>*}{*
							<!-- <div class="bb-list-view">{__('view')}</div> -->
						</div>
					</span></a>
					*}
				{/if}
			{/foreach}
		
	</div>
	{include file="common_templates/pagination.tpl"}
{/if}

{*if $expired == 0}
	{if $request_user_id != $smarty.session.auth.user_id}
		{include file="buttons/button.tpl" but_text=__('place_bid') but_href="vendor.php?dispatch=billibuys.place_bid&request_id=`$request.id`"|@fn_url but_role="link"}
	{/if}
{else if $expired > 0}
	{__('auction_finished')}. <a href="{"billibuys.view"|fn_url}">{__('click_here_to_return_to_main_page')}</a>
{/if*}