
		<div id="main">

			{top_bar_tpl}

			{top_menu_tpl}
			
			<div id="content" class="container">




<table class="notable">
<!-- START perms -->
<tr><td class="notable"><a href="{site_url}admin/edit_permission/{perm_id}">{perm_name}</a>{if '{perm_locked}'=='1'} [{protected}]{/if}</td></tr>
<!-- END perms -->

<tr><td class="notable"><input type="button" name="New" value="{create_perm}" onclick="window.location='{site_url}admin/create_permission'" /></td></tr>
</table>

    </div>

			</div><!-- end content -->
		
		</div><!-- end main -->
