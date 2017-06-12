
		<div id="main">

			{top_bar_tpl}

			{top_menu_tpl}
			
			<div id="content" class="container">




{if '{error_message}'!=''}
<h3>{error_message}</h3>
{/if}

<form action="{site_url}admin/editing_post/{post_id}" method="post">

<input type="hidden" name="topicID" value="{topic_id}" />

{post_text}:<br />
<textarea style="width: 500px" name='post_body' rows='10'>{post_body}</textarea>
<br /><br />

<p><input type='submit' value='{submit}'/></p>

</form>

			</div><!-- end content -->
		
		</div><!-- end main -->
