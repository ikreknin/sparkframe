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

<p>{pagination}</p>

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
		<i class="fa fa-clock-o"></i>{create_date} {create_time}
	</span>
	<span class="post-meta-comments">
		<i class="fa fa-comment"></i>{comments_count}
	</span>
</p>

</header>

{before_blog_article_hook}

{article}

<div class="read_more">
{if '{article_extended}'!=''}<p><a href="{site_url}{CMS0}/more/{more}">{read_more}</a></p>{/if}
</div>

<div class="edit_this">
{if '{admin_level}'=='1'}<p><a href="{site_url}admin/edit_article/{article_id}">[{edit_this}]</a></p>{/if}
</div>

<!-- END articles -->

</article>

<p>{pagination}</p>

</section>

<!-- END CONTENT -->

			    </div>
	<!-- Sidebar Content
	================================================== -->
			    <div class="six columns">

<!-- BEGIN SIDEBAR -->

<aside id="sidebar" class="sidebar">

<h3 class="side-title">Info</h3>

<p>SparkFrame integrates its own PHP framework, content management system (multilevel dynamic and static pages, w/ automatic multilevel categories/menu, blocks, and a few types of custom fields), HTML and WYSIWYG, forum and online shop (w/ IPN PayPal). It supports modules, extensions and widgets (including hooks), has multiple site support, advanced membership support, language localization support, template engine (including {if}{else}{/if} ), GNU GPL v.3, and White Label.</p>

</aside>

<!-- END SIDEBAR -->

			    </div><!-- end sixteen columns  -->

</div>
