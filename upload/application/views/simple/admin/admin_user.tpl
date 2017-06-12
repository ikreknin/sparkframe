{top_bar_tpl}
{top_menu_tpl}

		<main role="main">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">

<h2 class="black">{heading}: {username}</h2>

<h2>{user_roles} (<a href="{site_url}admin/edit_user_roles/{user_id}">{manage_roles}</a>)</h2>

<ul>
<!-- START roles -->
<li class="red">- {role_name}</li>
<!-- END roles -->
</ul>

<h2>{user_perms} (<a href="{site_url}admin/edit_user_permissions/{user_id}">{manage_perms}</a>)</h2>

<table>
<!-- START perms -->
<tr><td>{perm_name}</td><td class="notable"><img src="{site_url}application/views/default/img/{perm_level}.png" width="16" height="16" alt="{perm_alt}" /></td></tr>
<!-- END perms -->
</table>

					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->

		</main>
