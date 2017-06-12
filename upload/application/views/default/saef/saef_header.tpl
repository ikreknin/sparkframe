<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{lang_code}" lang="{lang_code}">
	<head>

		<meta http-equiv="Content-Type" content="text/html; charset={charset}" />
		<meta name="description" content="{metadescription}" />
		<meta name="keywords" content="{metakeywords}" />
		<title>{pagetitle}</title>
		<link rel="stylesheet" type="text/css" href="{VIEWDIR}css/reset.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="{VIEWDIR}css/style.css" />
		<!--[if !IE 7]>
			<style type="text/css">
				#main {display:table;height:100%}
			</style>
		<![endif]-->
		{jquery}
		{editor}
		{tinybrowser}
		{bbcodeeditor}
<script type="text/javascript">
function deletechecked()
{
    var answer = confirm("{delete_question}")
    if (answer){
        document.messages.submit();
    }
    
    return false;  
}
</script>

<link rel="stylesheet" type="text/css" href="{VIEWDIR}css/jqueryslidemenu.css" />
<!--[if lte IE 7]>
	<style type="text/css">
		html .jqueryslidemenu{height: 1%;} /*Holly Hack for IE7 and below*/
	</style>
<![endif]-->
<script type="text/javascript" src="{site_url}js/jqueryslidemenu/jqueryslidemenu.js"></script>

{before_closing_head_tag_hook}
{admin_before_closing_head_tag_hook}
	</head>
	<body>