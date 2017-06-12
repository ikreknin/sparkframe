<html>
<head>
<title>{pagetitle}</title>
</head>
<body>

<h3>{heading}</h3>
{if '{stage}'=='1'}

<br />

<form action="" method="post">
<input type="hidden" name="processing" value="processing" />
<input type="submit" value="Update" />
</form>
{/if}

{if '{stage}'=='2'}
{message}
<br />
{/if}

</body>
</html> 