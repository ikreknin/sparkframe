{top_bar_tpl}
{top_menu_tpl}

		<main role="main">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">

<br />

{if '{error_message}'!=''}
<h3>{error_message}</h3>
{/if}

<div class="admin">
{admin_categories_list}
</div>

<br />

<hr>

<br />

<form action="{site_url}admin/creating_category" method="post">

<input type="hidden" name="parent_id" value="{parent_id}" />

{parent_category_text}: {parent_category_name}
<br /><br />

{category_name_text} *:<br />
<input style="width: 500px" type='text' name='category_name' value='{category_name}' />
<br /><br />

{category_url_name_text} *:<br />
<input style="width: 500px" type='text' name='category_url_name' value='{category_url_name}' />
<br /><br />

{category_description_text}:<br />
<input style="width: 500px" type='text' name='category_description' value='{category_description}' />
<br /><br />

{category_image_name_text}:<br />
<input style="width: 500px" type='text' name='category_image_name' value='{category_image_name}' />
<br /><br />


<p><input type='submit' value='{submit}'/></p>

</form>

					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->

		</main>
