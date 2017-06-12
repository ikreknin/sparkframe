{top_bar_tpl}
{top_menu_tpl}

		<main role="main">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">

<h2 class="black">{heading}: <a href="{site_url}admin/user/{user_id}">{username}</a></h2>

<h2>{manage_perms}</h2>


<form action="../editing_user_permissions/{user_id}" method="post">

<table class="notable">
<!-- START perms -->
<tr>
<td class="notable">{perm_name} &nbsp; </td>
<td class="notable"> &nbsp; <img src="{site_url}application/views/default/img/{perm_level}.png" width="16" height="16" alt="{perm_alt}" /></td>
<td class="notable">  &nbsp; 
<select name="perm_{perm_id}">
<option value="1" {selected_1}>{allow}</option>
<option value="0" {selected_0}>{deny}</option>
<option value="x" {selected_x}>{inherit} {inherited_value}</option>
</select>
</td>
</tr>
<!-- END perms -->
</table>

<input type="hidden" name="userID" value="{user_id}" />
<input type="submit" name="Submit" value="{submit}" />

</form>

<form>
<input type="button" name="Cancel" onclick="window.location='../user/{user_id}'" value="{cancel}" />
</form>


<h3><a href="{site_url}admin/edit_user_roles/{user_id}">{manage_roles}</a></h3>

					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->

		</main>
