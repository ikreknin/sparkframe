{top_bar_tpl}
{top_menu_tpl}

		<main role="main">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">

{if '{error_message}'!=''}
<h3>{error_message}</h3>
{/if}

<form action="{site_url}admin/editing_shop" method="post">

<input type="hidden" name="shopID" value="{shop_id}" />

{shop_name_text} *:
<br />
<input style="width: 200px" type='text' name='shop_name' value='{shop_name}' />
<br /><br />

{shop_description_text}:
<br />
<input style="width: 400px" type='text' name='shop_description' value='{shop_description}' />
<br /><br />

<p><input type='submit' value='{submit}'/></p>

</form>
<br /><br />
<a href="{site_url}admin/shops_list">{shops_text}</a>

					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->

		</main>
