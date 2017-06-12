{top_bar_tpl}
{top_menu_tpl}

<div class="container">

	<!-- Info
	================================================== -->
			<div class="sixteen columns clearfix">
				<h2>{heading}</h2>
			</div>
			<div class="sixteen columns">
<table>
<tr>
<td>{username_text}</a></td>
<td>{registration}</a></td>
</tr>

<!-- START users -->
<tr>
<td><a href="{site_url}user/id/{users_id}">{username}</a></td>
<td>{user_created}</td>
</tr>
<!-- END users -->
</table>

<br />
<p>{pagination}</p>
<br />
			</div><!-- end sixteen columns  -->

</div>
