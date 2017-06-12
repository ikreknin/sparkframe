{top_bar_tpl}
{top_menu_tpl}

<!-- BEGIN CONTENT WRAPPER -->
<div class="container">
	<div class="six columns">

		<h2>{shop_text}</h2>
{if '{shops_available}'=='y'}
		<div id="shoplist">
{simple_shops_list}
		</div>
{else}
		<p>{no_shops_yet}</p>
{/if}
	</div>

	<div class="ten columns">

		<h2>{shop_text}: {shop_name}</h2>
<br />
		<h2>{products_text}</h2>
{pagination}

<!-- START products -->
		<h3>
			<a href="{site_url}{SHOP0}/viewproduct/{product_id}">{product_title}</a> 
{if '{admin_level}'=='1'}
			<a href="{site_url}{SHOP0}/edit_product/{product_id}">[{edit}]</a> 
{/if}
		</h3>
<!-- END products -->

{if '{admin_level}'=='1'}
		<p><a class="text" href="{site_url}{SHOP0}/newproduct/{shop_id}">{new_product}</a></p>
{/if}
	</div>
</div>
