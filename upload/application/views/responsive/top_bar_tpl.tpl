	<!-- Super-Container
	================================================== -->
		<div class="super-container">
		<div class="super-container1">

	<!-- BEGIN HEADER
	================================================== -->
				<header id="header" class="header">

	<!-- Top Bar
	================================================== -->
				    <div class="top-bar">

	<!-- Container
	================================================== -->
						<div class="container">
						    <div class="one column">
							&nbsp;
						    </div>
				    			<div class="nine columns">
						    	<!-- Control Panel -->
								<!-- Float Center -->
								<ul class="top-bar-control unstyled">
									{if '{visitor_user_id}'=='0'}{welcome} {guest} &nbsp; <a href="{site_url}login">{login}</a> &nbsp; <a href="{site_url}register">{registration}</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="{site_url}switching_language/english">En</a> | <a href="{site_url}switching_language/russian">Ru</a>{else}
									{welcome} {visitor_username} &nbsp; <a href="{site_url}admin">{cp}</a> &nbsp; <a href="{site_url}{CMS0}/logout">{logout}</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="{site_url}switching_language/english">En</a> | <a href="{site_url}switching_language/russian">Ru</a>{/if}
								</ul>
								<!-- /Float Center -->
							<!-- /Control Panel -->
						    </div>
						    <div class="six columns">
								<!-- Social Links -->
								<ul class="social-links unstyled">
									<li class="ico-twitter"><a href="https://twitter.com/ikreknin">Twitter</a></li>
									<li class="ico-facebook"><a href="https://www.facebook.com/ikreknin">Facebook</a></li>
									<li class="ico-googleplus"><a href="https://plus.google.com/u/0/106335034230933326851">Google+</a></li>
									<li class="ico-delicious"><a href="https://delicious.com/ikreknin">Delicious</a></li>
									<li class="ico-vimeo"><a href="https://vimeo.com/ikreknin">Vimeo</a></li>
									<li class="ico-rss"><a href="{site_url}rss">RSS</a></li>
								</ul>
								<!-- /Social Links -->
			    			</div><!-- end sixteen columns  -->
						</div><!-- end container -->
					</div><!-- end top-bar -->

					<div class="top-menu">
						<div class="container clearfix">
	<!-- Top Menu
	================================================== -->
						    <div class="sixteen columns hr-bottom">

								<!-- Begin Logo -->
								<div id="logo">
									<!-- Image Based Logo-->
									<a href="{site_url}"><img src="{VIEWDIR}images/logo.png" alt="Sparkframe" width="145" height="67" /></a>

									<!-- Text Based Logo
									<h1><a href="{site_url}">Sparkframe</a></h1>
									<p class="tagline">Responsive</p>
									-->
								</div>
								<!-- End Logo -->
