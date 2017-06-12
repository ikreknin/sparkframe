<?php

class Useraccountcontroller
{
	private $registry;
	private $model;
	private $sys_cms;
	private $prefix;
	private $noreply_email;
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
			preg_match("/^(http:\/\/)?([^\/]+)/i", FWURL, $matches);
			$host = $matches[2];
			preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $matches);
			$this->noreply_email = 'noreply@' . $matches[0];
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
			$this->registry->library('template')->addTemplateSegment('top_bar_tpl', 'top_bar_tpl.tpl');
			$this->registry->library('template')->addTemplateSegment('top_menu_tpl', 'top_menu_tpl.tpl');
			$this->registry->library('template')->page()->addTag('VIEWDIR', FWURL . APPDIR . '/views/' . $this->registry->setting('theme') . '/');
			$this->registry->library('template')->page()->addTag('site_url', FWURL);
			$this->registry->library('template')->page()->addTag('CMS0', $this->registry->setting('settings_site0'));
			$this->registry->library('template')->page()->addTag('FORUM0', $this->registry->setting('settings_forum0'));
			$this->registry->library('template')->page()->addTag('SHOP0', $this->registry->setting('settings_shop0'));
			$this->registry->library('template')->page()->addTag('cms_title', $this->registry->setting('settings_cms_title'));
			$this->registry->library('template')->page()->addTag('welcome', $this->registry->library('lang')->line('welcome'));
			$this->registry->library('template')->page()->addTag('registration', $this->registry->library('lang')->line('registration'));
			$this->registry->library('template')->page()->addTag('guest', $this->registry->library('lang')->line('guest'));
			$this->registry->library('template')->page()->addTag('charset', $this->registry->setting('settings_charset'));
			$this->registry->library('template')->page()->addTag('metakeywords', $this->registry->setting('settings_metakeywords'));
			$this->registry->library('template')->page()->addTag('metadescription', $this->registry->setting('settings_metadescription'));
			$this->registry->library('template')->page()->addTag('change_password', $this->registry->library('lang')->line('change_password'));
			$this->registry->library('template')->page()->addTag('current_password', $this->registry->library('lang')->line('current_password'));
			$this->registry->library('template')->page()->addTag('new_password', $this->registry->library('lang')->line('new_password'));
			$this->registry->library('template')->page()->addTag('confirm_password', $this->registry->library('lang')->line('confirm_password'));
			$this->registry->library('template')->page()->addTag('username_already_used', $this->registry->library('lang')->line('username_already_used'));
			$this->registry->library('template')->page()->addTag('email_already_used', $this->registry->library('lang')->line('email_already_used'));
			$this->registry->library('template')->page()->addTag('submit', $this->registry->library('lang')->line('submit'));
			$this->registry->library('template')->page()->addTag('sitename', $this->registry->setting('settings_cms_title'));
			$this->registry->library('template')->page()->addTag('send_password', $this->registry->library('lang')->line('send_password'));
			$this->registry->library('template')->page()->addTag('email_text', $this->registry->library('lang')->line('email_text'));
			$this->registry->library('template')->page()->addTag('enter_code', $this->registry->library('lang')->line('enter_code'));
			$this->registry->library('template')->page()->addTag('send_username', $this->registry->library('lang')->line('send_username'));
			$this->registry->library('template')->page()->addTag('home', $this->registry->library('lang')->line('home'));
			$this->registry->library('template')->page()->addTag('cp', $this->registry->library('lang')->line('cp'));
			$this->registry->library('template')->page()->addTag('forum_text', $this->registry->library('lang')->line('forum_text'));
			$this->registry->library('template')->page()->addTag('shop_text', $this->registry->library('lang')->line('shop_text'));
			$this->registry->library('template')->page()->addTag('blog_text', $this->registry->library('lang')->line('blog_text'));
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

					case 'confirm_registration' :
						$this->confirmRegistration();
						break;

					case 'change_password' :
						$this->changePassword();
						break;

					case 'changed_password' :
						$this->changedPassword();
						break;

					case 'send_password' :
						$this->sendPassword();
						break;

					case 'sent_password' :
						$this->sentPassword();
						break;

					case 'send_username' :
						$this->sendUsername();
						break;

					case 'sent_username' :
						$this->sentUsername();
						break;

					case 'reset_password' :
						$this->resetPassword();
						break;

					case 'control_panel' :
						$this->cp();
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
			$this->registry->library('template')->build('header.tpl', '404.tpl', 'footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function changePassword()
	{
		if ($this->registry->library('authenticate')->isLoggedIn() == true)
		{
			$this->registry->library('template')->page()->addTag('after_login', 'changed_password');
			$this->registry->library('template')->page()->addTag('after_reg', 'registering');
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('change_password'));
			$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->library('lang')->line('change_password'));
			$this->registry->library('template')->build('header.tpl', 'account/change_password.tpl', 'footer.tpl');
		}
		else
		{
			$this->registry->library('template')->page()->addTag('after_login', 'change_password');
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function changedPassword()
	{
		if ($this->registry->library('authenticate')->isLoggedIn() == true)
		{
			if (isset ($_POST['current_password']))
			{
				$currentPassword = md5($_POST['current_password']);
				if ($_POST['new_password'] == $_POST['confirm_new_password'])
				{
					$ID = $this->registry->library('authenticate')->getUserID();
					$checkPwdSQL = "SELECT *
					FROM " . $this->prefix . "users
					WHERE users_id='{$ID}' AND password='{$currentPassword}'";
					$this->registry->library('db')->execute($checkPwdSQL);
					if ($this->registry->library('db')->numRows() == 1)
					{
						$changes = array();
						$changes['password'] = md5($_POST['new_password']);
						$this->registry->library('db')->updateRecords('users', $changes, 'users_id=' . $ID);
						$this->registry->redirectUser('', $this->registry->library('lang')->line('password_changed'), $this->registry->library('lang')->line('password_has_been_changed'));
					}
					else
					{
						$this->registry->redirectUser('useraccount/change_password', $this->registry->library('lang')->line('incorrect_password'), $this->registry->library('lang')->line('old_password_was_not_correct'));
					}
				}
				else
				{
					$this->registry->redirectUser('useraccount/change_password', $this->registry->library('lang')->line('password_match_error'), $this->registry->library('lang')->line('password_and_confirmation_not_same'));
				}
			}
			else
			{
				$this->registry->library('template')->build('header.tpl', 'account/change-password.tpl', 'footer.tpl');
			}
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function sendUsername()
	{
		$this->registry->library('template')->page()->addTag('email_text', $this->registry->library('lang')->line('email_text'));
		$this->registry->library('template')->page()->addTag('enter_code', $this->registry->library('lang')->line('enter_code'));
		$captcha = $this->registry->library('authenticate')->getCaptcha();
		$_SESSION['captcha'] = $captcha;
		$this->registry->library('template')->page()->addTag('after_login', 'sent_username');
		$this->registry->library('template')->page()->addTag('after_reg', 'registering');
		$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('send_name'));
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->library('lang')->line('send_username'));
		$this->registry->library('template')->build('header.tpl', 'account/send_username.tpl', 'footer.tpl');
	}

	private function sentUsername()
	{
		if ($_POST['captcha'] == $_SESSION['captcha'])
		{
			if (isset ($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_INT))
			{
				$email = $this->registry->library('db')->sanitizeData($_POST['email']);
				$sql = "SELECT *
				FROM " . $this->prefix . "users
				WHERE email='{$email}'";
				$this->registry->library('db')->execute($sql);
				if ($this->registry->library('db')->numRows() == 1)
				{
					$pageData = $this->registry->library('db')->getRows();
					$username = $pageData['username'];
					$subject = 'Username';
					$message = '
------------------------
Username: ' . $username . '
------------------------
';
					$headers = "From:" . $this->noreply_email . "\r\n";
					$to = $email;
					mail($to, $subject, $message, $headers);
					$this->registry->redirectUser('', $this->registry->library('lang')->line('username_sent'), $this->registry->library('lang')->line('see_email_box'), false);
				}
			}
			$this->registry->redirectUser('useraccount/send_username', $this->registry->library('lang')->line('incorrect_email'), $this->registry->library('lang')->line('incorrect_email'), false);
		}
		else
		{
			$this->registry->redirectUser('useraccount/send_username', $this->registry->library('lang')->line('incorrect_captcha'), $this->registry->library('lang')->line('incorrect_captcha'), false);
		}
	}

	private function sendPassword()
	{
		$this->registry->library('template')->page()->addTag('after_login', 'sent_password');
		$this->registry->library('template')->page()->addTag('after_reg', 'registering');
		$captcha = $this->registry->library('authenticate')->getCaptcha();
		$_SESSION['captcha'] = $captcha;
		$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('send_password'));
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->library('lang')->line('send_password'));
		$this->registry->library('template')->build('header.tpl', 'account/send_password.tpl', 'footer.tpl');
	}

	private function sentPassword()
	{
		if (count($_POST) > 0)
		{
			if (isset ($_SESSION['captcha']) && $_SESSION['captcha'] == $_POST['captcha'])
			{
				$captcha = $this->registry->library('authenticate')->getCaptcha();
				$_SESSION['captcha'] = $captcha;
				$email = $this->registry->library('db')->sanitizeData($_POST['email']);
				$sql = "SELECT *
				FROM " . $this->prefix . "users
				WHERE email='{$email}'";
				$this->registry->library('db')->execute($sql);
				if ($this->registry->library('db')->numRows() == 1)
				{
					$pageData = $this->registry->library('db')->getRows();
					$active = $pageData['active'];
					if ($active != 1)
					{
						$this->registry->redirectUser('', $this->registry->library('lang')->line('account_not_activated'), $this->registry->library('lang')->line('activate_account'), false);
					}
					else
					{
						$new_key = md5($this->registry->library('helper')->generatePasswordKey(32));
						$changes = array();
						$changes['pwd_reset_key'] = $new_key;
						$this->registry->library('db')->updateRecords('users', $changes, "email='{$email}'");
						$subject = 'New Password';
						$message = '
						------------------------
						Please conform: ' . FWURL . 'useraccount/reset_password/' . $new_key . '
						------------------------
						';
						$headers = "From:" . $this->noreply_email . "\r\n";
						$to = $email;
						mail($to, $subject, $message, $headers);
						$this->registry->redirectUser('', $this->registry->library('lang')->line('email_sent'), $this->registry->library('lang')->line('see_email_reset'), false);
					}
				}
				else
				{
					$this->registry->redirectUser('useraccount/send_password', $this->registry->library('lang')->line('incorrect_email'), $this->registry->library('lang')->line('incorrect_email'), false);
				}
			}
			else
			{
				$this->registry->redirectUser('useraccount/send_password', $this->registry->library('lang')->line('incorrect_captcha'), $this->registry->library('lang')->line('incorrect_captcha'), false);
			}
		}
	}

	private function resetPassword()
	{
		$temp_key = $this->seg_2;
		$sql = "SELECT *
		FROM " . $this->prefix . "users
		WHERE pwd_reset_key='{$temp_key}'";
		$this->registry->library('db')->execute($sql);
		$pageData = $this->registry->library('db')->getRows();
		$ID = $pageData['users_id'];
		$email = $pageData['email'];
		if ($this->registry->library('db')->numRows() == 1)
		{
			$pwd = $this->registry->library('helper')->generatePasswordKey(8);
			$changes = array();
			$changes['password'] = md5($pwd);
			$this->registry->library('db')->updateRecords('users', $changes, "users_id=" . $ID);
			$subject = 'New Password';
			$message = '
			------------------------
			New password: ' . $pwd . '
			------------------------
			';
			$headers = "From:" . $this->noreply_email . "\r\n";
			$to = $email;
			mail($to, $subject, $message, $headers);
			$this->registry->redirectUser('', $this->registry->library('lang')->line('new_password_sent'), $this->registry->library('lang')->line('see_email_box'), false);
		}
	}

	private function confirmRegistration()
	{
		$temp_key = $this->seg_2;
		$sql = "SELECT *
		FROM " . $this->prefix . "users
		WHERE pwd_reset_key='{$temp_key}'";
		$this->registry->library('db')->execute($sql);
		$pageData = $this->registry->library('db')->getRows();
		$ID = $pageData['users_id'];
		$pwd_reset_key = $pageData['pwd_reset_key'];
		if ($this->registry->library('db')->numRows() == 1 && $pwd_reset_key != '')
		{
			$changes = array();
			$changes['active'] = 1;
			$changes['pwd_reset_key'] = '';
			$this->registry->library('db')->updateRecords('users', $changes, 'users_id=' . $ID);
// perm 2 (Registered)
			$data = array();
			$data['ur_role_id'] = 2;
			$this->registry->library('db')->updateRecords('user_roles', $data, 'ur_id=' . $ID . ' AND ur_role_id=' . 5);
// end perm 2
			$this->registry->redirectUser('', $this->registry->library('lang')->line('account_activated'), $this->registry->library('lang')->line('account_activated_successfully'), false);
		}
		else
		{
			$this->registry->redirectUser('', $this->registry->library('lang')->line('link_code_incorrect'), $this->registry->library('lang')->line('linkode_incorrect'), false);
		}
	}

	private function cp()
	{
		if ($this->registry->library('authenticate')->isLoggedIn() == true)
		{
			$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->library('lang')->line('cp'));
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('cp'));
			$this->registry->library('template')->build('header.tpl', 'account/cp.tpl', 'footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

}
?>