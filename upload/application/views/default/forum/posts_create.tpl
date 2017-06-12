
		<div id="main">

			{top_bar_tpl}

			{top_menu_tpl}
			
			<div id="content" class="container">

<br />

{if '{error_message}'!=''}
<h3>{error_message}</h3>
{/if}

<form action="{site_url}{FORUM0}/creating_post/{topic_id}" method="post">

<input type="hidden" name="topicID" value="{topic_id}" />

{post_text}:<br />
<br />
<textarea name="body" style="width: 500px" rows="20">{post_body}</textarea>
<br /><br />

<p><input type='submit' value='{submit}'/></p>

</form>

<br /><br />

<div class="preview"></div>

			</div><!-- end content -->
		
		</div><!-- end main -->
