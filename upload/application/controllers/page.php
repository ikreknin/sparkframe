<?php

class Pagecontroller
{
	private $registry;
	private $prefix;
	private $sys_cms;
	private $noreply_email;

	public function __construct(Registry $registry, $directCall)
	{
		$this->registry = $registry;
		if ($directCall == true)
		{
			$this->prefix = $this->registry->library('db')->getPrefix();
			$this->sys_cms = $this->registry->library('db')->getSys();
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
			$this->noreply_email = 'no-reply@' . substr(substr(FWURL, 7), 0, - 1);
			$this->registry->library('template')->page()->addTag('VIEWDIR', FWURL . APPDIR . '/views/' . $this->registry->setting('theme') . '/');
			$this->registry->library('template')->page()->addTag('site_url', FWURL);
			$this->registry->library('template')->page()->addTag('CMS0', $this->registry->setting('settings_site0'));
			$this->registry->library('template')->page()->addTag('FORUM0', $this->registry->setting('settings_forum0'));
			$this->registry->library('template')->page()->addTag('SHOP0', $this->registry->setting('settings_shop0'));

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
			$this->registry->library('template')->page()->addTag('guest', $this->registry->library('lang')->line('guest'));
			$this->registry->library('template')->page()->addTag('welcome', $this->registry->library('lang')->line('welcome'));
			$this->registry->library('template')->page()->addTag('registration', $this->registry->library('lang')->line('registration'));
			$this->registry->library('template')->page()->addTag('charset', $this->registry->setting('settings_charset'));
			$this->registry->library('template')->page()->addTag('metakeywords', $this->registry->setting('settings_metakeywords'));
			$this->registry->library('template')->page()->addTag('metadescription', $this->registry->setting('settings_metadescription'));
			$this->registry->library('template')->page()->addTag('click_here_if', $this->registry->library('lang')->line('click_here_if'));
			$this->registry->library('template')->page()->addTag('home', $this->registry->library('lang')->line('home'));
			$this->registry->library('template')->page()->addTag('admin_home', $this->registry->library('lang')->line('admin_home'));
			$this->registry->library('template')->page()->addTag('login', $this->registry->library('lang')->line('login'));
			$this->registry->library('template')->page()->addTag('logout', $this->registry->library('lang')->line('logout'));
			$this->registry->library('template')->page()->addTag('username_text', $this->registry->library('lang')->line('username_text'));
			$this->registry->library('template')->page()->addTag('password_text', $this->registry->library('lang')->line('password_text'));
			$this->registry->library('template')->page()->addTag('registration', $this->registry->library('lang')->line('registration'));
			$this->registry->library('template')->page()->addTag('register', $this->registry->library('lang')->line('register'));
			$this->registry->library('template')->page()->addTag('forgot_pass', $this->registry->library('lang')->line('forgot_pass'));
			$this->registry->library('template')->page()->addTag('cp', $this->registry->library('lang')->line('cp'));
			$this->registry->library('template')->page()->addTag('sitename', $this->registry->setting('settings_cms_title'));
			$this->registry->library('template')->page()->addTag('forum_text', $this->registry->library('lang')->line('forum_text'));
			$this->registry->library('template')->page()->addTag('shop_text', $this->registry->library('lang')->line('shop_text'));
			$this->registry->library('template')->page()->addTag('blog_text', $this->registry->library('lang')->line('blog_text'));
			$this->registry->library('template')->page()->addTag('contact', $this->registry->library('lang')->line('contact'));
			$this->registry->library('template')->page()->addTag('name', $this->registry->library('lang')->line('name'));
			$this->registry->library('template')->page()->addTag('message', $this->registry->library('lang')->line('message'));
			$this->registry->library('template')->page()->addTag('enter_code', $this->registry->library('lang')->line('enter_code'));
			$this->registry->library('template')->page()->addTag('submit', $this->registry->library('lang')->line('submit'));
			$this->registry->library('template')->page()->addTag('terms_of_service', $this->registry->library('lang')->line('terms_of_service'));
			$this->registry->library('template')->page()->addTag('terms_of_service_text', $this->registry->library('lang')->line('terms_of_service_text'));
			$this->registry->library('template')->page()->addTag('agree_terms_of_service', $this->registry->library('lang')->line('agree_terms_of_service'));
			$this->registry->library('template')->page()->addTag('sections_text', $this->registry->library('lang')->line('sections_text'));
			$this->registry->library('template')->page()->addTag('delete_question', $this->registry->library('lang')->line('delete_question'));
			$this->registry->library('template')->page()->addTag('users_text', $this->registry->library('lang')->line('users_text'));
			$this->registry->library('template')->page()->addTag('system', $this->registry->library('lang')->line('system'));
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
			$this->registry->library('template')->page()->addTag('remember_me', $this->registry->library('lang')->line('remember_me'));
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
			$urlSegments = $this->registry->getURLSegments();
			$this->registry->library('template')->page()->addTag('blogCalendar', '');
			$this->registry->library('template')->page()->addTag('jquery', '<script type="text/javascript" src="' . FWURL . SUBDIR . 'js/jquery/' . $this->registry->setting('settings_jquery') . '"></script>');
			$this->registry->library('template')->page()->addTag('editor', '');
			$this->registry->library('template')->page()->addTag('bbcodeeditor', '');

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
//
			$w = $this->registry->widget('nivoslider_widget')->index();
			$this->registry->library('template')->addWidgetTag('nivoslider_widget', $w);
//
//
			$w = $this->registry->widget('ajaxemailsignup_widget')->index();
			$this->registry->library('template')->addWidgetTag('ajaxemailsignup_widget', $w);
//
//
			$w = $this->registry->widget('pages_menu_vertical_widget')->index();
			$this->registry->library('template')->addWidgetTag('pages_menu_vertical_widget', $w);
//
//
			$w = $this->registry->widget('latest_articles_plus_widget')->index(3);
			$this->registry->library('template')->addWidgetTag('latest_articles_plus_widget', $w);
//
//
			$w = $this->registry->widget('piecemaker_widget')->index();
			$this->registry->library('template')->addWidgetTag('piecemaker_widget', $w);
//
//
			$w = $this->registry->widget('googlemaps_widget')->index();
			$this->registry->library('template')->addWidgetTag('googlemaps_widget', $w);
//
//
			$w = $this->registry->widget('monthly_archive_widget')->index();
			$this->registry->library('template')->addWidgetTag('monthly_archive_widget', $w);
//
//
			$w = $this->registry->widget('wdsolutions_slider_widget')->index();
			$this->registry->library('template')->addWidgetTag('wdsolutions_slider_widget', $w);
//
//
			$w = $this->registry->widget('slidedeck_widget')->index();
			$this->registry->library('template')->addWidgetTag('slidedeck_widget', $w);
//
//
			$w = $this->registry->widget('jtabsrss_widget')->index();
			$this->registry->library('template')->addWidgetTag('jtabsrss_widget', $w);
//
			$w = $this->registry->widget('latest_articles_frontpage_widget')->index();
			$this->registry->library('template')->addWidgetTag('latest_articles_frontpage_widget', $w);
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
			$w = $this->registry->widget('jssorslider_widget')->index();
			$this->registry->library('template')->addWidgetTag('jssorslider_widget', $w);
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
			if ($urlSegments[0] == '' && $this->registry->setting('settings_cms_enabled') == 'y')
			{
				$this->index();
			}
			elseif ($this->registry->setting('settings_cms_enabled') != 'y')
			{
				$this->siteClosed();
			}
			else
			{
// Static Page ?
				$sql = 'SELECT *
					FROM ' . $this->prefix . 'static
					WHERE static_sys = "' . $this->sys_cms . '"
					AND page_url_1 = "' . $urlSegments[0] . '"
					AND page_url_2 = "' . $urlSegments[1] . '"
					AND page_url_3 = "' . $urlSegments[2] . '"
					AND page_url_4 = "' . $urlSegments[3] . '"
					AND page_url_5 = "' . $urlSegments[4] . '"
					AND page_url_6 = "' . $urlSegments[5] . '"
					AND page_url_7 = "' . $urlSegments[6] . '"
					AND page_url_8 = "' . $urlSegments[7] . '"';
				$this->registry->library('db')->execute($sql);
				if ($this->registry->library('db')->numRows() != 0)
				{
// Static
					$data = $this->registry->library('db')->getRows();
					$this->staticPage($data);
				}
// Dynamic
				else
				{
					switch ($urlSegments[0])
					{

						case 'login' :
							$this->login();
							break;

						case 'register' :
							$this->registration();
							break;

						case 'contact' :
							$this->contact();
							break;

						case 'send_email' :
							$this->send_email();
							break;

						case 'terms_of_service' :
							$this->terms_of_service();
							break;

						case 'switching_language' :
							$this->switching_language();
							break;

						default :
							$this->pageNotFound();
							break;
					}
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
		$urlSegments = $this->registry->getURLSegments();
		if($this->registry->library('db')->sanitizeData($urlSegments[0]) == 'contact')
		{
			$this->registry->library('template')->page()->addTag('heading', 'Contact');
		}
		else
		{
			$this->registry->library('template')->page()->addTag('heading', 'Home');
		}
		$this->registry->library('template')->page()->addTag('pagetitle', 'Site Closed');
		$this->registry->library('template')->build('header.tpl', 'closed.tpl', 'footer.tpl');
	}

	private function terms_of_service()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->library('lang')->line('terms_of_service'));
		$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('terms_of_service'));
		$this->registry->library('template')->build('header.tpl', 'tos.tpl', 'footer.tpl');
	}

