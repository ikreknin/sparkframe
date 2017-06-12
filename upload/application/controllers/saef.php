<?php

class Saefcontroller
{
	private $registry;
	private $model;
	private $prefix;
	private $sys_cms;
	private $seg_1;
	private $seg_2;
	private $seg_3;

	public function __construct(Registry $registry, $directCall)
	{
		$this->registry = $registry;
		if ($directCall == true)
		{
			$this->prefix = $this->registry->library('db')->getPrefix();
			$this->sys_cms = $this->registry->library('db')->getSys();
			$this->registry->library('hook')->init();
			$this->registry->library('template')->page()->addTag('footer_hook', '');
			$footer_hook = $this->registry->library('hook')->call('footer_hook');
			$this->registry->library('template')->page()->addTag('footer_hook', $footer_hook);

			$this->registry->library('template')->page()->addTag('footer_1_hook', '');
			$footer_1_hook = $this->registry->library('hook')->call('footer_1_hook');
			$this->registry->library('template')->page()->addTag('footer_1_hook', $footer_1_hook);

			$this->registry->library('template')->page()->addTag('footer_2_hook', '');
			$footer_2_hook = $this->registry->library('hook')->call('footer_2_hook');
			$this->registry->library('template')->page()->addTag('footer_2_hook', $footer_2_hook);

			$this->registry->library('template')->page()->addTag('footer_3_hook', '');
			$footer_3_hook = $this->registry->library('hook')->call('footer_3_hook');
			$this->registry->library('template')->page()->addTag('footer_3_hook', $footer_3_hook);

			$this->registry->library('template')->page()->addTag('before_closing_body_tag_hook', '');
			$before_closing_body_tag_hook = $this->registry->library('hook')->call('before_closing_body_tag_hook');
			$this->registry->library('template')->page()->addTag('before_closing_body_tag_hook', $before_closing_body_tag_hook);
			$this->registry->library('template')->page()->addTag('before_closing_head_tag_hook', '');
			$before_closing_head_tag_hook = $this->registry->library('hook')->call('before_closing_head_tag_hook');
			$this->registry->library('template')->page()->addTag('before_closing_head_tag_hook', $before_closing_head_tag_hook);
			$this->registry->library('template')->page()->addTag('admin_before_closing_head_tag_hook', '');
			$admin_before_closing_head_tag_hook = $this->registry->library('hook')->call('admin_before_closing_head_tag_hook');
			$this->registry->library('template')->page()->addTag('admin_before_closing_head_tag_hook', $admin_before_closing_head_tag_hook);
			$this->registry->library('template')->page()->addTag('charset', $this->registry->setting('settings_charset'));
			$this->registry->library('template')->page()->addTag('metakeywords', $this->registry->setting('settings_metakeywords'));
			$this->registry->library('template')->page()->addTag('metadescription', $this->registry->setting('settings_metadescription'));
			$this->registry->library('template')->addTemplateSegment('top_bar_tpl', 'top_bar_tpl.tpl');
			$this->registry->library('template')->addTemplateSegment('top_menu_tpl', 'top_menu_tpl.tpl');
			$this->registry->library('template')->page()->addTag('VIEWDIR', FWURL . APPDIR . '/views/' . $this->registry->setting('theme') . '/');
			$this->registry->library('template')->page()->addTag('site_url', FWURL);
			$this->registry->library('template')->page()->addTag('CMS0', $this->registry->setting('settings_site0'));
			$this->registry->library('template')->page()->addTag('FORUM0', $this->registry->setting('settings_forum0'));
			$this->registry->library('template')->page()->addTag('SHOP0', $this->registry->setting('settings_shop0'));
			$this->registry->library('template')->page()->addTag('cms_title', $this->registry->setting('settings_cms_title'));
			if ($_SESSION['language'] != '')
			{
				$this->registry->library('lang')->setLanguage($_SESSION['language']);
			}
			else
			{
				$this->registry->library('lang')->setLanguage($this->registry->setting('settings_lang_full'));
			}
			$this->registry->library('lang')->loadLanguage('site');
			$this->registry->library('template')->page()->addTag('cur_lang_code', $this->registry->library('lang')->line('cur_lang_code'));
			$this->registry->library('template')->page()->addTag('lang_code', $this->registry->setting('settings_lang'));
			$this->registry->library('template')->page()->addTag('home', $this->registry->library('lang')->line('home'));
			$this->registry->library('template')->page()->addTag('admin_home', $this->registry->library('lang')->line('admin_home'));
			$this->registry->library('template')->page()->addTag('logout', $this->registry->library('lang')->line('logout'));
			$this->registry->library('template')->page()->addTag('manage_users', $this->registry->library('lang')->line('manage_users'));
			$this->registry->library('template')->page()->addTag('manage_roles', $this->registry->library('lang')->line('manage_roles'));
			$this->registry->library('template')->page()->addTag('manage_perms', $this->registry->library('lang')->line('manage_perms'));
			$this->registry->library('template')->page()->addTag('user_roles', $this->registry->library('lang')->line('user_roles'));
			$this->registry->library('template')->page()->addTag('user_perms', $this->registry->library('lang')->line('user_perms'));
			$this->registry->library('template')->page()->addTag('user_perms', $this->registry->library('lang')->line('create_perm'));
			$this->registry->library('template')->page()->addTag('role_name_text', $this->registry->library('lang')->line('role_name_text'));
			$this->registry->library('template')->page()->addTag('submit', $this->registry->library('lang')->line('submit'));
			$this->registry->library('template')->page()->addTag('delete', $this->registry->library('lang')->line('delete'));
			$this->registry->library('template')->page()->addTag('cancel', $this->registry->library('lang')->line('cancel'));
			$this->registry->library('template')->page()->addTag('allow', $this->registry->library('lang')->line('allow'));
			$this->registry->library('template')->page()->addTag('deny', $this->registry->library('lang')->line('deny'));
			$this->registry->library('template')->page()->addTag('ignore', $this->registry->library('lang')->line('ignore'));
			$this->registry->library('template')->page()->addTag('create_perm', $this->registry->library('lang')->line('create_perm'));
			$this->registry->library('template')->page()->addTag('manage_perm', $this->registry->library('lang')->line('manage_perm'));
			$this->registry->library('template')->page()->addTag('perm_name_text', $this->registry->library('lang')->line('perm_name_text'));
			$this->registry->library('template')->page()->addTag('key', $this->registry->library('lang')->line('key'));
			$this->registry->library('template')->page()->addTag('inherit', $this->registry->library('lang')->line('inherit'));
			$this->registry->library('template')->page()->addTag('member', $this->registry->library('lang')->line('member'));
			$this->registry->library('template')->page()->addTag('not_member', $this->registry->library('lang')->line('not_member'));
			$this->registry->library('template')->page()->addTag('articles', $this->registry->library('lang')->line('articles'));
			$this->registry->library('template')->page()->addTag('create_article', $this->registry->library('lang')->line('create_article'));
			$this->registry->library('template')->page()->addTag('click_here_if', $this->registry->library('lang')->line('click_here_if'));
			$this->registry->library('template')->page()->addTag('date_text', $this->registry->library('lang')->line('date_text'));
			$this->registry->library('template')->page()->addTag('title_text', $this->registry->library('lang')->line('title_text'));
			$this->registry->library('template')->page()->addTag('url_title_text', $this->registry->library('lang')->line('url_title_text'));
			$this->registry->library('template')->page()->addTag('body_text', $this->registry->library('lang')->line('body_text'));
			$this->registry->library('template')->page()->addTag('extended_text', $this->registry->library('lang')->line('extended_text'));
			$this->registry->library('template')->page()->addTag('comment_text', $this->registry->library('lang')->line('comment_text'));
			$this->registry->library('template')->page()->addTag('comments_text', $this->registry->library('lang')->line('comments_text'));
			$this->registry->library('template')->page()->addTag('approved_text', $this->registry->library('lang')->line('approved'));
			$this->registry->library('template')->page()->addTag('edit', $this->registry->library('lang')->line('edit'));
			$this->registry->library('template')->page()->addTag('view', $this->registry->library('lang')->line('view'));
			$this->registry->library('template')->page()->addTag('delete', $this->registry->library('lang')->line('delete'));
			$this->registry->library('template')->page()->addTag('pinned_text', $this->registry->library('lang')->line('pinned'));
			$this->registry->library('template')->page()->addTag('visible_text', $this->registry->library('lang')->line('visible'));
			$this->registry->library('template')->page()->addTag('category_text', $this->registry->library('lang')->line('category_text'));
			$this->registry->library('template')->page()->addTag('categories_text', $this->registry->library('lang')->line('categories_text'));
			$this->registry->library('template')->page()->addTag('create_category', $this->registry->library('lang')->line('create_category'));
			$this->registry->library('template')->page()->addTag('no_categories_yet', $this->registry->library('lang')->line('no_categories_yet'));
			$this->registry->library('template')->page()->addTag('is_children_category', $this->registry->library('lang')->line('is_children_category'));
			$this->registry->library('template')->page()->addTag('yes', $this->registry->library('lang')->line('yes'));
			$this->registry->library('template')->page()->addTag('no', $this->registry->library('lang')->line('no'));
			$this->registry->library('template')->page()->addTag('settings_text', $this->registry->library('lang')->line('settings'));
			$this->registry->library('template')->page()->addTag('parent_id_text', $this->registry->library('lang')->line('parent_id_text'));
			$this->registry->library('template')->page()->addTag('parent_category_text', $this->registry->library('lang')->line('parent_category_text'));
			$this->registry->library('template')->page()->addTag('category_name_text', $this->registry->library('lang')->line('category_name_text'));
			$this->registry->library('template')->page()->addTag('category_url_name_text', $this->registry->library('lang')->line('category_url_name_text'));
			$this->registry->library('template')->page()->addTag('category_description_text', $this->registry->library('lang')->line('category_description_text'));
			$this->registry->library('template')->page()->addTag('category_image_name_text', $this->registry->library('lang')->line('category_image_name_text'));
			$this->registry->library('template')->page()->addTag('short_code', $this->registry->library('lang')->line('short_code'));
			$this->registry->library('template')->page()->addTag('full_code', $this->registry->library('lang')->line('full_code'));
			$this->registry->library('template')->page()->addTag('change_password', $this->registry->library('lang')->line('change_password'));
			$this->registry->library('template')->page()->addTag('current_password', $this->registry->library('lang')->line('current_password'));
			$this->registry->library('template')->page()->addTag('old_password', $this->registry->library('lang')->line('old_password'));
			$this->registry->library('template')->page()->addTag('username_text', $this->registry->library('lang')->line('username_text'));
			$this->registry->library('template')->page()->addTag('password_text', $this->registry->library('lang')->line('password_text'));
			$this->registry->library('template')->page()->addTag('name_text', $this->registry->library('lang')->line('name_text'));
			$this->registry->library('template')->page()->addTag('email_text', $this->registry->library('lang')->line('email_text'));
			$this->registry->library('template')->page()->addTag('active_text', $this->registry->library('lang')->line('active'));
			$this->registry->library('template')->page()->addTag('banned_text', $this->registry->library('lang')->line('banned'));
			$this->registry->library('template')->page()->addTag('ban_text', $this->registry->library('lang')->line('ban'));
			$this->registry->library('template')->page()->addTag('unban_text', $this->registry->library('lang')->line('unban'));
			$this->registry->library('template')->page()->addTag('modules_text', $this->registry->library('lang')->line('modules_text'));
			$this->registry->library('template')->page()->addTag('extensions_text', $this->registry->library('lang')->line('extensions_text'));
			$this->registry->library('template')->page()->addTag('cp', $this->registry->library('lang')->line('cp'));
			$this->registry->library('template')->page()->addTag('acp', $this->registry->library('lang')->line('acp'));
			$this->registry->library('template')->page()->addTag('contact', $this->registry->library('lang')->line('contact'));
			$this->registry->library('template')->page()->addTag('forum_text', $this->registry->library('lang')->line('forum_text'));
			$this->registry->library('template')->page()->addTag('shop_text', $this->registry->library('lang')->line('shop_text'));
			$this->registry->library('template')->page()->addTag('blog_text', $this->registry->library('lang')->line('blog_text'));
			$this->registry->library('template')->page()->addTag('forums_text', $this->registry->library('lang')->line('forums_text'));
			$this->registry->library('template')->page()->addTag('create_forum', $this->registry->library('lang')->line('create_forum'));
			$this->registry->library('template')->page()->addTag('forum_name_text', $this->registry->library('lang')->line('forum_name_text'));
			$this->registry->library('template')->page()->addTag('forum_description_text', $this->registry->library('lang')->line('forum_description_text'));
			$this->registry->library('template')->page()->addTag('no_forums_yet', $this->registry->library('lang')->line('no_forums_yet'));
			$this->registry->library('template')->page()->addTag('shops_text', $this->registry->library('lang')->line('shops_text'));
			$this->registry->library('template')->page()->addTag('create_shop', $this->registry->library('lang')->line('create_shop'));
			$this->registry->library('template')->page()->addTag('shop_name_text', $this->registry->library('lang')->line('shop_name_text'));
			$this->registry->library('template')->page()->addTag('shop_description_text', $this->registry->library('lang')->line('shop_description_text'));
			$this->registry->library('template')->page()->addTag('no_shops_yet', $this->registry->library('lang')->line('no_shops_yet'));
			$this->registry->library('template')->page()->addTag('new_shop', $this->registry->library('lang')->line('new_shop'));
			$this->registry->library('template')->page()->addTag('protected', $this->registry->library('lang')->line('protected'));
			$this->registry->library('template')->page()->addTag('this_role_protected', $this->registry->library('lang')->line('this_role_protected'));
			$this->registry->library('template')->page()->addTag('go_to_article', $this->registry->library('lang')->line('go_to_article'));
			$this->registry->library('template')->page()->addTag('go_to_comment', $this->registry->library('lang')->line('go_to_comment'));
			$this->registry->library('template')->page()->addTag('forum_categories_list', $this->registry->library('lang')->line('forum_categories_list'));
			$this->registry->library('template')->page()->addTag('create_forum_category', $this->registry->library('lang')->line('create_forum_category'));
			$this->registry->library('template')->page()->addTag('forum_category_text', $this->registry->library('lang')->line('forum_category_text'));
			$this->registry->library('template')->page()->addTag('forum_category_description_text', $this->registry->library('lang')->line('forum_category_description_text'));
			$this->registry->library('template')->page()->addTag('create_forum_category_text', $this->registry->library('lang')->line('create_forum_category_text'));
			$this->registry->library('template')->page()->addTag('welcome', $this->registry->library('lang')->line('welcome'));
			$this->registry->library('template')->page()->addTag('registration', $this->registry->library('lang')->line('registration'));
			$this->registry->library('template')->page()->addTag('add_cf', $this->registry->library('lang')->line('add_cf'));
			$this->registry->library('template')->page()->addTag('list_cf', $this->registry->library('lang')->line('list_cf'));
			$this->registry->library('template')->page()->addTag('field_name', $this->registry->library('lang')->line('field_name'));
			$this->registry->library('template')->page()->addTag('field_url_title', $this->registry->library('lang')->line('field_url_title'));
			$this->registry->library('template')->page()->addTag('field_description', $this->registry->library('lang')->line('field_description'));
			$this->registry->library('template')->page()->addTag('field_type', $this->registry->library('lang')->line('field_type'));
			$this->registry->library('template')->page()->addTag('field_value', $this->registry->library('lang')->line('field_value'));
			$this->registry->library('template')->page()->addTag('cms_section', $this->registry->library('lang')->line('cms_section'));
			$this->registry->library('template')->page()->addTag('required_field', $this->registry->library('lang')->line('required_field'));
			$this->registry->library('template')->page()->addTag('users_text', $this->registry->library('lang')->line('users_text'));
			$this->registry->library('template')->page()->addTag('system', $this->registry->library('lang')->line('system'));
			$this->registry->library('template')->page()->addTag('sites', $this->registry->library('lang')->line('sites'));
			$this->registry->library('template')->page()->addTag('add_site', $this->registry->library('lang')->line('add_site'));
			$this->registry->library('template')->page()->addTag('delete_site', $this->registry->library('lang')->line('delete_site'));
			$this->registry->library('template')->page()->addTag('delete_question', $this->registry->library('lang')->line('delete_question'));
			$this->registry->library('template')->page()->addTag('sections_text', $this->registry->library('lang')->line('sections_text'));
			$this->registry->library('template')->page()->addTag('pages_text', $this->registry->library('lang')->line('pages_text'));
			$this->registry->library('template')->page()->addTag('create_page', $this->registry->library('lang')->line('create_page'));
			$this->registry->library('template')->page()->addTag('parent_page_text', $this->registry->library('lang')->line('parent_page_text'));
			$this->registry->library('template')->page()->addTag('page_title_text', $this->registry->library('lang')->line('page_title_text'));
			$this->registry->library('template')->page()->addTag('page_url_name_text', $this->registry->library('lang')->line('page_url_name_text'));
			$this->registry->library('template')->page()->addTag('page_description_text', $this->registry->library('lang')->line('page_description_text'));
			$this->registry->library('template')->page()->addTag('page_content_text', $this->registry->library('lang')->line('page_content_text'));
			$this->registry->library('template')->page()->addTag('no_pages_yet', $this->registry->library('lang')->line('no_pages_yet'));
			$this->registry->library('template')->page()->addTag('static_page_header', $this->registry->library('lang')->line('static_page_header'));
			$this->registry->library('template')->page()->addTag('static_page_main', $this->registry->library('lang')->line('static_page_main'));
			$this->registry->library('template')->page()->addTag('static_page_footer', $this->registry->library('lang')->line('static_page_footer'));
			$this->registry->library('template')->page()->addTag('web_url_text', $this->registry->library('lang')->line('web_url_text'));
			$this->registry->library('template')->page()->addTag('pages_text', $this->registry->library('lang')->line('pages_text'));
			$this->registry->library('template')->page()->addTag('blocks_text', $this->registry->library('lang')->line('blocks_text'));
			$this->registry->library('template')->page()->addTag('edit_articles', $this->registry->library('lang')->line('edit_articles'));
			$uid = $this->registry->library('authenticate')->getUserID();
			$this->registry->library('authenticate')->buildUserPermissions($uid);
			if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
			{
				$this->registry->library('template')->page()->addTag('admin_level', '1');
			}
			else
			{
				$this->registry->library('template')->page()->addTag('admin_level', '0');
			}
			$un = $this->registry->library('authenticate')->getUsername();
			if ($un != '' && $uid > 0)
			{
				$this->registry->library('template')->page()->addTag('visitor_user_id', $uid);
				$this->registry->library('template')->page()->addTag('visitor_username', $un);
			}
			else
			{
				$this->registry->library('template')->page()->addTag('visitor_user_id', 0);
				$this->registry->library('template')->page()->addTag('visitor_username', '');
			}
			$startyear = $this->registry->setting('settings_startyear');
			$copyright_years = $this->registry->library('helper')->copyright_years($startyear);
			$this->registry->library('template')->page()->addTag('copyright_years', $copyright_years);
//
			$w = $this->registry->widget('latest_comments_plus_widget')->index(5);
			$this->registry->library('template')->addWidgetTag('latest_comments_plus_widget', $w);
//
//
			$w = $this->registry->widget('latest_topics_plus_widget')->index(5);
			$this->registry->library('template')->addWidgetTag('latest_topics_plus_widget', $w);
//
//
			$w = $this->registry->widget('latest_posts_plus_widget')->index(5);
			$this->registry->library('template')->addWidgetTag('latest_posts_plus_widget', $w);
//
//
			$w = $this->registry->widget('latest_opinions_plus_widget')->index(5);
			$this->registry->library('template')->addWidgetTag('latest_opinions_plus_widget', $w);
//
			$urlSegments = $this->registry->getURLSegments();
			$this->seg_1 = $this->registry->library('db')->sanitizeData($urlSegments[1]);
			$this->seg_2 = $this->registry->library('db')->sanitizeData($urlSegments[2]);
			$this->seg_3 = $this->registry->library('db')->sanitizeData($urlSegments[3]);
			if (true)
			{
				$this->registry->library('template')->page()->addTag('jquery', '<script type="text/javascript" src="' . FWURL . 'js/jquery/' . $this->registry->setting('settings_jquery') . '"></script>');
			}
			else
			{
				$this->registry->library('template')->page()->addTag('jquery', '');
			}
			$this->registry->library('template')->page()->addTag('editor_type', $this->registry->setting('settings_editor'));
			$this->registry->library('template')->page()->addTag('editor', '');
			$this->registry->library('template')->page()->addTag('highlighter', '');
			if (($this->seg_1 == '' || $this->seg_1 == 'create_article' || $this->seg_1 == 'edit_article' || ($this->seg_1 == 'edit_page') || ($this->seg_1 == 'create_page')) && $this->registry->setting('settings_editor') == 't')
			{
				$this->registry->library('template')->page()->addTag('editor', '<script type="text/javascript" src="' . FWURL . 'js/tinymce/tinymce.min.js"></script>
<script>
tinymce.init({
    selector: "textarea",
    theme: "modern",
    plugins: [
         "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker sh4tinymce",
         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
         "save table contextmenu directionality emoticons template paste textcolor"
   ],
   toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons | sh4tinymce", 
   style_formats: [
        {title: \'Bold text\', inline: \'b\'},
        {title: \'Red text\', inline: \'span\', styles: {color: \'#ff0000\'}},
        {title: \'Red header\', block: \'h1\', styles: {color: \'#ff0000\'}},
        {title: \'Example 1\', inline: \'span\', classes: \'example1\'},
        {title: \'Example 2\', inline: \'span\', classes: \'example2\'},
        {title: \'Table styles\'},
        {title: \'Table row 1\', selector: \'tr\', classes: \'tablerow1\'}
    ]
 }); 
</script>');
				$this->registry->library('template')->page()->addTag('highlighter', '
<link href="' . FWURL . '/js/ckeditor/plugins/codesnippet/lib/highlight/styles/dark.css" rel="stylesheet">
<script src="' . FWURL . '/js/ckeditor/plugins/codesnippet/lib/highlight/highlight.pack.js"></script>
<script>hljs.initHighlightingOnLoad();</script>

<script type="text/javascript" src="' . FWURL . 'js/syntaxhighlighter/scripts/shCore.js"></script>
<script type="text/javascript" src="' . FWURL . 'js/syntaxhighlighter/scripts/shBrushCss.js"></script>
<script type="text/javascript" src="' . FWURL . 'js/syntaxhighlighter/scripts/shBrushJScript.js"></script>
<script type="text/javascript" src="' . FWURL . 'js/syntaxhighlighter/scripts/shBrushPhp.js"></script>
<script type="text/javascript" src="' . FWURL . 'js/syntaxhighlighter/scripts/shBrushCpp.js"></script>
<script type="text/javascript" src="' . FWURL . 'js/syntaxhighlighter/scripts/shBrushCSharp.js"></script>
<link href="' . FWURL . 'js/syntaxhighlighter/styles/shCore.css" rel="stylesheet" type="text/css" />
<link href="' . FWURL . 'js/syntaxhighlighter/styles/shThemeDefault.css" rel="stylesheet" type="text/css" />
<script>
$(document).ready(function () {
  SyntaxHighlighter.all();   
});
</script>
');
			}
			if (($this->seg_1 == '' || $this->seg_1 == 'create_article' || $this->seg_1 == 'edit_article' || ($this->seg_1 == 'edit_page') || ($this->seg_1 == 'create_page')) && $this->registry->setting('settings_editor') == 'c')
			{
				$this->registry->library('template')->page()->addTag('editor', '<script type="text/javascript" src="' . FWURL . 'js/ckeditor/ckeditor.js"></script>');
			}
			if ($this->seg_1 == 'edit_comment')
			{
				$this->registry->library('template')->page()->addTag('bbcodeeditor', "<link rel=\"stylesheet\" href=\"" . FWURL . "js/sceditor/minified/themes/default.min.css\" type=\"text/css\" media=\"all\" />
<script src=\"" . FWURL . "js/sceditor/minified/jquery.sceditor.bbcode.min.js\"></script>
<script>
	var loadCSS = function(url, callback){
		var link = document.createElement('link');
		link.type = 'text/css';
		link.rel = 'stylesheet';
		link.href = url;
		link.id = 'theme-style';
		document.getElementsByTagName('head')[0].appendChild(link);
		var img = document.createElement('img');
		img.onerror = function(){
			if(callback) callback(link);
		}
		img.src = url;
	}
	$(document).ready(function() {
		var initEditor = function() {
			$(\"textarea\").sceditor({
				plugins: 'bbcode',
				toolbar: \"bold,italic,underline,strike|quote,link,unlink,image,emoticon|maximize,source\",
				emoticonsRoot: \"" . FWURL . "js/\",
				style: \"" . FWURL . "js/sceditor/minified/jquery.sceditor.default.min.css\"
			});
		};
		$(\"#theme\").change(function() {
			var theme = \"" . FWURL . "js/sceditor/minified/themes/default.min.css\";
			$(\"textarea\").sceditor(\"instance\").destroy();
			$(\"link:first\").remove();
			$(\"#theme-style\").remove();
			loadCSS(theme, initEditor);
		});
		initEditor();
	});
</script>");
			}
			else
			{
				$this->registry->library('template')->page()->addTag('bbcodeeditor', '');
			}
			$controller_init_hook = $this->registry->library('hook')->call('controller_init_hook');
			if ($this->seg_1 == '')
			{
				$this->create_article();
			}
			else
			{
				switch ($this->seg_1)
				{

					case 'creating_article' :
						$this->creating_article();
						break;

					default :
						$this->pageNotFound();
						break;
				}
			}
		}
	}

	private function pageNotFound()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', '404 Not Found');
		$this->registry->library('template')->page()->addTag('heading', 'Page Not Found');
		$this->registry->library('template')->build('header.tpl', '404.tpl', 'footer.tpl');
	}

	private function create_article()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		$this->registry->library('template')->page()->addTag('author_id', $this->registry->library('authenticate')->getUserID());
		$this->registry->library('template')->page()->addTag('error_message', '');
		if ($this->registry->library('authenticate')->hasPermission('publish_articles') == true)
		{
			$categories_available = '';
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'categories
			WHERE categories_sys = "' . $this->sys_cms . '"
			ORDER BY category_order ASC';
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
			{
				$categories_available = 'y';
				$data = $this->registry->library('db')->rowsFromCache($cache);
				if ($this->registry->setting('settings_one_cat') == 0)
				{
					$html = $this->registry->library('helper')->adminCatCheckBoxList($data);
				}
				else
				{
					$html = $this->registry->library('helper')->adminCatDropDownList($data);
				}
			}
			$this->registry->library('template')->page()->addTag('adminCatCheckBoxList', $html);
			$this->registry->library('template')->page()->addTag('categories_available', $categories_available);
			$this->registry->library('template')->page()->addTag('art_created', date("Y-m-d H:i:s", time()));
			$this->registry->library('template')->page()->addTag('title', '');
			$this->registry->library('template')->page()->addTag('url_title', '');
			$this->registry->library('template')->page()->addTag('article', '');
			$this->registry->library('template')->page()->addTag('article_extended', '');
//
			$cache = $this->registry->library('db')->cacheQuery('SELECT *
			FROM ' . $this->prefix . 'c_fields_created
			WHERE c_fields_created_sys = "' . $this->sys_cms . '"
			AND (c_created_type = 1 OR c_created_type = 2)');
			$this->registry->library('template')->page()->addTag('custom_fields_12', array('SQL', $cache));
			$stringField3 = '';
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'c_fields_created
			WHERE c_fields_created_sys = "' . $this->sys_cms . '"
			AND c_created_type = 3';
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
			{
				$fields = array();
				$skip = 0;
				$num = $this->registry->library('db')->numRowsFromCache($cache);
				$data = $this->registry->library('db')->rowsFromCache($cache);
				foreach ($data as $k => $v)
				{
					if ($skip == 0)
					{
						$stringField3 .= $v['c_created_name'] . '<br /><select name="custom_field_' . $v['c_created_id'] . '">';
						$skip = 1;
					}
					$array1 = explode("|", $v['c_type_default_value']);
					foreach ($array1 as $key => $value)
					{
						$stringField3 .= '<option value="' . $value . '">' . $value . '</option>';
					}
				}
				$stringField3 .= '</select>';
			}
			$this->registry->library('template')->page()->addTag('stringField3', $stringField3);
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('new_article'));
			$this->registry->library('template')->build('saef/saef_header.tpl', 'saef/saef_articles_create.tpl', 'saef/saef_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function creating_article()
	{
		if ($this->registry->library('authenticate')->hasPermission('publish_articles') == true)
		{
			$this->registry->library('template')->page()->addTag('author_id', $this->registry->library('authenticate')->getUserID());
//			if($_POST['title'] == '' || $_POST['url_title'] == '' || $_POST['article'] == '')
			if ($_POST['title'] == '' || $_POST['article'] == '')
			{
				$this->registry->library('template')->page()->addTag('error_message', $this->registry->library('lang')->line('insufficient_data'));
				$this->registry->library('template')->page()->addTag('art_created', $this->registry->library('db')->sanitizeData($_POST['art_created']));
				$this->registry->library('template')->page()->addTag('title', $this->registry->library('db')->sanitizeData($_POST['title']));
				$this->registry->library('template')->page()->addTag('url_title', $this->registry->library('db')->sanitizeData($_POST['url_title']));
				$this->registry->library('template')->page()->addTag('article', $this->registry->library('db')->sanitizeData($_POST['article']));
				$this->registry->library('template')->page()->addTag('article_extended', $this->registry->library('db')->sanitizeData($_POST['article_extended']));
				$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('new_article'));
				$this->registry->library('template')->page()->addTag('article_visible', $this->registry->library('db')->sanitizeData($_POST['article_visible']));
				$this->registry->library('template')->page()->addTag('pinned', $this->registry->library('db')->sanitizeData($_POST['pinned']));
				$cache = $this->registry->library('db')->cacheQuery('SELECT *
			FROM ' . $this->prefix . 'c_fields_created
			WHERE c_fields_created_sys = "' . $this->sys_cms . '"
			AND (c_created_type = 1 OR c_created_type = 2)');
				$this->registry->library('template')->page()->addTag('custom_fields_12', array('SQL', $cache));
				$stringField3 = '';
				$sql = 'SELECT *
			FROM ' . $this->prefix . 'c_fields_created
			WHERE c_fields_created_sys = "' . $this->sys_cms . '"
			AND c_created_type = 3';
				$cache = $this->registry->library('db')->cacheQuery($sql);
				if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
				{
					$fields = array();
					$skip = 0;
					$num = $this->registry->library('db')->numRowsFromCache($cache);
					$data = $this->registry->library('db')->rowsFromCache($cache);
					foreach ($data as $k => $v)
					{
						if ($skip == 0)
						{
							$stringField3 .= $v['c_created_name'] . '<br /><select name="custom_field_' . $v['c_created_id'] . '">';
							$skip = 1;
						}
						$array1 = explode("|", $v['c_type_default_value']);
						foreach ($array1 as $key => $value)
						{
							$stringField3 .= '<option value="' . $value . '">' . $value . '</option>';
						}
					}
					$stringField3 .= '</select>';
				}
				$this->registry->library('template')->page()->addTag('stringField3', $stringField3);
				$categories_available = '';
				$sql = 'SELECT *
			FROM ' . $this->prefix . 'categories
			WHERE categories_sys = "' . $this->sys_cms . '"
			ORDER BY category_order ASC';
				$cache = $this->registry->library('db')->cacheQuery($sql);
				if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
				{
					$categories_available = 'y';
					$data = $this->registry->library('db')->rowsFromCache($cache);
					if ($this->registry->setting('settings_one_cat') == 0)
					{
						$html = $this->registry->library('helper')->adminCatCheckBoxList($data);
					}
					else
					{
						$html = $this->registry->library('helper')->adminCatDropDownList($data);
					}
				}
				$this->registry->library('template')->page()->addTag('adminCatCheckBoxList', $html);
				$this->registry->library('template')->page()->addTag('categories_available', $categories_available);
				$this->registry->library('template')->build('saef/saef_header.tpl', 'saef/saef_articles_create.tpl', 'saef/saef_footer.tpl');
			}
			elseif ($this->registry->library('helper')->firstCharacterCheck($_POST['url_title']))
			{
				$this->registry->library('template')->page()->addTag('error_message', $this->registry->library('lang')->line('first_character_number'));
				$this->registry->library('template')->page()->addTag('art_created', $this->registry->library('db')->sanitizeData($_POST['art_created']));
				$this->registry->library('template')->page()->addTag('title', $this->registry->library('db')->sanitizeData($_POST['title']));
				$this->registry->library('template')->page()->addTag('url_title', $this->registry->library('db')->sanitizeData($_POST['url_title']));
				$this->registry->library('template')->page()->addTag('article', $this->registry->library('db')->sanitizeData($_POST['article']));
				$this->registry->library('template')->page()->addTag('article_extended', $this->registry->library('db')->sanitizeData($_POST['article_extended']));
				$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('new_article'));
				$this->registry->library('template')->page()->addTag('article_visible', $this->registry->library('db')->sanitizeData($_POST['article_visible']));
				$this->registry->library('template')->page()->addTag('pinned', $this->registry->library('db')->sanitizeData($_POST['pinned']));
				$cache = $this->registry->library('db')->cacheQuery('SELECT *
			FROM ' . $this->prefix . 'c_fields_created
			WHERE c_fields_created_sys = "' . $this->sys_cms . '"
			AND (c_created_type = 1 OR c_created_type = 2)');
				$this->registry->library('template')->page()->addTag('custom_fields_12', array('SQL', $cache));
				$stringField3 = '';
				$sql = 'SELECT *
			FROM ' . $this->prefix . 'c_fields_created
			WHERE c_fields_created_sys = "' . $this->sys_cms . '"
			AND c_created_type = 3';
				$cache = $this->registry->library('db')->cacheQuery($sql);
				if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
				{
					$fields = array();
					$skip = 0;
					$num = $this->registry->library('db')->numRowsFromCache($cache);
					$data = $this->registry->library('db')->rowsFromCache($cache);
					foreach ($data as $k => $v)
					{
						if ($skip == 0)
						{
							$stringField3 .= $v['c_created_name'] . '<br /><select name="custom_field_' . $v['c_created_id'] . '">';
							$skip = 1;
						}
						$array1 = explode("|", $v['c_type_default_value']);
						foreach ($array1 as $key => $value)
						{
							$stringField3 .= '<option value="' . $value . '">' . $value . '</option>';
						}
					}
					$stringField3 .= '</select>';
				}
				$this->registry->library('template')->page()->addTag('stringField3', $stringField3);
				$categories_available = '';
				$sql = 'SELECT *
			FROM ' . $this->prefix . 'categories
			WHERE categories_sys = "' . $this->sys_cms . '"
			ORDER BY category_order ASC';
				$cache = $this->registry->library('db')->cacheQuery($sql);
				if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
				{
					$categories_available = 'y';
					$data = $this->registry->library('db')->rowsFromCache($cache);
					if ($this->registry->setting('settings_one_cat') == 0)
					{
						$html = $this->registry->library('helper')->adminCatCheckBoxList($data);
					}
					else
					{
						$html = $this->registry->library('helper')->adminCatDropDownList($data);
					}
				}
				$this->registry->library('template')->page()->addTag('adminCatCheckBoxList', $html);
				$this->registry->library('template')->page()->addTag('categories_available', $categories_available);
				$this->registry->library('template')->build('saef/saef_header.tpl', 'saef/saef_articles_create.tpl', 'saef/saef_footer.tpl');
			}
			else
			{
// Caching OFF
				$this->registry->library('db')->setCacheOn(0);
// To add Article
				$data = array();
				$data['author_id'] = $this->registry->library('authenticate')->getUserID();
				$data['art_created'] = $this->registry->library('db')->sanitizeData($_POST['art_created']);
				$data['title'] = $this->registry->library('db')->sanitizeData($_POST['title']);
				$data['url_title'] = $this->registry->library('db')->sanitizeData($_POST['url_title']);
				$data['article'] = $this->registry->library('db')->sanitizeData($_POST['article']);
				$data['article_extended'] = $this->registry->library('db')->sanitizeData($_POST['article_extended']);
				$data['article_visible'] = $this->registry->library('db')->sanitizeData($_POST['article_visible']);
				$data['pinned'] = $this->registry->library('db')->sanitizeData($_POST['pinned']);
				if ($this->registry->setting('settings_one_cat') == 1)
				{
					$data['categories'] = $this->registry->library('db')->sanitizeData($_POST['catOne']);
				}
				$this->registry->library('db')->insertRecordsSys('articles', $data);
// To add Categories
				$lastInsertID = $this->registry->library('db')->lastInsertID();
				$data = array();
				if ($this->registry->setting('settings_one_cat') == 0)
				{
					$catGroup = $_POST['catGroup'];
					$how_many = count($catGroup);
				}
				else
				{
					$catOne = $_POST['catOne'];
					$how_many = 1;
				}
				for ($i = 0; $i < $how_many; $i++)
				{
					$data[$i] = array();
					$data[$i]['ac_art_id'] = $lastInsertID;
					if ($this->registry->setting('settings_one_cat') == 0)
					{
						$data[$i]['ac_cats_id'] = $catGroup[$i];
					}
					else
					{
						$data[$i]['ac_cats_id'] = $catOne;
					}
					$this->registry->library('db')->insertRecordsSys('art_cats', $data[$i]);
				}
// Custom Fields Start
				$sql = 'select *, c_type_name
		FROM ' . $this->prefix . 'c_fields_created
		LEFT JOIN ' . $this->prefix . 'c_fields_types ON ' . $this->prefix . 'c_fields_created.c_created_type = ' . $this->prefix . 'c_fields_types.c_types_id
		WHERE c_fields_created_sys = "' . $this->sys_cms . '"
		AND c_created_site_section = "b"';
				$cache = $this->registry->library('db')->cacheQuery($sql);
				if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
				{
					$fields = array();
					$num = $this->registry->library('db')->numRowsFromCache($cache);
					$data = $this->registry->library('db')->rowsFromCache($cache);
					foreach ($data as $k => $v)
					{
						if ($_POST['custom_field_' . $v['c_created_id']] != '')
						{
							$arr[$k]['c_name_id'] = $v['c_created_id'];
							$arr[$k]['c_body'] = $_POST['custom_field_' . $v['c_created_id']];
							$arr[$k]['c_art_id'] = $lastInsertID;
							$this->registry->library('db')->insertRecordsSys('c_fields', $arr[$k]);
						}
					}
				}
// Custom Fields End
// Restore CacheOn & Delete Cache
				$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
				if ($this->registry->setting('settings_cached') == 1)
				{
					$this->registry->library('db')->deleteCache('cache_', true);
				}
				$this->registry->redirectUser('', $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
			}
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

}
?>