<?xml version="1.0" encoding="{charset}"?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:atom="http://www.w3.org/2005/Atom">

	<channel>
	
	<title>{cms_title}</title>
	<link>{site_url}</link>
	<description>RSS</description>
	<copyright>Copyright {site_url}</copyright>

	<docs>http://www.rssboard.org/rss-specification</docs>
	<generator>SparkFrame {site_url}</generator>
	<language>{lang_code}</language>
	<atom:link href="{site_url}{CMS0}/" rel="self" type="application/rss+xml" />

<!-- START articles -->

	<item>

		<title>{title}</title>
		<link>{site_url}{CMS0}/more/{more}</link>
		<dc:creator>{author_name}</dc:creator>
		<category>{category_name}</category>

		<description>
{if '{category_name}'!=''}
{category_text}: {category_name} | 
{/if}
{author_text}: {author_name} | {comments_text}: {comments_count}
<![CDATA[<br/>]]>
			<![CDATA[<p>
				{article}
			</p>]]>
		</description>

		<guid isPermaLink="false">{create_date} {create_time}</guid>
		<pubDate>{datetime}</pubDate>
	</item>

<!-- END articles -->

	</channel>
</rss>
