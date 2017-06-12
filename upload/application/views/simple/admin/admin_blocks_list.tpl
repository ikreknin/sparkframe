{top_bar_tpl}
{top_menu_tpl}

		<main role="main">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">

<h2>{heading}</h2>

<div class="admin">
{if '{blocks_available}'=='y'}
{admin_blocks_list}
{else}
<p>{no_blocks_yet}</p>
{/if}

<br /><br />

<p><a href="{site_url}admin/create_block">{create_block}</a><p/>
</div>

					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->

		</main>
