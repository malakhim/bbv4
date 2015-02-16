{literal}
<script src="addons/billibuys/js/left_nav.js" type="text/javascript"></script>
{/literal}
<div id="cat-header">{__('categories')}</div>
{assign var="bb_cats" value=""|fn_bb_get_categories}

{foreach from=$bb_cats item="cat"}
	{if $cat.status == 'A'}
		{if $cat.parent_category_id == 0}
			<a href="{"billibuys.view?category_id=`$cat.bb_request_category_id`"|fn_url}"><span class="root-lvl-cat" cat_id="{$cat.bb_request_category_id}">
				{$cat.category_name}
				{if $cat.children_categories}<span class="left-side-nav-img" width="10px"></span>{/if}
			</span></a>
		{else}
			<div class="second-lvl-cat" cat_id="{$cat.bb_request_category_id}">{$cat.category_name}</div>
		{/if}
	{/if}
{/foreach}
