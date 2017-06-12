
		<div id="main">

			{top_bar_tpl}

			{top_menu_tpl}
			
			<div id="content" class="container">

<br />

<div class="admin">
{if '{forums_available}'=='y'}<ul>{/if}
<!-- START forums -->
<li>
<a href="{site_url}{FORUM0}/viewforum/{forum_id}">{forum_category}</a>
<br />
<a href="{site_url}admin/edit_forum_category/{forum_id}">Edit</a> | <a onclick="return deletechecked();" href="{site_url}admin/delete_forum_category/{forum_id}">Delete</a> | <a href="{site_url}admin/forum_category_up/{forum_id}">Up</a> | <a href="{site_url}admin/forum_category_down/{forum_id}">Down</a><p>
<br />
</li>
<!-- END forums -->
{if '{forums_available}'=='y'}</ul>
{else}
<p>{no_forums_yet}</p>
{/if}

<br /><br />

<p><a href="{site_url}admin/create_forum_category">{create_forum_category}</a><p/>
</div>
			</div><!-- end content -->
		
		</div><!-- end main -->
