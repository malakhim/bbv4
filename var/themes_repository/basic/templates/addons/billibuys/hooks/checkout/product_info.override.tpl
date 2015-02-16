{if $product.exclude_from_calculate}
	<strong><span class="price">{__('free')}</span></strong>
{elseif $product.discount|floatval || ($product.taxes && $settings.General.tax_calculation != "subtotal")}
	{if $product.discount|floatval}
		{assign var="price_info_title" value=__('discount')}
	{else}
		{assign var="price_info_title" value=__('taxes')}
	{/if}
	<p><a rev="discount_{$key}" class="cm-dialog-opener cm-dialog-auto-size">{$price_info_title}</a></p>

	<div class="product-options hidden" id="discount_{$key}" title="{$price_info_title}">
	<table class="table" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<th>{__('price')}</th>
		<th>{__('quantity')}</th>
		{if $product.discount|floatval}<th>{__('discount')}</th>{/if}
		{if $product.taxes && $settings.General.tax_calculation != "subtotal"}<th>{__('tax')}</th>{/if}
		<th>{__('subtotal')}</th>
	</tr>
	<tr>
		<td>{include file="common_templates/price.tpl" value=$product.original_price span_id="original_price_`$key`" class="none"}</td>
		<td class="center">{$product.amount}</td>
		{if $product.discount|floatval}<td>{include file="common_templates/price.tpl" value=$product.discount span_id="discount_subtotal_`$key`" class="none"}</td>{/if}
		{if $product.taxes && $settings.General.tax_calculation != "subtotal"}<td>{include file="common_templates/price.tpl" value=$product.tax_summary.total span_id="tax_subtotal_`$key`" class="none"}</td>{/if}
		<td>{include file="common_templates/price.tpl" span_id="product_subtotal_2_`$key`" value=$product.display_subtotal class="none"}</td>
	</tr>
	<tr class="table-footer">
		<td colspan="5">&nbsp;</td>
	</tr>
	</table>
	</div>
{/if}
{include file="views/companies/components/product_company_data.tpl" company_name=$product.company_name company_id=$product.company_id}