{top_bar_tpl}
{top_menu_tpl}

		<main role="main">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">

<h2>{edit_block}</h2>

{if '{error_message}'!=''}
<h3>{error_message}</h3>
{/if}


<form action="{site_url}admin/editing_block" method="post">

<input type="hidden" name="blockID" value="{block_id}" />
<input type="hidden" name="parent_id" value="0" />

{block_title_text}:
<br />
<input style="width: 200px" type='text' name='block_title' value='{block_title}' />
<br /><br />

{block_order_text}:
<br />
<input style="width: 200px" type='text' name='block_order' value='{block_order}' />
<br /><br />

{block_description_text}:
<br />
<input style="width: 400px" type='text' name='block_description' value='{block_description}' />
<br /><br />

{block_content_text}:{editor_type}
<br />
{if '{editor_type}'=='n'}
<textarea style="width: 500px" name='block_content' rows='16'>{block_content}</textarea>
{/if}
{if '{editor_type}'=='t'}
<textarea style="width: 500px" name='block_content' rows='16'>{block_content}</textarea>
{/if}
{if '{editor_type}'=='c'}
<textarea class="ckeditor" name='block_content' rows='16'>{block_content}</textarea>
{/if}
<br /><br />

<p><input type='submit' value='{submit}'/></p>

</form>

					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->

		</main>
