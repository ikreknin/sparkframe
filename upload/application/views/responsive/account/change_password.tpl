
		<div id="main">

			{top_bar_tpl}

			{top_menu_tpl}
			
			<div id="content" class="container">

<br />

<h2>{change_password}</h2>

<div class="admin">
<form action="{after_login}" method="post">
<label for="">{current_password}</label>
<input type="password" id="current_password" name="current_password" /><br />
<label for="">{new_password}</label>
<input type="password" id="new_password" name="new_password" /><br />
<label for="">{confirm_password}</label>
<input type="password" id="confirm_new_password" name="confirm_new_password" /><br />
<input type="submit" id="cp" name="cp" value="{submit}" />
</form>
</div>
			</div><!-- end content -->
		
		</div><!-- end main -->
