
		<div id="main">

			{top_bar_tpl}

			{top_menu_tpl}
			
			<div id="content" class="container">

<br />

{pagination}
<br /><br />

<table width="100%">

<tr class="topicstitle">
<th colspan="3"><strong>{forum_title}</strong>
<br />
{forum_description}</th>
</tr>
<tr class="topicsinfo">
<td width="25%">{topics_text}</td>
<td width="63%">{latest_post_text}</td>
<td width="12%" align="center">{posts_text}</td>
</tr>

<!-- START topics -->
<tr class="topic">
<td width="25%"><a href="{site_url}{FORUM0}/viewtopic/{topic_id}">{topic_title}</a></td>
<td width="63%">{latest_post}<br /><a href="{site_url}user/id/{post_author_id}">{post_author}</a></td>
<td width="12%" align="center">{posts_count}</td>
</tr>
<!-- END topics -->

</table>

<p>&nbsp;</p>
<p><a class="button" href="{site_url}{FORUM0}/newtopic/{forum_id}"><span>{new_topic}</span></a></p>

			</div><!-- end content -->
		
		</div><!-- end main -->
