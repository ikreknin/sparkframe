
		<div id="main">

			{top_bar_tpl}

			{top_menu_tpl}
			
			<div id="content" class="container">


<h2>{heading}</h2>

<div class="admin">

{admin_simple_shops_list}

{if '{shops_available}'!='y'}
<p>{no_shops_yet}</p>
{/if}

<br /><br />

<p><a href="{site_url}admin/create_shop">{create_shop}</a><p/>
</div>
			</div><!-- end content -->
		
		</div><!-- end main -->
