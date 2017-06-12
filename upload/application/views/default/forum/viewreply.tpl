
		<div id="main">

			{top_bar_tpl}

			{top_menu_tpl}
			
			<div id="content" class="container">

<br />

{pagination}

<br /><br />

<table width="100%">
<tr class="poststitle">
<th colspan="2"><a href="{site_url}{FORUM0}/viewforum/{forum_id}"><strong>{forum_title}</strong></a><br />{forum_description}</th>
</tr>
<tr class="postsinfo">
<td width="25%"></td>
<td width="75%" class="post"><strong>{topic_title}</strong> 

{if '{topic_visible}'=='y' && '{admin_level}'=='1'}
<a href="{site_url}admin/topic_hide/{topic_id}" >[Hide]</a> 
{/if}
{if '{topic_visible}'=='n' && '{admin_level}'=='1'}
<a href="{site_url}admin/topic_show/{topic_id}" >[<strong>Show</strong>]</a> 
{/if}

{if '{status}'=='o' && '{admin_level}'=='1'}
<a href="{site_url}admin/topic_close/{topic_id}" >[Close]</a> 
{/if}
{if '{status}'=='c' && '{admin_level}'=='1'}
<a href="{site_url}admin/topic_open/{topic_id}" >[<strong>Open</strong>]</a> 
{/if}

{if '{admin_level}'=='1'}
<a onclick="return deletechecked();" href="{site_url}admin/topic_delete/{topic_id}" >[Delete]</a>
{/if}
</td>
</tr>
<tr class="post">
<td class="forumuser" width="25%">
<div>
<a href="{site_url}user/id/{topic_author_id}">{topic_author}</a>
<br />
<img class="avatar" src="{topic_gravatar}" />
</div>
{user_created_date_text}: {user_created_date}</td>
<td class="postdata" width="75%">{published}: {topic_distance} 
{if '{admin_level}'=='1'}
<a href="{site_url}admin/topic_edit/{topic_id}" >[Edit]</a>
{/if}
<br /><br />
{topic_body}
</td>
</tr>

<!-- START posts -->
<tr class="post">
<td class="forumuser" width="25%">
<div>
<a href="{site_url}user/id/{post_author_id}">{post_author}</a>
<br />
<img class="avatar" src="{post_gravatar}" />
</div>
{user_created_date_text}: {user_created_date}</td>
<td class="postdata" width="75%">
[<a name="{post_id}" href="{site_url}{FORUM0}/viewreply/{topic_id}/#{post_id}" title="Permalink to this post">#{post_serial}</a>] 
{published}: {post_distance} 

{if '{post_visible}'=='y' && '{admin_level}'=='1'}
<a href="{site_url}admin/post_hide/{topic_id}/{post_id}" >[Hide]</a> 
{/if}
{if '{post_visible}'=='n' && '{admin_level}'=='1'}
<a href="{site_url}admin/post_show/{topic_id}/{post_id}" >[<strong>Show</strong>]</a> 
{/if}
{if '{admin_level}'=='1'}
<a href="{site_url}admin/post_edit/{topic_id}/{post_id}" >[Edit]</a>
{/if}
{if '{admin_level}'=='1'}
<a onclick="return deletechecked();" href="{site_url}admin/post_delete/{topic_id}/{post_id}" >[Delete]</a>
{/if}
<br /><br />
{post_body}
</td>
</tr>
<!-- END posts -->

</table>

<p>&nbsp;</p>
<p><a class="button" href="{site_url}{FORUM0}/newpost/{topic_id}"><span>{new_post}</span></a></p>

			</div><!-- end content -->
		
		</div><!-- end main -->
