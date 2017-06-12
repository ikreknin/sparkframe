{top_bar_tpl}
{top_menu_tpl}

		<main role="main">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">

<h2>{edit_forum}</h2>

{if '{error_message}'!=''}
<h3>{error_message}</h3>
{/if}


<form action="{site_url}admin/editing_forum" method="post">

<input type="hidden" name="forumID" value="{forum_id}" />

{forum_name_text} *:
<br />
<input style="width: 200px" type='text' name='forum_name' value='{forum_name}' />
<br /><br />

{forum_description_text}:
<br />
<input style="width: 400px" type='text' name='forum_description' value='{forum_description}' />
<br /><br />

<p><input type='submit' value='{submit}'/></p>

</form>

					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->

		</main>
