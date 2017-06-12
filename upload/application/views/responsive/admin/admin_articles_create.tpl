
		<div id="main">

			{top_bar_tpl}

			{top_menu_tpl}
			
			<div id="content" class="container">

<br />

{if '{error_message}'!=''}
<p class="validation">{error_message}</p>
{/if}


<form action="{site_url}admin/creating_article" method="post">


{date_text} (yyyy-mm-dd hh:mm:ss):<br />
<input style="width: 200px" type='text' id="art_created" name='art_created' value='{art_created}' />
<br /><br />

{title_text}:<br />
<input id="title" style="width: 500px" type='text' name='title' value='{title}' />
<br /><br />

{url_title_text}:<br />
<input id="permalink" style="width: 500px" type='text' name='url_title' value='{url_title}' />
<br /><br />

{body_text}:<br />
{if '{editor_type}'=='n'}
<textarea style="width: 500px" name='article' rows='16'>{article}</textarea>
{/if}
{if '{editor_type}'=='t'}
<textarea style="width: 500px" name='article' rows='16'>{article}</textarea>
{/if}
{if '{editor_type}'=='c'}
<textarea id='article' class="ckeditor" name='article' rows='16'>{article}</textarea>
{/if}
<br /><br />

{extended_text}:<br />
{if '{editor_type}'=='n'}
<textarea style="width: 500px" name='article_extended' rows='16'>{article_extended}</textarea>
{/if}
{if '{editor_type}'=='t'}
<textarea style="width: 500px" name='article_extended' rows='16'>{article_extended}</textarea>
{/if}
{if '{editor_type}'=='c'}
<textarea id='article_extended' class="ckeditor" name='article_extended' rows='16'>{article_extended}</textarea>
{/if}
<br /><br />



<!-- START custom_fields_12 -->

<tr>
<td width='100px'></td>
<td>

{if '{c_created_type}'=='1' && '{c_created_obligatory}'=='y'}* {/if}
{if '{c_created_type}'=='1'}
{c_created_name} ({c_created_description})
<p><input style="width: 500px" type="text" name='custom_field_{c_created_id}' value='{c_type_default_value}' /></p>
{/if}


{if '{c_created_type}'=='2' && '{c_created_obligatory}'=='y'}* {/if}
{if '{c_created_type}'=='2' && '{editor_type}'=='n'}
{c_created_name} ({c_created_description})
<p><textarea style="width: 500px" name='custom_field_{c_created_id}' rows='3'>{c_type_default_value}</textarea></p>
{/if}
{if '{c_created_type}'=='2' && '{editor_type}'=='t'}
{c_created_name} ({c_created_description})
<p><textarea style="width: 500px" name='custom_field_{c_created_id}' rows='3'>{c_type_default_value}</textarea></p>
{/if}
{if '{c_created_type}'=='2' && '{editor_type}'=='c'}
{c_created_name} ({c_created_description})
<p><textarea class="ckeditor" name='custom_field_{c_created_id}' rows='3'>{c_type_default_value}</textarea></p>
{/if}

</td></tr>

<!-- END custom_fields_12 -->

<br />

{stringField3}

<br /><br />

{visible_text}:<br />
<select name="article_visible">
<option value="2" selected="selected">{yes}</option>
<option value="1">{no}</option>
</select>
<br /><br />

{pinned_text}:<br />
<select name="pinned">
<option value="2">{yes}</option>
<option value="1" selected="selected">{no}</option>
</select>
<br /><br />

{categories_text}:<br />

{if '{categories_available}'=='y'}
{adminCatCheckBoxList}
{else}
<p>{no_categories_yet}</p>
{/if}

<br /><br />

{admin_articles_create_before_submit_hook}

<p><input type='submit' value='{submit}'/></p>

</form>
<br /><br />

			</div><!-- end content -->
		
		</div><!-- end main -->
