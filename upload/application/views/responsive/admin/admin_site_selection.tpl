
		<div id="main">

			{top_bar_tpl}

			{top_menu_tpl}
			
			<div id="content" class="container">

<form action="{site_url}admin/switching_site" method="post">

<h2>{sites}</h2>
<br /><br />
{site_selector}
<br /><br />
<p><input type='submit' value='{submit}'/></p>

</form>
<br /><br />

			</div><!-- end content -->
		
		</div><!-- end main -->
