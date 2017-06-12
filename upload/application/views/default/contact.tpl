
		<div id="main">

			{top_bar_tpl}

			{top_menu_tpl}
			
			<div id="content" class="container">

{if '{error_message}'!=''}
<p class="validation">{error_message}</p>
{/if}

<br /><br />

<form action="{site_url}send_email" method="post">
<table id="border">
    <tr>
        <td width='10%'><label for="full_name">{name}:</label></td>
        <td><input type="text" name="full_name" size="40" value='{full_name}'/></td>

    </tr>
    <tr>
        <td><label for="email">E-mail:</label></td>
        <td><input type="text" name="email" size="40" value='{email}'/></td>
    </tr>

    <tr>
        <td><label for="message">{message}:</label></td>

        <td><textarea rows="9" name="body" cols="60">{body}</textarea></td>
    </tr>
    
    <tr>
        <td><label for="captchaImage">{enter_code}:</label></td>
        <td><img src="{site_url}{CMS0}/captcha" alt="" /></td>
    </tr>

    <tr>
        <td><label for="confirmCaptcha"></label></td>
        <td><input type="text" id="captcha" name="captcha" /></td>
    </tr>
    
    <tr>
    	<td> </td>
        <td><input type="submit" value="{submit}" name="submit" /></td>
    </tr>
</table>

</form>

			</div><!-- end content -->
		
		</div><!-- end main -->
