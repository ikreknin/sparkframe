
		<div id="main">

			{top_bar_tpl}

			{top_menu_tpl}
			
			<div id="content" class="container">


{if '{error_message}'!=''}
<h3>{error_message}</h3>
{/if}

<form action="{site_url}admin/editing_topic/{forum_id}" method="post">

<input type="hidden" name="forumID" value="{forum_id}" />

{title_text}:<br />
<input style="width: 500px" type='text' name='topic_title' value='{topic_title}' />
<br /><br />

{topic_text}:<br />
<textarea style="width: 500px" name='topic_body' rows='10'>{topic_body}</textarea>
<br /><br />

<p><input type='submit' value='{submit}'/></p>

</form>

			</div><!-- end content -->
		
		</div><!-- end main -->
