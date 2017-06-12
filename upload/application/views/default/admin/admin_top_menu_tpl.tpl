<div id="header">

				<div id="branding" class="container">
					<h1>{cms_title}</h1>
					<p class="desc">{heading}</p>
				</div><!-- end branding -->
<div class="jqsmenu">
<div class="container">
<div id="myslidemenu" class="jqueryslidemenu">
	<ul>
		<li class="current_page"><a href="{site_url}">{home}</a></li>
		<li><a href="{site_url}{CMS0}">{blog_text}</a></li>
		<li><a href="{site_url}{SHOP0}">{shop_text}</a></li>
		<li><a href="{site_url}{FORUM0}">{forum_text}</a></li>
		<li><a href="{site_url}contact">{contact}</a></li>
{if '{admin_level}'=='1'}
		<li><a href="{site_url}admin">{admin_home}</a>
  			<ul>
    				<li><a href="#">{users_text}</a>
					<ul>
    						<li><a href="{site_url}admin/users">{manage_users}</a></li>
    						<li><a href="{site_url}admin/roles">{manage_roles}</a></li>
    						<li><a href="{site_url}admin/permissions">{manage_perms}</a></li>
					</ul>
    				</li>
    				<li><a href="#">{blog_text}</a>
					<ul>
    						<li><a href="{site_url}admin/create_article">{create_article}</a></li>
    						<li><a href="{site_url}admin/articles_list">{edit_articles}</a></li>
    						<li><a href="{site_url}admin/comments_list">{comments_text}</a></li>
    						<li><a href="{site_url}admin/categories_list">{categories_text}</a></li>
					</ul>
    				</li>
    				<li><a href="#">{forums_text}</a>
					<ul>
    						<li><a href="{site_url}admin/forum_categories_list">{forum_categories_list}</a></li>
    						<li><a href="{site_url}admin/forums_list">{forums_text}</a></li>
					</ul>
    				</li>
    				<li><a href="#">{shops_text}</a>
					<ul>
    						<li><a href="{site_url}admin/shops_list">{shops_text}</a></li>
					</ul>
    				</li>
    				<li><a href="#">{system}</a>
					<ul>
    						<li><a href="{site_url}admin/settings">{settings}</a></li>
    						<li><a href="{site_url}admin/pages_list">{pages_text}</a></li>
    						<li><a href="{site_url}admin/blocks_list">{blocks_text}</a></li>
    						<li><a href="{site_url}useraccount/change_password">{change_password}</a></li>
    						<li><a href="{site_url}admin/modules">{modules_text}</a></li>
    						<li><a href="{site_url}admin/extensions">{extensions_text}</a></li>
    						<li><a href="{site_url}admin/add_field">{add_cf}</a></li>
    						<li><a href="{site_url}admin/fields_list">{list_cf}</a></li>
    						<li><a href="{site_url}admin/sites_list">{sites}</a></li>
    						<li><a href="{site_url}admin/add_site">{add_site}</a></li>
    						<li><a href="{site_url}admin/delete_site">{delete_site}</a></li>
					</ul>
    				</li>
  			</ul>
		</li>
{/if}
	</ul>
<br style="clear: left" />
</div>
</div>
</div>

			</div><!-- end header -->