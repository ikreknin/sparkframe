<?php

class Sitecontroller
{
	private $registry;
	private $model;
	private $prefix;
	private $sys_cms;
	private $seg_1;
	private $seg_2;
	private $seg_3;
	private $seg_4;
	private $expiretime = 63244800;
// two years for Remember Me

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
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('articles'));
			$this->registry->library('template')->page()->addTag('home', $this->registry->library('lang')->line('home'));
			$this->registry->library('template')->page()->addTag('admin_home', $this->registry->library('lang')->line('admin_home'));
			$this->registry->library('template')->page()->addTag('author_text', $this->registry->library('lang')->line('author_text'));
			$this->registry->library('template')->page()->addTag('date', $this->registry->library('lang')->line('date'));
			$this->registry->library('template')->page()->addTag('time', $this->registry->library('lang')->line('time'));
			$this->registry->library('template')->page()->addTag('login', $this->registry->library('lang')->line('login'));
			$this->registry->library('template')->page()->addTag('logout', $this->registry->library('lang')->line('logout'));
			$this->registry->library('template')->page()->addTag('read_more', $this->registry->library('lang')->line('read_more'));
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
			$this->registry->library('template')->page()->addTag('forum_text', $this->registry->library('lang')->line('forum_text'));
			$this->registry->library('template')->page()->addTag('shop_text', $this->registry->library('lang')->line('shop_text'));
			$this->registry->library('template')->page()->addTag('blog_text', $this->registry->library('lang')->line('blog_text'));
			$this->registry->library('template')->page()->addTag('cp', $this->registry->library('lang')->line('cp'));
			$this->registry->library('template')->page()->addTag('hide', $this->registry->library('lang')->line('hide'));
			$this->registry->library('template')->page()->addTag('show', $this->registry->library('lang')->line('show'));
			$this->registry->library('template')->page()->addTag('welcome', $this->registry->library('lang')->line('welcome'));
			$this->registry->library('template')->page()->addTag('registration', $this->registry->library('lang')->line('registration'));
			$this->registry->library('template')->page()->addTag('search', $this->registry->library('lang')->line('search'));
			$this->registry->library('template')->page()->addTag('search_results', $this->registry->library('lang')->line('search_results'));
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
			$this->registry->library('template')->page()->addTag('guests_comments_allowed', $this->registry->setting('settings_guests_comments_allowed'));
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
			if ($this->seg_1 == 'more')
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
			$this->registry->library('template')->page()->addTag('blogCalendar', '');
//
			$w = $this->registry->widget('latest_articles_plus_widget')->index(15);
			$this->registry->library('template')->addWidgetTag('latest_articles_plus_widget', $w);
//
//
			$w = $this->registry->widget('monthly_archive_widget')->index();
			$this->registry->library('template')->addWidgetTag('monthly_archive_widget', $w);
//
//
			$w = $this->registry->widget('poll_widget')->index();
			$this->registry->library('template')->addWidgetTag('poll_widget', $w);
//
//
			$w = $this->registry->widget('jtabsrss_widget')->index();
			$this->registry->library('template')->addWidgetTag('jtabsrss_widget', $w);
//
			$w = $this->registry->widget('latest_tweets_widget')->index();
			$this->registry->library('template')->addWidgetTag('latest_tweets_widget', $w);
//
			$w = $this->registry->widget('elastislide_widget')->index();
			$this->registry->library('template')->addWidgetTag('elastislide_widget', $w);
//
			$w = $this->registry->widget('accessible_mega_menu_widget')->index();
			$this->registry->library('template')->addWidgetTag('accessible_mega_menu_widget', $w);
//
			$w = $this->registry->widget('article_tags_widget')->index();
			$this->registry->library('template')->addWidgetTag('article_tags_widget', $w);
//
			$w = $this->registry->widget('tagcloud_widget')->index();
			$this->registry->library('template')->addWidgetTag('tagcloud_widget', $w);
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
			if ($this->seg_1 != '' && $this->seg_1 != 'more' && $this->seg_1 != 'page')
			{
				$this->registry->library('template')->page()->addTag('before_blog_article_hook', '');
			}
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

					case 'page' :
						$this->page();
						break;

					case 'more' :
						$this->more();
						break;

					case 'adding_comment' :
						$this->adding_comment();
						break;

					case 'loggedin' :
						$this->loggedin();
						break;

					case 'logout' :
						$this->logout();
						break;

					case 'captcha' :
						$this->captchaOutput();
						break;

					case 'category' :
						$this->category();
						break;

					case 'search' :
						$this->search();
						break;

					case 'search_page' :
						$this->search_page();
						break;

					case 'rss' :
						$this->rss();
						break;

					case 'calendar' :
						$this->calendar();
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
// for Search redirect if absent or too short
		$urlSegments = $this->registry->getURLSegments();
		$_SESSION['redirect'] = '';
		if ($this->registry->library('db')->sanitizeData($urlSegments[0]) != '')
		{
			$_SESSION['redirect'] .= $this->registry->library('db')->sanitizeData($urlSegments[0]);
		}
		if ($this->registry->library('db')->sanitizeData($urlSegments[1]) != '')
		{
			$_SESSION['redirect'] .= '/' . $this->registry->library('db')->sanitizeData($urlSegments[1]);
		}
		if ($this->registry->library('db')->sanitizeData($urlSegments[2]) != '')
		{
			$_SESSION['redirect'] .= '/' . $this->registry->library('db')->sanitizeData($urlSegments[2]);
		}

// CRON
		$delta = time() - strtotime($this->registry->setting('settings_cron'));
//	60 s x 60 m x 24 h = 86400 (once a day)
		if ($delta > $this->registry->setting('settings_cron_period'))
		{
			$data = array();
			$data['settings_cron'] = date("Y-m-d H:i:s", time());
			$this->registry->library('db')->updateRecordsSys('settings', $data, '');
//				// To do cron operation HERE
//				// To do cron operation HERE
		}
