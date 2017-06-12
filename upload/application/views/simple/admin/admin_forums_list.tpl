{top_bar_tpl}
{top_menu_tpl}

		<main role="main">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">

{if '{forums_available}'=='y'}<ul>{/if}
<!-- START forums -->
<li>
<a href="{site_url}{FORUM0}/viewforum/{forum_id}">{forum_name}</a>
<br />
<a href="{site_url}admin/edit_forum/{forum_id}">Edit</a> | <a onclick="return deletechecked();" href="{site_url}admin/delete_forum/{forum_id}">Delete</a> | <a href="{site_url}admin/forum_up/{forum_id}/">Up</a> | <a href="{site_url}admin/forum_down/{forum_id}">Down</a><p>
</li>
<br />
<!-- END forums -->
{if '{forums_available}'=='y'}</ul>
{else}
<p>{no_forums_yet}</p>
{/if}

<br /><br />

<p><a href="{site_url}admin/create_forum">{create_forum}</a><p/>

					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->

		</main>
