<div class="container_16">
{capture name="mainbox"}

<script src="addons/billibuys/js/place_bid.js" type="text/javascript"></script>

{__('place_bid_instr')}
{**
{include file="views/products/components/products_search_form.tpl" dispatch="products.manage"}
**}

<div id="content_manage_products">
<form action="{""|fn_url}" method="post" name="manage_products_form">
<input type="hidden" name="request_id" value="{$smarty.request.request_id}" id="request_id"/>

{include file="common_templates/pagination.tpl" save_current_page=true save_current_url=true div_id=$smarty.request.content_id}

{assign var="c_url" value=$config.current_url|fn_query_remove:"sort_by":"sort_order"}

{assign var="rev" value=$smarty.request.content_id|default:"pagination_contents"}

<table cellpadding="0" cellspacing="0" border="0" width="100%" class="table sortable hidden-inputs">
<tr>
	<th class="center"></th>
	{if $search.cid && $search.subcats != "Y"}
	<th><a class="cm-ajax{if $search.sort_by == "position"} sort-link-{$search.sort_order}{/if}" href="{"`$c_url`&amp;sort_by=position&amp;sort_order=`$search.sort_order`"|fn_url}" rev={$rev}>{__('position_short')}</a></th>
	{/if}
	<th width="5%"><span>{__('image')}</span></th>
	<th width="60%"><a class="{$ajax_class}{if $search.sort_by == "product"} sort-link-{$search.sort_order}{/if}" href="{"`$c_url`&amp;sort_by=product&amp;sort_order=`$search.sort_order`"|fn_url}" rev={$rev}>{__('name')}</a>{** / <a class="{$ajax_class}{if $search.sort_by == "code"} sort-link-{$search.sort_order}{/if}" href="{"`$c_url`&amp;sort_by=code&amp;sort_order=`$search.sort_order`"|fn_url}" rev={$rev}>{__('product_code')}</a>**}</th>
	<th width="15%"><a class="cm-ajax{if $search.sort_by == "price"} sort-link-{$search.sort_order}{/if}" href="{"`$c_url`&amp;sort_by=price&amp;sort_order=`$search.sort_order`"|fn_url}" rev={$rev}>{__('price')} ({$currencies.$primary_currency.symbol})</a></th>
	{**<th width="5%"><a class="cm-ajax{if $search.sort_by == "list_price"} sort-link-{$search.sort_order}{/if}" href="{"`$c_url`&amp;sort_by=list_price&amp;sort_order=`$search.sort_order`"|fn_url}" rev={$rev}>{__('list_price')} ({$currencies.$primary_currency.symbol})</a></th>**}
	{*if $search.order_ids}
	<th width="5%"><a class="cm-ajax{if $search.sort_by == "p_qty"} sort-link-{$search.sort_order}{/if}" href="{"`$c_url`&amp;sort_by=p_qty&amp;sort_order=`$search.sort_order`"|fn_url}" rev={$rev}>{__('purchased_qty')}</a></th>
	<th width="5%"><a class="cm-ajax{if $search.sort_by == "p_subtotal"} sort-link-{$search.sort_order}{/if}" href="{"`$c_url`&amp;sort_by=p_subtotal&amp;sort_order=`$search.sort_order`"|fn_url}" rev={$rev}>{__('subtotal_sum')} ({$currencies.$primary_currency.symbol})</a></th>
	{/if*}
	<th width="5%"><a class="cm-ajax{if $search.sort_by == "amount"} sort-link-{$search.sort_order}{/if}" href="{"`$c_url`&amp;sort_by=amount&amp;sort_order=`$search.sort_order`"|fn_url}" rev={$rev}>{__('quantity')}</a></th>
</tr>
{foreach from=$products item=product}

