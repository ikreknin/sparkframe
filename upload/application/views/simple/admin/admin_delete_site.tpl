{top_bar_tpl}
{top_menu_tpl}

		<main role="main">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">

<form action="{site_url}admin/deleting_site" method="post">

<h2>{delete_site}</h2>
<p>{site_selector}</p>
<p><input onclick="return deletechecked();" type='submit' value='{submit}'/></p>

</form>

					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->

		</main>
