<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->

	<head>
	<!-- Basic Page Needs
	================================================== -->
		<meta charset="{charset}">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>{cms_title} :: {pagetitle}</title>
		<meta name="description" content="{metadescription}">
		<meta name="keywords" content="{metakeywords}" />
		<meta name="author" content="sparkframe.id.lv">

	<!-- Mobile Specific Metas
	================================================== -->
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- CSS
	================================================== -->
		<!-- Normalize -->
		<link rel="stylesheet" href="{VIEWDIR}css/normalize.css">
		<!-- Skeleton -->
		<link rel="stylesheet" href="{VIEWDIR}css/skeleton.css" media="screen" />
		<!-- Base Template Styles -->
		<link rel="stylesheet" href="{VIEWDIR}css/base.css" media="screen" />
		<!-- Custom Template Styles -->
		<link rel="stylesheet" href="{VIEWDIR}css/style.css" media="screen" />
		<!-- FontAwesome -->
		<link rel="stylesheet" href="{VIEWDIR}css/font-awesome.min.css" media="screen" />
		<!-- Superfish -->
		<link rel="stylesheet" href="{VIEWDIR}css/superfish.css" media="screen" />
		<!-- prettyPhoto -->
		<link rel="stylesheet" href="{VIEWDIR}css/prettyPhoto.css" media="screen" />
		<!-- FlexSlider -->
		<link rel="stylesheet" href="{VIEWDIR}css/flexslider.css" media="screen" />
		<!-- Media Queries -->
		<link rel="stylesheet" href="{VIEWDIR}css/media-queries.css" media="screen" />
		<!-- SCEditor -->
		<link rel="stylesheet" href="{site_url}js/sceditor/minified/themes/default.min.css" type="text/css" media="all" />

		<link rel="stylesheet" type="text/css" href="{VIEWDIR}css/calendar.css" />

	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- Favicons
	================================================== -->
		<link rel="shortcut icon" href="{VIEWDIR}images/favicon.ico">
		<link rel="apple-touch-icon" href="{VIEWDIR}images/apple-touch-icon.png">
		<link rel="apple-touch-icon" sizes="72x72" href="{VIEWDIR}images/apple-touch-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="114x114" href="{VIEWDIR}images/apple-touch-icon-114x114.png">

	<!-- Javascript Files
	================================================== -->
		<!-- initialize jQuery Library -->
		{jquery}
		<script src="{VIEWDIR}js/jquery-migrate-1.2.1.min.js"></script>
		<!-- Modernizr -->
		<script src="{VIEWDIR}js/modernizr-2.6.2.min.js"></script>
		<!-- Easing -->
		<script src="{VIEWDIR}js/jquery.easing.1.3.js"></script>
		<!-- Flickr -->
		<script src="{VIEWDIR}js/jflickrfeed.min.js"></script>
		<!-- Mobile Menu -->
		<script src="{VIEWDIR}js/jquery.mobilemenu.js"></script>
		<!-- Isotope -->
		<script src="{VIEWDIR}js/jquery.isotope.min.js"></script>
		<!-- imagesLoaded -->
		<script src="{VIEWDIR}js/imagesloaded.pkgd.min.js"></script>
		<!-- Superfish -->
		<script src="{VIEWDIR}js/superfish.min.js"></script>
		<!-- Prettyphoto -->
		<script src="{VIEWDIR}js/jquery.prettyPhoto.js"></script>
		<!-- ElastiSlide -->
		<script src="{VIEWDIR}js/jquery.elastislide.js"></script>
		<!-- FlexSlider -->
		<script src="{VIEWDIR}js/jquery.flexslider-min.js"></script>
		<!-- SCEditor -->
		<script type="text/javascript" src="{site_url}js/sceditor/minified/jquery.sceditor.bbcode.min.js"></script>

		<script>
			$(function() {
				$("textarea").sceditor({
					plugins: "bbcode",
					width: "500",
					emoticonsRoot: "{site_url}js/sceditor/",
{if '{seg_1}' == 'contact' || '{seg_1}' == 'send_email'}
					toolbar: "maximize",
					style: "minified/jquery.sceditor.default.min.css"
{else}
					toolbar: "bold,italic,underline,strike|quote,link,unlink,image,youtube,emoticon|maximize,source",
{/if}

				});
			});
		</script>

		<script type="text/javascript" src="{site_url}js/swfobject/swfobject.js"></script>

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

		<!-- Custom -->
		<script src="{VIEWDIR}js/custom.js"></script>

{before_closing_head_tag_hook}
	</head>

	<body>
		<!--[if lt IE 7]>
			<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
		<![endif]-->
