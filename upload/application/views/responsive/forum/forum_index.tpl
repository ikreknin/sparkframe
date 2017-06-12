
{top_bar_tpl}

{top_menu_tpl}

				<!-- BEGIN CONTENT WRAPPER -->
				<div id="content-wrapper" class="content-wrapper">
					<div class="container">
						<div class="clearfix">
							<div class="grid_12">

				{if '{forums_available}'=='y'}
				<table width="100%">
				{/if}

<!-- START forums -->

				{if '{type}'=='forum'}
					<tr class="foruminfo forumentry">
						<td width="25%"><a href="{site_url}{FORUM0}/viewforum/{forum_id}">{forum_name}</a></td>
						<td width="51%"><a href="{site_url}{FORUM0}/viewtopic/{latest_topic_id}">{latest_topic}</a></td>
						<td width="12%" align="center">{topics_count}</td>
						<td width="12%" align="center">{posts_count}</td>
					</tr>
				{/if}

				{if '{type}'=='first_category'}
					<tr>
						<th class="forumheading" colspan="4">
							<a href="{site_url}{FORUM0}/viewforum/{forum_id}">{forum_name}</a>
						</th>
					</tr>
					<tr class="forumtitle">
						<td width="25%">{forum_text}</td>
						<td width="51%">{latest_post_text}</td>
						<td width="12%" align="center">{topics_text}</td>
						<td width="12%" align="center">{posts_text}</td>
					</tr>
					{/if}

					{if '{type}'=='another_category'}
				</table>
				<br />
				<table width="100%">
					<tr>
						<th class="forumheading" colspan="4">
							<a href="{site_url}{FORUM0}/viewforum/{forum_id}">{forum_name}</a>
						</th>
					</tr>
					<tr class="forumtitle">
						<td width="25%">{forum_text}</td>
						<td width="51%">{latest_post_text}</td>
						<td width="12%" align="center">{topics_text}</td>
						<td width="12%" align="center">{posts_text}</td>
					</tr>
					{/if}

<!-- END forums -->

					{if '{forums_available}'=='y'}
				</table>
				{else}
				<div class="text">
					<br />
					{no_forums_yet}
				</div>
				{/if}

							</div>
						</div>
					</div>
				</div>
				<!-- END CONTENT WRAPPER -->
