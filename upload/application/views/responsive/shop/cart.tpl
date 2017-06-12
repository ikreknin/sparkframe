{top_bar_tpl}
{top_menu_tpl}

<!-- BEGIN CONTENT WRAPPER -->
<div class="container">
	<div class="six columns">
{if '{shops_available}'=='y'}
		<div>
{simple_shops_list}
		</div>
{else}
		<p>{no_shops_yet}</p>
{/if}
	</div>

	<div class="ten columns">
		<h2>{shopping_cart}</h2>
{if '{visitor_user_id}'!='0'}
		<table class="u-full-width">
			<tr>
				<th>{product_text}</th>
				<th>{shop_text}</th>
				<th>{q-ty}</th>
				<th>{currency}</th>
				<th>{price_text}</th>
				<th></th>
				<th></th>
				<th></th>
			</tr>
{else}
			<p>{logged_in_to_buy}</p>
{/if}
{if '{visitor_user_id}'!='0' && '{products_available}'=='y'}
			<form action="{site_url}cart/order" method="post">
				<input type="hidden" name="sending_order" value="sending_order">
<!-- START cart -->
			<tr>
				<td><a href="{site_url}{SHOP0}/viewproduct/{product_id}">{product_name}</a></td>
				<td><a href="{site_url}{SHOP0}/viewshop/{product_shop_id}">{product_shop_name}</a></td>
				<td>{product_qty}</td>
				<td>{product_currency}</td>
				<td>{product_price}</td>
				<td><a href="{site_url}cart/add/{product_id}">[+]</a></td>
				<td><a href="{site_url}cart/remove/{product_id}">[-]</a></td>
				<td><a href="{site_url}cart/empty/{product_id}">[x]</a></td>
			</tr>
<!-- END cart -->
			<tr>
				<td></td>
				<td></td>
				<td>{total_text}:</td>
				<td>USD</td>
				<td>{cart_total}</td>
				<td></td>
				<td></td>
				<td><a href="{site_url}cart/empty_cart">[x]</a></td>
			</tr>
{/if}
{if '{visitor_user_id}'!='0'}
		</table>
{/if}

{if '{visitor_user_id}'!='0' && '{products_available}'=='y'}
		<p><input type="submit" value="{send_order}" name="submit" /></p>
	</form>
{/if}
</div>
</div>
