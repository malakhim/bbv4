{*DEPRECATED: Changed to a block now*}
{*<div id="bb_submit_form">
	<br/><br/>
	<form id="create" name="create" method="POST" action="/dutchme2/index.php?dispatch=billibuys.view">
		<label for="item_name">{__('bb_enter_item')}:</label>
		<input type="text" id="item_name" name="item_name"/>
		<input type="submit" value="submit" name="submit"/>
	</form>
</div>
*}
{if $auth.user_id}
	<a href="{"billibuys.place_request"|fn_url}">{__('bb_text_place_request_question')}</a>
{else}
	<a href="{"auth.login_form&return_url=billibuys.place_request"|fn_url}">{__('bb_text_log_in_to_place_request')}</a>
{/if}
<div id="bb_requests">
	{if $requests.success eq 1}
		<table cellpadding="0" cellspacing="0" width="100%" border="0" class="table">
			<tr>
				<th>{__('item')}</th>
				<th>{__('durat_since_start')}</th>
				{*<th>{__('current_bid')}</th>*}
			</tr>
		{foreach from=$requests item=request}
			{if is_array($request)}
				<tr {cycle values="class=\"table-row\","}>
					<td>{include file="buttons/button.tpl" but_text=$request.title but_href="billibuys.request&request_id=`$request.bb_request_id`"|fn_url but_role="text"}</td>
					<td>
						{if $request.timestamp.error == 0}
							{if $request.timestamp.msg != 'over_two_weeks'}
								{$request.timestamp.value}&nbsp;{$request.timestamp.unit}
							{else}
								{__('two_weeks_plus')}
							{/if}
						{else}
							{if $request.timestamp.msg == 'invalid_date'}
								{__('invalid_date_format')}
							{elseif $request.timestamp.msg == 'nonpositive_value'}
								{__('date_nonpositive')}
							{/if}
						{/if}
					</td>
					{*<td>{if $request.current_bid ne ''}${$request.current_bid}{else}{__('bb_no_bids')}!{/if}</td>*}
				</tr>
			{/if}
		{/foreach}
		</table>
	{else}
	<!-- Need to add in search results-->
		{if $requests.message eq 'no_results'}
			<p class="no-items">{$error_msg}</p>
		{elseif $requests.message eq 'user_not_logged_in'}
			{__('please_login')}
		{else}
			{__('bb_error_occurred')}: <a href="mailto:{$settings.Company.company_support_department}">{$settings.Company.company_support_department}</a>
		{/if}
	{/if}
</div>

{capture name="mainbox_title"}{__('view_requests')}{/capture}