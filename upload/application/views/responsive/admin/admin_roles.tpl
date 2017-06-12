
		<div id="main">

			{top_bar_tpl}

			{top_menu_tpl}
			
			<div id="content" class="container">


<table class="notable">
<!-- START roles -->
<tr><td class="notable"><a href="{site_url}admin/edit_role/{role_id}">{role_name}</a>{if '{role_locked}'=='1'} [{protected}]{/if}</td></tr>
<!-- END roles -->

<tr><td class="notable"><input type="button" name="New" value="Create Role" onclick="window.location='{site_url}admin/create_role'" /></td></tr>
</table>

			</div><!-- end content -->
		
		</div><!-- end main -->
