
		<div id="main">

			{top_bar_tpl}

			{top_menu_tpl}
			
			<div id="content" class="container">

				<h2>{heading}</h2>

				<div class="admin">

					<!-- START modules -->
					<p><a href="{site_url}{mod_file_name}"><b>{mod_file_name}</b></a> | 
					{if '{mod_installed}'=='0'}<a href="{site_url}{mod_file_name}/install"><font color="green">Install</font></a> {/if}
					{if '{mod_installed}'=='1'}<a onclick="return deletechecked();" href="{site_url}{mod_file_name}/uninstall"><font color="red">Uninstall</font></a>{/if}
					</p>
<br />
					<!-- END modules -->

				</div>

			</div><!-- end content -->
		
		</div><!-- end main -->
