{top_bar_tpl}
{top_menu_tpl}

		<main role="main">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">

<h2>{manage_role}</h2>

<form action="{site_url}admin/editing_role/{role_id}" method="post">

<br />

<label for="roleName">{role_name_text}:</label><input type="text" name="roleName" id="roleName" value="{role_name}" />

<br /><br />

<table border="0" cellpadding="5" cellspacing="0">

<tr><th></th><th>&nbsp;{allow} &nbsp;</th><th>{deny} &nbsp;</th><th>{ignore}</th></tr>

<!-- START perms -->
<tr>
<td><label>{perm_name}</label></td>
<td>&nbsp; <input type="radio" name="perm_{perm_id}" id="perm_{perm_id}_1" value="1" {checked_1} /></td>
<td>&nbsp; <input type="radio" name="perm_{perm_id}" id="perm_{perm_id}_0" value="0" {checked_0} /></td>
<td>&nbsp; <input type="radio" name="perm_{perm_id}" id="perm_{perm_id}_x" value="x" {checked_x} /></td>
</tr>
<!-- END perms -->

</table>

<input type="hidden" name="roleID" value="{role_id}" />
<input type="submit" name="Submit" value="{submit}" />

</form>

<form action="{site_url}admin/deleting_role/{role_id}" method="post">
<input type="hidden" name="roleID" value="{role_id}" />
<input onclick="return deletechecked();" type="submit" name="Delete" value="{delete}" />
</form>

<form action="{site_url}admin/roles" method="post">
	<input type="submit" name="Cancel" value="{cancel}" />
</form>

					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->

		</main>
