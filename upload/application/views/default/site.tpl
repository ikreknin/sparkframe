
		<div id="main">

			{top_bar_tpl}

			{top_menu_tpl}

			<div id="content" class="container">

				<div id="posts">

					{if '{current_category}'!=''}<h2>{category_text}: {current_category}</h2>{/if}

					<p>{pagination}</p>

					<!-- START articles -->
						<h2><a href="{site_url}{CMS0}/more/{more}">{title}</a></h2>

						<div class="articleinfo">{if '{one_cat_available}'=='y'}<small>{category_text}: <a href="{site_url}{CMS0}/category/{category_id}">{category_name}</a> | {/if}{author_text}: <a href="{site_url}user/id/{author_id}">{author_name}</a> | {create_date} {create_time} | {comments_text}: {comments_count}</small></div>

{before_blog_article_hook}
						<br />

						{article}
						<div class="read_more">
							{if '{article_extended}'!=''}<p><a href="{site_url}{CMS0}/more/{more}">{read_more}</a></p>{/if}
						</div>
						<div class="edit_this">
							{if '{admin_level}'=='1'}<p><a href="{site_url}admin/edit_article/{article_id}">[{edit_this}]</a></p>{/if}
						</div>
					<!-- END articles -->

					<p>{pagination}</p>

				</div><!-- end posts -->

				<div id="sidebar">

					<h3>{search}</h3>
					<form action="{site_url}{CMS0}/search" method="post" id="searchForm">
						<input class="text" name="search" type="text" value="" maxlength="150" />
					</form>

					<h3>{categories_text}</h3>
					{if '{categories_available}'=='y'}
					{simple_categories_list}
					{else}
					<p>{no_categories_yet}</p>
					{/if}
<br /><br />
					{poll_widget}
<br /><br />
					{latest_articles_plus_widget}
<br /><br /><br />
					{blogCalendar}
<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
					{monthly_archive_widget}

				</div><!-- end sidebar -->

			</div><!-- end content -->

		</div><!-- end main -->
