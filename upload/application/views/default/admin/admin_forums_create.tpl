
		<div id="main">

			{top_bar_tpl}

			{top_menu_tpl}
			
			<div id="content" class="container">


{if '{error_message}'!=''}
<h3>{error_message}</h3>
{/if}


<form action="{site_url}admin/creating_forum" method="post">

{forum_name_text} *:<br />
<input style="width: 500px" type='text' name='forum_name' value='{forum_name}' />
<br /><br />

{forum_description_text}:<br />
<input style="width: 500px" type='text' name='forum_description' value='{forum_description}' />
<br /><br />

<p><input type='submit' value='{submit}'/></p>

</form>

			</div><!-- end content -->
		
		</div><!-- end main -->
