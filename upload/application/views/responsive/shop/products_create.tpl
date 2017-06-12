
{top_bar_tpl}

{top_menu_tpl}

				<!-- BEGIN CONTENT WRAPPER -->
				<div id="content-wrapper" class="content-wrapper">
					<div class="container">
						<div class="clearfix">
							<div class="grid_12">

{if '{error_message}'!=''}
<h3>{error_message}</h3>
{/if}

<form action="{site_url}{SHOP0}/creating_product/{shop_id}" method="post">

<input type="hidden" name="shopID" value="{shop_id}" />

{title_text}:<br />
<input style="width: 500px" type='text' name='product_title' value='{product_title}' />
<br /><br />

{product_text}:<br />
<textarea style="width: 500px" name='product_body' rows='10'>{product_body}</textarea>
<br /><br />

{price_text}:<br />
<input style="width: 500px" type='text' name='price' value='{price}' />
<br /><br />

{filename_text}:<br />
<input style="width: 500px" type='text' name='filename' value='{filename}' />
<br /><br />

<p><input type='submit' value='{submit}'/></p>

</form>

							</div>
						</div>
					</div>
				</div>
				<!-- END CONTENT WRAPPER -->
			</div>
		</div>
