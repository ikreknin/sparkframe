
		<div id="main">

			{top_bar_tpl}

			{top_menu_tpl}
			
			<div id="content" class="container">

<br />

{if '{error_message}'!=''}
<h3>{error_message}</h3>
{/if}


<form action="{site_url}admin/editing_comment" method="post">

<input type="hidden" name="commentID" value="{comment_id}" />
<input type="hidden" name="more" value="{more}" />

{comment_text}:
<br /><br />
<textarea id="comment" style="width: 500px" name='comment' rows='10'>{body}</textarea>
<br /><br />


<p><input type='submit' value='{submit}'/></p>

</form>

<p><a href="{site_url}{CMS0}/more/{more}">{go_to_article}</a></p>

			</div><!-- end content -->
		
		</div><!-- end main -->
