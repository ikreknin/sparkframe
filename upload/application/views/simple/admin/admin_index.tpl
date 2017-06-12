{top_bar_tpl}
{top_menu_tpl}

		<main role="main">
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
<h3>{users_text}</h3>
<p><a href="{site_url}admin/users">{manage_users}</a></p>
<p><a href="{site_url}admin/roles">{manage_roles}</a></p>
<p><a href="{site_url}admin/permissions">{manage_perms}</a></p>

<h3>{blog_text}</h3>
<p><a href="{site_url}admin/create_article">{create_article}</a></p>
<p><a href="{site_url}admin/articles_list">{edit_articles}</a></p>
<p><a href="{site_url}admin/comments_list">{comments_text}</a></p>
<p><a href="{site_url}admin/categories_list">{categories_text}</a></p>

<h3>{forums_text}</h3>
<p><a href="{site_url}admin/forum_categories_list">{forum_categories_list}</a></p>
<p><a href="{site_url}admin/forums_list">{forums_text}</a></p>

<h3>{shops_text}</h3>
<p><a href="{site_url}admin/shops_list">{shops_text}</a></p>

<h3>{system}</h3>
<p><a href="{site_url}admin/settings">{settings}</a></p>
<p><a href="{site_url}admin/pages_list">{pages_text}</a></p>
<p><a href="{site_url}admin/blocks_list">{blocks_text}</a></p>
<p><a href="{site_url}useraccount/change_password">{change_password}</a></p>
<p><a href="{site_url}admin/modules">{modules_text}</a></p>
<p><a href="{site_url}admin/extensions">{extensions_text}</a></p>
<p>&nbsp;</p>
<p><a href="{site_url}admin/add_field">{add_cf}</a></p>
<p><a href="{site_url}admin/fields_list">{list_cf}</a></p>
<p>&nbsp;</p>
<p><a href="{site_url}admin/sites_list">{sites}</a></p>
<p><a href="{site_url}admin/add_site">{add_site}</a></p>
<p><a href="{site_url}admin/delete_site">{delete_site}</a></p>
					</div>
					<div class="col-sm-8">
						<div class="row">
							<div class="col-sm-12">
								{latest_comments_plus_widget}
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								{latest_topics_plus_widget}
							</div>
							<div class="col-sm-6">
								{latest_posts_plus_widget}
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								{latest_opinions_plus_widget}
							</div>
						</div>
					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->

		</main>
