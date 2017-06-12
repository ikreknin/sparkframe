
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
					<div class="text">{no_shops_yet}</div>
					{/if}

<br /><br />
{if '{cart_available}'=='y' && '{visitor_user_id}'!='0'}
<a href="{site_url}cart">{shopping_cart}</a>
{/if}

				</div>
				<div id="col-right">
					{latest_products_plus_widget}
				</div>

			</div><!-- end content -->

		</div><!-- end main -->
