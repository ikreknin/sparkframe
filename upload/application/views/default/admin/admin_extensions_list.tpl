
		<div id="main">

			{top_bar_tpl}

			{top_menu_tpl}
			
			<div id="content" class="container">

<h2>{extensions_text}</h2>

<div class="admin">
<!-- START extensions -->
<p><b>{ext_file_name}</b> | 
{if '{ext_installed}'=='0'}<a href="{site_url}{ext_file_name}/install">Install</a> {/if}
{if '{ext_installed}'=='1'}<a href="{site_url}{ext_file_name}/uninstall">Uninstall</a>{/if}
</p>
<br />
<!-- END extensions -->
</div>
			</div><!-- end content -->
		
		</div><!-- end main -->
