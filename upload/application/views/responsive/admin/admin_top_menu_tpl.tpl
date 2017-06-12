	<!-- BEGIN NAV
	================================================== -->
								<nav class="primary">
									<ul class="sf-menu">
										{if '{seg_1}'==''}<li class="current-menu-item">{else}<li>{/if}
											<a href="{site_url}">{if '{cur_lang_code}'=='en'}Home{else}Начало{/if} <span><i>|</i> {if '{cur_lang_code}'=='en'}Framework{else}Фреймворк{/if}</span></a>
											<ul>
{if '{admin_level}'=='1'}
<li><a href="{site_url}admin">{admin_home}</a>
	<ul>
		<li><a href="#">{users_text}</a>
			<ul>
				<li><a href="{site_url}admin/users">{manage_users}</a><li>
				<li><a href="{site_url}admin/roles">{manage_roles}</a><li>
				<li><a href="{site_url}admin/permissions">{manage_perms}</a><li>
			</ul>
		</li>
		<li><a href="#">{blog_text}</a>
			<ul>
				<li><a href="{site_url}admin/create_article">{create_article}</a><li>
				<li><a href="{site_url}admin/articles_list">{edit_articles}</a><li>
				<li><a href="{site_url}admin/comments_list">{comments_text}</a><li>
				<li><a href="{site_url}admin/categories_list">{categories_text}</a><li>
			</ul>
		</li>
		<li><a href="#">{forums_text}</a>
			<ul>
				<li><a href="{site_url}admin/forum_categories_list">{forum_categories_list}</a><li>
				<li><a href="{site_url}admin/forums_list">{forums_text}</a><li>
			</ul>
		</li>
		<li><a href="#">{shops_text}</a>
			<ul>
				<li><a href="{site_url}admin/shops_list">{shops_text}</a><li>
			</ul>
		</li>
		<li><a href="#">{system}</a>
			<ul>
				<li><a href="{site_url}admin/settings">{settings}</a><li>
				<li><a href="{site_url}admin/pages_list">{pages_text}</a><li>
				<li><a href="{site_url}admin/blocks_list">{blocks_text}</a><li>
				<li><a href="{site_url}useraccount/change_password">{change_password}</a><li>
				<li><a href="{site_url}admin/modules">{modules_text}</a><li>
				<li><a href="{site_url}admin/extensions">{extensions_text}</a><li>
				<li><a href="{site_url}admin/add_field">{add_cf}</a><li>
				<li><a href="{site_url}admin/fields_list">{list_cf}</a><li>
				<li><a href="{site_url}admin/sites_list">{sites}</a><li>
				<li><a href="{site_url}admin/add_site">{add_site}</a><li>
				<li><a href="{site_url}admin/delete_site">{delete_site}</a><li>
			</ul>
		</li>

	</ul>
</li>
{/if}
											</ul>
										</li>
										{if '{seg_1}'=='site'}<li class="current-menu-item">{else}<li>{/if}
											<a href="{site_url}site">{if '{cur_lang_code}'=='en'}Blog{else}Блог{/if} <span><i>|</i> {if '{cur_lang_code}'=='en'}Articles{else}Статьи{/if}</span></a>
										</li>
										{if '{seg_1}'=='forum'}<li class="current-menu-item">{else}<li>{/if}
											<a href="{site_url}forum">{if '{cur_lang_code}'=='en'}Forum{else}Форум{/if} <span><i>|</i> {if '{cur_lang_code}'=='en'}Q&A{else}Q&A{/if}</span></a>
										</li>
										{if '{seg_1}'=='shop'}<li class="current-menu-item">{else}<li>{/if}
											<a href="{site_url}shop">{if '{cur_lang_code}'=='en'}Shop{else}Магазин{/if} <span><i>|</i> {if '{cur_lang_code}'=='en'}Files{else}Файлы{/if}</span></a>
										</li>
										{if '{seg_1}'=='contact'}<li class="current-menu-item">{else}<li>{/if}
											<a href="{site_url}contact">{if '{cur_lang_code}'=='en'}Contact{else}Контакты{/if} <span><i>|</i> {if '{cur_lang_code}'=='en'}Mail{else}Почта{/if}</span></a>
										</li>
									</ul>
	<!-- END NAV
	================================================== -->
							</nav>

				    		</div><!-- end sixteen columns  -->
						</div><!-- end container -->
					</div><!-- end top-menu -->

	<!-- END HEADER
	================================================== -->
				</header>
