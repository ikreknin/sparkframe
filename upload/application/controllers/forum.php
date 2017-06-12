<?php

class Forumcontroller
{
	private $registry;
	private $model;
	private $prefix;
	private $sys_cms;
	private $guests_allowed;
	private $guests_posts_allowed;
	private $seg_1;
	private $seg_2;
	private $seg_3;
	private $seg_4;

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

			$this->registry->library('template')->page()->addTag('footer_4_hook', '');
			$footer_3_hook = $this->registry->library('hook')->call('footer_4_hook');
			$this->registry->library('template')->page()->addTag('footer_4_hook', $footer_4_hook);

			$this->registry->library('template')->page()->addTag('before_closing_body_tag_hook', '');
			$before_closing_body_tag_hook = $this->registry->library('hook')->call('before_closing_body_tag_hook');
			$this->registry->library('template')->page()->addTag('before_closing_body_tag_hook', $before_closing_body_tag_hook);
			$this->registry->library('template')->page()->addTag('before_closing_head_tag_hook', '');
			$before_closing_head_tag_hook = $this->registry->library('hook')->call('before_closing_head_tag_hook');
			$this->registry->library('template')->page()->addTag('before_closing_head_tag_hook', $before_closing_head_tag_hook);
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
			$this->registry->library('template')->page()->addTag('VIEWDIR', FWURL . APPDIR . '/views/' . $this->registry->setting('theme') . '/');
			$this->registry->library('template')->page()->addTag('site_url', FWURL);
			$this->registry->library('template')->page()->addTag('CMS0', $this->registry->setting('settings_site0'));
			$this->registry->library('template')->page()->addTag('FORUM0', $this->registry->setting('settings_forum0'));
			$this->registry->library('template')->page()->addTag('SHOP0', $this->registry->setting('settings_shop0'));
			$this->registry->library('template')->page()->addTag('cms_title', $this->registry->setting('settings_cms_title'));
			$this->registry->library('template')->page()->addTag('charset', $this->registry->setting('settings_charset'));
			$this->registry->library('template')->page()->addTag('metakeywords', $this->registry->setting('settings_metakeywords'));
			$this->registry->library('template')->page()->addTag('metadescription', $this->registry->setting('settings_metadescription'));
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('forum_text'));
			$this->registry->library('template')->page()->addTag('home', $this->registry->library('lang')->line('home'));
			$this->registry->library('template')->page()->addTag('admin_home', $this->registry->library('lang')->line('admin_home'));
			$this->registry->library('template')->page()->addTag('author_text', $this->registry->library('lang')->line('author_text'));
			$this->registry->library('template')->page()->addTag('date', $this->registry->library('lang')->line('date'));
			$this->registry->library('template')->page()->addTag('time', $this->registry->library('lang')->line('time'));
			$this->registry->library('template')->page()->addTag('login', $this->registry->library('lang')->line('login'));
			$this->registry->library('template')->page()->addTag('logout', $this->registry->library('lang')->line('logout'));
			$this->registry->library('template')->page()->addTag('read_more', $this->registry->library('lang')->line('read_more'));
			$this->registry->library('template')->page()->addTag('published', $this->registry->library('lang')->line('published'));
			$this->registry->library('template')->page()->addTag('comment_text', $this->registry->library('lang')->line('comment_text'));
			$this->registry->library('template')->page()->addTag('your_name', $this->registry->library('lang')->line('your_name'));
			$this->registry->library('template')->page()->addTag('your_comment', $this->registry->library('lang')->line('your_comment'));
			$this->registry->library('template')->page()->addTag('add_comment', $this->registry->library('lang')->line('add_comment'));
			$this->registry->library('template')->page()->addTag('your_email', $this->registry->library('lang')->line('your_email'));
			$this->registry->library('template')->page()->addTag('your_website', $this->registry->library('lang')->line('your_website'));
			$this->registry->library('template')->page()->addTag('comments_text', $this->registry->library('lang')->line('comments_text'));
			$this->registry->library('template')->page()->addTag('approved_text', $this->registry->library('lang')->line('approved'));
			$this->registry->library('template')->page()->addTag('visible_text', $this->registry->library('lang')->line('visible'));
			$this->registry->library('template')->page()->addTag('edit', $this->registry->library('lang')->line('edit'));
			$this->registry->library('template')->page()->addTag('view', $this->registry->library('lang')->line('view'));
			$this->registry->library('template')->page()->addTag('delete', $this->registry->library('lang')->line('delete'));
			$this->registry->library('template')->page()->addTag('guest', $this->registry->library('lang')->line('guest'));
			$this->registry->library('template')->page()->addTag('no_comments_yet', $this->registry->library('lang')->line('no_comments_yet'));
			$this->registry->library('template')->page()->addTag('category_text', $this->registry->library('lang')->line('category_text'));
			$this->registry->library('template')->page()->addTag('categories_text', $this->registry->library('lang')->line('categories_text'));
			$this->registry->library('template')->page()->addTag('no_categories_yet', $this->registry->library('lang')->line('no_categories_yet'));
			$this->registry->library('template')->page()->addTag('no_right_to_comment', $this->registry->library('lang')->line('no_right_to_comment'));
			$this->registry->library('template')->page()->addTag('commenting_disabled', $this->registry->library('lang')->line('commenting_disabled'));
			$this->registry->library('template')->page()->addTag('username_text', $this->registry->library('lang')->line('username_text'));
			$this->registry->library('template')->page()->addTag('password_text', $this->registry->library('lang')->line('password_text'));
			$this->registry->library('template')->page()->addTag('edit_this', $this->registry->library('lang')->line('edit_this'));
			$this->registry->library('template')->page()->addTag('cp', $this->registry->library('lang')->line('cp'));
			$this->registry->library('template')->page()->addTag('forum_text', $this->registry->library('lang')->line('forum_text'));
			$this->registry->library('template')->page()->addTag('shop_text', $this->registry->library('lang')->line('shop_text'));
			$this->registry->library('template')->page()->addTag('blog_text', $this->registry->library('lang')->line('blog_text'));
			$this->registry->library('template')->page()->addTag('forums_text', $this->registry->library('lang')->line('forums_text'));
			$this->registry->library('template')->page()->addTag('forum_name_text', $this->registry->library('lang')->line('forum_name_text'));
			$this->registry->library('template')->page()->addTag('forum_description_text', $this->registry->library('lang')->line('forum_description_text'));
			$this->registry->library('template')->page()->addTag('latest_post_text', $this->registry->library('lang')->line('latest_post_text'));
			$this->registry->library('template')->page()->addTag('topics_text', $this->registry->library('lang')->line('topics_text'));
			$this->registry->library('template')->page()->addTag('posts_text', $this->registry->library('lang')->line('posts_text'));
			$this->registry->library('template')->page()->addTag('user_created_date_text', $this->registry->library('lang')->line('user_created_date_text'));
			$this->registry->library('template')->page()->addTag('click_here_if', $this->registry->library('lang')->line('click_here_if'));
			$this->registry->library('template')->page()->addTag('sections_text', $this->registry->library('lang')->line('sections_text'));
			$this->registry->library('template')->page()->addTag('delete_question', $this->registry->library('lang')->line('delete_question'));
			$this->registry->library('template')->page()->addTag('sites', $this->registry->library('lang')->line('sites'));
			$this->registry->library('template')->page()->addTag('add_site', $this->registry->library('lang')->line('add_site'));
			$this->registry->library('template')->page()->addTag('delete_site', $this->registry->library('lang')->line('delete_site'));
			$this->registry->library('template')->page()->addTag('forums_text', $this->registry->library('lang')->line('forums_text'));
			$this->registry->library('template')->page()->addTag('shops_text', $this->registry->library('lang')->line('shops_text'));
			$this->registry->library('template')->page()->addTag('manage_users', $this->registry->library('lang')->line('manage_users'));
			$this->registry->library('template')->page()->addTag('manage_roles', $this->registry->library('lang')->line('manage_roles'));
			$this->registry->library('template')->page()->addTag('manage_perms', $this->registry->library('lang')->line('manage_perms'));
			$this->registry->library('template')->page()->addTag('create_article', $this->registry->library('lang')->line('create_article'));
			$this->registry->library('template')->page()->addTag('edit_articles', $this->registry->library('lang')->line('edit_articles'));
			$this->registry->library('template')->page()->addTag('comments_text', $this->registry->library('lang')->line('comments_text'));
			$this->registry->library('template')->page()->addTag('categories_text', $this->registry->library('lang')->line('categories_text'));
			$this->registry->library('template')->page()->addTag('forum_categories_list', $this->registry->library('lang')->line('forum_categories_list'));
			$this->registry->library('template')->page()->addTag('settings_text', $this->registry->library('lang')->line('settings'));
			$this->registry->library('template')->page()->addTag('pages_text', $this->registry->library('lang')->line('pages_text'));
			$this->registry->library('template')->page()->addTag('blocks_text', $this->registry->library('lang')->line('blocks_text'));
			$this->registry->library('template')->page()->addTag('change_password', $this->registry->library('lang')->line('change_password'));
			$this->registry->library('template')->page()->addTag('modules_text', $this->registry->library('lang')->line('modules_text'));
			$this->registry->library('template')->page()->addTag('extensions_text', $this->registry->library('lang')->line('extensions_text'));
			$this->registry->library('template')->page()->addTag('add_cf', $this->registry->library('lang')->line('add_cf'));
			$this->registry->library('template')->page()->addTag('list_cf', $this->registry->library('lang')->line('list_cf'));
			$this->registry->library('template')->page()->addTag('users_text', $this->registry->library('lang')->line('users_text'));
			$this->registry->library('template')->page()->addTag('system', $this->registry->library('lang')->line('system'));
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
			if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('post_comments') == true)
			{
				$this->registry->library('template')->page()->addTag('comments_level', '1');
			}
			else
			{
				$this->registry->library('template')->page()->addTag('comments_level', '0');
			}
			if ($this->registry->setting('settings_enable_comments') == 1)
			{
				$this->registry->library('template')->page()->addTag('comments_allowed', '1');
			}
			else
			{
				$this->registry->library('template')->page()->addTag('comments_allowed', '0');
			}
			$this->guests_allowed = 1;
			$this->registry->library('template')->page()->addTag('guests_allowed', $this->guests_allowed);
			$this->guests_comments_allowed = 1;
			$this->registry->library('template')->page()->addTag('guests_posts_allowed', $this->guests_posts_allowed);
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
			$this->registry->library('template')->page()->addTag('no_forums_yet', $this->registry->library('lang')->line('no_forums_yet'));
			$this->registry->library('template')->page()->addTag('new_topic', $this->registry->library('lang')->line('new_topic'));
			$this->registry->library('template')->page()->addTag('new_post', $this->registry->library('lang')->line('new_post'));
			$this->registry->library('template')->page()->addTag('title_text', $this->registry->library('lang')->line('title_text'));
			$this->registry->library('template')->page()->addTag('topic_text', $this->registry->library('lang')->line('topic_text'));
			$this->registry->library('template')->page()->addTag('post_text', $this->registry->library('lang')->line('post_text'));
			$this->registry->library('template')->page()->addTag('submit', $this->registry->library('lang')->line('submit'));
			$this->registry->library('template')->page()->addTag('welcome', $this->registry->library('lang')->line('welcome'));
			$this->registry->library('template')->page()->addTag('registration', $this->registry->library('lang')->line('registration'));
			$this->registry->library('template')->page()->addTag('contact', $this->registry->library('lang')->line('contact'));

			$this->registry->library('template')->addTemplateSegment('top_1_tpl', 'top_1_tpl.tpl');
			$this->registry->library('template')->addTemplateSegment('top_2_tpl', 'top_2_tpl.tpl');
			$this->registry->library('template')->addTemplateSegment('sidebar_1_tpl', 'sidebar_1_tpl.tpl');
			$this->registry->library('template')->addTemplateSegment('sidebar_2_tpl', 'sidebar_2_tpl.tpl');
			$this->registry->library('template')->addTemplateSegment('sidebar_3_tpl', 'sidebar_3_tpl.tpl');
			$this->registry->library('template')->addTemplateSegment('sidebar_4_tpl', 'sidebar_4_tpl.tpl');
			$this->registry->library('template')->addTemplateSegment('bottom_top_tpl', 'bottom_top_tpl.tpl');
			$this->registry->library('template')->addTemplateSegment('bottom_1_tpl', 'bottom_1_tpl.tpl');
			$this->registry->library('template')->addTemplateSegment('bottom_2_tpl', 'bottom_2_tpl.tpl');
			$this->registry->library('template')->addTemplateSegment('top_bar_tpl', 'top_bar_tpl.tpl');
			$this->registry->library('template')->addTemplateSegment('top_menu_tpl', 'top_menu_tpl.tpl');
			$this->registry->library('template')->addTemplateSegment('bottom_bar_tpl', 'bottom_bar_tpl.tpl');
			$this->registry->library('template')->addTemplateSegment('slider_tpl', 'slider_tpl.tpl');

			$urlSegments = $this->registry->getURLSegments();
			$this->seg_1 = $this->registry->library('db')->sanitizeData($urlSegments[1]);
			$this->seg_2 = $this->registry->library('db')->sanitizeData($urlSegments[2]);
			$this->seg_3 = $this->registry->library('db')->sanitizeData($urlSegments[3]);
			$this->seg_4 = $this->registry->library('db')->sanitizeData($urlSegments[4]);
			if (true)
			{
				$this->registry->library('template')->page()->addTag('jquery', '<script type="text/javascript" src="' . FWURL . 'js/jquery/' . $this->registry->setting('settings_jquery') . '"></script>');
			}
			else
			{
				$this->registry->library('template')->page()->addTag('jquery', '');
			}
			if (false)
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
			}
			else
			{
				$this->registry->library('template')->page()->addTag('editor', '');
			}
			if (true)
			{
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
			else
			{
				$this->registry->library('template')->page()->addTag('highlighter', '');
			}
			if ($this->seg_1 == 'newtopic' || $this->seg_1 == 'newpost' || $this->seg_1 == 'creating_topic' || $this->seg_1 == 'creating_post')
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
//
			$w = $this->registry->widget('accessible_mega_menu_widget')->index();
			$this->registry->library('template')->addWidgetTag('accessible_mega_menu_widget', $w);
//
			$this->registry->library('template')->page()->addTag('seg_1', $urlSegments[0]);
			$this->registry->library('template')->page()->addTag('seg_2', $urlSegments[1]);
			$this->registry->library('template')->page()->addTag('seg_3', $urlSegments[2]);
			$this->registry->library('template')->page()->addTag('seg_4', $urlSegments[3]);
			$this->registry->library('template')->page()->addTag('seg_5', $urlSegments[4]);
			$this->registry->library('template')->page()->addTag('seg_6', $urlSegments[5]);
			$this->registry->library('template')->page()->addTag('seg_7', $urlSegments[6]);
			$this->registry->library('template')->page()->addTag('seg_8', $urlSegments[7]);
			$this->registry->library('template')->page()->addTag('seg_9', $urlSegments[8]);

			$controller_init_hook = $this->registry->library('hook')->call('controller_init_hook');
			if ($this->seg_1 == '' && $this->registry->setting('settings_cms_enabled') == 'y')
			{
				$this->index();
			}
			elseif ($this->registry->setting('settings_cms_enabled') != 'y')
			{
				$this->siteClosed();
			}
			else
			{
				switch ($this->seg_1)
				{

					case 'viewforum' :
						$this->viewforum();
						break;

					case 'viewtopic' :
						$this->viewtopic();
						break;

					case 'viewreply' :
						$this->viewreply();
						break;

					case 'newtopic' :
						$this->newtopic();
						break;

					case 'creating_topic' :
						$this->creating_topic();
						break;

					case 'newpost' :
						$this->newpost();
						break;

					case 'creating_post' :
						$this->creating_post();
						break;

					case 'captcha' :
						$this->captchaOutput();
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

	private function siteClosed()
	{
		$this->registry->library('template')->build('header.tpl', 'closed.tpl', 'footer.tpl');
	}

	private function index()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isLoggedIn() == true || $this->guests_allowed == 1)
		{
			$forums_available = '';
			$sql = 'SELECT f_forum_id, f_level, f_name, f_description, t_title, t_topic_id, COUNT(DISTINCT t_topic_id) AS topics_count, COUNT(p_post_id) AS posts_count
			FROM ' . $this->prefix . 'forums
			LEFT JOIN (SELECT *
				FROM ' . $this->prefix . 'forum_topics
				WHERE forum_topics_sys = "' . $this->sys_cms . '"
				ORDER BY t_last_post_date DESC) AS forum_topics ON f_forum_id = t_forum_id AND forum_topics_sys = "' . $this->sys_cms . '"
			LEFT JOIN ' . $this->prefix . 'forum_posts ON t_topic_id = p_topic_id AND forum_posts_sys = "' . $this->sys_cms . '"
			WHERE forums_sys = "' . $this->sys_cms . '"
			GROUP BY f_forum_id
			ORDER BY f_order ASC';
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
			{
				$forums_available = 'y';
				$first = 1;
				$forums = array();
				$i = 0;
				$num = $this->registry->library('db')->numRowsFromCache($cache);
				$data = $this->registry->library('db')->rowsFromCache($cache);
				while ($i < $num)
				{
					foreach ($data as $k => $v)
					{
						$forums[$i]['forum_id'] = $v['f_forum_id'];
						$forums[$i]['forum_name'] = $v['f_name'];
						$forums[$i]['forum_description'] = $v['f_description'];
						$forums[$i]['topics_count'] = $v['topics_count'];
						$forums[$i]['posts_count'] = $v['posts_count'];
						$forums[$i]['latest_topic_id'] = $v['t_topic_id'];
						$forums[$i]['latest_topic'] = $v['t_title'];
						$forums[$i]['type'] = 'forum';
						if ($first == 1 and $v['f_level'] == 0)
						{
							$forums[$i]['type'] = 'first_category';
						}
						if ($first == 0 and $v['f_level'] == 0)
						{
							$forums[$i]['type'] = 'another_category';
						}
						if ($first == 1 and $v['f_level'] == 0)
						{
							$first = 0;
						}
						$i = $i + 1;
					}
				}
			}
			$cache = $this->registry->library('db')->cacheData($forums);
			$this->registry->library('template')->page()->addTag('forums', array('DATA', $cache));
			$this->registry->library('template')->page()->addTag('forums_available', $forums_available);
			$this->registry->library('template')->build('header.tpl', $this->registry->setting('settings_forum0') . '/forum_index.tpl', 'footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

	private function viewforum()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isLoggedIn() == true || $this->guests_allowed == 1)
		{
// Forum Category OR Forum ?
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'forums
			WHERE forums_sys = "' . $this->sys_cms . '"
			AND f_forum_id = ' . $this->seg_2;
			$this->registry->library('db')->execute($sql);
			if ($this->registry->library('db')->numRows() != 0)
			{
				$data = $this->registry->library('db')->getRows();
				if ($data['f_level'] == 0)
				{
// IF Forum Category 0
					$forums_available = '';
// To find Forum Category and its Forums $arrCatAndForums
					$arrCatAndForums = array();
					$sql = 'SELECT *
FROM ' . $this->prefix . 'forums
WHERE forums_sys = "' . $this->sys_cms . '"
ORDER BY f_order ASC';
					$cache = $this->registry->library('db')->cacheQuery($sql);
					if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
					{
						$start = 0;
						$stop = - 1;
						$data = $this->registry->library('db')->rowsFromCache($cache);
						foreach ($data as $k => $v)
						{
							if ($v['f_forum_id'] == $this->seg_2)
							{
								$start = 1;
							}
							if ($v['f_level'] == 0 && $start == 1)
							{
								$stop++;
							}
							if ($stop == 0 && $start == 1)
							{
								$arrCatAndForums[] = $v['f_forum_id'];
							}
						}
					}
					$listCatAndForums = implode(",", $arrCatAndForums);
					$sql = 'SELECT f_forum_id, f_level, f_name, f_description, t_title, t_topic_id, COUNT(DISTINCT t_topic_id) AS topics_count, COUNT(p_post_id) AS posts_count
					FROM ' . $this->prefix . 'forums
					LEFT JOIN (SELECT *
						FROM ' . $this->prefix . 'forum_topics
						WHERE forum_topics_sys = "' . $this->sys_cms . '"
						ORDER BY t_last_post_date DESC) AS forum_topics ON f_forum_id = t_forum_id
					LEFT JOIN ' . $this->prefix . 'forum_posts ON t_topic_id = p_topic_id AND forum_posts_sys = "' . $this->sys_cms . '"
					WHERE forums_sys = "' . $this->sys_cms . '"
					AND f_forum_id IN (' . $listCatAndForums . ')
					GROUP BY f_forum_id
					ORDER BY f_order ASC';
					$cache = $this->registry->library('db')->cacheQuery($sql);
					if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
					{
						$forums_available = 'y';
						$first = 1;
						$forums = array();
						$i = 0;
						$num = $this->registry->library('db')->numRowsFromCache($cache);
						$data = $this->registry->library('db')->rowsFromCache($cache);
						while ($i < $num)
						{
							foreach ($data as $k => $v)
							{
								$forums[$i]['forum_id'] = $v['f_forum_id'];
								$forums[$i]['forum_name'] = $v['f_name'];
								$forums[$i]['forum_description'] = $v['f_description'];
								$forums[$i]['topics_count'] = $v['topics_count'];
								$forums[$i]['posts_count'] = $v['posts_count'];
								$forums[$i]['latest_topic_id'] = $v['t_topic_id'];
								$forums[$i]['latest_topic'] = $v['t_title'];
								$forums[$i]['type'] = 'forum';
								if ($first == 1 and $v['f_level'] == 0)
								{
									$forums[$i]['type'] = 'first_category';
								}
								if ($first == 0 and $v['f_level'] == 0)
								{
									$forums[$i]['type'] = 'another_category';
								}
								if ($first == 1 and $v['f_level'] == 0)
								{
									$first = 0;
								}
								$i = $i + 1;
							}
						}
					}
					$cache = $this->registry->library('db')->cacheData($forums);
					$this->registry->library('template')->page()->addTag('forums', array('DATA', $cache));
					$this->registry->library('template')->page()->addTag('forums_available', $forums_available);
					$this->registry->library('template')->build('header.tpl', $this->registry->setting('settings_forum0') . '/forum_index.tpl', 'footer.tpl');
				}
				else
				{
// IF Forum 1
					$topics_available = '';
					$rows_per_page = $this->registry->setting('settings_forum_topics_per_page');
					if ($this->seg_3 == '')
					{
						$offset = 0;
					}
					else
					{
						$offset = ($this->seg_3 - 1) * $rows_per_page;
					}
					$condition = 'WHERE forum_topics_sys = "' . $this->sys_cms . '" AND t_forum_id = ' . $this->seg_2;
					$pagination = $this->registry->library('paginate')->createLinksSys('forum_topics', $rows_per_page, 3, $this->registry->setting('settings_forum0') . '/viewforum/' . $this->seg_2, $condition);
					$this->registry->library('template')->page()->addTag('pagination', $pagination);
// To get forum name
					$sql = 'SELECT *
						FROM ' . $this->prefix . 'forums
						WHERE forums_sys = "' . $this->sys_cms . '"
						AND f_forum_id = ' . $this->seg_2;
					$this->registry->library('db')->execute($sql);
					if ($this->registry->library('db')->numRows() != 0)
					{
						$data = $this->registry->library('db')->getRows();
						$this->registry->library('template')->page()->addTag('forum_id', $data['f_forum_id']);
						$this->registry->library('template')->page()->addTag('forum_title', $data['f_name']);
						$this->registry->library('template')->page()->addTag('forum_description', $data['f_description']);
					}
// To get topics
					$sql = 'SELECT *, COUNT(p_post_id) AS `posts_count`
						FROM ' . $this->prefix . 'forum_topics
						LEFT JOIN ' . $this->prefix . 'forum_posts ON t_topic_id = p_topic_id AND forum_posts_sys = "' . $this->sys_cms . '"
						LEFT JOIN ' . $this->prefix . 'users ON t_user_id = users_id
						WHERE forum_topics_sys = "' . $this->sys_cms . '"
						AND t_forum_id = ' . $this->seg_2 . '
						GROUP BY t_topic_id
						ORDER BY t_last_post_date DESC
						LIMIT ' . $offset . ',' . $rows_per_page;
					$cache = $this->registry->library('db')->cacheQuery($sql);
					if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
					{
						$topics_available = 'y';
						$topics = array();
						$i = 0;
						$num = $this->registry->library('db')->numRowsFromCache($cache);
						$data = $this->registry->library('db')->rowsFromCache($cache);
						while ($i < $num)
						{
							foreach ($data as $k => $v)
							{
								$topics[$i]['topic_id'] = $v['t_topic_id'];
								$topics[$i]['topic_title'] = $v['t_title'];
								$topics[$i]['latest_post'] = $v['t_last_post_date'];
								$topics[$i]['posts_count'] = $v['posts_count'];
								$topics[$i]['post_author'] = $v['username'];
								$topics[$i]['post_author_id'] = $v['users_id'];
								$gravatar = $this->registry->library('helper')->gravatar($v['email']);
								$topics[$i]['post_gravatar'] = $gravatar;
								$i = $i + 1;
							}
						}
					}
					$cache = $this->registry->library('db')->cacheData($topics);
					$this->registry->library('template')->page()->addTag('topics', array('DATA', $cache));
					$this->registry->library('template')->page()->addTag('forum_id', $this->seg_2);
					$this->registry->library('template')->page()->addTag('topics_available', $topics_available);
					$this->registry->library('template')->build('header.tpl', $this->registry->setting('settings_forum0') . '/viewforum.tpl', 'footer.tpl');
				}
			}
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

	private function viewtopic()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isLoggedIn() == true || $this->guests_allowed == 1)
		{
			$posts_available = '';
			$rows_per_page = $this->registry->setting('settings_forum_posts_per_page');
			if ($this->seg_3 == '')
			{
				$offset = 0;
			}
			else
			{
				$offset = ($this->seg_3 - 1) * $rows_per_page;
			}
			$condition = 'WHERE p_topic_id = ' . $this->seg_2;
			$pagination = $this->registry->library('paginate')->createLinksSys('forum_posts', $rows_per_page, 3, $this->registry->setting('settings_forum0') . '/viewtopic/' . $this->seg_2, $condition);
			$this->registry->library('template')->page()->addTag('pagination', $pagination);
			$sql = 'SELECT *
				FROM ' . $this->prefix . 'forum_topics
				LEFT JOIN ' . $this->prefix . 'forums ON t_forum_id = f_forum_id AND forums_sys = "' . $this->sys_cms . '"
				LEFT JOIN ' . $this->prefix . 'users ON t_user_id = users_id
				WHERE forum_topics_sys = "' . $this->sys_cms . '"
				AND t_topic_id = ' . $this->seg_2;
			$this->registry->library('db')->execute($sql);
			if ($this->registry->library('db')->numRows() != 0)
			{
				$data = $this->registry->library('db')->getRows();
				$this->registry->library('template')->page()->addTag('forum_id', $data['t_forum_id']);
				$this->registry->library('template')->page()->addTag('forum_title', $data['f_name']);
				$this->registry->library('template')->page()->addTag('forum_description', $data['f_description']);
				$this->registry->library('template')->page()->addTag('topic_id', $data['t_topic_id']);
				$this->registry->library('template')->page()->addTag('topic_title', $data['t_title']);
				$this->registry->library('template')->page()->addTag('topic_author_id', $data['t_user_id']);
				$this->registry->library('template')->page()->addTag('topic_author', $data['username']);
				$user_created_date = $this->registry->library('helper')->convertDate($data['user_created']);
				$this->registry->library('template')->page()->addTag('user_created_date', $user_created_date);
				$gravatar = $this->registry->library('helper')->gravatar($data['email']);
				$this->registry->library('template')->page()->addTag('topic_gravatar', $gravatar);
				$data['t_body'] = str_replace(array("\r\n", "\n", "\r"), "<br />", $data['t_body']);
				$this->registry->library('template')->page()->addTag('topic_body', $data['t_body']);
				$this->registry->library('template')->page()->addTag('topic_datetime', $data['t_topic_date']);
				$this->registry->library('template')->page()->addTag('topic_distance', $this->registry->library('helper')->timeWord($data['t_topic_date']));
				$this->registry->library('template')->page()->addTag('topic_visible', $data['t_topic_visible']);
				$this->registry->library('template')->page()->addTag('status', $data['t_status']);
// To find Start ID and End ID for Post IDs
				$sql = 'SELECT t_topicid, t_last_post_date
					FROM ' . $this->prefix . 'forum_topics
					WHERE forum_topics_sys = "' . $this->sys_cms . '"
					AND t_forumid = ' . $this->seg_3;
// Difference btw. 2 queries
				if ($this->registry->library('authenticate')->isAdmin() != true && $this->registry->library('authenticate')->hasPermission('access_admin') != true)
				{
// temp !					$this->db->where('t_topic_visible', 'yes');
				}
				$rows_per_page = $this->registry->setting('settings_forum_posts_per_page');
				$from = intval($this->seg_4);
				$sql = $sql . '
					LIMIT $rows_per_page, ' . $from . ')
					ORDER BY t_last_post_date DESC';
				$skip = 0;
				$start_topic_id = '';
				$end_topic_id = '';
				$sql = 'SELECT f_forum_id, f_level, f_name, f_description, t_title, t_topic_id, COUNT(DISTINCT t_topic_id) AS topics_count, COUNT(p_post_id) AS posts_count
					FROM ' . $this->prefix . 'forums
					LEFT JOIN (SELECT *
					FROM ' . $this->prefix . 'forum_topics
					WHERE forum_topics_sys = "' . $this->sys_cms . '"
					ORDER BY t_last_post_date DESC) AS forum_topics ON f_forum_id = t_forum_id
					LEFT JOIN ' . $this->prefix . 'forum_posts ON t_topic_id = p_topic_id AND forum_posts_sys = "' . $this->sys_cms . '"
					WHERE forums_sys = "' . $this->sys_cms . '"
					GROUP BY f_forum_id
					ORDER BY f_order ASC';
				$cache = $this->registry->library('db')->cacheQuery($sql);
				if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
				{
					$topics = array();
					$i = 0;
					$num = $this->registry->library('db')->numRowsFromCache($cache);
					$data = $this->registry->library('db')->rowsFromCache($cache);
					while ($i < $num)
					{
						foreach ($data as $k => $v)
						{
							if ($skip == 0)
							{
								$end_last_post_date = $row->t_last_post_date;
								$skip = 1;
							}
							$start_last_post_date = $row->t_last_post_date;
							$i = $i + 1;
						}
					}
					if (isset ($end_last_post_date))
					{
						$where_condition = 't_last_post_date <= $end_last_post_date';
					}
					if (isset ($start_last_post_date))
					{
						$where_condition = 't_last_post_date >= $start_last_post_date';
					}
					$sql = 'SELECT *, COUNT(p_post_id) AS `posts_count`, display_name
						FROM ' . $this->prefix . 'forum_topics
						LEFT JOIN ' . $this->prefix . 'forum_posts ON t_topic_id = p_topic_id AND forum_posts_sys = "' . $this->sys_cms . '"
						LEFT JOIN ' . $this->prefix . 'users ON t_user_id = user_id ' . $where_condition . '
						WHERE forum_topics_sys = "' . $this->sys_cms . '"
						AND t_forumid = ' . $this->seg_3 . '
						GROUP BY t_topic_id
						ORDER BY t_last_post_date DESC';
					$sql = 'SELECT *
						FROM ' . $this->prefix . 'forum_posts
						LEFT JOIN ' . $this->prefix . 'users ON users_id = p_user_id
						WHERE forum_posts_sys = "' . $this->sys_cms . '"
						AND p_topic_id = ' . $this->seg_2 . '
						ORDER BY p_post_id ASC
						LIMIT ' . $offset . ',' . $rows_per_page;
					$cache = $this->registry->library('db')->cacheQuery($sql);
					if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
					{
						$posts_available = 'y';
						$posts = array();
						$i = 0;
						$num = $this->registry->library('db')->numRowsFromCache($cache);
						$data = $this->registry->library('db')->rowsFromCache($cache);
						while ($i < $num)
						{
							foreach ($data as $k => $v)
							{
								$posts[$i]['post_id'] = $v['p_post_id'];
								$v['p_body'] = str_replace(array("\r\n", "\n", "\r"), "<br />", $v['p_body']);
								$posts[$i]['post_body'] = $v['p_body'];
								$posts[$i]['post_author_id'] = $v['p_user_id'];
								$posts[$i]['post_author'] = $v['username'];
								$posts[$i]['post_visible'] = $v['p_post_visible'];
								$posts[$i]['post_datetime'] = $v['p_post_date'];
								$posts[$i]['post_distance'] = $this->registry->library('helper')->timeWord($v['p_post_date']);
								$posts[$i]['post_serial'] = $i + 1 + $offset;
								$gravatar = $this->registry->library('helper')->gravatar($v['email']);
								$posts[$i]['post_gravatar'] = $gravatar;
								$i = $i + 1;
							}
						}
					}
					$cache = $this->registry->library('db')->cacheData($posts);
					$this->registry->library('template')->page()->addTag('posts', array('DATA', $cache));
					$this->registry->library('template')->page()->addTag('topic_id', $this->seg_2);
					$this->registry->library('template')->page()->addTag('posts_available', $posts_available);
					$this->registry->library('template')->build('header.tpl', $this->registry->setting('settings_forum0') . '/viewtopic.tpl', 'footer.tpl');
				}
				else
				{
					$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
				}
			}
		}
	}

	private function viewreply()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isLoggedIn() == true || $this->guests_allowed == 1)
		{
			$posts_available = '';
			$rows_per_page = $this->registry->setting('settings_forum_posts_per_page');
			if ($this->seg_3 == '')
			{
				$offset = 0;
			}
			else
			{
				$offset = ($this->seg_3 - 1) * $rows_per_page;
			}
			$condition = 'WHERE p_topic_id = ' . $this->seg_2;
			$pagination = $this->registry->library('paginate')->createLinksSys('forum_posts', $rows_per_page, 3, $this->registry->setting('settings_forum0') . '/viewreply/' . $this->seg_2, $condition);
			$this->registry->library('template')->page()->addTag('pagination', $pagination);
			$sql = 'SELECT *
				FROM ' . $this->prefix . 'forum_topics
				LEFT JOIN ' . $this->prefix . 'forums ON t_forum_id = f_forum_id AND forums_sys = "' . $this->sys_cms . '"
				LEFT JOIN ' . $this->prefix . 'users ON t_user_id = users_id
				WHERE forum_topics_sys = "' . $this->sys_cms . '"
				AND t_topic_id = ' . $this->seg_2;
			$this->registry->library('db')->execute($sql);
			if ($this->registry->library('db')->numRows() != 0)
			{
				$data = $this->registry->library('db')->getRows();
				$this->registry->library('template')->page()->addTag('forum_id', $data['t_forum_id']);
				$this->registry->library('template')->page()->addTag('forum_title', $data['f_name']);
				$this->registry->library('template')->page()->addTag('forum_description', $data['f_description']);
				$this->registry->library('template')->page()->addTag('topic_id', $data['t_topic_id']);
				$this->registry->library('template')->page()->addTag('topic_title', $data['t_title']);
				$this->registry->library('template')->page()->addTag('topic_author_id', $data['t_user_id']);
				$this->registry->library('template')->page()->addTag('topic_author', $data['username']);
				$user_created_date = $this->registry->library('helper')->convertDate($data['user_created']);
				$this->registry->library('template')->page()->addTag('user_created_date', $user_created_date);
				$gravatar = $this->registry->library('helper')->gravatar($data['email']);
				$this->registry->library('template')->page()->addTag('topic_gravatar', $gravatar);
				$data['t_body'] = str_replace(array("\r\n", "\n", "\r"), "<br />", $data['t_body']);
				$this->registry->library('template')->page()->addTag('topic_body', $data['t_body']);
				$this->registry->library('template')->page()->addTag('topic_datetime', $data['t_topic_date']);
				$this->registry->library('template')->page()->addTag('topic_distance', $this->registry->library('helper')->timeWord($data['t_topic_date']));
				$this->registry->library('template')->page()->addTag('topic_visible', $data['t_topic_visible']);
				$this->registry->library('template')->page()->addTag('status', $data['t_status']);
// To find Start ID and End ID for Post IDs
				$sql = 'SELECT t_topicid, t_last_post_date
					FROM ' . $this->prefix . 'forum_topics
					WHERE forum_topics_sys = "' . $this->sys_cms . '"
					AND t_forumid = ' . $this->seg_3;
// Difference btw. 2 queries
				if ($this->registry->library('authenticate')->isAdmin() != true && $this->registry->library('authenticate')->hasPermission('access_admin') != true)
				{
// temp !					$this->db->where('t_topic_visible', 'yes');
				}
				$rows_per_page = $this->registry->setting('settings_forum_posts_per_page');
				$from = intval($this->seg_4);
				$sql = $sql . '
					LIMIT $rows_per_page, ' . $from . ')
					ORDER BY t_last_post_date DESC';
				$skip = 0;
				$start_topic_id = '';
				$end_topic_id = '';
				$sql = 'SELECT f_forum_id, f_level, f_name, f_description, t_title, t_topic_id, COUNT(DISTINCT t_topic_id) AS topics_count, COUNT(p_post_id) AS posts_count
					FROM ' . $this->prefix . 'forums
					LEFT JOIN (SELECT *
					FROM ' . $this->prefix . 'forum_topics
					WHERE forum_topics_sys = "' . $this->sys_cms . '"
					ORDER BY t_last_post_date DESC) AS forum_topics ON f_forum_id = t_forum_id
					LEFT JOIN ' . $this->prefix . 'forum_posts ON t_topic_id = p_topic_id AND forum_posts_sys = "' . $this->sys_cms . '"
					WHERE forums_sys = "' . $this->sys_cms . '"
					GROUP BY f_forum_id
					ORDER BY f_order ASC';
				$cache = $this->registry->library('db')->cacheQuery($sql);
				if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
				{
					$topics = array();
					$i = 0;
					$num = $this->registry->library('db')->numRowsFromCache($cache);
					$data = $this->registry->library('db')->rowsFromCache($cache);
					while ($i < $num)
					{
						foreach ($data as $k => $v)
						{
							if ($skip == 0)
							{
								$end_last_post_date = $row->t_last_post_date;
								$skip = 1;
							}
							$start_last_post_date = $row->t_last_post_date;
							$i = $i + 1;
						}
					}
					if (isset ($end_last_post_date))
					{
						$where_condition = 't_last_post_date <= $end_last_post_date';
					}
					if (isset ($start_last_post_date))
					{
						$where_condition = 't_last_post_date >= $start_last_post_date';
					}
					$sql = 'SELECT *, COUNT(p_post_id) AS `posts_count`, display_name
						FROM ' . $this->prefix . 'forum_topics
						LEFT JOIN ' . $this->prefix . 'forum_posts ON t_topic_id = p_topic_id AND forum_posts_sys = "' . $this->sys_cms . '"
						LEFT JOIN ' . $this->prefix . 'users ON t_user_id = user_id ' . $where_condition . '
						WHERE forum_topics_sys = "' . $this->sys_cms . '"
						AND t_forumid = ' . $this->seg_3 . '
						GROUP BY t_topic_id
						ORDER BY t_last_post_date DESC';
					$sql = 'SELECT *
						FROM ' . $this->prefix . 'forum_posts
						LEFT JOIN ' . $this->prefix . 'users ON users_id = p_user_id
						WHERE forum_posts_sys = "' . $this->sys_cms . '"
						AND p_topic_id = ' . $this->seg_2 . '
						ORDER BY p_post_id ASC
						LIMIT ' . $offset . ',' . $rows_per_page;
					$cache = $this->registry->library('db')->cacheQuery($sql);
					if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
					{
						$posts_available = 'y';
						$posts = array();
						$i = 0;
						$num = $this->registry->library('db')->numRowsFromCache($cache);
						$data = $this->registry->library('db')->rowsFromCache($cache);
						while ($i < $num)
						{
							foreach ($data as $k => $v)
							{
								$posts[$i]['post_id'] = $v['p_post_id'];
								$v['p_body'] = str_replace(array("\r\n", "\n", "\r"), "<br />", $v['p_body']);
								$posts[$i]['post_body'] = $v['p_body'];
								$posts[$i]['post_author_id'] = $v['p_user_id'];
								$posts[$i]['post_author'] = $v['username'];
								$posts[$i]['post_visible'] = $v['p_post_visible'];
								$posts[$i]['post_datetime'] = $v['p_post_date'];
								$posts[$i]['post_distance'] = $this->registry->library('helper')->timeWord($v['p_post_date']);
								$posts[$i]['post_serial'] = $i + 1 + $offset;
								$gravatar = $this->registry->library('helper')->gravatar($v['email']);
								$posts[$i]['post_gravatar'] = $gravatar;
								$i = $i + 1;
							}
						}
					}
					$cache = $this->registry->library('db')->cacheData($posts);
					$this->registry->library('template')->page()->addTag('posts', array('DATA', $cache));
					$this->registry->library('template')->page()->addTag('topic_id', $this->seg_2);
					$this->registry->library('template')->page()->addTag('posts_available', $posts_available);
					$this->registry->library('template')->build('header.tpl', $this->registry->setting('settings_forum0') . '/viewreply.tpl', 'footer.tpl');
				}
				else
				{
					$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
				}
			}
		}
	}

	private function newtopic()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isLoggedIn() == true || $this->guests_allowed == 1)
		{
			$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
			$this->registry->library('template')->page()->addTag('author_id', $this->registry->library('authenticate')->getUserID());
			$this->registry->library('template')->page()->addTag('error_message', '');
			if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true || $this->registry->library('authenticate')->hasPermission('limited_admin') == true)
			{
				$this->registry->library('template')->page()->addTag('author_id', '');
				$this->registry->library('template')->page()->addTag('topic_title', '');
				$this->registry->library('template')->page()->addTag('topic_body', '');
				$this->registry->library('template')->page()->addTag('forum_id', $this->seg_2);
				$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('new_topic'));
				$this->registry->library('template')->build('header.tpl', $this->registry->setting('settings_forum0') . '/topics_create.tpl', 'footer.tpl');
			}
			else
			{
				$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
			}
		}
	}

	private function creating_topic()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isLoggedIn() == true || $this->guests_allowed == 1)
		{
			if ($_POST['topic_title'] != '' && $_POST['body'] != '')
			{
// Caching OFF
				$this->registry->library('db')->setCacheOn(0);
				$data['t_forum_id'] = $this->registry->library('db')->sanitizeData($_POST['forumID']);
				$data['t_user_id'] = $this->registry->library('authenticate')->getUserID();
				$data['t_last_post_user_id'] = $this->registry->library('authenticate')->getUserID();
// XSS
				$data['t_title'] = $this->registry->library('db')->sanitizeDataX($_POST['topic_title']);
				$data['t_body'] = $this->registry->library('db')->sanitizeDataX($_POST['body']);
				$data['t_topic_date'] = date("Y-m-d H:i:s", time());
				$data['t_last_post_date'] = date("Y-m-d H:i:s", time());
				$data['t_ip_address'] = getenv('REMOTE_ADDR');
				$this->registry->library('db')->insertRecordsSys('forum_topics', $data);
// Restore CacheOn & Delete Cache
				$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
				if ($this->registry->setting('settings_cached') == 1)
				{
					$this->registry->library('db')->deleteCache('cache_', true);
				}
				$this->registry->redirectUser($this->registry->setting('settings_forum0') . '/viewforum/' . $this->seg_2, $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
			}
			else
			{
				$this->registry->library('template')->page()->addTag('topic_title', $_POST['topic_title']);
				$this->registry->library('template')->page()->addTag('topic_body', $_POST['body']);
				$this->registry->library('template')->page()->addTag('error_message', $this->registry->library('lang')->line('insufficient_data'));
				$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('new_topic'));
				$this->registry->library('template')->build('header.tpl', $this->registry->setting('settings_forum0') . '/topics_create.tpl', 'footer.tpl');
			}
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

	private function newpost()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isLoggedIn() == true || $this->guests_allowed == 1)
		{
			$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
			$this->registry->library('template')->page()->addTag('author_id', $this->registry->library('authenticate')->getUserID());
			$this->registry->library('template')->page()->addTag('error_message', '');
			if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true || $this->registry->library('authenticate')->hasPermission('limited_admin') == true)
			{
				$this->registry->library('template')->page()->addTag('author_id', '');
				$this->registry->library('template')->page()->addTag('post_title', '');
				$this->registry->library('template')->page()->addTag('post_body', '');
				$this->registry->library('template')->page()->addTag('topic_id', $this->seg_2);
				$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('new_post'));
				$this->registry->library('template')->build('header.tpl', $this->registry->setting('settings_forum0') . '/posts_create.tpl', 'footer.tpl');
			}
			else
			{
				$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
			}
		}
	}

	private function creating_post()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isLoggedIn() == true || $this->guests_allowed == 1)
		{
			if ($_POST['body'] != '')
			{
// Restore CacheOn & Delete Cache
				$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
				if ($this->registry->setting('settings_cached') == 1)
				{
					$this->registry->library('db')->deleteCache('cache_', true);
				}
				$topic_id = $this->registry->library('db')->sanitizeData($_POST['topicID']);
				$data['p_topic_id'] = $topic_id;
				$data['p_user_id'] = $this->registry->library('authenticate')->getUserID();
// XSS
				$data['p_body'] = $this->registry->library('db')->sanitizeDataX($_POST['body']);
				$data['p_post_date'] = date("Y-m-d H:i:s", time());
				$sql = 'SELECT *
				FROM ' . $this->prefix . 'forum_topics
				WHERE forum_topics_sys = "' . $this->sys_cms . '"
				AND t_topic_id = ' . $topic_id;
				$this->registry->library('db')->execute($sql);
				if ($this->registry->library('db')->numRows() != 0)
				{
					$arr = $this->registry->library('db')->getRows();
					$data['p_forum_id'] = $arr['t_forum_id'];
					$data['p_ip_address'] = getenv('REMOTE_ADDR');
				}
				$this->registry->library('db')->insertRecordsSys('forum_posts', $data);
				$data = array();
				$data['t_last_post_date'] = date("Y-m-d H:i:s", time());
				$this->registry->library('db')->updateRecordsSys('forum_topics', $data, 't_topic_id = ' . $topic_id);
// Restore CacheOn & Delete Cache
				$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
				if ($this->registry->setting('settings_cached') == 1)
				{
					$this->registry->library('db')->deleteCache('cache_', true);
				}
				$this->registry->redirectUser($this->registry->setting('settings_forum0') . '/viewtopic/' . $this->seg_2, $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
			}
			else
			{
				$this->registry->library('template')->page()->addTag('post_body', $_POST['body']);
				$this->registry->library('template')->page()->addTag('error_message', $this->registry->library('lang')->line('insufficient_data'));
				$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('new_post'));
				$this->registry->library('template')->build('header.tpl', $this->registry->setting('settings_forum0') . '/posts_create.tpl', 'footer.tpl');
			}
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

	private function captchaOutput()
	{
		$this->registry->library('authenticate')->getCaptchaImage($this->seg_2);
	}

}
?>