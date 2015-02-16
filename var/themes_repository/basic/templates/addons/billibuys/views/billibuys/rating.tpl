{*$unrated|var_dump*}

<script type="text/javascript" src="/addons/billibuys/js/rating.js"></script>
{if $unrated.products && $unrated.user_ids}
	<form name="bb_rating_form" action="{"billibuys.rating"|fn_url}" method="post" enctype="multipart/form-data">
		<h2>{__('products')|upper}</h2>
		{foreach from=$unrated.products item=u}
			<div class="rating-row">
			{*<div class="image-border float-left center cm-reload-{$u.product_id}" id="product_images_{$u.product_id}_update">
				{include file="views/products/components/product_images.tpl" product=$u show_detailed_link="Y"}
			</div>*}
			<h1 class="mainbox-title">{$u.product}</h1>
			<label>{__('add_rating')}</label>
			<div class="ratings-star-container">
				{section name=num start=1 loop=6 step=1}
					<i class="fa ratings-star fa-star-o" data-num="{$smarty.section.num.index}"></i>
				{/section}
				<input type="hidden" value="" class="star-hidden-value" name="p_rating_{$u.product_id}[stars]"/>
			</div><br/>
			<label>{__('add_comment')}</label>
			<input id="bb_rating_{$u.product_id}" type="text" name="p_rating_{$u.product_id}[comment]" size="50" maxlength="50" value="" class="input-text" />
		</div>
		{/foreach}
		<div class="buttons-container">
			{include file="buttons/button.tpl" but_text=__('submit') but_name="dispatch[billibuys.rating]" but_id="but_submit_ratings" }
		</div>
	</form>

{else}
{*TODO: Add in no ratings case*}

{/if}

<script type="text/javascript">
//<![CDATA[
{literal}
regexp['bb_max_price'] = {
	regexp: "(([1-9][0-9]{0,2}(,[0-9]{3})*)|[0-9]+)(\.[0-9]{1,2})?$"{/literal}, message: "{__('bb_error_validator_price_format')|escape:'javascript'}"
{literal}
};
{/literal}
//]]>
</script>

{capture name="mainbox_title"}{__('ratings')}{/capture}
