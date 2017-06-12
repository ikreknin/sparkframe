
		<div id="main">

			{top_bar_tpl}

			{top_menu_tpl}
			
			<div id="content" class="container">

{if '{error_message}'!=''}
<h3>{error_message}</h3>
{/if}


<form action="{site_url}admin/editing_field/{c_field_id}" method="post">

<input type="hidden" name="fieldID" value="{c_field_id}" />

<p>{field_name}</p>
<p><input type="text" name='field_name' value='{c_field_name}'></p>

<p> </p>

<p>{field_url_title}</p>
<p><input type="text" name='field_url_title' value='{c_field_url_title}'></p>

<p> </p>

<p>{field_description}</p>
<p><textarea style="width: 500px" name='field_description' rows='3'>{c_field_description}</textarea></p>

<p> </p>

<p>{field_type}</p>
<p>
<select name="field_type">
<option {if '{c_field_type}'=='1'}selected {/if}value="1">Input</option>
<option {if '{c_field_type}'=='2'}selected {/if}value="2">Textarea</option>
<option {if '{c_field_type}'=='3'}selected {/if}value="3">List</option>
</select></p>

<p>{field_value}</p>

<p><textarea style="width: 400px" name='list_items' rows='5'>{c_list_items}</textarea></p>

<p> </p>

<p>{cms_section}</p>
<p>
<select name="site_section">

<option {if '{c_site_section}'=='b'}selected {/if}value="b">{blog_text}</option>
<option {if '{c_site_section}'=='m'}selected {/if}value="m">{forum_text}</option>
<option {if '{c_site_section}'=='s'}selected {/if}value="s">{shop_text}</option>
</select></p>

<p> </p>

<p>{required_field}</p>
<p><input type="checkbox" name="obligatory" {if '{c_obligatory}'=='y'}checked="checked" {/if}value="y" /></p>



<p><input type='submit' value='{submit}' /></p>

</form>
<br /><br />

			</div><!-- end content -->
		
		</div><!-- end main -->
