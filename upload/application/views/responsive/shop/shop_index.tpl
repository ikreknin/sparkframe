{top_bar_tpl}
{top_menu_tpl}

<!-- BEGIN CONTENT WRAPPER -->
<div class="container">
	<div class="six columns">

{if '{shops_available}'=='y'}
		<div id="shoplist">
{simple_shops_list}
		</div>
{else}
		<p>{no_shops_yet}</p>
{/if}
	</div>

	<div class="ten columns">

{if '{cart_available}'=='y' && '{visitor_user_id}'!='0'}
		<a href="{site_url}cart">{shopping_cart}</a>
{/if}

<br />

{latest_products_plus_widget}

	</div>
</div>
