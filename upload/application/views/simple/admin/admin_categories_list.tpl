{top_bar_tpl}
{top_menu_tpl}

		<main role="main">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">

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

					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->

		</main>
