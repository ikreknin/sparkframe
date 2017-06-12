{top_bar_tpl}
{top_menu_tpl}

		<main role="main">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">

<h2 class="black">{heading}: <a href="{site_url}admin/user/{user_id}">{username}</a></h2>

<h2>{manage_roles}</h2>


<form action="../editing_user_roles/{user_id}" method="post">

<table border="0" cellpadding="5" cellspacing="0">
<tr><th></th><th>{member} &nbsp; </th><th>{not_member} &nbsp; </th></tr>

<!-- START roles -->
<tr>
<td><label>{role_name} &nbsp; </label></td>
<td><input type="radio" name="role_{role_id}" id="role_{role_id}_1" value="{value_1}" {checked_1} /></td>
<td><input type="radio" name="role_{role_id}" id="role_{role_id}_0" value="{value_2}" {checked_2} /></td>
</tr>
<!-- END roles -->

</table>

<input type="hidden" name="userID" value="{user_id}" />
<input type="submit" name="Submit" value="{submit}" />

</form>

<form>
<input type="button" name="Cancel" onclick="window.location='../user/{user_id}'" value="{cancel}" />
</form>


<h3><a href="{site_url}admin/edit_user_permissions/{user_id}">{manage_perms}</a></h3>

					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->

		</main>
