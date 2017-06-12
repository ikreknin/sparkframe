{top_bar_tpl}
{top_menu_tpl}

		<main role="main">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">

<p>{pagination}</p>
<br />

<table>
<tr>
<td>{username_text}</a></td>
<td>{registration}</a></td>
{if '{admin_level}'=='1'}
<td>{name_text}</td>
<td>{email_text}</td>
<td>{active_text}</td>
<td>{banned_text}</td>

<td>{ban_text}</td>
<td>{edit}</td>
<td>{delete}</td>
{/if}
</tr>

<!-- START users -->
<tr>
<td><a href="{site_url}admin/user/{users_id}">{username}</a></td>
<td>{user_created}</td>
{if '{admin_level}'=='1'}
<td>{name}</td>
<td>{email}</td>
<td>{active}</td>
<td>{banned}</td>

<td><a href="{site_url}admin/user/ban/{users_id}">{ban_text}</a></td>
<td><a href="{site_url}admin/user/unban/{users_id}">{unban_text}</a></td>
<td><a onclick="return deletechecked();" href="{site_url}admin/user/delete/{users_id}">{delete}</a></td>
{/if}
</tr>
<!-- END users -->
</table>

					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->

		</main>
