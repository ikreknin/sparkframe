
		<div id="main">

			{top_bar_tpl}

			{top_menu_tpl}
			
			<div id="content" class="container">


{if '{error_message}'!=''}
<h3>{error_message}</h3>
{/if}


<form action="{site_url}admin/editing_forum_category" method="post">

<input type="hidden" name="forumCategoryID" value="{forum_category_id}" />

{forum_category_text} *:
<br />
<input style="width: 200px" type='text' name='forum_category' value='{forum_category}' />
<br /><br />

{forum_category_description_text}:
<br />
<input style="width: 400px" type='text' name='forum_category_description' value='{forum_category_description}' />
<br /><br />

<p><input type='submit' value='{submit}'/></p>

</form>

			</div><!-- end content -->
		
		</div><!-- end main -->
