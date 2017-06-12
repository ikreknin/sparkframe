	<header role="banner">
		<nav role="navigation" class="navbar navbar-static-top navbar-default">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="{site_url}">
						<img alt="Brand" width="20" height="20" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAMAAAC7IEhfAAAA81BMVEX///9VPnxWPXxWPXxWPXxWPXxWPXxWPXz///9hSYT6+vuFc6BXPn37+vz8+/z9/f2LeqWMe6aOfqiTg6uXiK5bQ4BZQX9iS4VdRYFdRYJfSINuWI5vWY9xXJF0YJR3Y5Z4ZZd5ZZd6Z5h9apq0qcW1qsW1q8a6sMqpnLyrn76tocCvpMGwpMJoUoprVYxeRoJjS4abjLGilLemmbrDutDFvdLPx9nX0eDa1OLb1uPd1+Td2OXe2eXh3Ofj3+nk4Orl4evp5u7u7PLv7fPx7/T08vb08/f19Pf29Pj39vn6+fuEcZ9YP35aQn/8/P1ZQH5fR4PINAOdAAAAB3RSTlMAIWWOw/P002ipnAAAAPhJREFUeF6NldWOhEAUBRvtRsfdfd3d3e3/v2ZPmGSWZNPDqScqqaSBSy4CGJbtSi2ubRkiwXRkBo6ZdJIApeEwoWMIS1JYwuZCW7hc6ApJkgrr+T/eW1V9uKXS5I5GXAjW2VAV9KFfSfgJpk+w4yXhwoqwl5AIGwp4RPgdK3XNHD2ETYiwe6nUa18f5jYSxle4vulw7/EtoCdzvqkPv3bn7M0eYbc7xFPXzqCrRCgH0Hsm/IjgTSb04W0i7EGjz+xw+wR6oZ1MnJ9TWrtToEx+4QfcZJ5X6tnhw+nhvqebdVhZUJX/oFcKvaTotUcvUnY188ue/n38AunzPPE8yg7bAAAAAElFTkSuQmCC">
					</a>
				</div>
				<div class="collapse navbar-collapse">
					<ul class="nav navbar-nav navbar-right">
						<li><p class="navbar-text"><a style="color:#333;text-decoration: none;" href="{site_url}switching_language/english">En</a> | <a style="color:#333;text-decoration: none;" href="{site_url}switching_language/russian">Ru</a></p></li>
						<li><p class="navbar-text">{heading}</p></li>
						<li><a href="{site_url}{CMS0}/logout" target="_blank">{logout}</a></li>
						<li><p class="navbar-text">{visitor_username}</p></li>
					</ul>
					<ul class="nav navbar-nav">
						{if '{seg_1}'==''}<li class="active">{else}<li>{/if}<a href="{site_url}">{if '{cur_lang_code}'=='en'}Home{else}Начало{/if}</a></li>
						{if '{seg_1}'=='site'}<li class="active">{else}<li>{/if}<a href="{site_url}site">{if '{cur_lang_code}'=='en'}Blog{else}Блог{/if}</a></li>
						{if '{seg_1}'=='forum'}<li class="active">{else}<li>{/if}<a href="{site_url}forum">{if '{cur_lang_code}'=='en'}Forum{else}Форум{/if}</a></li>
						{if '{seg_1}'=='shop'}<li class="active">{else}<li>{/if}<a href="{site_url}shop">{if '{cur_lang_code}'=='en'}Shop{else}Магазин{/if}</a></li>
						{if '{seg_1}'=='contact'}<li class="active">{else}<li>{/if}<a href="{site_url}contact">{if '{cur_lang_code}'=='en'}Contact{else}Контакты{/if}</a></li>
							{if '{seg_1}'=='admin'}<li class="active">{else}<li>{/if}
{if '{admin_level}'=='1'}
							<a href="{site_url}admin" class="dropdown-toggle" data-toggle="dropdown">{admin_home} <b class="caret"></b></a>
							<ul class="dropdown-menu multi-level">
								<li class="dropdown-submenu">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">{users_text}</a>
									<ul class="dropdown-menu">
										<li><a href="{site_url}admin/users">{manage_users}</a></li>
										<li><a href="{site_url}admin/roles">{manage_roles}</a></li>
										<li><a href="{site_url}admin/permissions">{manage_perms}</a></li>
									</ul>
								</li>
								<li class="dropdown-submenu">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">{blog_text}</a>
									<ul class="dropdown-menu">
										<li><a href="{site_url}admin/create_article">{create_article}</a></li>
										<li><a href="{site_url}admin/articles_list">{edit_articles}</a></li>
										<li><a href="{site_url}admin/comments_list">{comments_text}</a></li>
										<li><a href="{site_url}admin/categories_list">{categories_text}</a></li>
									</ul>
								</li>
								<li class="dropdown-submenu">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">{forums_text}</a>
									<ul class="dropdown-menu">
										<li><a href="{site_url}admin/forum_categories_list">{forum_categories_list}</a></li>
										<li><a href="{site_url}admin/forums_list">{forums_text}</a></li>
									</ul>
								</li>
								<li class="dropdown-submenu">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">{shops_text}</a>
									<ul class="dropdown-menu">
										<li><a href="{site_url}admin/shops_list">{shops_text}</a></li>
									</ul>
								</li>
								<li class="dropdown-submenu">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">{system}</a>
									<ul class="dropdown-menu">
										<li><a href="{site_url}admin/settings">{settings_text}</a></li>
										<li><a href="{site_url}admin/pages_list">{pages_text}</a></li>
										<li><a href="{site_url}admin/blocks_list">{blocks_text}</a></li>
										<li><a href="{site_url}useraccount/change_password">{change_password}</a></li>
										<li><a href="{site_url}admin/modules">{modules_text}</a></li>
										<li><a href="{site_url}admin/extensions">{extensions_text}</a></li>
										<li class="divider"></li>
										<li><a href="{site_url}admin/add_field">{add_cf}</a></li>
											<li><a href="{site_url}admin/fields_list">{list_cf}</a></li>
										<li class="divider"></li>
										<li><a href="{site_url}admin/sites_list">{sites}</a></li>
										<li><a href="{site_url}admin/add_site">{add_site}</a></li>
										<li><a href="{site_url}admin/delete_site">{delete_site}</a></li>
									</ul>
								</li>
							</ul>
{/if}
						</li>
					</ul>
				</div><!--/.nav-collapse -->
			</div><!--/.container -->
		</nav>
	</header>