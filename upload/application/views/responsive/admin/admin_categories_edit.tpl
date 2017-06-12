
		<div id="main">

			{top_bar_tpl}

			{top_menu_tpl}
			
			<div id="content" class="container">

<br />

{if '{error_message}'!=''}
<h3>{error_message}</h3>
{/if}


<form action="{site_url}admin/editing_category" method="post">

<input type="hidden" name="categoryID" value="{category_id}" />


{parent_id_text}:
<br />
<input style="width: 200px" type='text' name='parent_id' value='{parent_id}' />
<br /><br />

{category_name_text}:
<br />
<input style="width: 200px" type='text' name='category_name' value='{category_name}' />
<br /><br />

{category_url_name_text}:
<br />
<input style="width: 200px" type='text' name='category_url_name' value='{category_url_name}' />
<br /><br />

{category_description_text}:
<br />
<input style="width: 400px" type='text' name='category_description' value='{category_description}' />
<br /><br />

{category_image_name_text}:
<br />
<input style="width: 200px" type='text' name='category_image_name' value='{category_image_name}' />
<br /><br />


<p><input type='submit' value='{submit}'/></p>

</form>

			</div><!-- end content -->
		
		</div><!-- end main -->
