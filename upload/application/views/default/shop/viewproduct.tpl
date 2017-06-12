
		<div id="main">

			{top_bar_tpl}

			{top_menu_tpl}
			
			<div id="content" class="container">

				<div id="col-left">
					{if '{shops_available}'=='y'}
					<div id="shoplist">
						{simple_shops_list}
					</div>
					{else}
					<p>{no_shops_yet}</p>
					{/if}
				</div>

				<div id="col-right">
<h2>{shop_text}: {shop_name}</h2>
<br />
<h2>
{product_text}: {title}
</h2>

<div class="text">
{if '{admin_level}'=='1'}
<a href="{site_url}{SHOP0}/edit_product/{product_id}">[{edit}]</a> | <a onclick="return deletechecked();" href="{site_url}admin/delete_product/{product_id}">[{delete}]</a>
{/if}
<br /><br />

{body}
<br /><br />
USD {price}
</div>
<br /><br />

{if '{visitor_user_id}'!='0'}
<form method="post" action= "https://www.{sandbox_url}paypal.com/cgi-bin/webscr">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="{business_email}">
<input type="hidden" name="item_name" value="{product_name}">
<input type="hidden" name="item_number" value="{product_number}">
<input type="hidden" name="amount" value="{amount}">
<input type="hidden" name="no_shipping" value="{no_shipping}">

<input type="hidden" name="custom" value="{visitor_user_id}">

<input type="hidden" name="return" value="{site_url}{SHOP0}/paypal_success">
<input type="hidden" name="cancel_return" value="{site_url}{SHOP0}/paypal_cancel">
<input type="hidden" name="notify_url" value="{site_url}{SHOP0}/paypal_notify">
{else}
<p>{logged_in_to_buy}</p>
{/if}

{if '{pp_available}'=='y' && '{visitor_user_id}'!='0'}
<input type="submit" value="{buy}">
{/if}

<br /><br />

{if '{cart_available}'=='y' && '{visitor_user_id}'!='0'}
<p><a href="{site_url}cart/add/{product_id}">{add_to_cart}</a></p>
{/if}


{if '{link_available}'=='1'}
<br /><br />
<p><a class="text" href="{site_url}{SHOP0}/get_link/{item_id}">{link_to_download}</a></p>
{/if}

</form>

{if '{opinions_available}'=='y'}
<br /><br />
<h3>{opinions_text}:</h3>
{/if}
<!-- START opinions -->
<br />{opinion_body}<br />
{if '{admin_level}'=='1'}
<a href="{site_url}admin/delete_opinion/{product_id}/{opinion_id}">[{delete}]</a>
{/if}
<hr>
<!-- END opinions -->
<br /><br />
{if '{visitor_user_id}'!='0'}
<p><a class="text" href="{site_url}{SHOP0}/newopinion/{shop_id}">{new_opinion}</a></p>
{/if}

				</div>

			</div><!-- end content -->

		</div><!-- end main -->
