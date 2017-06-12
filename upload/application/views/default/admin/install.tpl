<html>
<head>
<title>{pagetitle}</title>
</head>
<body>

<h3>{heading}</h3>
{if '{stage}'=='1'}
<p>{db_host_text}: <b>{db_host}</b></p>
<p>{db_user_text}: <b>{db_user}</b></p>
<p>{db_pass_text}: <b>{db_pass}</b></p>
<p>{db_name_text}: <b>{db_name}</b></p>
<p>{prefix_text}: <b>{prefix}</b></p>
<p>{sys_cms_text}: <b>{sys_cms}</b></p>

<br />

<form action="" method="post">
{name_text}: <input type="text" name="name" /><br />
{pass_text}: <input type="text" name="pass" /><br />
<br />
{fullname_text}: <input type="text" name="fullname" /><br />
{email_text}: <input type="text" name="email" /><br />
{ppemail_text}: <input type="text" name="ppemail" /><br />
<input type="hidden" name="processing" value="processing" />
<input type="submit" value="Submit" />
</form>
{/if}

{if '{stage}'=='2'}
{message}
<h3 style="color:red">!!! {delete_install} !!!</h3>
<p>{name_text}: <b>{name}</b></p>
<p>{pass_text}: <b>{pass}</b></p>
<br />
{/if}

</body>
</html> 