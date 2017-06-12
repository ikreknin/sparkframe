<?php

class Usercontroller
{
	private $registry;
	private $prefix;
	private $sys_cms;
	private $model;
	private $seg_1;
	private $seg_2;

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
			$this->registry->library('template')->addTemplateSegment('top_bar_tpl', 'top_bar_tpl.tpl');
			$this->registry->library('template')->addTemplateSegment('top_menu_tpl', 'top_menu_tpl.tpl');
			$this->registry->library('template')->page()->addTag('cms_title', $this->registry->setting('settings_cms_title'));
			$this->registry->library('template')->page()->addTag('charset', $this->registry->setting('settings_charset'));
			$this->registry->library('template')->page()->addTag('metakeywords', $this->registry->setting('settings_metakeywords'));
			$this->registry->library('template')->page()->addTag('metadescription', $this->registry->setting('settings_metadescription'));
			$this->registry->library('template')->page()->addTag('username_text', $this->registry->library('lang')->line('username_text'));
			$this->registry->library('template')->page()->addTag('home', $this->registry->library('lang')->line('home'));
			$this->registry->library('template')->page()->addTag('cp', $this->registry->library('lang')->line('cp'));
			$this->registry->library('template')->page()->addTag('forum_text', $this->registry->library('lang')->line('forum_text'));
			$this->registry->library('template')->page()->addTag('shop_text', $this->registry->library('lang')->line('shop_text'));
			$this->registry->library('template')->page()->addTag('blog_text', $this->registry->library('lang')->line('blog_text'));
			$this->registry->library('template')->page()->addTag('welcome', $this->registry->library('lang')->line('welcome'));
			$this->registry->library('template')->page()->addTag('login', $this->registry->library('lang')->line('login'));
			$this->registry->library('template')->page()->addTag('logout', $this->registry->library('lang')->line('logout'));
			$this->registry->library('template')->page()->addTag('admin_home', $this->registry->library('lang')->line('admin_home'));
			$this->registry->library('template')->page()->addTag('contact', $this->registry->library('lang')->line('contact'));
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
			$this->registry->library('template')->page()->addTag('settings', $this->registry->library('lang')->line('settings'));
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
			$urlSegments = $this->registry->getURLSegments();
			$this->seg_1 = $this->registry->library('db')->sanitizeData($urlSegments[1]);
			$this->seg_2 = $this->registry->library('db')->sanitizeData($urlSegments[2]);
			if (true)
			{
				$this->registry->library('template')->page()->addTag('jquery', '<script type="text/javascript" src="' . FWURL . SUBDIR . 'js/jquery/' . $this->registry->setting('settings_jquery') . '"></script>');
			}
			if (true)
			{
				$this->registry->library('template')->page()->addTag('editor', '<script type="text/javascript" src="' . FWURL . SUBDIR . 'js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
	remove_script_host : false,
	convert_urls : false,

	mode : "textareas",
	theme : "advanced",
	theme_advanced_toolbar_location : "top",
	file_browser_callback : "tinyBrowser",
	plugins : "syntaxhl",
	theme_advanced_buttons1 : "bold, italic, underline, separator, undo, redo, separator, link, unlink, separator, image, separator, forecolor, separator, styleselect, removeformat, cleanup, code, separator, syntaxhl",
	theme_advanced_buttons2 : "bullist, numlist, separator, outdent, indent, separator, hr, separator, sub, sup, separator, charmap",
	theme_advanced_buttons3 : "",
	remove_linebreaks : false,
	extended_valid_elements : "textarea[cols|rows|disabled|name|readonly|class]"
});
</script>');
				$this->registry->library('template')->page()->addTag('tinybrowser', '<script src="' . FWURL . SUBDIR . 'js/tiny_mce/plugins/tinybrowser/tb_tinymce.js.php" type="text/javascript"></script>');
			}
			if (true)
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
			$this->registry->library('template')->page()->addTag('highlighter', '');
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

					case 'id' :
						$this->id();
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
		if ($this->registry->library('authenticate')->isLoggedIn() == true)
		{
			$this->pageNotFound();
		}
		else
		{
			$this->registry->redirectUser('login', $this->registry->library('lang')->line('you_are_not_logged_in'), $this->registry->library('lang')->line('please_log_in_or_register'));
		}
	}

	private function id()
	{
		if (!isset ($this->seg_2))
		{
			$this->pageNotFound();
		}
		else
		{
			if ($this->registry->library('authenticate')->isLoggedIn() == true)
			{
				$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->library('lang')->line('member'));
				$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('member'));
				$sql = "SELECT *
				FROM " . $this->prefix . "users
				WHERE users_id='{$this->seg_2}'";
				$cache = $this->registry->library('db')->cacheQuery($sql);
				$this->registry->library('template')->page()->addTag('users', array('SQL', $cache));
				$this->registry->library('template')->addTemplateSegment('top_menu_tpl', 'top_menu_tpl.tpl');
				$this->registry->library('template')->build('header.tpl', 'user.tpl', 'footer.tpl');
			}
			else
			{
				$this->registry->redirectUser('login', $this->registry->library('lang')->line('you_are_not_logged_in'), $this->registry->library('lang')->line('please_log_in_or_register'));
			}
		}
	}

}
?>