
{top_bar_tpl}

{top_menu_tpl}

				<!-- BEGIN CONTENT WRAPPER -->
				<div id="content-wrapper" class="content-wrapper">
					<div class="container">
						<div class="clearfix">
							<div class="grid_12">

				<div id="col-left">
					<h2>{shop_text}</h2>

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
<h2>{products_text}</h2>

{pagination}

<br /><br />

<!-- START products -->
<h3>
<a href="{site_url}{SHOP0}/viewproduct/{product_id}">{product_title}</a> 
{if '{admin_level}'=='1'}
<a href="{site_url}{SHOP0}/edit_product/{product_id}">[{edit}]</a> 
{/if}
</h3>
<br />
<!-- END products -->

<br /><br />

{if '{admin_level}'=='1'}
<p><a class="text" href="{site_url}{SHOP0}/newproduct/{shop_id}">{new_product}</a></p>
{/if}
				</div>

							</div>
						</div>
					</div>
				</div>
				<!-- END CONTENT WRAPPER -->
			</div>
		</div>
