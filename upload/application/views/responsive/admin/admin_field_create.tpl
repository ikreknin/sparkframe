
		<div id="main">

			{top_bar_tpl}

			{top_menu_tpl}
			
			<div id="content" class="container">
{if '{error_message}'!=''}
<h3>{error_message}</h3>
{/if}

<h2>{add_cf}</h2>

<form action="{site_url}admin/adding_field" method="post">


<p>{field_name}</p>
<p><input type="text" name='field_name'></p>

<p> </p>

<p>{field_url_title}</p>
<p><input type="text" name='field_url_title'></p>

<p> </p>

<p>{field_description}</p>
<p><textarea style="width: 500px" name='field_description' rows='3'></textarea></p>

<p> </p>

<p>{field_type}</p>
<p>
<select name="field_type">
<option value="1">Input</option>
<option value="2">Textarea</option>
<option value="3">List</option>
</select></p>

<p>{field_value}</p>

<p><textarea style="width: 400px" name='list_items' rows='5'></textarea></p>

<p> </p>

<p>{cms_section}</p>
<p>
<select name="site_section">
<option value="b">{blog_text}</option>
<option value="m">{forum_text}</option>
<option value="s">{shop_text}</option>
</select></p>

<p> </p>

<p>{required_field}</p>
<p><input type="checkbox" name="obligatory" value="1"  /></p>



<p><input type='submit' value='{submit}'/></p>

</form>
<br /><br />

			</div><!-- end content -->
		
		</div><!-- end main -->
