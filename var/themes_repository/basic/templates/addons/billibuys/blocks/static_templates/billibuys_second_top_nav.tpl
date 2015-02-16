<ul id="second-top-nav-elements" class="row">
	<a href="{'billibuys.view'|fn_url}"><li class="top_menu_item">{__('bb_browse')}</li></a>
	<li class="top_menu_item">{__('buy')}&nbsp;&nbsp;<i class="fa-angle-down fa"></i>
		<div class="submenu-wrapper"></div>
		<ul class="top-nav-submenu header-solid">
			<div class="top-nav-triangle"></div>
			<a href="{"index.php?dispatch=billibuys.view&my_requests=1"|fn_url}"><li class="submenu_item">{__('my_requests')}</li></a>
			<a href="{'billibuys.place_request'|fn_url}"><li class="submenu_item">{__('place_request')}</li></a>
			<a href="{"orders.search"|fn_url}"><li class="submenu_item">{__('view_orders')}</li></a>
		</ul>
	</li>
	<li class="top_menu_item">{__('sell')}&nbsp;&nbsp;<i class="fa-angle-down fa"></i>
		<div class="submenu-wrapper"></div>
		<ul class="top-nav-submenu header-solid">
			<div class="top-nav-triangle"></div>
			{*Placeholder for my_offers for now*}
			{*<a href="{"billibuys.view_offers&user_id=`$smarty.session.auth.user_id`"|fn_url}"><li class="submenu_item">{__('my_offers')}</li></a>*}
			<a href="{'/vendor.php?dispatch=products.manage'|fn_url}"><li class="submenu_item">{__('block_products')}</li></a>
			<a href="{'/vendor.php?dispatch=products.add'|fn_url}"><li class="submenu_item">{__('add_new_product')}</li></a>
			<a href="{'/vendor.php?dispatch=orders.manage'|fn_url}"><li class="submenu_item">{__('sales')}</li></a>
		</ul>
	</li>
	<form method='get' action="{"billibuys.view"|fn_url}" id="top-search-form" name="top_search_bar">
    	  <input type="text" class="form-control input-text input-search cm-hint" name="search" title="{__('enter_item_to_sell')}" id="input-search" value="{if $smarty.request.search}{$smarty.request.search}{/if}">
    	  <i class="fa fa-search" id="search-submit"></i>
	</form>
</ul>