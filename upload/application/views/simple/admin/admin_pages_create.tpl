{top_bar_tpl}
{top_menu_tpl}

		<main role="main">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">

{if '{error_message}'!=''}
<h3>{error_message}</h3>
{/if}

<div class="admin">
{admin_pages_list}
</div>

<br />

<hr>

<br />

<form action="{site_url}admin/creating_page" method="post">

<input type="hidden" name="parent_id" value="{parent_id}" />

{parent_page_text}: {parent_page_name}
<br /><br />

{page_title_text} *:<br />
<input style="width: 500px" type='text' name='page_title' value='{page_title}' />
<br /><br />

{page_url_name_text} *:<br />
<input style="width: 500px" type='text' name='page_url_name' value='{page_url_name}' />
<br /><br />

{page_description_text}:<br />
<input style="width: 500px" type='text' name='page_description' value='{page_description}' />
<br /><br />

{page_content_text}:
<br />
{if '{editor_type}'=='n'}
<textarea style="width: 500px" name='page_content' rows='16'>{page_content}</textarea>
{/if}
{if '{editor_type}'=='t'}
<textarea style="width: 500px" name='page_content' rows='16'>{page_content}</textarea>
{/if}
{if '{editor_type}'=='c'}
<textarea class="ckeditor" name='page_content' rows='16'>{page_content}</textarea>
{/if}
<br /><br />

{static_page_header}:<br />
<input style="width: 500px" type='text' name='st_header' value='{st_header}' />
<br /><br />

{static_page_main}:<br />
<input style="width: 500px" type='text' name='st_main' value='{st_main}' />
<br /><br />

{static_page_footer}:<br />
<input style="width: 500px" type='text' name='st_footer' value='{st_footer}' />
<br /><br />

{web_url_text}:<br />
<input style="width: 500px" type='text' name='web_url' value='{web_url}' />
<br /><br />

<p><input type='submit' value='{submit}'/></p>

</form>

					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->

		</main>
