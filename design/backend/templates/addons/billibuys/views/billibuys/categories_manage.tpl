{capture name="mainbox"}

<div class="items-container multi-level">
	{if $categories}
		{include file="addons/billibuys/views/billibuys/components/categories_tree.tpl" header="1" parent_id=$bb_request_category_id categories=$categories}
	{else}
		<p class="no-items">{__('no_items')}</p>
	{/if}
</div>

{capture name="tools"}
	{include file="common_templates/tools.tpl" tool_href="billibuys.category_add" prefix="top" hide_tools="true" link_text=__('add_category')}
{/capture}

{/capture}
{include file="common_templates/mainbox.tpl" title=__('bb_manage_billibuys_categories') content=$smarty.capture.mainbox tools=$smarty.capture.tools}