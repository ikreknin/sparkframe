
		<div id="main">

			{top_bar_tpl}

			{top_menu_tpl}
			
			<div id="content" class="container">

<h2>{heading}</h2>

<div class="admin">
{if '{categories_available}'=='y'}
{admin_categories_list}
{else}
<p>{no_categories_yet}</p>
{/if}

<br /><br />

<p><a href="{site_url}admin/create_category">{create_category}</a><p/>
</div>
			</div><!-- end content -->
		
		</div><!-- end main -->
