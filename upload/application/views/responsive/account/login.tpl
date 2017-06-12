
		<div id="main">

			{top_bar_tpl}

			{top_menu_tpl}
			
			<div id="content" class="container">

<br />

<form action="{after_login}" method="post">
<div id="border">
	<table class="reg">
		<tr>
			<td>{username_text}:</td>
			<td><input type="text" name="auth_user" /></td>
		</tr>
		<tr>
			<td>{password_text}:</td>
			<td><input type="password" name="auth_pass" /></td>
		</tr>
		<tr>
			<td> </td>
			<td><input type="checkbox" name="setcookie" value="setcookie" /> {remember_me}</td>
		</tr>
		<tr>
			<td colspan="2" align="center"><input type="submit" name="submit" value="{login}" /></td>
		</tr>
		<tr>
			<td align="center" colspan="2"><a href="{site_url}register">{register}</a> | <a href="{site_url}useraccount/send_password">{forgot_pass}</a></td>
		</tr>
	</table>
</div>
</form>

			</div><!-- end content -->
		
		</div><!-- end main -->
