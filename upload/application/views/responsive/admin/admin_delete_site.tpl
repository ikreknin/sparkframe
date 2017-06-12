
		<div id="main">

			{top_bar_tpl}

			{top_menu_tpl}
			
			<div id="content" class="container">

<form action="{site_url}admin/deleting_site" method="post">

<h2>{delete_site}</h2>
<br /><br />
{site_selector}
<br /><br />
<p><input onclick="return deletechecked();" type='submit' value='{submit}'/></p>

</form>
<br /><br />

			</div><!-- end content -->
		
		</div><!-- end main -->