	private function index()
	{
		$htmlCalendar = $this->registry->library('helper')->blogCalendarCurrent();
		$this->registry->library('template')->page()->addTag('blogCalendar', $htmlCalendar);
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		$this->registry->library('template')->page()->addTag('heading', '&nbsp;');
		$this->registry->library('template')->build('header.tpl', 'index.tpl', 'footer.tpl');
	}

	private function login()
	{
		$this->registry->library('template')->page()->addTag('after_login', $this->registry->setting('settings_site0') . '/loggedin');
		$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('login'));
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->library('lang')->line('login'));
		if ((isset ($_COOKIE['username'])) && (isset ($_COOKIE['password'])))
		{
			$username = $this->registry->library('crypter')->decrypt($_COOKIE['username']);
			$username = $this->registry->library('db')->sanitizeData($username);
			$password = $this->registry->library('crypter')->decrypt($_COOKIE['password']);
			$password = $this->registry->library('db')->sanitizeData($password);
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'users
			WHERE username = "' . $username . '" and password = "' . $password . '"';
			$this->registry->library('db')->execute($sql);
			if ($this->registry->library('db')->numRows() != 0)
			{
				$usernameCookie = $this->registry->library('crypter')->encrypt($username);
				$passwordCookie = $this->registry->library('crypter')->encrypt($password);
				setcookie("username", $usernameCookie, $time + 3600 * 24 * 366 * 2, '/');
				setcookie("password", $passwordCookie, $time + 3600 * 24 * 366 * 2, '/');
				$this->registry->library('authenticate')->postAuthenticate($username, $password);
				$this->registry->redirectUser('', $this->registry->library('lang')->line('welcome_message'), $this->registry->library('lang')->line('you_are_logged_in_successfully'));
			}
			else
			{
				$this->registry->library('template')->build('header.tpl', 'account/login.tpl', 'footer.tpl');
			}
		}
		else
		{
			$this->registry->library('template')->build('header.tpl', 'account/login.tpl', 'footer.tpl');
		}
	}

	private function registration()
	{
		if (!isset ($_POST['repeated']))
		{
			$this->registry->library('template')->page()->addTag('error_message', '');
			$this->registry->library('template')->page()->addTag('after_reg', 'register');
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('registration'));
			$this->registry->library('template')->page()->addTag('confirm_password', $this->registry->library('lang')->line('confirm_password'));
			$this->registry->library('template')->page()->addTag('name_text', $this->registry->library('lang')->line('name_text'));
			$this->registry->library('template')->page()->addTag('email_text', $this->registry->library('lang')->line('email_text'));
			$this->registry->library('template')->page()->addTag('terms_of_service', $this->registry->library('lang')->line('terms_of_service'));
			$this->registry->library('template')->page()->addTag('terms_of_service_text', $this->registry->library('lang')->line('terms_of_services_text'));
			$this->registry->library('template')->page()->addTag('agree_terms_of_service', $this->registry->library('lang')->line('agree_terms_of_service'));
			$this->registry->library('template')->page()->addTag('username', '');
			$this->registry->library('template')->page()->addTag('password', '');
			$this->registry->library('template')->page()->addTag('email', '');
			$this->registry->library('template')->page()->addTag('name', '');
			$this->registry->library('template')->page()->addTag('accept_terms', '');
			$this->registry->library('template')->page()->addTag('checked', ' ');
			$this->registry->library('template')->page()->addTag('enter_code', $this->registry->library('lang')->line('enter_code'));
			$captcha = $this->registry->library('authenticate')->getCaptcha();
			$this->registry->library('template')->page()->addTag('captcha', $captcha);
			$_SESSION['captcha'] = $captcha;
			$this->registry->library('template')->page()->addTag('repeated', '1');
			$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->library('lang')->line('registration'));
			$this->registry->library('template')->build('header.tpl', 'account/reg.tpl', 'footer.tpl');
		}
		else
		{
			$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->library('lang')->line('registration'));
			$err = '';
			$this->registry->library('template')->page()->addTag('after_reg', 'register');
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('registration'));
			$this->registry->library('template')->page()->addTag('confirm_password', $this->registry->library('lang')->line('confirm_password'));
			$this->registry->library('template')->page()->addTag('name_text', $this->registry->library('lang')->line('name_text'));
			$this->registry->library('template')->page()->addTag('email_text', $this->registry->library('lang')->line('email_text'));
			$this->registry->library('template')->page()->addTag('terms_of_services', $this->registry->library('lang')->line('terms_of_services'));
			$this->registry->library('template')->page()->addTag('terms_of_services_text', $this->registry->library('lang')->line('terms_of_services_text'));
			$this->registry->library('template')->page()->addTag('agree_terms_of_services', $this->registry->library('lang')->line('agree_terms_of_services'));
			$this->registry->library('template')->page()->addTag('username', $this->registry->library('db')->sanitizeDataX($_POST['username']));
			$this->registry->library('template')->page()->addTag('email', $this->registry->library('db')->sanitizeDataX($_POST['email']));
			$this->registry->library('template')->page()->addTag('name', $this->registry->library('db')->sanitizeDataX($_POST['name']));
			$this->registry->library('template')->page()->addTag('accept_terms', $this->registry->library('db')->sanitizeData($_POST['accept_terms']));
			$checked = '';
			if ($this->registry->library('db')->sanitizeData($_POST['accept_terms']) == 'y')
			{
				$this->registry->library('template')->page()->addTag('checked', 'checked ');
			}
			$testUsername = $this->registry->library('db')->sanitizeData($_POST['username']);
			$checkUsernameSQL = "SELECT *
			FROM " . $this->prefix . "users
			WHERE username='{$testUsername}'";
			$this->registry->library('db')->execute($checkUsernameSQL);
			if ($this->registry->library('db')->numRows() == 1)
			{
				$usernameUsed = 1;
			}
			$testEmail = $this->registry->library('db')->sanitizeData($_POST['email']);
			$checkEmailSQL = "SELECT *
			FROM " . $this->prefix . "users
			WHERE email='{$testEmail}'";
			$this->registry->library('db')->execute($checkEmailSQL);
			if ($this->registry->library('db')->numRows() == 1)
			{
				$emailUsed = 1;
			}
			if ($this->registry->library('helper')->minUsernameCheck($_POST['username']))
			{
				$err .= $this->registry->library('lang')->line('min_username') . '<br />';
			}
			if ($usernameUsed == 1)
			{
				$err .= $this->registry->library('lang')->line('username_already_used') . '<br />';
			}
			if ($this->registry->library('helper')->minPasswordCheck($_POST['password']))
			{
				$err .= $this->registry->library('lang')->line('min_password') . '<br />';
			}
			if ($_POST['username'] == '' || $_POST['password'] == '' || $_POST['confirm_password'] == '' || $_POST['email'] == '')
			{
				$err .= $this->registry->library('lang')->line('insufficient_data') . '<br />';
			}
			if ($_POST['accept_terms'] != 'y')
			{
				$err .= $this->registry->library('lang')->line('terms_of_service_not_accepted') . '<br />';
			}
			if ($_POST['password'] != $_POST['confirm_password'])
			{
				$err .= $this->registry->library('lang')->line('passwords_do_not_match') . '<br />';
			}
			if ($_POST['captcha'] != $_SESSION['captcha'])
			{
				$err .= $this->registry->library('lang')->line('incorrect_captcha') . '<br />';
			}
			if ($emailUsed == 1)
			{
				$err .= $this->registry->library('lang')->line('email_already_used') . '<br />';
			}
			if (filter_var($testEmail, FILTER_VALIDATE_EMAIL) == false)
			{
				$err .= $this->registry->library('lang')->line('incorrect_email') . '<br />';
			}
			if ($this->registry->setting('settings_ban_masks') == 'y')
			{
// part of email
				$arr = explode("\n", $this->registry->setting('settings_banned_emails'));
				$banned = 0;
				foreach ($arr as $line)
				{
					if ($banned == 0)
					{
						if (ereg($line, $testEmail))
						{
							$banned = 1;
						}
					}
				}
// foreach end
				if ($banned == 1)
				{
					$err .= $this->registry->library('lang')->line('banned_email_text') . '<br />';
				}
			}
			else
			{
// full email
				$arr = explode("\n", $this->registry->setting('settings_banned_emails'));
				$banned = 0;
				foreach ($arr as $line)
				{
					if ($banned == 0)
					{
						if ($testEmail == $line)
						{
							$banned = 1;
						}
					}
				}
// foreach end
				if ($banned == 1)
				{
					$err .= $this->registry->library('lang')->line('banned_email_text') . '<br />';
				}
			}
			if ($err != '')
			{
				$this->registry->library('template')->page()->addTag('enter_code', $this->registry->library('lang')->line('enter_code'));
				$captcha = $this->registry->library('authenticate')->getCaptcha();
				$this->registry->library('template')->page()->addTag('captcha', $captcha);
				$_SESSION['captcha'] = $captcha;
				$this->registry->library('template')->page()->addTag('error_message', $err);
				$this->registry->library('template')->build('header.tpl', 'account/reg.tpl', 'footer.tpl');
			}
			else
			{
				$data = array();
				$data['username'] = $this->registry->library('db')->sanitizeData($_POST['username']);
				$data['password'] = md5($this->registry->library('db')->sanitizeData($_POST['password']));
				$data['name'] = $this->registry->library('db')->sanitizeData($_POST['name']);
				$data['email'] = $this->registry->library('db')->sanitizeData($_POST['email']);
				$data['user_created'] = date("Y-m-d H:i:s", time());
// for mail()
				$to = $data['email'];
				$data['active'] = 0;
				$data['admin'] = 0;
				$data['banned'] = 0;
				$new_key = $this->registry->library('helper')->generatePasswordKey(32);
				$data['pwd_reset_key'] = $new_key;
				$this->registry->library('db')->insertRecords('users', $data);
// perm 5 (Awaiting)
				$newUser = array();
				$newUser['ur_id'] = $this->registry->library('db')->lastInsertID();
				$newUser['ur_role_id'] = 5;
				$newUser['ur_add_date'] = date("Y-m-d H:i:s");
				$this->registry->library('db')->insertRecords('user_roles', $newUser);
// end perm 5
				$subject = 'New User';
				$message = '
				------------------------
				Please conform: ' . FWURL . 'useraccount/confirm_registration/' . $new_key . '
				------------------------
				';
				$headers = "From:" . $this->noreply_email . "\r\n";
				mail($to, $subject, $message, $headers);
				$data['ur_id'] = $newUser['ur_id'];
				$data['ur_add_date'] = $newUser['ur_add_date'];
				$after_adding_user_hook = '';
				$after_adding_user_hook = $this->registry->library('hook')->call('after_adding_user_hook', $data);
				$this->registry->redirectUser('', $this->registry->library('lang')->line('user_registered'), $this->registry->library('lang')->line('see_email_box_to_activate'), false);
			}
		}
	}

	private function contact()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->library('lang')->line('contact'));
		$this->registry->library('template')->page()->addTag('error_message', '');
		$this->registry->library('template')->page()->addTag('full_name', '');
		$this->registry->library('template')->page()->addTag('email', '');
		$this->registry->library('template')->page()->addTag('body', '');
		$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('contact'));
		$captcha = $this->registry->library('authenticate')->getCaptcha();
		$this->registry->library('template')->page()->addTag('captcha', $captcha);
		$_SESSION['captcha'] = $captcha;
		$this->registry->library('template')->build('header.tpl', 'contact.tpl', 'footer.tpl');
	}

	private function send_email()
	{
		$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('contact'));
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->library('lang')->line('contact'));
		$err = '';
		if ($_POST['full_name'] == '' || $_POST['email'] == '' || $_POST['body'] == '')
		{
			$err .= $this->registry->library('lang')->line('insufficient_data') . '<br />';
		}
		if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == false)
		{
			$err .= $this->registry->library('lang')->line('incorrect_email') . '<br />';
		}
		if ($_POST['captcha'] != $_SESSION['captcha'])
		{
			$err .= $this->registry->library('lang')->line('incorrect_captcha') . '<br />';
		}
		if ($err == '')
		{
			$subject = 'Contact: ' . $_POST['full_name'] . ' | ' . $_POST['email'];
			$message = $_POST['body'];
			$headers = "From:" . $this->noreply_email . "\r\n";
			$to = $this->registry->setting('settings_admin_email');
			mail($to, $subject, $message, $headers);
			$this->registry->redirectUser('', $this->registry->library('lang')->line('email_sent_successfully'), $this->registry->library('lang')->line('see_email_box'), false);
		}
		else
		{
			$this->registry->library('template')->page()->addTag('error_message', $err);
			$this->registry->library('template')->page()->addTag('full_name', $_POST['full_name']);
			$this->registry->library('template')->page()->addTag('email', $_POST['email']);
			$this->registry->library('template')->page()->addTag('body', $_POST['body']);
			$captcha = $this->registry->library('authenticate')->getCaptcha();
			$this->registry->library('template')->page()->addTag('captcha', $captcha);
			$_SESSION['captcha'] = $captcha;
			$this->registry->library('template')->build('header.tpl', 'contact.tpl', 'footer.tpl');
		}
	}

	private function switching_language()
	{
		$urlSegments = $this->registry->getURLSegments();
		$workingLanguages = $this->registry->getWorkingLanguages();
		if (in_array($urlSegments[1], $workingLanguages))
		{
			$_SESSION['language'] = $urlSegments[1];
			$this->registry->library('lang')->setLanguage($urlSegments[1]);
			$this->registry->library('lang')->loadLanguage('site');
			$current_lang_phrase_1 = $this->registry->library('lang')->line('changes_saved_successfully');
			$current_lang_phrase_2 = $this->registry->library('lang')->line('please_wait_for_the_redirect');
			$current_lang_phrase_3 = $this->registry->library('lang')->line('click_here_if');
			$controller_init_hook = $this->registry->library('hook')->call('controller_init_hook');
			$this->registry->library('template')->page()->addTag('click_here_if', $current_lang_phrase_3);
			$this->registry->redirectUser('', $current_lang_phrase_1, $current_lang_phrase_2);
		}
		else
		{
			$this->pageNotFound();
		}
	}

	private function staticPage($data)
	{
// url ?
		if ($data['web_url'] != '')
		{
			echo '<meta http-equiv="refresh" content="0;url=http://' . $data['web_url'] . '">';
		}
		else
		{

		$this->registry->library('template')->page()->addTag('pagetitle', $data['page_title']);
		$this->registry->library('template')->page()->addTag('heading', $data['page_title']);
		$newContent = str_replace('{VIEWDIR}', FWURL . APPDIR . '/views/' . $this->registry->setting('theme') . '/', $data['page_content']);
		$newContent = str_replace('&amp;', '&', $newContent);
		$this->registry->library('template')->page()->addTag('page_content', $newContent);
		$st_header = $data['st_header'];
		$st_main = $data['st_main'];
		$st_footer = $data['st_footer'];
//
		$w = $this->registry->widget('nivoslider_widget')->index();
		$this->registry->library('template')->addWidgetTag('nivoslider_widget', $w);
//
		$this->registry->library('template')->build($st_header . '.tpl', $st_main . '.tpl', $st_footer . '.tpl');
		}
	}

}
?>