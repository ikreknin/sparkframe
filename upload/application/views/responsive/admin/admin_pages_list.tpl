
		<div id="main">

			{top_bar_tpl}

			{top_menu_tpl}
			
			<div id="content" class="container">

<h2>{heading}</h2>

<div class="admin">
{if '{pages_available}'=='y'}
{admin_pages_list}
{else}
<p>{no_pages_yet}</p>
{/if}

<br /><br />

<p><a href="{site_url}admin/create_page">{create_page}</a><p/>
</div>
			</div><!-- end content -->
		
		</div><!-- end main -->