<tr class="{cycle values="table-row,"} {$hide_inputs_if_shared_product}">
	<td class="center">
   		<input type="radio" name="product_ids[]" value="{$product.product_id}" class="checkbox cm-item" {if $saved_selected_product_id == $product.product_id}checked{/if}/>
   	</td>
	{if $search.cid && $search.subcats != "Y"}
	<td>
		<input type="text" name="products_data[{$product.product_id}][position]" size="3" value="{$product.position}" class="input-text-short" /></td>
	{/if}
	<td class="product-image-table">
	{include file="common_templates/image.tpl" image=$product.main_pair.icon|default:$product.main_pair.detailed image_id=$product.main_pair.image_id image_width=50 object_type=$object_type href="products.update?product_id=`$product.product_id`"|fn_url}
		</td>
	<td>
		<div class="float-left">
				<input type="hidden" name="products_data[{$product.product_id}][product]" value="{$product.product}" {if $no_hide_input_if_shared_product} class="{$no_hide_input_if_shared_product}"{/if} />
				<a href="{"products.update?product_id=`$product.product_id`"|fn_url}" class="strong{if $product.status == "N"} manage-root-item-disabled{/if}">{$product.product|unescape} 
					{**{include file="views/companies/components/company_name.tpl" company_name=$product.company_name company_id=$product.company_id}</a><div><span class="product-code-label">{__('product_code')}: </span><input type="text" name="products_data[{$product.product_id}][product_code]" size="15" maxlength="32" value="{$product.product_code}" class="input-text product-code" /></div>**}</div>
		<div class="float-right">
		</div>
	</td>
	<td{if $no_hide_input_if_shared_product} class="{$no_hide_input_if_shared_product}"{/if}>
		<div class="product-price">
			<input type="number" min="0" step="any" name="products_data[{$product.product_id}][price]" size="6" value="{if $saved_selected_product_id == $product.product_id}{$saved_selected_product.price}{else}{$product.price|fn_format_price:$primary_currency:null:false}{/if}" class="input-text" />
			{include file="buttons/update_for_all.tpl" display=$show_update_for_all object_id='price' name="update_all_vendors[price]"}
		</div>
	</td>
	{**<td>
		<input type="text" name="products_data[{$product.product_id}][list_price]" size="6" value="{$product.list_price}" class="input-text" /></td>**}
	{if $search.order_ids}
	<td>{$product.purchased_qty}</td>
	<td>{$product.purchased_subtotal}</td>
	{/if}
	<td>
		{**{if $product.tracking == "O"}
		{include file="buttons/button.tpl" but_text=__('edit') but_href="product_options.inventory?product_id=`$product.product_id`" but_role="edit"}
		{else}**}
		{if $product.amount < 1}
			{include file="buttons/button.tpl" but_text=__('zero_quantity') but_href="products.update?product_id=`$product.product_id`#product_amount" but_role="edit"}
			<input type="hidden" name="products_data[{$product.product_id}][amount]" value="0">
		{else}
			<select name="products_data[{$product.product_id}][amount]" class="amount">
				{section name=amount max=$product.amount loop=$product.amount+1 step=-1}
					<option value="{$smarty.section.amount.index}" {if $saved_selected_product_id == $product.product_id && $saved_selected_product.amount == $smarty.section.amount.index}selected="selected"{/if}>{$smarty.section.amount.index}</option>
				{/section}
			</select>
		{/if}
		{**{/if}**}
	</td>

</tr>
{foreachelse}
<tr class="no-items">
	<td colspan="{if $search.cid && $search.subcats != "Y"}12{else}11{/if}"><p>{__('no_data')}</p></td>
</tr>
{/foreach}
</table>

{include file="common_templates/pagination.tpl" div_id=$smarty.request.content_id}

{if $products}
	<div class="buttons-container buttons-bg">
		<div class="float-left">
			{include file="buttons/save_cancel.tpl" but_text=__('btn_place_bid_txt') but_name="dispatch[billibuys.m_place_bid]" hide_second_button=true cancel_action="close"}
		</div>
	</div>
{/if}

<div class="buttons-container">

</div>

{include file="common_templates/popupbox.tpl" id="select_fields_to_edit" text=__('select_fields_to_edit') content=$smarty.capture.select_fields_to_edit}

{capture name="tools"}
	{include file="common_templates/tools.tpl" tool_href=$create_product_href prefix="top" link_text=__('create_product_package') hide_tools=true}
{/capture}

</form>
<!--content_manage_products--></div>



{/capture}
{include file="common_templates/mainbox.tpl" title=__('products') content=$smarty.capture.mainbox title_extra=$smarty.capture.title_extra tools=$smarty.capture.tools select_languages=true}
</div>