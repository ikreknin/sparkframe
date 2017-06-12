		<footer role="contentinfo">
			<div class="container footer-bar">
				<div class="row">
					<div class="col-sm-6">
						<p class="footer-text">Copyright &copy; {copyright_years} All Rights Reserved</p>
						<p class="footer-text">Powered by CMS. Version {current_version}</p>
					</div>
					<div class="col-sm-6">
						<div class="footer-search">
							<form action="{site_url}{CMS0}/search" method="post">
								<input type="text" name="search" placeholder="{search}...">
								<i class="fa fa-search"></i>
							</form>
{footer_hook}
						</div>
					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->
		</footer>

{highlighter}
        <script src="{site_url}application/views/simple/admin/js/plugins.js"></script>
        <script src="{site_url}application/views/simple/admin/js/main.js"></script>
{before_closing_body_tag_hook}
{ckfinder_end}
    </body>
</html>