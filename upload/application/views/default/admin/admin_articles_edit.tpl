
		<div id="main">

			{top_bar_tpl}

			{top_menu_tpl}
			
			<div id="content" class="container">

<br />

{if '{error_message}'!=''}
<h3>{error_message}</h3>
{/if}


<form action="{site_url}admin/editing_article" method="post">

<input type="hidden" name="articleID" value="{article_id}" />


{date_text} (yyyy-mm-dd hh:mm:ss):
<br />
<input style="width: 200px" type='text' id="art_created" name='art_created' value='{art_created}' /> &nbsp; <a href="{site_url}{CMS0}/more/{article_id}">{go_to_article}</a>
<br /><br />

{title_text}:
<br />
<input style="width: 500px" type='text' name='title' value='{title}' />
<br /><br />

{url_title_text}:
<br />
<input style="width: 500px" type='text' name='url_title' value='{url_title}' />
<br /><br />

{body_text}:
<br />
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

{extended_text}:
<br />
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
{if '{c_created_type}'=='1' && '{c_created_encrypted}'=='y'} ({encrypted_field}) {/if}
{if '{c_created_type}'=='1'}
{c_created_name} ({c_created_description})
<p><input style="width: 500px" type="text" name='custom_field_{c_created_id}' value='{c_body}' /></p>
{/if}


{if '{c_created_type}'=='2' && '{c_created_obligatory}'=='y'}* {/if}
{if '{c_created_type}'=='2' && '{c_created_encrypted}'=='y'} ({encrypted_field}) {/if}
{if '{c_created_type}'=='2' && '{editor_type}'=='n'}
{c_created_name} ({c_created_description})
<p><textarea style="width: 500px" name='custom_field_{c_created_id}' rows='3'>{c_body}</textarea></p>
{/if}
{if '{c_created_type}'=='2' && '{editor_type}'=='t'}
{c_created_name} ({c_created_description})
<p><textarea style="width: 500px" name='custom_field_{c_created_id}' rows='3'>{c_body}</textarea></p>
{/if}
{if '{c_created_type}'=='2' && '{editor_type}'=='c'}
{c_created_name} ({c_created_description})
<p><textarea name='custom_field_{c_created_id}' rows='3'>{c_body}</textarea></p>
{/if}

</td></tr>

<!-- END custom_fields_12 -->

<br />

{stringField3}

<br /><br />



{visible_text}:<br />
<select name="article_visible">
{if '{article_visible}'=='1'}
<option value="1" selected="selected">{yes}</option>
<option value="0">{no}</option>
{else}
<option value="1">{yes}</option>
<option value="0" selected="selected">{no}</option>
{/if}
</select>
<br /><br />

{pinned_text}:<br />
<select name="pinned">
{if '{pinned}'=='1'}
<option value="1" selected="selected">{yes}</option>
<option value="0">{no}</option>
{else}
<option value="1">{yes}</option>
<option value="0" selected="selected">{no}</option>
{/if}
</select>
<br /><br />

{categories_text}:<br />

{if '{categories_available}'=='y'}
{adminCatCheckBoxList}
{else}
<p>{no_categories_yet}</p>
{/if}

<br /><br />

<p><input type='submit' value='{submit}'/></p>

</form>

			</div><!-- end content -->
		
		</div><!-- end main -->
