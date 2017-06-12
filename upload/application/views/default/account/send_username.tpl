
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
<input type="submit" id="sn" name="sn" value="{submit}" />
</div>
</form>

			</div><!-- end content -->
		
		</div><!-- end main -->
