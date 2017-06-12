{top_bar_tpl}
{top_menu_tpl}

		<main role="main">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">

<h1>Create Role</h1>

<form action="{site_url}admin/creating_role" method="post">
	<label for="permName">Role Name:</label>
	<input type="text" name="roleName" id="roleName" value="" maxlength="20" />

	<table border="0" cellpadding="5" cellspacing="0">
	<tr><th></th><th>Allow</th><th>Deny</th></tr>

	<!-- START perms -->
	<tr>
	<td><label>{perm_name}</label></td>
	<td><input type="radio" name="perm_{perm_id}" id="perm_{perm_id}_1" value="1" /></td>
	<td><input type="radio" name="perm_{perm_id}" id="perm_{perm_id}_0" value="0" /></td>
	<td><input type="radio" name="perm_{perm_id}" id="perm_{perm_id}_x" value="x" checked="checked" /></td>
	</tr>
	<!-- END perms -->

	</table>

	<input type="submit" name="Submit" value="Submit" />
</form>

<form action="{site_url}admin/roles" method="post">
	<input type="submit" name="Cancel" value="Cancel" />
</form>

			</div><!-- end content -->

					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->

		</main>
