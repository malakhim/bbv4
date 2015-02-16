{literal}
<link rel="stylesheet" type="text/css" href="addons/billibuys/js/jquery.countdown/jquery.countdown.css">
<script src="addons/billibuys/js/jquery.countdown/jquery.plugin.min.js" type="text/javascript"></script>
<script src="addons/billibuys/js/jquery.countdown/jquery.countdown.min.js" type="text/javascript"></script>
<script src="addons/billibuys/js/view_requests.js" type="text/javascript"></script>
{/literal}

{*if $category_title}
	{capture name="title"}<span>{$category_title}</span>{/capture}
{else}
	{capture name="title"}<span>{__('view_requests')}</span>{/capture}
{/if*}

{if $requests.success eq 1}
	{include file="addons/billibuys/components/sorting.tpl" hide_layouts=true location="requests"}

	{include file="common_templates/pagination.tpl"}

	{foreach from=$requests item=request}
		{if is_array($request)}
			<a class="bb-large-list-href" href="{"billibuys.request&request_id=`$request.bb_request_id`"|fn_url}"><span class="bb-large-list">
				<div class="bb-list-img">
				{include file="common_templates/image.tpl" image_width="100" image_height="100" images=$request.image show_thumbnail="Y" no_ids=true class="request-list-image"}
				</div>
				<div class="bb-list-txt">
					<div class="bb-list-field bb-list-title">{$request.title}</div>
					{*<div class="bb-list-rating bb-list-field">{*Placeholder for rating stars*}{*</div>*}
					<div class="bb-list-field bb-list-time-remaining" expiry="{$request.expiry_date}"></div>
					<div class="bb-list-field bb-list-current-bid">
						<div class="bb-list-txt-title">
							{__('lowest_bid')}<br/>
							{if $request.lowest_bid ne ''}${$request.lowest_bid}{else} --- {/if}
						</div>
					</div>
					<div class="bb-list-desc bb-list-field">{$request.description}</div>
					<div class="bb-list-field bb-list-price"><span class="bb-list-txt-title">{__('bb_max_price')}:</span> &nbsp;{if $request.max_price}{include file="common_templates/price.tpl" value=$request.max_price"}{else}{__('no_max_price')}{/if}</div>
					{if $request.quantity}<div class="bb-list-field bb-list-qty">{__('desired_quantity')}:&nbsp;{$request.quantity}</div>{/if}

				</div>
			</span></a>
		{/if}
	{/foreach}

	{include file="common_templates/pagination.tpl"}
{else}
	<p class="no-items">{$error_msg}</p>
{/if}