{top_bar_tpl}
{top_menu_tpl}

		<main role="main">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">

<h2>{heading}</h2>

{admin_simple_shops_list}

{if '{shops_available}'!='y'}
<p>{no_shops_yet}</p>
{/if}

<br /><br />

<p><a href="{site_url}admin/create_shop">{create_shop}</a><p/>

					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->

		</main>
