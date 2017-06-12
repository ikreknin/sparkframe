{top_bar_tpl}
{top_menu_tpl}

		<main role="main">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">

{pagination}

<br /><br />

<!-- START comments -->
<p class="text">{body}</p>
<p>
{if '{author_id}'!='0'}
<a href="{site_url}user/id/{author_id}">{author}</a>
{else}
{author}
{/if}
 | {create_date} | {create_time}</p>
<p>{approved_text}: {approved} {visible_text}: {visible}</p>
<p><a href="{site_url}admin/edit_comment/{comment_id}">{edit}</a> | <a href="{site_url}{CMS0}/more/{article_id}/#{comment_id}">{go_to_comment}</a> | <a onclick="return deletechecked();" href="{site_url}admin/delete_comment/{comment_id}">{delete}</a><p>
<br />
<!-- END comments -->

{pagination}

					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->

		</main>
