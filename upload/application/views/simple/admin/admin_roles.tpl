{top_bar_tpl}
{top_menu_tpl}

		<main role="main">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">

<table>
<!-- START roles -->
<tr><td><a href="{site_url}admin/edit_role/{role_id}">{role_name}</a>{if '{role_locked}'=='1'} [{protected}]{/if}</td></tr>
<!-- END roles -->

<tr><td><input type="button" name="New" value="Create Role" onclick="window.location='{site_url}admin/create_role'" /></td></tr>
</table>

					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->

		</main>
