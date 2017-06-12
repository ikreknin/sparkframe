{top_bar_tpl}
{top_menu_tpl}

		<main role="main">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">

<h2>{heading}</h2>

{if '{pages_available}'=='y'}
{admin_pages_list}
{else}
<p>{no_pages_yet}</p>
{/if}

<br /><br />

<p><a href="{site_url}admin/create_page">{create_page}</a><p/>

					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->

		</main>
