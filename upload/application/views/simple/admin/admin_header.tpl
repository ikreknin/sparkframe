<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="{charset}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{cms_title} :: {pagetitle}</title>
        <meta name="description" content="{metadescription}">
	<meta name="keywords" content="{metakeywords}">
	<meta name="author" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" href="favicon.ico">
	<link rel="apple-touch-icon" href="apple-touch-icon.png">

        <link rel="stylesheet" href="{site_url}application/views/simple/css/bootstrap.min.css">
        <link href="{site_url}application/views/simple/css/navbar.css" rel="stylesheet">
	<link rel="stylesheet" href="{VIEWDIR}css/font-awesome.min.css" media="screen" />
	<link href="{site_url}application/views/simple/css/style.css" rel="stylesheet">

        <script src="{site_url}application/views/simple/js/vendor/modernizr-2.6.2.min.js"></script>

{jquery}
{editor}
{tinybrowser}
{bbcodeeditor}
<script type="text/javascript">
	function deletechecked()
	{
		var answer = confirm("Are you sure you want to delete this information?")
  		if (answer){
			document.messages.submit();
		}
    		return false;
	}
</script>
{before_closing_head_tag_hook}
{admin_before_closing_head_tag_hook}

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
    </head>
    <body>
