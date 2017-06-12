{top_bar_tpl}
{top_menu_tpl}

		<main role="main">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">

<h1>{create_perm}</h1>

<form action="{site_url}admin/creating_permission" method="post">
	<label for="permName">Name:</label>
	<input type="text" name="permName" id="permName" value="" maxlength="30" />
	<br />
	<label for="permKey">Key:</label>
	<input type="text" name="permKey" id="permKey" value="" maxlength="30" />
	<br />
	<input type="hidden" name="permID" value="{perm_id}" />
	<input type="submit" name="Submit" value="Submit" />
</form>

<form action="{site_url}admin/permissions" method="post">
<input type="submit" name="Cancel" value="Cancel" />
</form>

					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->

		</main>
