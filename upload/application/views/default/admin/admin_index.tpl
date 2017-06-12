
		<div id="main">

			{top_bar_tpl}

			{top_menu_tpl}
			
			<div id="content" class="container">
				<div class="admin">
				<div id="col-left">

<table class="notable" width="100%" border="0">
  <tr>
    <td class="notable" width="10%"><img src="{VIEWDIR}/img/icons/one_person.png" width="44" height="62" alt="Users" /></td>
    <td class="notable">				<h3>{users_text}</h3>
					<a href="{site_url}admin/users">{manage_users}</a><br />
					<a href="{site_url}admin/roles">{manage_roles}</a><br />
					<a href="{site_url}admin/permissions">{manage_perms}</a><br />
					<br /></td>
  </tr>
  <tr>
    <td class="notable" width="10%"><img src="{VIEWDIR}/img/icons/blog.png" width="48" height="57" alt="Blog" /></td>
    <td class="notable">				<h3>{blog_text}</h3>
 					<a href="{site_url}admin/create_article">{create_article}</a><br />
					<br />
 					<a href="{site_url}admin/articles_list">{edit_articles}</a><br />
					<br />
					<a href="{site_url}admin/comments_list">{comments_text}</a><br />
 					<br />
					<a href="{site_url}admin/categories_list">{categories_text}</a><br />
					<br /></td>
  </tr>
  <tr>
    <td class="notable" width="10%"><img src="{VIEWDIR}/img/icons/persons.png" width="82" height="62" alt="Forum" /></td>
    <td class="notable">				<h3>{forums_text}</h3>
					<a href="{site_url}admin/forum_categories_list">{forum_categories_list}</a><br />
					<a href="{site_url}admin/forums_list">{forums_text}</a><br />
					<br /></td>
  </tr>
  <tr>
    <td class="notable" width="10%"><img src="{VIEWDIR}/img/icons/shop.png" width="73" height="61" alt="Shop" /></td>
    <td class="notable">				<h3>{shops_text}</h3>
  					<a href="{site_url}admin/shops_list">{shops_text}</a><br />
					<br /></td>
  </tr>
  <tr>
    <td class="notable" width="10%"><img src="{VIEWDIR}/img/icons/system.png" width="82" height="60" alt="System" /></td>
    <td class="notable">				<h3>{system}</h3>
					<a href="{site_url}admin/settings">{settings}</a><br />
					<br />
					<a href="{site_url}admin/pages_list">{pages_text}</a><br />
					<br />
					<a href="{site_url}admin/blocks_list">{blocks_text}</a><br />
					<br />
					<a href="{site_url}useraccount/change_password">{change_password}</a><br />
					<br />
					<a href="{site_url}admin/modules">{modules_text}</a><br />
					<br />
					<a href="{site_url}admin/extensions">{extensions_text}</a><br />
					<br />
					<a href="{site_url}admin/add_field">{add_cf}</a><br />
					<a href="{site_url}admin/fields_list">{list_cf}</a><br />
					<br />
					<a href="{site_url}admin/sites_list">{sites}</a><br />
					<a href="{site_url}admin/add_site">{add_site}</a><br />
					<a href="{site_url}admin/delete_site">{delete_site}</a><br /></td>
  </tr>
</table>
				</div>
				<div id="col-right" >
					{latest_comments_plus_widget}
					<br /><br />
					<table width="100%" class="notable2">
    					    <tr>
					        <td width="50%" valign="top" class="notable2">{latest_topics_plus_widget}</td>
					        <td width="50%" valign="top" class="notable2">{latest_posts_plus_widget}</td>
					    </tr>
					</table>
					<br /><br />
					{latest_opinions_plus_widget}
				</div>
				</div>
			</div><!-- end content -->

		</div><!-- end main -->