// CRON end
		if ($this->registry->library('authenticate')->isLoggedIn() == true || $this->registry->setting('settings_guests_allowed') == 1)
		{
// Selection of Articles
// article_visible = enum "1"
			$cache = $this->registry->library('db')->cacheQuery('SELECT *, COUNT(com_article_id) AS `comments_count`
			FROM ' . $this->prefix . 'articles
			LEFT JOIN ' . $this->prefix . 'users ON ' . $this->prefix . 'users.users_id = ' . $this->prefix . 'articles.author_id
			LEFT JOIN ' . $this->prefix . 'categories ON ' . $this->prefix . 'categories.category_id = ' . $this->prefix . 'articles.categories
			LEFT JOIN ' . $this->prefix . 'comments ON ' . $this->prefix . 'comments.com_article_id = ' . $this->prefix . 'articles.article_id
			WHERE article_visible = 2
			AND articles_sys = "' . $this->sys_cms . '"
			GROUP BY article_id
			ORDER BY pinned DESC, article_id DESC
			LIMIT ' . $this->registry->setting('settings_rows_per_page'));
			$num = $this->registry->library('db')->numRowsFromCache($cache);
			if ($num != 0)
			{
				$articles = array();
				$i = 0;
				$data = $this->registry->library('db')->rowsFromCache($cache);
				while ($i < $num)
				{
					foreach ($data as $k => $v)
					{
						$articles[$i]['article_id'] = $v['article_id'];
						$articles[$i]['author_id'] = $v['author_id'];
						$articles[$i]['title'] = $v['title'];
						$articles[$i]['url_title'] = $v['url_title'];
						$articles[$i]['article'] = $v['article'];
						$articles[$i]['article_extended'] = $v['article_extended'];
						$articles[$i]['create_date'] = $this->registry->library('helper')->convertDate($v['art_created']);
						$articles[$i]['create_time'] = $this->registry->library('helper')->convertTime($v['art_created']);
						if ($v['url_title'] == '')
						{
							$articles[$i]['more'] = $v['article_id'];
						}
						else
						{
							$articles[$i]['more'] = $v['url_title'];
						}
						$articles[$i]['author_name'] = $v['username'];
						$articles[$i]['category_id'] = $v['categories'];
						$articles[$i]['category_name'] = $v['category_name'];
						$articles[$i]['category_image_name'] = $v['category_image_name'];
						$articles[$i]['comments_count'] = $v['comments_count'];
// tree of categories?
						if ($this->registry->setting('settings_one_cat') == 0)
						{
							$articles[$i]['one_cat_available'] = 'n';
						}
						else
						{
							$articles[$i]['one_cat_available'] = 'y';
						}
						$articles[$i]['before_blog_article_hook'] = '';
						$before_blog_article_hook = $this->registry->library('hook')->call('before_blog_article_hook', $v['article_id']);
						$articles[$i]['before_blog_article_hook'] = $before_blog_article_hook;
						$i = $i + 1;
					}
				}
			}
			$cache = $this->registry->library('db')->cacheData($articles);
			$this->registry->library('template')->page()->addTag('articles', array('DATA', $cache));
// $table, $rows_per_page, $pag_seg_number, $urlstring, $condition
			$condition = 'WHERE article_visible = 2';
			$pagination = $this->registry->library('paginate')->createLinksSys('articles', $this->registry->setting('settings_rows_per_page'), 3, $this->registry->setting('settings_site0') . '/page', $condition);
			$this->registry->library('template')->page()->addTag('pagination', $pagination);
			$this->registry->library('template')->page()->addTag('current_category', '');
// HTML list of all categories
			$categories_available = '';
			$html = '';
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'categories
			WHERE categories_sys = "' . $this->sys_cms . '"
			ORDER BY category_order ASC';
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
			{
				$categories_available = 'y';
				$data = $this->registry->library('db')->rowsFromCache($cache);
				$html = $this->registry->library('helper')->simpleCatList($data);
			}
			$this->registry->library('template')->page()->addTag('simple_categories_list', $html);
			$this->registry->library('template')->page()->addTag('categories_available', $categories_available);
			$htmlCalendar = $this->registry->library('helper')->blogCalendarCurrent();
			$this->registry->library('template')->page()->addTag('blogCalendar', $htmlCalendar);
			$this->registry->library('template')->build('header.tpl', 'site.tpl', 'footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

	private function more()
	{
// for Search redirect if absent or too short
		$urlSegments = $this->registry->getURLSegments();
		$_SESSION['redirect'] = '';
		if ($this->registry->library('db')->sanitizeData($urlSegments[0]) != '')
		{
			$_SESSION['redirect'] .= $this->registry->library('db')->sanitizeData($urlSegments[0]);
		}
		if ($this->registry->library('db')->sanitizeData($urlSegments[1]) != '')
		{
			$_SESSION['redirect'] .= '/' . $this->registry->library('db')->sanitizeData($urlSegments[1]);
		}
		if ($this->registry->library('db')->sanitizeData($urlSegments[2]) != '')
		{
			$_SESSION['redirect'] .= '/' . $this->registry->library('db')->sanitizeData($urlSegments[2]);
		}

		if ($this->registry->library('authenticate')->isLoggedIn() == true || $this->registry->setting('settings_guests_allowed') == 1)
		{
			$this->registry->library('template')->page()->addTag('error_message', '');
// 1st character - number or letter?
			if (filter_var($this->seg_2, FILTER_VALIDATE_INT))
			{
// id
				$sql = 'SELECT *, COUNT(com_article_id) AS `comments_count`
	FROM ' . $this->prefix . 'articles
	LEFT JOIN ' . $this->prefix . 'users ON ' . $this->prefix . 'users.users_id = ' . $this->prefix . 'articles.author_id
	LEFT JOIN ' . $this->prefix . 'categories ON ' . $this->prefix . 'categories.category_id = ' . $this->prefix . 'articles.categories AND categories_sys = "' . $this->sys_cms . '"
	LEFT JOIN ' . $this->prefix . 'comments ON ' . $this->prefix . 'comments.com_article_id = ' . $this->prefix . 'articles.article_id AND comments_sys = "' . $this->sys_cms . '"
	WHERE article_visible = 2
	AND articles_sys = "' . $this->sys_cms . '"
	AND article_id = ' . $this->seg_2 . ' GROUP BY article_id';
			}
			else
			{
// url
				$sql = 'SELECT *, COUNT(com_article_id) AS `comments_count`
	FROM ' . $this->prefix . 'articles
	LEFT JOIN ' . $this->prefix . 'users ON ' . $this->prefix . 'users.users_id = ' . $this->prefix . 'articles.author_id
	LEFT JOIN ' . $this->prefix . 'categories ON ' . $this->prefix . 'categories.category_id = ' . $this->prefix . 'articles.categories AND categories_sys = "' . $this->sys_cms . '"
	LEFT JOIN ' . $this->prefix . 'comments ON ' . $this->prefix . 'comments.com_article_id = ' . $this->prefix . 'articles.article_id AND comments_sys = "' . $this->sys_cms . '"
	WHERE article_visible = 2 AND articles_sys = "' . $this->sys_cms . '"
	AND url_title = "' . $this->seg_2 . '" GROUP BY article_id';
			}
			$this->registry->library('db')->execute($sql);
			if ($this->registry->library('db')->numRows() != 0)
			{
				$data = $this->registry->library('db')->getRows();
				$this->registry->library('template')->page()->addTag('before_blog_article_hook', '');
				$before_blog_article_hook = $this->registry->library('hook')->call('before_blog_article_hook', $data['article_id']);
				$this->registry->library('template')->page()->addTag('before_blog_article_hook', $before_blog_article_hook);
				$art_id = $data['article_id'];
				$this->registry->library('template')->page()->addTag('article_id', $data['article_id']);
				$this->registry->library('template')->page()->addTag('author_id', $data['author_id']);
				$this->registry->library('template')->page()->addTag('author_name', $data['username']);
				$this->registry->library('template')->page()->addTag('title', $data['title']);
				$this->registry->library('template')->page()->addTag('url_title', $data['url_title']);
				$this->registry->library('template')->page()->addTag('article', $data['article']);
				$this->registry->library('template')->page()->addTag('article_extended', $data['article_extended']);
				$this->registry->library('template')->page()->addTag('create_date', $this->registry->library('helper')->convertDate($data['art_created']));
				$this->registry->library('template')->page()->addTag('create_time', $this->registry->library('helper')->convertTime($data['art_created']));
// tree of categories?
				if ($this->registry->setting('settings_one_cat') == 0)
				{
					$this->registry->library('template')->page()->addTag('one_cat_available', 'n');
					$this->registry->library('template')->page()->addTag('category_id', '');
					$this->registry->library('template')->page()->addTag('category_name', '');
				}
				else
				{
					$this->registry->library('template')->page()->addTag('one_cat_available', 'y');
					$this->registry->library('template')->page()->addTag('category_id', $data['category_id']);
					$this->registry->library('template')->page()->addTag('category_name', $data['category_name']);
				}
				$this->registry->library('template')->page()->addTag('comments_count', $data['comments_count']);
				if ($data['url_title'] == '')
				{
// id
					$this->registry->library('template')->page()->addTag('more', $data['article_id']);
				}
				else
				{
// url
					$this->registry->library('template')->page()->addTag('more', $data['url_title']);
				}
				$comments_available = '';
				$sql = 'SELECT *
			FROM ' . $this->prefix . 'comments
			LEFT JOIN ' . $this->prefix . 'users ON ' . $this->prefix . 'users.users_id = ' . $this->prefix . 'comments.user_id
			WHERE com_article_id = ' . $data['article_id'] . '
			AND comments_sys = "' . $this->sys_cms . '"
			ORDER BY comment_id ASC';
				$cache = $this->registry->library('db')->cacheQuery($sql);
				if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
				{
					$comments_available = 'y';
					$comments = array();
					$i = 0;
					$num = $this->registry->library('db')->numRowsFromCache($cache);
					$data = $this->registry->library('db')->rowsFromCache($cache);
					while ($i < $num)
					{
						foreach ($data as $k => $v)
						{
							if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
							{
// Admins can see all comments
								$comments[$i]['comment_id'] = $v['comment_id'];
								$comments[$i]['article_id'] = $v['com_article_id'];
								$comments[$i]['com_author_id'] = $v['user_id'];
								$comments[$i]['com_author'] = $v['author'];
								$comments[$i]['author_email'] = $v['author_email'];
								$comments[$i]['author_website'] = $v['author_website'];
								$comments[$i]['author_ip'] = $v['author_ip'];
								$v['body'] = str_replace(array("\r\n", "\n", "\r"), "<br />", $v['body']);
								$comments[$i]['body'] = $v['body'];
								$process_each_comment_hook = '';
								$process_each_comment_hook = $this->registry->library('hook')->call('process_each_comment_hook', $v['body']);
								if ($v['body'] != $this->registry->library('hook')->resultArray['comment'] && $this->registry->library('hook')->resultArray['comment'] != null)
								{
									$comments[$i]['body'] = $this->registry->library('hook')->resultArray['comment'];
								}
								$comments[$i]['updated'] = $v['updated'];
								$comments[$i]['approved'] = $v['comment_approved'];
								$comments[$i]['visible'] = $v['comment_visible'];
								$comments[$i]['spam'] = $v['spam'];
								$comments[$i]['create_date'] = $this->registry->library('helper')->convertDate($v['created']);
								$comments[$i]['create_time'] = $this->registry->library('helper')->convertTime($v['created']);
								$comments[$i]['author_name'] = $v['username'];
								if ($v['comment_approved'] == 'y')
								{
									$comments[$i]['approved'] = $this->registry->library('lang')->line('yes');
								}
								else
								{
									$comments[$i]['approved'] = $this->registry->library('lang')->line('no');
								}
							}
							else
							{
// Guests can see approved AND visible comments
								if ($v['comment_approved'] == 'y' && $v['comment_visible'] == 'y')
								{
									$comments[$i]['comment_id'] = $v['comment_id'];
									$comments[$i]['article_id'] = $v['com_article_id'];
									$comments[$i]['com_author_id'] = $v['user_id'];
									$comments[$i]['com_author'] = $v['author'];
									$comments[$i]['author_email'] = $v['author_email'];
									$comments[$i]['author_website'] = $v['author_website'];
									$comments[$i]['author_ip'] = $v['author_ip'];
									$v['body'] = str_replace(array("\r\n", "\n", "\r"), "<br />", $v['body']);
									$comments[$i]['body'] = $v['body'];
									$comments[$i]['updated'] = $v['updated'];
									$comments[$i]['approved'] = $v['comment_approved'];
									$comments[$i]['visible'] = $v['comment_visible'];
									$comments[$i]['create_date'] = $this->registry->library('helper')->convertDate($v['created']);
									$comments[$i]['create_time'] = $this->registry->library('helper')->convertTime($v['created']);
									$comments[$i]['author_name'] = $v['username'];
									if ($v['comment_approved'] == 'y')
									{
										$comments[$i]['approved'] = $this->registry->library('lang')->line('yes');
									}
									else
									{
										$comments[$i]['approved'] = $this->registry->library('lang')->line('no');
									}
									if ($v['comment_visible'] == 'y')
									{
										$comments[$i]['visible'] = $this->registry->library('lang')->line('yes');
									}
									else
									{
										$comments[$i]['visible'] = $this->registry->library('lang')->line('no');
									}
								}
							}
							$i = $i + 1;
						}
					}
				}
				$this->registry->library('template')->page()->addTag('current_category', '');
// HTML list of all categories
				$categories_available = '';
				$html = '';
				$sql = 'SELECT *
			FROM ' . $this->prefix . 'categories
			WHERE categories_sys = "' . $this->sys_cms . '"
			ORDER BY category_order ASC';
				$cache = $this->registry->library('db')->cacheQuery($sql);
				if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
				{
					$categories_available = 'y';
					$data = $this->registry->library('db')->rowsFromCache($cache);
					$html = $this->registry->library('helper')->simpleCatList($data);
				}
// Custom Fields
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'c_fields_created
			LEFT JOIN ' . $this->prefix . 'c_fields_types ON ' . $this->prefix . 'c_fields_created.c_created_type = ' . $this->prefix . 'c_fields_types.c_types_id
			LEFT JOIN ' . $this->prefix . 'c_fields ON c_created_id = c_name_id
			AND c_fields_sys = "' . $this->sys_cms . '"
			WHERE c_fields_created_sys = "' . $this->sys_cms . '"
			AND (c_created_type = 1 OR c_created_type = 2)
			AND c_art_id = "' . $art_id . '"
			AND c_created_site_section = "b"';
			$cache = $this->registry->library('db')->cacheQuery($sql);

			if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
			{
				$data12 = array();
				$data12New = array();
				$data12 = $this->registry->library('db')->rowsFromCache($cache);
				foreach ($data12 as $k => $v)
				{
					if ($v['c_created_encrypted'] == 'y')
					{
						$v['c_body'] = rtrim($this->registry->library('crypter')->decrypt($v['c_body']));
					}
						$data12New[] = array('c_created_id' => $v['c_created_id'], 'c_created_name' => $v['c_created_name'], 'c_created_url_title' => $v['c_created_url_title'], 'c_created_description' => $v['c_created_description'], 'c_created_type' => $v['c_created_type'], 'c_created_site_section' => $v['c_created_site_section'], 'c_created_obligatory' => $v['c_created_obligatory'], 'c_type_default_value' => $v['c_type_default_value'], 'c_fields_created_sys' => $v['c_fields_created_sys'], 'c_created_encrypted' => $v['c_created_encrypted'], 'c_created_encrypted' => $v['c_created_encrypted'], 'c_type_name' => $v['c_type_name'], 'c_fields_id' => $v['c_fields_id'], 'c_name_id' => $v['c_name_id'], 'c_body' => $v['c_body'], 'c_art_id' => $v['c_art_id'], 'c_fields_sys' => $v['c_fields_sys']);
				}
				$cache = $this->registry->library('db')->cacheData($data12New);
			}
			$this->registry->library('template')->page()->addTag('custom_fields_12', array('DATA', $cache));

			$stringField3 = '';
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'c_fields_created
			LEFT JOIN ' . $this->prefix . 'c_fields_types ON ' . $this->prefix . 'c_fields_created.c_created_type = ' . $this->prefix . 'c_fields_types.c_types_id
			LEFT JOIN ' . $this->prefix . 'c_fields ON c_created_id = c_name_id
			AND c_fields_sys = "' . $this->sys_cms . '"
			WHERE c_fields_created_sys = "' . $this->sys_cms . '"
			AND c_created_type = 3
			AND c_created_site_section = "b"';
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
						$stringField3 .= '<option value="' . $value . '"';
						if ($v['c_body'] == $value)
						{
							$stringField3 .= ' selected="selected"';
						}
						$stringField3 .= '>' . $value . '</option>';
					}
				}
				$stringField3 .= '</select>';
			}


				$this->registry->library('template')->page()->addTag('simple_categories_list', $html);
				$this->registry->library('template')->page()->addTag('categories_available', $categories_available);
				$this->registry->library('template')->page()->addTag('comments_available', $comments_available);
				$cache = $this->registry->library('db')->cacheData($comments);
				$this->registry->library('template')->page()->addTag('comments', array('DATA', $cache));
				$this->registry->library('template')->page()->addTag('enter_code', $this->registry->library('lang')->line('enter_code'));
				$captcha = $this->registry->library('authenticate')->getCaptcha();
				$this->registry->library('template')->page()->addTag('captcha', $captcha);
				$_SESSION['captcha'] = $captcha;
				$this->registry->library('template')->page()->addTag('new_com_author', '');
				$this->registry->library('template')->page()->addTag('email', '');
				$this->registry->library('template')->page()->addTag('website', '');
				$this->registry->library('template')->page()->addTag('comment', '');
				$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
				$this->registry->library('template')->page()->addTag('pagination', '');
				$this->registry->library('template')->build('header.tpl', 'more.tpl', 'footer.tpl');
			}
// if article was not found
			else
			{
				$this->pageNotFound();
			}
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

	private function adding_comment()
	{
		if ($this->registry->library('authenticate')->isLoggedIn() == true || $this->registry->setting('settings_guests_allowed') == 1)
		{
// Caching OFF
			$this->registry->library('db')->setCacheOn(0);
			$data = array();
			$data['com_article_id'] = $this->registry->library('db')->sanitizeData($_POST['com_articleid']);
			$data['user_id'] = $this->registry->library('authenticate')->getUserID();
			$data['author'] = $this->registry->library('db')->sanitizeDataX($_POST['new_com_author']);
			$data['author_email'] = $this->registry->library('db')->sanitizeDataX($_POST['email']);
			$data['author_website'] = $this->registry->library('db')->sanitizeDataX($_POST['website']);
			$data['author_ip'] = getenv('REMOTE_ADDR');
// XSS
			$data['body'] = $this->registry->library('db')->sanitizeDataX($_POST['body']);
			$data['created'] = date("Y-m-d H:i:s", time());
			if (($_POST['captcha'] == $_SESSION['captcha'] || $this->registry->library('authenticate')->getUserID() != 0) && $_POST['body'] != '')
			{
// Comment SPAM check
				$before_adding_comment_hook = '';
				$before_adding_comment_hook = $this->registry->library('hook')->call('before_adding_comment_hook', $data);
// IF SPAM
				$pos = strpos($before_adding_comment_hook, 'SPAM');
				if ($pos !== false)
				{
					$data['comment_visible'] = 'n';
					$data['spam'] = 'y';
					$redirect_message = $this->registry->library('lang')->line('may_be_spam');
				}
				else
				{
					$redirect_message = $this->registry->library('lang')->line('comment_added');
				}
// Add Comment
				$this->registry->library('db')->insertRecordsSys('comments', $data);
				$after_adding_comment_hook = '';
				$after_adding_comment_hook = $this->registry->library('hook')->call('after_adding_comment_hook', $data);
				$this->registry->redirectUser($this->registry->setting('settings_site0') . '/more/' . $this->seg_2, $redirect_message, $this->registry->library('lang')->line('please_wait_for_the_redirect'));
			}
			else
			{
				if ($this->registry->library('authenticate')->isLoggedIn() == true || $this->registry->setting('settings_guests_allowed') == 1)
				{
					$error_message = '';
					if ($_POST['captcha'] != $_SESSION['captcha'] && $this->registry->library('authenticate')->getUserID() == 0)
					{
						$error_message .= $this->registry->library('lang')->line('incorrect_captcha') . '<br />';
					}
					if ($_POST['captcha'] != $_SESSION['captcha'])
					{
						$error_message .= $this->registry->library('lang')->line('insufficient_data') . '<br />';
					}
					$this->registry->library('template')->page()->addTag('error_message', $error_message);
					$sql = 'SELECT *
					FROM ' . $this->prefix . 'articles
					LEFT JOIN ' . $this->prefix . 'users ON ' . $this->prefix . 'users.users_id = ' . $this->prefix . 'articles.author_id
					LEFT JOIN ' . $this->prefix . 'categories ON ' . $this->prefix . 'categories.category_id = ' . $this->prefix . 'articles.categories AND categories_sys = "' . $this->sys_cms . '"
					WHERE articles_sys = "' . $this->sys_cms . '"
					AND article_id =' . $_POST['com_articleid'];
					$this->registry->library('db')->execute($sql);
					if ($this->registry->library('db')->numRows() != 0)
					{
						$data = $this->registry->library('db')->getRows();
						$this->registry->library('template')->page()->addTag('article_id', $data['article_id']);
						$this->registry->library('template')->page()->addTag('more', $_POST['more']);
						$this->registry->library('template')->page()->addTag('author_id', $data['author_id']);
						$this->registry->library('template')->page()->addTag('article_author', $data['username']);
						$this->registry->library('template')->page()->addTag('title', $data['title']);
						$this->registry->library('template')->page()->addTag('url_title', $data['url_title']);
						$this->registry->library('template')->page()->addTag('article', $data['article']);
						$this->registry->library('template')->page()->addTag('article_extended', $data['article_extended']);
						$this->registry->library('template')->page()->addTag('create_date', $this->registry->library('helper')->convertDate($data['art_created']));
						$this->registry->library('template')->page()->addTag('create_time', $this->registry->library('helper')->convertTime($data['art_created']));
						$this->registry->library('template')->page()->addTag('category_id', $data['category_id']);
						$this->registry->library('template')->page()->addTag('category_name', $data['category_name']);
						$this->registry->library('template')->page()->addTag('category_image_name', $data['category_image_name']);
						$uid = $this->registry->library('authenticate')->getUserID();
						$un = $this->registry->library('authenticate')->getUsername();
						if ($un != '' && $uid > 0)
						{
							$this->registry->library('template')->page()->addTag('visitor_user_id', $this->registry->library('authenticate')->getUserID());
							$this->registry->library('template')->page()->addTag('visitor_username', $this->registry->library('authenticate')->getUsername());
						}
						else
						{
							$this->registry->library('template')->page()->addTag('visitor_user_id', 0);
							$this->registry->library('template')->page()->addTag('visitor_username', '');
						}
					}
					$comments_available = '';
					$sql = 'SELECT *
					FROM ' . $this->prefix . 'comments
					LEFT JOIN ' . $this->prefix . 'users ON ' . $this->prefix . 'users.users_id = ' . $this->prefix . 'comments.user_id
					WHERE com_article_id = ' . $_POST['com_articleid'] . '
					AND comments_sys = "' . $this->sys_cms . '"
					ORDER BY comment_id DESC';
					$cache = $this->registry->library('db')->cacheQuery($sql);
					if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
					{
						$comments_available = 'y';
						$comments = array();
						$i = 0;
						$num = $this->registry->library('db')->numRowsFromCache($cache);
						$data = $this->registry->library('db')->rowsFromCache($cache);
						while ($i < $num)
						{
							foreach ($data as $k => $v)
							{
								$comments[$i]['comment_id'] = $v['comment_id'];
								$comments[$i]['article_id'] = $v['com_article_id'];
								$comments[$i]['com_author_id'] = $v['user_id'];
								$comments[$i]['com_author'] = $v['author'];
								$comments[$i]['author_email'] = $v['author_email'];
								$comments[$i]['author_website'] = $v['author_website'];
								$comments[$i]['author_ip'] = $v['author_ip'];
								$comments[$i]['body'] = $v['body'];
								$comments[$i]['updated'] = $v['updated'];
								$comments[$i]['approved'] = $v['comment_approved'];
								$comments[$i]['visible'] = $v['comment_visible'];
								$comments[$i]['create_date'] = $this->registry->library('helper')->convertDate($v['created']);
								$comments[$i]['create_time'] = $this->registry->library('helper')->convertTime($v['created']);
								$comments[$i]['author_name'] = $v['username'];
								if ($v['comment_approved'] == 'y')
								{
									$comments[$i]['approved'] = $this->registry->library('lang')->line('yes');
								}
								else
								{
									$comments[$i]['approved'] = $this->registry->library('lang')->line('no');
								}
								if ($v['comment_visible'] == 'y')
								{
									$comments[$i]['visible'] = $this->registry->library('lang')->line('yes');
								}
								else
								{
									$comments[$i]['visible'] = $this->registry->library('lang')->line('no');
								}
								$i = $i + 1;
							}
						}
					}
					$this->registry->library('template')->page()->addTag('comments_available', $comments_available);
					$cache = $this->registry->library('db')->cacheData($comments);
					$this->registry->library('template')->page()->addTag('comments', array('DATA', $cache));
					$this->registry->library('template')->page()->addTag('enter_code', $this->registry->library('lang')->line('enter_code'));
					$captcha = $this->registry->library('authenticate')->getCaptcha();
					$this->registry->library('template')->page()->addTag('captcha', $captcha);
					$_SESSION['captcha'] = $captcha;
					$this->registry->library('template')->page()->addTag('new_com_author', $_POST['new_com_author']);
					$this->registry->library('template')->page()->addTag('email', $_POST['email']);
					$this->registry->library('template')->page()->addTag('website', $_POST['website']);
					$this->registry->library('template')->page()->addTag('comment', $_POST['body']);
					$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
					$this->registry->library('template')->page()->addTag('pagination', '');
// Restore CacheOn & Delete Cache
					$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
					if ($this->registry->setting('settings_cached') == 1)
					{
						$this->registry->library('db')->deleteCache('cache_', true);
					}
					$this->registry->library('template')->build('header.tpl', 'more.tpl', 'footer.tpl');
				}
				else
				{
					$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
				}
			}
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

	private function page()
	{
// for Search redirect if absent or too short
		$urlSegments = $this->registry->getURLSegments();
		$_SESSION['redirect'] = '';
		if ($this->registry->library('db')->sanitizeData($urlSegments[0]) != '')
		{
			$_SESSION['redirect'] .= $this->registry->library('db')->sanitizeData($urlSegments[0]);
		}
		if ($this->registry->library('db')->sanitizeData($urlSegments[1]) != '')
		{
			$_SESSION['redirect'] .= '/' . $this->registry->library('db')->sanitizeData($urlSegments[1]);
		}
		if ($this->registry->library('db')->sanitizeData($urlSegments[2]) != '')
		{
			$_SESSION['redirect'] .= '/' . $this->registry->library('db')->sanitizeData($urlSegments[2]);
		}

		if ($this->registry->library('authenticate')->isLoggedIn() == true || $this->registry->setting('settings_guests_allowed') == 1)
		{
			$condition = 'WHERE article_visible = 2';
			$pagination = $this->registry->library('paginate')->createLinksSys('articles', $this->registry->setting('settings_rows_per_page'), 2, $this->registry->setting('settings_site0') . '/page', $condition);
			$this->registry->library('template')->page()->addTag('pagination', $pagination);
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
				$html = $this->registry->library('helper')->simpleCatList($data);
			}
			$this->registry->library('template')->page()->addTag('simple_categories_list', $html);
			$this->registry->library('template')->page()->addTag('categories_available', $categories_available);
			$current_page = $this->seg_2;
			$rows_per_page = $this->registry->setting('settings_rows_per_page');
			$offset = ($current_page - 1) * $rows_per_page;
			$sql = 'SELECT *, COUNT(com_article_id) AS `comments_count`
			FROM ' . $this->prefix . 'articles
			LEFT JOIN ' . $this->prefix . 'users ON ' . $this->prefix . 'users.users_id = ' . $this->prefix . 'articles.author_id
			LEFT JOIN ' . $this->prefix . 'categories ON ' . $this->prefix . 'categories.category_id = ' . $this->prefix . 'articles.categories AND categories_sys = "' . $this->sys_cms . '"
			LEFT JOIN ' . $this->prefix . 'comments ON ' . $this->prefix . 'comments.com_article_id = ' . $this->prefix . 'articles.article_id AND comments_sys = "' . $this->sys_cms . '"
			WHERE article_visible = 2
			AND articles_sys = "' . $this->sys_cms . '"
			GROUP BY article_id
			ORDER BY pinned DESC, article_id DESC
			LIMIT ' . $offset . ',' . $rows_per_page;
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
			{
				$articles = array();
				$i = 0;
				$num = $this->registry->library('db')->numRowsFromCache($cache);
				$data = $this->registry->library('db')->rowsFromCache($cache);
				while ($i < $num)
				{
					foreach ($data as $k => $v)
					{
						$articles[$i]['article_id'] = $v['article_id'];
						$articles[$i]['author_id'] = $v['author_id'];
						$articles[$i]['title'] = $v['title'];
						$articles[$i]['url_title'] = $v['url_title'];
						$articles[$i]['article'] = $v['article'];
						$articles[$i]['article_extended'] = $v['article_extended'];
						$articles[$i]['create_date'] = $this->registry->library('helper')->convertDate($v['art_created']);
						$articles[$i]['create_time'] = $this->registry->library('helper')->convertTime($v['art_created']);
						$articles[$i]['author_name'] = $v['username'];
						$articles[$i]['category_id'] = $v['category_id'];
						$articles[$i]['category_name'] = $v['category_name'];
						$articles[$i]['category_image_name'] = $v['category_image_name'];
						$articles[$i]['comments_count'] = $v['comments_count'];
						if ($v['url_title'] == '')
						{
							$more = $v['article_id'];
						}
						else
						{
							$more = $v['url_title'];
						}
						$articles[$i]['more'] = $more;
// tree of categories?
						if ($this->registry->setting('settings_one_cat') == 0)
						{
							$articles[$i]['one_cat_available'] = 'n';
						}
						else
						{
							$articles[$i]['one_cat_available'] = 'y';
						}
						$articles[$i]['before_blog_article_hook'] = '';
						$before_blog_article_hook = $this->registry->library('hook')->call('before_blog_article_hook', $v['article_id']);
						$articles[$i]['before_blog_article_hook'] = $before_blog_article_hook;
						$i = $i + 1;
					}
				}
			}
			$cache = $this->registry->library('db')->cacheData($articles);
			$this->registry->library('template')->page()->addTag('articles', array('DATA', $cache));
			$this->registry->library('template')->page()->addTag('current_category', '');
			$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
			$this->registry->library('template')->build('header.tpl', 'site.tpl', 'footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

	private function loggedin()
	{
		$username = $this->registry->library('db')->sanitizeData($_POST['auth_user']);
		$password = md5($this->registry->library('db')->sanitizeData($_POST['auth_pass']));
		$sql = 'SELECT *
		FROM ' . $this->prefix . 'users
		WHERE username = "' . $username . '" and password = "' . $password . '"';
		$this->registry->library('db')->execute($sql);
		if ($this->registry->library('db')->numRows() != 0)
		{
			$time = time();
			$check = $_POST['setcookie'];
			if ($check)
			{
				$username = $this->registry->library('crypter')->encrypt($username);
				$password = $this->registry->library('crypter')->encrypt($password);
				setcookie("username", $username, $time + $this->expiretime, '/');
				setcookie("password", $password, $time + $this->expiretime, '/');
			}
			$this->registry->redirectUser('', $this->registry->library('lang')->line('welcome_message'), $this->registry->library('lang')->line('you_are_logged_in_successfully'));
		}
		else
		{
			$this->registry->redirectUser('login', $this->registry->library('lang')->line('wrong_usernamer_or_password'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function logout()
	{
		if ((isset ($_COOKIE['username'])) && (isset ($_COOKIE['password'])))
		{
			$time = time();
			setcookie('username', '', $time - $this->expiretime, '/');
			setcookie('password', '', $time - $this->expiretime, '/');
		}
		$this->registry->library('authenticate')->logout();
		$this->registry->redirectUser('', $this->registry->library('lang')->line('logged_out'), $this->registry->library('lang')->line('you_are_logged_out'));
	}

	private function captchaOutput()
	{
		$this->registry->library('authenticate')->getCaptchaImage($this->seg_2);
	}

	private function category()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isLoggedIn() == true || $this->registry->setting('settings_guests_allowed') == 1)
		{
if (is_numeric($this->seg_2))
{
			$sql = 'SELECT *
				FROM ' . $this->prefix . 'categories
				WHERE categories_sys = "' . $this->sys_cms . '"
				AND category_id =' . $this->seg_2;
}
else
{
			$sql = 'SELECT *
				FROM ' . $this->prefix . 'categories
				WHERE categories_sys = "' . $this->sys_cms . '"
				AND category_url_name = "' . $this->seg_2 . '"';
}

			$this->registry->library('db')->execute($sql);
$curent_category_id = '';
			if ($this->registry->library('db')->numRows() != 0)
			{
				$data = $this->registry->library('db')->getRows();
				$this->registry->library('template')->page()->addTag('current_category', $data['category_name']);

$curent_category_id = $data['category_id'];
			}
			if ($this->seg_3 != 'page')
			{
				if ($this->registry->setting('settings_one_cat') == 0)
				{
					$sql = 'SELECT *, COUNT(com_article_id) AS `comments_count`
					FROM ' . $this->prefix . 'articles
					LEFT JOIN ' . $this->prefix . 'users ON ' . $this->prefix . 'users.users_id = ' . $this->prefix . 'articles.author_id
					LEFT JOIN ' . $this->prefix . 'categories ON ' . $this->prefix . 'categories.category_id = ' . $this->prefix . 'articles.categories AND categories_sys = "' . $this->sys_cms . '"
					LEFT JOIN ' . $this->prefix . 'comments ON ' . $this->prefix . 'comments.com_article_id = ' . $this->prefix . 'articles.article_id AND comments_sys = "' . $this->sys_cms . '"
					LEFT JOIN ' . $this->prefix . 'art_cats ON ' . $this->prefix . 'art_cats.ac_art_id = ' . $this->prefix . 'articles.article_id AND art_cats_sys = "' . $this->sys_cms . '"
					WHERE article_visible = 2
					AND ac_cats_id = ' . $curent_category_id . '
					AND articles_sys = "' . $this->sys_cms . '"
					GROUP BY article_id
					ORDER BY article_id
					DESC LIMIT ' . $this->registry->setting('settings_rows_per_page');
				}
				else
				{
					$sql = 'SELECT *, COUNT(com_article_id) AS `comments_count`
					FROM ' . $this->prefix . 'articles
					LEFT JOIN ' . $this->prefix . 'users ON ' . $this->prefix . 'users.users_id = ' . $this->prefix . 'articles.author_id
					LEFT JOIN ' . $this->prefix . 'categories ON ' . $this->prefix . 'categories.category_id = ' . $this->prefix . 'articles.categories AND categories_sys = "' . $this->sys_cms . '"
					LEFT JOIN ' . $this->prefix . 'comments ON ' . $this->prefix . 'comments.com_article_id = ' . $this->prefix . 'articles.article_id AND comments_sys = "' . $this->sys_cms . '"
					WHERE categories = ' . $curent_category_id . '
					AND article_visible = 2
					AND articles_sys = "' . $this->sys_cms . '"
					GROUP BY article_id
					ORDER BY article_id
					DESC LIMIT ' . $this->registry->setting('settings_rows_per_page');
				}
			}
			else
			{
				$current_page = $this->seg_4;
				$rows_per_page = $this->registry->setting('settings_rows_per_page');
				$offset = ($current_page - 1) * $rows_per_page;
				if ($this->registry->setting('settings_one_cat') == 0)
				{
					$sql = 'SELECT *, COUNT(com_article_id) AS `comments_count`
					FROM ' . $this->prefix . 'articles
					LEFT JOIN ' . $this->prefix . 'users ON ' . $this->prefix . 'users.users_id = ' . $this->prefix . 'articles.author_id
					LEFT JOIN ' . $this->prefix . 'categories ON ' . $this->prefix . 'categories.category_id = ' . $this->prefix . 'articles.categories AND categories_sys = "' . $this->sys_cms . '"
					LEFT JOIN ' . $this->prefix . 'comments ON ' . $this->prefix . 'comments.com_article_id = ' . $this->prefix . 'articles.article_id AND comments_sys = "' . $this->sys_cms . '"
					LEFT JOIN ' . $this->prefix . 'art_cats ON ' . $this->prefix . 'art_cats.ac_art_id = ' . $this->prefix . 'articles.article_id AND art_cats_sys = "' . $this->sys_cms . '"
					WHERE article_visible = 2
					AND ac_cats_id = ' . $curent_category_id . '
					AND articles_sys = "' . $this->sys_cms . '"
					GROUP BY article_id
					ORDER BY article_id
					DESC LIMIT ' . $offset . ',' . $rows_per_page;
				}
				else
				{
					$sql = 'SELECT *, COUNT(com_article_id) AS `comments_count`
					FROM ' . $this->prefix . 'articles
					LEFT JOIN ' . $this->prefix . 'users ON ' . $this->prefix . 'users.users_id = ' . $this->prefix . 'articles.author_id
					LEFT JOIN ' . $this->prefix . 'categories ON ' . $this->prefix . 'categories.category_id = ' . $this->prefix . 'articles.categories AND categories_sys = "' . $this->sys_cms . '"
					LEFT JOIN ' . $this->prefix . 'comments ON ' . $this->prefix . 'comments.com_article_id = ' . $this->prefix . 'articles.article_id AND comments_sys = "' . $this->sys_cms . '"
					WHERE article_visible = 2
					AND categories = ' . $curent_category_id . '
					AND articles_sys = "' . $this->sys_cms . '"
					GROUP BY article_id
					ORDER BY article_id
					DESC LIMIT ' . $offset . ',' . $rows_per_page;
				}
			}
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
			{
				$articles = array();
				$i = 0;
				$num = $this->registry->library('db')->numRowsFromCache($cache);
				$data = $this->registry->library('db')->rowsFromCache($cache);
				while ($i < $num)
				{
					foreach ($data as $k => $v)
					{
						$articles[$i]['article_id'] = $v['article_id'];
						$articles[$i]['author_id'] = $v['author_id'];
						$articles[$i]['title'] = $v['title'];
						$articles[$i]['url_title'] = $v['url_title'];
						$articles[$i]['article'] = $v['article'];
						$articles[$i]['article_extended'] = $v['article_extended'];
						$articles[$i]['create_date'] = $this->registry->library('helper')->convertDate($v['art_created']);
						$articles[$i]['create_time'] = $this->registry->library('helper')->convertTime($v['art_created']);
						if ($v['url_title'] == '')
						{
							$articles[$i]['more'] = $v['article_id'];
						}
						else
						{
							$articles[$i]['more'] = $v['url_title'];
						}
						$articles[$i]['author_name'] = $v['username'];
						$articles[$i]['category_id'] = $v['category_id'];
						$articles[$i]['category_name'] = $v['category_name'];
						$articles[$i]['category_image_name'] = $v['category_image_name'];
						$articles[$i]['comments_count'] = $v['comments_count'];
// tree of categories?
						if ($this->registry->setting('settings_one_cat') == 0)
						{
							$articles[$i]['one_cat_available'] = 'n';
						}
						else
						{
							$articles[$i]['one_cat_available'] = 'y';
						}
						$i = $i + 1;
					}
				}
			}
			$cache = $this->registry->library('db')->cacheData($articles);
			$this->registry->library('template')->page()->addTag('articles', array('DATA', $cache));
			$condition = 'WHERE categories = ' . $curent_category_id;
			$pagination = $this->registry->library('paginate')->createLinksSys('articles', $this->registry->setting('settings_rows_per_page'), 4, $this->registry->setting('settings_site0') . '/category/' . $this->seg_2 . '/page', $condition);
			$this->registry->library('template')->page()->addTag('pagination', $pagination);
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
				$html = $this->registry->library('helper')->simpleCatList($data, $curent_category_id);
			}
			$this->registry->library('template')->page()->addTag('simple_categories_list', $html);
			$this->registry->library('template')->page()->addTag('categories_available', $categories_available);
			$this->registry->library('template')->build('header.tpl', 'site.tpl', 'footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

	private function search()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isLoggedIn() == true || $this->registry->setting('settings_guests_allowed') == 1)
		{
			$search = trim($this->registry->library('db')->sanitizeData($_POST['search']));
			$_SESSION['search'] = $search;
			$redirect = '';
			if ($_SESSION['redirect'] != '')
			{
				$redirect = $_SESSION['redirect'];
			}

			if ($search == '')
			{
				
				$this->registry->redirectUser($redirect, $this->registry->library('lang')->line('search_absent'), $this->registry->library('lang')->line('search_absent_message'));
			}
			elseif (strlen($search) < 4)
			{
				$this->registry->redirectUser($redirect, $this->registry->library('lang')->line('search_short'), $this->registry->library('lang')->line('search_short_message'));
			}
			else
			{
				$pieces = explode(" ", $search);
				reset($pieces);
				foreach ($pieces as $key => $value)
				{
					$search_condition .= 'AND (article LIKE "%' . $value . '%" OR article_extended LIKE "%' . $value . '%" OR title LIKE "%' . $value . '%") ';
				}

// Selection of Articles
// article_visible = enum "1"
				$cache = $this->registry->library('db')->cacheQuery('SELECT *, COUNT(com_article_id) AS `comments_count`
				FROM ' . $this->prefix . 'articles
				LEFT JOIN ' . $this->prefix . 'users ON ' . $this->prefix . 'users.users_id = ' . $this->prefix . 'articles.author_id
				LEFT JOIN ' . $this->prefix . 'categories ON ' . $this->prefix . 'categories.category_id = ' . $this->prefix . 'articles.categories
				LEFT JOIN ' . $this->prefix . 'comments ON ' . $this->prefix . 'comments.com_article_id = ' . $this->prefix . 'articles.article_id
				WHERE article_visible = 2
				AND articles_sys = "' . $this->sys_cms . '"
				' . $search_condition . '
				GROUP BY article_id
				ORDER BY pinned DESC, article_id DESC
				LIMIT ' . $this->registry->setting('settings_rows_per_page'));
				$num = $this->registry->library('db')->numRowsFromCache($cache);
				if ($num != 0)
				{
					$articles = array();
					$i = 0;
					$data = $this->registry->library('db')->rowsFromCache($cache);
					while ($i < $num)
					{
						foreach ($data as $k => $v)
						{
							$articles[$i]['article_id'] = $v['article_id'];
							$articles[$i]['author_id'] = $v['author_id'];
							$articles[$i]['title'] = $v['title'];
							$articles[$i]['url_title'] = $v['url_title'];
							$articles[$i]['article'] = $v['article'];
							$articles[$i]['article_extended'] = $v['article_extended'];
							$articles[$i]['create_date'] = $this->registry->library('helper')->convertDate($v['art_created']);
							$articles[$i]['create_time'] = $this->registry->library('helper')->convertTime($v['art_created']);
							if ($v['url_title'] == '')
							{
								$articles[$i]['more'] = $v['article_id'];
							}
							else
							{
								$articles[$i]['more'] = $v['url_title'];
							}
							$articles[$i]['author_name'] = $v['username'];
							$articles[$i]['category_id'] = $v['categories'];
							$articles[$i]['category_name'] = $v['category_name'];
							$articles[$i]['category_image_name'] = $v['category_image_name'];
							$articles[$i]['comments_count'] = $v['comments_count'];
// tree of categories?
							if ($this->registry->setting('settings_one_cat') == 0)
							{
								$articles[$i]['one_cat_available'] = 'n';
							}
							else
							{
								$articles[$i]['one_cat_available'] = 'y';
							}
							$i = $i + 1;
						}
					}
				}
				$cache = $this->registry->library('db')->cacheData($articles);
				$this->registry->library('template')->page()->addTag('articles', array('DATA', $cache));
// $table, $rows_per_page, $pag_seg_number, $urlstring, $condition
				$condition = 'WHERE article_visible = 2
				' . $search_condition;
				$pagination = $this->registry->library('paginate')->createLinksSys('articles', $this->registry->setting('settings_rows_per_page'), 3, $this->registry->setting('settings_site0') . '/search_page', $condition);
				$this->registry->library('template')->page()->addTag('pagination', $pagination);
				$this->registry->library('template')->page()->addTag('current_category', '');
// HTML list of all categories
				$categories_available = '';
				$html = '';
				$sql = 'SELECT *
				FROM ' . $this->prefix . 'categories
				WHERE categories_sys = "' . $this->sys_cms . '"
				ORDER BY category_order ASC';
				$cache = $this->registry->library('db')->cacheQuery($sql);
				if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
				{
					$categories_available = 'y';
					$data = $this->registry->library('db')->rowsFromCache($cache);
					$html = $this->registry->library('helper')->simpleCatList($data);
				}
				$this->registry->library('template')->page()->addTag('simple_categories_list', $html);
				$this->registry->library('template')->page()->addTag('categories_available', $categories_available);
				$this->registry->library('template')->build('header.tpl', 'search.tpl', 'footer.tpl');
			}
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

	private function search_page()
	{
// for Search redirect if absent or too short
		$urlSegments = $this->registry->getURLSegments();
		$_SESSION['redirect'] = '';
		if ($this->registry->library('db')->sanitizeData($urlSegments[0]) != '')
		{
			$_SESSION['redirect'] .= $this->registry->library('db')->sanitizeData($urlSegments[0]);
		}
		if ($this->registry->library('db')->sanitizeData($urlSegments[1]) != '')
		{
			$_SESSION['redirect'] .= '/' . $this->registry->library('db')->sanitizeData($urlSegments[1]);
		}
		if ($this->registry->library('db')->sanitizeData($urlSegments[2]) != '')
		{
			$_SESSION['redirect'] .= '/' . $this->registry->library('db')->sanitizeData($urlSegments[2]);
		}

		if ($this->registry->library('authenticate')->isLoggedIn() == true || $this->registry->setting('settings_guests_allowed') == 1)
		{
			$search = trim($this->registry->library('db')->sanitizeData($_SESSION['search']));
			$search_condition = 'AND (article LIKE "%' . $search . '%" OR article_extended LIKE "%' . $search . '%" OR title LIKE "%' . $search . '%") ';
			$condition = 'WHERE article_visible = 2
			' . $search_condition;
			$pagination = $this->registry->library('paginate')->createLinksSys('articles', $this->registry->setting('settings_rows_per_page'), 2, $this->registry->setting('settings_site0') . '/search_page', $condition);
			$this->registry->library('template')->page()->addTag('pagination', $pagination);
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
				$html = $this->registry->library('helper')->simpleCatList($data);
			}
			$this->registry->library('template')->page()->addTag('simple_categories_list', $html);
			$this->registry->library('template')->page()->addTag('categories_available', $categories_available);
			$current_page = $this->seg_2;
			$rows_per_page = $this->registry->setting('settings_rows_per_page');
			$offset = ($current_page - 1) * $rows_per_page;
			$sql = 'SELECT *, COUNT(com_article_id) AS `comments_count`
			FROM ' . $this->prefix . 'articles
			LEFT JOIN ' . $this->prefix . 'users ON ' . $this->prefix . 'users.users_id = ' . $this->prefix . 'articles.author_id
			LEFT JOIN ' . $this->prefix . 'categories ON ' . $this->prefix . 'categories.category_id = ' . $this->prefix . 'articles.categories AND categories_sys = "' . $this->sys_cms . '"
			LEFT JOIN ' . $this->prefix . 'comments ON ' . $this->prefix . 'comments.com_article_id = ' . $this->prefix . 'articles.article_id AND comments_sys = "' . $this->sys_cms . '"
			WHERE article_visible = 2
			' . $search_condition . '
			AND articles_sys = "' . $this->sys_cms . '"
			GROUP BY article_id
			ORDER BY pinned DESC, article_id DESC
			LIMIT ' . $offset . ',' . $rows_per_page;
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
			{
				$articles = array();
				$i = 0;
				$num = $this->registry->library('db')->numRowsFromCache($cache);
				$data = $this->registry->library('db')->rowsFromCache($cache);
				while ($i < $num)
				{
					foreach ($data as $k => $v)
					{
						$articles[$i]['article_id'] = $v['article_id'];
						$articles[$i]['author_id'] = $v['author_id'];
						$articles[$i]['title'] = $v['title'];
						$articles[$i]['url_title'] = $v['url_title'];
						$articles[$i]['article'] = $v['article'];
						$articles[$i]['article_extended'] = $v['article_extended'];
						$articles[$i]['create_date'] = $this->registry->library('helper')->convertDate($v['art_created']);
						$articles[$i]['create_time'] = $this->registry->library('helper')->convertTime($v['art_created']);
						$articles[$i]['author_name'] = $v['username'];
						$articles[$i]['category_id'] = $v['category_id'];
						$articles[$i]['category_name'] = $v['category_name'];
						$articles[$i]['category_image_name'] = $v['category_image_name'];
						$articles[$i]['comments_count'] = $v['comments_count'];
						if ($v['url_title'] == '')
						{
							$more = $v['article_id'];
						}
						else
						{
							$more = $v['url_title'];
						}
						$articles[$i]['more'] = $more;
// tree of categories?
						if ($this->registry->setting('settings_one_cat') == 0)
						{
							$articles[$i]['one_cat_available'] = 'n';
						}
						else
						{
							$articles[$i]['one_cat_available'] = 'y';
						}
						$i = $i + 1;
					}
				}
			}
			$cache = $this->registry->library('db')->cacheData($articles);
			$this->registry->library('template')->page()->addTag('articles', array('DATA', $cache));
			$this->registry->library('template')->page()->addTag('current_category', '');
			$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
			$this->registry->library('template')->build('header.tpl', 'search.tpl', 'footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

	private function rss()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isLoggedIn() == true || $this->registry->setting('settings_guests_allowed') == 1)
		{
// Selection of Articles
// article_visible = enum "1"
			$sql = 'SELECT *, COUNT(com_article_id) AS `comments_count`
				FROM ' . $this->prefix . 'articles
				LEFT JOIN ' . $this->prefix . 'users ON ' . $this->prefix . 'users.users_id = ' . $this->prefix . 'articles.author_id
				LEFT JOIN ' . $this->prefix . 'categories ON ' . $this->prefix . 'categories.category_id = ' . $this->prefix . 'articles.categories AND categories_sys = "' . $this->sys_cms . '"
				LEFT JOIN ' . $this->prefix . 'comments ON ' . $this->prefix . 'comments.com_article_id = ' . $this->prefix . 'articles.article_id AND comments_sys = "' . $this->sys_cms . '"
				WHERE article_visible = 2
				AND articles_sys = "' . $this->sys_cms . '"
				GROUP BY article_id
				ORDER BY pinned DESC, article_id DESC
				LIMIT ' . $this->registry->setting('settings_rows_per_page');
			$cache = $this->registry->library('db')->cacheQuery($sql);
			$num = $this->registry->library('db')->numRowsFromCache($cache);
			if ($num != 0)
			{
				$articles = array();
				$i = 0;
				$data = $this->registry->library('db')->rowsFromCache($cache);
				while ($i < $num)
				{
					foreach ($data as $k => $v)
					{
						$articles[$i]['article_id'] = $v['article_id'];
						$v['author_id'] = $this->rssTags($v['author_id']);
						$articles[$i]['author_id'] = $v['author_id'];
						$v['title'] = $this->rssTags($v['title']);
						$v['title'] = str_replace('--', '&#8212;', $v['title']);
						$articles[$i]['title'] = $v['title'];
						$articles[$i]['url_title'] = $v['url_title'];
						$v['article'] = $this->rssTags($v['article']);
						$articles[$i]['article'] = strip_tags($v['article'], '<p><a><br><ul><ol><li>');
						$articles[$i]['article'] = str_replace('&amp;nbsp;', '&nbsp;', $articles[$i]['article']);
						$v['article_extended'] = $this->rssTags($v['article_extended']);
						$articles[$i]['article_extended'] = strip_tags($v['article_extended'], '<p><a><br><ul><ol><li>');
						$articles[$i]['article'] = str_replace('&amp;nbsp;', '&nbsp;', $articles[$i]['article']);
						$articles[$i]['create_date'] = $this->registry->library('helper')->convertDate($v['art_created']);
						$articles[$i]['create_time'] = $this->registry->library('helper')->convertTime($v['art_created']);
						$articles[$i]['datetime'] = $this->registry->library('helper')->rssDate($v['art_created']);
						if ($v['url_title'] == '')
						{
							$articles[$i]['more'] = $v['article_id'];
						}
						else
						{
							$articles[$i]['more'] = $v['url_title'];
						}
						$articles[$i]['author_name'] = $v['username'];
						$articles[$i]['category_id'] = $v['category_id'];
						$articles[$i]['category_name'] = $v['category_name'];
						$articles[$i]['category_image_name'] = $v['category_image_name'];
						$articles[$i]['comments_count'] = $v['comments_count'];
						$i = $i + 1;
					}
				}
			}
			$cache = $this->registry->library('db')->cacheData($articles);
			$this->registry->library('template')->page()->addTag('articles', array('DATA', $cache));
			$this->registry->library('template')->build('rss.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

	private function rssTags($content)
	{
		$bbcode_rss = array("/\[youtube\](.*?)\[\/youtube\]/is" => "");
		$content = preg_replace(array_keys($bbcode_rss), array_values($bbcode_rss), $content);
		$content = str_replace("&", "&amp;", $content);
		$content = str_replace('&amp;#123;', '{', $content);
		$content = str_replace('&amp;#125;', '}', $content);
		return $content;
	}

	private function calendar()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isLoggedIn() == true || $this->registry->setting('settings_guests_allowed') == 1)
		{
// Selection of Articles
// article_visible = enum "1"
			if ($this->seg_4)
			{
				$datetimeSearch = 'AND art_created between "' . $this->seg_2 . '-' . $this->seg_3 . '-' . $this->seg_4 . ' 00:00:00" and "' . $this->seg_2 . '-' . $this->seg_3 . '-' . $this->seg_4 . ' 23:59:59"';
				$htmlCalendar = $this->registry->library('helper')->blogCalendar($this->seg_2, $this->seg_3, $this->seg_4);
			}
			else
			{
				$datetimeSearch = 'AND art_created between "' . $this->seg_2 . '-' . $this->seg_3 . '-01 00:00:00" and "' . $this->seg_2 . '-' . $this->seg_3 . '-31 23:59:59"';
				$htmlCalendar = $this->registry->library('helper')->blogCalendar($this->seg_2, $this->seg_3, 0);
			}
			$this->registry->library('template')->page()->addTag('blogCalendar', $htmlCalendar);
			$cache = $this->registry->library('db')->cacheQuery('SELECT *, COUNT(com_article_id) AS `comments_count`
			FROM ' . $this->prefix . 'articles
			LEFT JOIN ' . $this->prefix . 'users ON ' . $this->prefix . 'users.users_id = ' . $this->prefix . 'articles.author_id
			LEFT JOIN ' . $this->prefix . 'categories ON ' . $this->prefix . 'categories.category_id = ' . $this->prefix . 'articles.categories
			LEFT JOIN ' . $this->prefix . 'comments ON ' . $this->prefix . 'comments.com_article_id = ' . $this->prefix . 'articles.article_id
			WHERE article_visible = 2
			AND articles_sys = "' . $this->sys_cms . '"' . $datetimeSearch . '
			GROUP BY article_id
			ORDER BY pinned DESC, article_id DESC');
// DEV OFF
//			LIMIT ' . $this->registry->setting('settings_rows_per_page'));
			$num = $this->registry->library('db')->numRowsFromCache($cache);
			if ($num != 0)
			{
				$articles = array();
				$i = 0;
				$data = $this->registry->library('db')->rowsFromCache($cache);
				while ($i < $num)
				{
					foreach ($data as $k => $v)
					{
						$articles[$i]['article_id'] = $v['article_id'];
						$articles[$i]['author_id'] = $v['author_id'];
						$articles[$i]['title'] = $v['title'];
						$articles[$i]['url_title'] = $v['url_title'];
						$articles[$i]['article'] = $v['article'];
						$articles[$i]['article_extended'] = $v['article_extended'];
						$articles[$i]['create_date'] = $this->registry->library('helper')->convertDate($v['art_created']);
						$articles[$i]['create_time'] = $this->registry->library('helper')->convertTime($v['art_created']);
						if ($v['url_title'] == '')
						{
							$articles[$i]['more'] = $v['article_id'];
						}
						else
						{
							$articles[$i]['more'] = $v['url_title'];
						}
						$articles[$i]['author_name'] = $v['username'];
						$articles[$i]['category_id'] = $v['categories'];
						$articles[$i]['category_name'] = $v['category_name'];
						$articles[$i]['category_image_name'] = $v['category_image_name'];
						$articles[$i]['comments_count'] = $v['comments_count'];
// tree of categories?
						if ($this->registry->setting('settings_one_cat') == 0)
						{
							$articles[$i]['one_cat_available'] = 'n';
						}
						else
						{
							$articles[$i]['one_cat_available'] = 'y';
						}
						$i = $i + 1;
					}
				}
			}
			$cache = $this->registry->library('db')->cacheData($articles);
			$this->registry->library('template')->page()->addTag('articles', array('DATA', $cache));
// $table, $rows_per_page, $pag_seg_number, $urlstring, $condition
			$condition = 'WHERE article_visible = 2';
			$pagination = $this->registry->library('paginate')->createLinksSys('articles', $this->registry->setting('settings_rows_per_page'), 3, $this->registry->setting('settings_site0') . '/page', $condition);
// DEV OFF
			$pagination = '';
			$this->registry->library('template')->page()->addTag('pagination', $pagination);
			$this->registry->library('template')->page()->addTag('current_category', '');
// HTML list of all categories
			$categories_available = '';
			$html = '';
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'categories
			WHERE categories_sys = "' . $this->sys_cms . '"
			ORDER BY category_order ASC';
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
			{
				$categories_available = 'y';
				$data = $this->registry->library('db')->rowsFromCache($cache);
				$html = $this->registry->library('helper')->simpleCatList($data);
			}
			$this->registry->library('template')->page()->addTag('simple_categories_list', $html);
			$this->registry->library('template')->page()->addTag('categories_available', $categories_available);
			$this->registry->library('template')->build('header.tpl', 'site.tpl', 'footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

}
?>