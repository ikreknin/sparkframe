
		<div id="main">

			{top_bar_tpl}

			{top_menu_tpl}
			
			<div id="content" class="container">

<!-- START custom_fields -->
<p><a href="{site_url}admin/edit_field/{c_created_id}">{c_created_name}</a> [<a onclick="return deletechecked();" href="{site_url}admin/delete_field/{c_created_id}">Delete</a>] {encrypted_field}: {c_created_encrypted}</p>
<!-- END custom_fields -->

			</div><!-- end content -->
		
		</div><!-- end main -->
