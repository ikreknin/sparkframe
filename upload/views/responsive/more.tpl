{top_bar_tpl}
{top_menu_tpl}

<div class="container">

	<!-- Main Content
	================================================== -->
			    <div class="ten columns clearfix">

<!-- BEGIN CONTENT -->

<section id="content">

	<div class="page-title">
		<h2>Blog</h2>
	</div>

{if '{current_category}'!=''}<h2>{category_text}: {current_category}</h2>{/if}

<article class="post clearfix">

<!-- START articles -->

<header class="post-header">

<h3><a href="{site_url}{CMS0}/more/{more}">{title}</a></h3>
<p class="post-meta">
{if '{one_cat_available}'=='y'}
	<span class="post-meta-cats">
		<a href="{site_url}user/id/{author_id}"><i class="fa fa-tag"></i>{category_name}</a>
	</span>
{/if}
	<span class="post-meta-author">
		<a href="user/id/1"><i class="fa fa-user"></i>{author_name}</a>
	</span>
	<span class="post-meta-time">
		<i class="fa fa-time"></i>{create_date} {create_time}
	</span>
	<span class="post-meta-comments">
		<i class="fa fa-comment"></i>{comments_count}
	</span>
</p>

</header>

{before_blog_article_hook}

{article}
{article_extended}

{article_tags_widget}

<div class="edit_this">
{if '{admin_level}'=='1'}<p><a href="{site_url}admin/edit_article/{article_id}">[{edit_this}]</a></p>{/if}
</div>

<!-- END articles -->

</article>

<br /><br />

<h3>{comments_text}</h3>

<!-- START comments -->
<a name="{comment_id}" href="#"></a>
<p>
{if '{com_author_id}'!='0'}
<a href="{site_url}user/id/{com_author_id}">{com_author}</a>
{else}
{com_author} ({guest})
{/if}
 | {create_date} | {create_time}</p>
{if '{spam}'=='y'}
<p><font color="red"><strong>SPAM</strong></font></p>
{/if}
<p>{body}</p>

{if '{admin_level}'=='1' AND '{visible}'=='y'}
<p><a href="{site_url}admin/edit_comment/{comment_id}">{edit}</a> | <a href="{site_url}admin/hide_comment/{article_id}/{comment_id}">{hide}</a> | <a onclick="return deletechecked();" href="{site_url}admin/delete_comment/{comment_id}">{delete}</a><p>
{/if}

{if '{admin_level}'=='1' AND '{visible}'!='y'}
<p><a href="{site_url}admin/edit_comment/{comment_id}">{edit}</a> | <a href="{site_url}admin/show_comment/{article_id}/{comment_id}"><strong>{show}</strong></a> | <a onclick="return deletechecked();" href="{site_url}admin/delete_comment/{comment_id}">{delete}</a><p>
{/if}

<hr />
<!-- END comments -->

{if '{comments_available}'==''}{no_comments_yet}{/if}

<br /><br />

{if '{error_message}'!=''}
<h3>{error_message}</h3>
{/if}

{if '{comments_level}'=='1' && '{comments_allowed}'=='1'}
<form action="{site_url}{CMS0}/adding_comment/{more}" method="post" id="commentForm">
<input type="hidden" name="com_articleid" value="{article_id}" />
<input type="hidden" name="more" value="{more}" />
<fieldset>

<legend>{comment_text}</legend>

<label for="name">{your_name}: </label>
{visitor_username}
<input type="hidden" name="new_com_author" value="{visitor_username}" />
<input type="hidden" name="email" value="" />
<input type="hidden" name="website" value="" />
<br /><br />

<label for="comment">{your_comment}: <span>*</span></label>
<br />
<div class="btn bold" title="bold"></div><div class="btn italic"></div><div class="btn underline"></div><div class="btn link"></div><div class="btn quote"></div>
<div class="btn code"></div><div class="btn image"></div><div class="btn usize"></div><div class="btn dsize"></div><div class="btn nlist"></div>
<div class="btn blist"></div><div class="btn litem"></div><div class="btn back"></div><div class="btn forward"></div>
<textarea id="comment" name="body" cols="50" rows="10">{comment}</textarea>
<br />

<input class="button" type="submit" name="submit" value="{add_comment}">

</fieldset>
</form>
{/if}


{if '{guests_comments_allowed}'=='1' && '{comments_allowed}'=='1' && '{visitor_user_id}'=='0'}
<form action="{site_url}{CMS0}/adding_comment/{article_id}" method="post" id="commentForm">
<input type="hidden" name="com_articleid" value="{article_id}" />
<fieldset>

<legend>{comment_text}</legend>

<label for="name">{your_name}: <span>*</span></label>
<input type="text" name="new_com_author" value="{new_com_author}"/>
<br />

<label for="name">{your_email}: <span>*</span></label>
<input type="text" name="email" value="{email}"/>
<br />

<label for="name">{your_website}: <span>*</span></label>
<input type="text" name="website" value="{website}"/>
<br />

<label for="comment">{your_comment}: <span>*</span></label>
<div class="btn bold" title="bold"></div><div class="btn italic"></div><div class="btn underline"></div><div class="btn link"></div><div class="btn quote"></div>
<div class="btn code"></div><div class="btn image"></div><div class="btn usize"></div><div class="btn dsize"></div><div class="btn nlist"></div>
<div class="btn blist"></div><div class="btn litem"></div><div class="btn back"></div><div class="btn forward"></div>
<textarea id="comment" name="body" cols="50" rows="10">{comment}</textarea>
<br />

{enter_code}: <img src="{site_url}{CMS0}/captcha" alt="" />
<br />
<input type="text" id="captcha" name="captcha" />
<br />

<input class="button" type="submit" name="submit" value="{add_comment}">

</fieldset>
</form>
{/if}

<br />

<div class="preview"></div>

{if '{comments_level}'=='0' && '{guests_comments_allowed}'=='0'}
{no_right_to_comment}
{/if}

{if '{comments_allowed}'=='0'}
{commenting_disabled}
{/if}


</section>

<!-- END CONTENT -->

			    </div>
	<!-- Sidebar Content
	================================================== -->
			    <div class="six columns">

<!-- BEGIN SIDEBAR -->

<aside id="sidebar" class="sidebar">

					<h3>{categories_text}</h3>
					{if '{categories_available}'=='y'}
					{simple_categories_list}
					{else}
					<p>{no_categories_yet}</p>
					{/if}

					<h3>{search}</h3>
					<form action="{site_url}{CMS0}/search" method="post" id="searchForm">
						<input class="text" name="search" type="text" value="" maxlength="150" />
					</form>

					{latest_articles_plus_widget}

					{blogCalendar}
<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
					{monthly_archive_widget}
<br />
{tagcloud_widget}
<br /><br /><br /><br /><br /><br /><br /><br />

</aside>

<!-- END SIDEBAR -->

			    </div><!-- end sixteen columns  -->

</div>
