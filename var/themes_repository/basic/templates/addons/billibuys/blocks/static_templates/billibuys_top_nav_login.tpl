	<div class="buttons-container float-right">

		{if $smarty.session.auth.user_id > 0}
			{if $smarty.session.cart.products}
				<a href="{"checkout.cart"|fn_url}" rel="nofollow" class="account"><span class="top_menu_item">{__('view_cart')}&nbsp;({$smarty.session.cart.products|@count})</a></span>
			{/if}
			<a href="{"profiles.update"|fn_url}" rel="nofollow" class="account"><span class="top_menu_item">{__('block_my_account')|capitalize}</a></span>
			{*<a href="{"auth.logout?redirect_url=`$config.current_url`"|fn_url}" rel="nofollow" class="account">*}<a href="{"auth.logout"|fn_url}" rel="nofollow" class="account"><span class="top_menu_item">{__('sign_out')|capitalize}</a></span>
		{else}
			<a href="{if $controller == "auth" && $mode == "login_form"}{$config.current_url|fn_url}{else}{"auth.login_form?return_url=`$return_current_url`"|fn_url}{/if}" {if $settings.General.secure_auth != "Y"} rev="login_block{$block.snapping_id}" class="cm-dialog-opener cm-dialog-auto-size account"{else}rel="nofollow" class="account"{/if}><span class="top_menu_item">{__('sign_in')|capitalize}</span></a> <a href="{"profiles.add"|fn_url}" rel="nofollow" class="account"><span class="top_menu_item">{__('register')}</span></a>
			{if $settings.General.secure_auth != "Y"}
				<div  id="login_block{$block.snapping_id}" class="hidden" title="{__('sign_in')}"> 
					<div class="login-popup">
						{include file="views/auth/login_form.tpl" style="popup" form_name="login_popup_form`$block.snapping_id`" id="popup`$block.snapping_id`"}
					</div>
				</div>
			{/if}
		{/if}
	</div>
