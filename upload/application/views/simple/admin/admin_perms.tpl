{top_bar_tpl}
{top_menu_tpl}

		<main role="main">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">

<h2>{manage_perms}</h2>

<table>
<!-- START perms -->
<tr><td><a href="{site_url}admin/edit_permission/{perm_id}">{perm_name}</a>{if '{perm_locked}'=='1'} [{protected}]{/if}</td></tr>
<!-- END perms -->

<tr><td><input type="button" name="New" value="{create_perm}" onclick="window.location='{site_url}admin/create_permission'" /></td></tr>
</table>

					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->

		</main>
