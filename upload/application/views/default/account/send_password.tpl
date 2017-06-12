
		<div id="main">

			{top_bar_tpl}

			{top_menu_tpl}
			
			<div id="content" class="container">

<br />

<form action="{after_login}" method="post">
<div>
<label for="email">{email_text}: </label>
<input type="text" id="email" name="email" />
<br />
<label for="captcha">{enter_code}:</label> <img src="{site_url}{CMS0}/captcha" alt="" />
<br />
<input type="text" id="captcha" name="captcha" />
<br />
<input type="submit" id="sm" name="sm" value="{send_password}" />
</div>
</form>
<p>&nbsp;</p>
<p class="reg"><a href="send_username">{send_username}</a></p>

			</div><!-- end content -->
		
		</div><!-- end main -->
