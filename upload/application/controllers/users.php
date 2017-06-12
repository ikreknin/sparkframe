<?php

class Userscontroller
{
	private $registry;
	private $model;
	private $prefix;
	private $sys_cms;
	private $seg_1;
	private $seg_2;
	private $guestsAllowed = 1;

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

			$this->registry->library('template')->page()->addTag('cms_title', $this->registry->setting('settings_cms_title'));
			$this->registry->library('template')->page()->addTag('charset', $this->registry->setting('settings_charset'));
			$this->registry->library('template')->page()->addTag('metakeywords', $this->registry->setting('settings_metakeywords'));
			$this->registry->library('template')->page()->addTag('metadescription', $this->registry->setting('settings_metadescription'));
			$this->registry->library('template')->page()->addTag('home', $this->registry->library('lang')->line('home'));
			$this->registry->library('template')->page()->addTag('admin_home', $this->registry->library('lang')->line('admin_home'));
			$this->registry->library('template')->page()->addTag('logout', $this->registry->library('lang')->line('logout'));
			$this->registry->library('template')->page()->addTag('login', $this->registry->library('lang')->line('login'));
			$this->registry->library('template')->page()->addTag('guest', $this->registry->library('lang')->line('guest'));
			$this->registry->library('template')->page()->addTag('welcome', $this->registry->library('lang')->line('welcome'));
			$this->registry->library('template')->page()->addTag('registration', $this->registry->library('lang')->line('registration'));
			$this->registry->library('template')->page()->addTag('cp', $this->registry->library('lang')->line('cp'));
			$this->registry->library('template')->page()->addTag('forum_text', $this->registry->library('lang')->line('forum_text'));
			$this->registry->library('template')->page()->addTag('shop_text', $this->registry->library('lang')->line('shop_text'));
			$this->registry->library('template')->page()->addTag('blog_text', $this->registry->library('lang')->line('blog_text'));
			$this->registry->library('template')->page()->addTag('contact', $this->registry->library('lang')->line('contact'));
			$this->registry->library('template')->page()->addTag('username_text', $this->registry->library('lang')->line('username_text'));
//			$this->registry->library('template')->page()->addTag('name_text', $this->registry->library('lang')->line('name'));
			$this->registry->library('template')->page()->addTag('registration', $this->registry->library('lang')->line('registration'));
			$this->registry->library('template')->page()->addTag('click_here_if', $this->registry->library('lang')->line('click_here_if'));
			$this->registry->library('template')->page()->addTag('sections_text', $this->registry->library('lang')->line('sections_text'));
			$this->registry->library('template')->page()->addTag('delete_question', $this->registry->library('lang')->line('delete_question'));
			if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
			{
				$this->registry->library('template')->page()->addTag('admin_level', '1');
			}
			else
			{
				$this->registry->library('template')->page()->addTag('admin_level', '0');
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

					case 'page' :
						$this->page();
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
		if ($this->registry->library('authenticate')->isLoggedIn() == true || $this->registry->setting('settings_guests_allowed') == $this->guestsAllowed)
		{
			$pagination = $this->registry->library('paginate')->createLinks('users', $this->registry->setting('settings_users_per_page'), 3, 'users/page');
			$this->registry->library('template')->page()->addTag('pagination', $pagination);
			$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->library('lang')->line('users_list'));
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('users_list'));
			$cache = $this->registry->library('db')->cacheQuery('SELECT * FROM ' . $this->prefix . 'users ORDER BY users_id ASC LIMIT ' . $this->registry->setting('settings_users_per_page'));
			$this->registry->library('template')->page()->addTag('users', array('SQL', $cache));
			$this->registry->library('template')->build('header.tpl', 'users.tpl', 'footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('login', $this->registry->library('lang')->line('you_are_not_logged_in'), $this->registry->library('lang')->line('please_log_in_or_register'));
		}
	}

	private function page()
	{
		if ($this->registry->library('authenticate')->isLoggedIn() == true || $this->registry->setting('settings_guests_allowed') == $this->guestsAllowed)
		{
			$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->library('lang')->line('members'));
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('members'));
			$pagination = $this->registry->library('paginate')->createLinks('users', $this->registry->setting('settings_users_per_page'), 2, 'users/page');
			$this->registry->library('template')->page()->addTag('pagination', $pagination);
			$current_page = $this->seg_2;
			$offset = ($current_page - 1) * $this->registry->setting('settings_users_per_page');
			$sql = "SELECT *
			FROM " . $this->prefix . "users
			ORDER BY users_id ASC
			LIMIT " . $offset . "," . $this->registry->setting('settings_users_per_page');
			$cache = $this->registry->library('db')->cacheQuery($sql);
			$this->registry->library('template')->page()->addTag('users', array('SQL', $cache));
			$this->registry->library('template')->build('header.tpl', 'users.tpl', 'footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('login', $this->registry->library('lang')->line('you_are_not_logged_in'), $this->registry->library('lang')->line('please_log_in_or_register'));
		}
	}

}
?>