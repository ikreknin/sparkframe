{top_bar_tpl}
{top_menu_tpl}

		<main role="main">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">

<h2>{edit_articles}</h2>

{pagination}

<!-- START articles -->
<h3>{title}</h3>
<p><a href="{site_url}user/id/{author_id}">{author_name}</a> | {create_date} | {create_time}</p>
<p><a href="{site_url}admin/edit_article/{article_id}">{edit}</a> <a href="{site_url}{CMS0}/more/{article_id}">{view}</a> <a onclick="return deletechecked();" href="{site_url}admin/delete_article/{article_id}">{delete}</a><p>
<br />
<!-- END articles -->

{pagination}

					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->

		</main>
