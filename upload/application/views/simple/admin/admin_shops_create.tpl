{top_bar_tpl}
{top_menu_tpl}

		<main role="main">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">

{if '{error_message}'!=''}
<h3>{error_message}</h3>
{/if}

<h2>{heading}</h2>

<br />

<form action="{site_url}admin/creating_shop" method="post">

<input type="hidden" name="parent_id" value="{parent_id}" />

{shop_name_text} *:<br />
<input style="width: 500px" type='text' name='shop_name' value='{shop_name}' />
<br /><br />

{shop_description_text}:<br />
<input style="width: 500px" type='text' name='shop_description' value='{shop_description}' />
<br /><br />

<p><input type='submit' value='{submit}'/></p>

</form>

					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->

		</main>
