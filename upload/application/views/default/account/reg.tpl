
		<div id="main">

			{top_bar_tpl}

			{top_menu_tpl}
			
			<div id="content" class="container">

<br />

{if '{error_message}'!=''}
<p class="validation">{error_message}</p>
{/if}

<div id="border">
<form action="{after_reg}" method="post">
<div>
<input type="hidden" name="repeated" value="{repeated}" />
</div>
	<table class="reg" cellpadding="2" cellspacing="0" border="0">
		<tr>
			<td>{username_text}: </td>
			<td><input type="text" name="username" value="{username}" /></td>
		</tr>
		<tr>
			<td>{password_text}: </td>
			<td><input type="password" name="password" /></td>
		</tr>
		<tr>
			<td>{confirm_password}: </td>
			<td><input type="password" name="confirm_password" /></td>
		</tr>
		<tr>
			<td>{email_text}: </td>
			<td><input type="text" name="email"  value="{email}" size="25"/></td>
		</tr>
		<tr>
			<td>{name_text}: </td>
			<td><input type="text" name="name" value="{name}" size="25"/></td>
		</tr>
		<tr>
			<td>{enter_code}: </td>
			<td><img src="{site_url}{CMS0}/captcha" alt="" /></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="text" id="captcha" name="captcha" /></td>
		</tr>

<tr><td></td>
<td>
<tr><td></td><td>
<p><a href="{site_url}terms_of_service" title="{terms_of_service}">{terms_of_service}</a></p>
</td></tr>
<tr><td></td><td>
<p><input type='checkbox' name='accept_terms' value='y' {checked}/>{agree_terms_of_service}</p>
</td></tr>
</td>
</tr>


		<tr>
			<td colspan="2" align="center"><input type="submit" name="submit" value="{register}" /></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><a href="{site_url}login">{login}</a> | <a href="{site_url}useraccount/send_password">{forgot_pass}</a></td>
		</tr>
	</table>

</form>
</div>

			</div><!-- end content -->
		
		</div><!-- end main -->
