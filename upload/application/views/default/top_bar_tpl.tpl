<div id="top_bar">
				<div class="container">
				{if '{visitor_user_id}'=='0'}<p id="login">{welcome} {guest} &nbsp; <a href="{site_url}login">{login}</a> &nbsp; <a href="{site_url}register">{registration}</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="{site_url}switching_language/english">En</a> | <a href="{site_url}switching_language/russian">Ru</a></p>{else}
				<p id="login">{welcome} {visitor_username} &nbsp; <a href="{site_url}admin">{cp}</a> &nbsp; <a href="{site_url}{CMS0}/logout">{logout}</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="{site_url}switching_language/english">En</a> | <a href="{site_url}switching_language/russian">Ru</a></p>{/if}

				<p id="subscribe"><a href="{site_url}{CMS0}/rss">RSS</a></p>
				</div><!-- end bar container -->
			</div><!-- end top bar -->