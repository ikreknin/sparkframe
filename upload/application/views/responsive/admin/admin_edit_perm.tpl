
		<div id="main">

			{top_bar_tpl}

			{top_menu_tpl}
			
			<div id="content" class="container">

<h2>{manage_perm}: ({perm_name})</h2>

<form action="{site_url}admin/editing_permission" method="post">

<label for="permName">{perm_name_text}:</label>
<input type="text" name="permName" id="permName" value="{perm_name}" maxlength="30" /><br />

<label for="permKey">{key}:</label>
<input type="text" name="permKey" id="permKey" value="{perm_key}" maxlength="30" /><br />

<input type="hidden" name="permID" value="{perm_id}" />
<input type="submit" name="Submit" value="{submit}" />
</form>

<form action="{site_url}admin/deleting_permission" method="post">
<input type="hidden" name="permID" value="{perm_id}" />
<input onclick="return deletechecked();" type="submit" name="Delete" value="{delete}" />
</form>

<form action="{site_url}admin/permissions" method="post">
<input type="submit" name="Cancel" value="{cancel}" />
</form>

			</div><!-- end content -->
		
		</div><!-- end main -->
