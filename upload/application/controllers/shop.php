<?php

class Shopcontroller
{
	private $registry;
	private $model;
	private $prefix;
	private $sys_cms;
	private $guests_allowed;
	private $guests_opinions_allowed;
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
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('shop_text'));
			$this->registry->library('template')->page()->addTag('sections', $this->registry->library('lang')->line('sections'));
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
			$this->registry->library('template')->page()->addTag('opinions_text', $this->registry->library('lang')->line('opinions_text'));
			$this->registry->library('template')->page()->addTag('approved_text', $this->registry->library('lang')->line('approved'));
			$this->registry->library('template')->page()->addTag('visible_text', $this->registry->library('lang')->line('visible'));
			$this->registry->library('template')->page()->addTag('edit', $this->registry->library('lang')->line('edit'));
			$this->registry->library('template')->page()->addTag('view', $this->registry->library('lang')->line('view'));
			$this->registry->library('template')->page()->addTag('delete', $this->registry->library('lang')->line('delete'));
			$this->registry->library('template')->page()->addTag('guest', $this->registry->library('lang')->line('guest'));
			$this->registry->library('template')->page()->addTag('no_opinions_yet', $this->registry->library('lang')->line('no_opinions_yet'));
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
			$this->registry->library('template')->page()->addTag('shops_text', $this->registry->library('lang')->line('shops_text'));
			$this->registry->library('template')->page()->addTag('shop_name_text', $this->registry->library('lang')->line('shop_name_text'));
			$this->registry->library('template')->page()->addTag('shop_description_text', $this->registry->library('lang')->line('shop_description_text'));
			$this->registry->library('template')->page()->addTag('filename_text', $this->registry->library('lang')->line('filename_text'));
			$this->registry->library('template')->page()->addTag('link_to_download', $this->registry->library('lang')->line('link_to_download'));
			$this->registry->library('template')->page()->addTag('download', $this->registry->library('lang')->line('download'));
			$this->registry->library('template')->page()->addTag('download_expired', $this->registry->library('lang')->line('download_expired'));
			$this->registry->library('template')->page()->addTag('logged_in_to_buy', $this->registry->library('lang')->line('logged_in_to_buy'));
			$this->registry->library('template')->page()->addTag('add_to_cart', $this->registry->library('lang')->line('add_to_cart'));
			$this->registry->library('template')->page()->addTag('pp_available', $this->registry->setting('pp_av'));
			$this->registry->library('template')->page()->addTag('cart_available', $this->registry->setting('cart_av'));
			$this->registry->library('template')->page()->addTag('shopping_cart', $this->registry->library('lang')->line('shopping_cart'));
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
			if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('opinion_opinions') == true)
			{
				$this->registry->library('template')->page()->addTag('opinions_level', '1');
			}
			else
			{
				$this->registry->library('template')->page()->addTag('opinions_level', '0');
			}
			if ($this->registry->setting('settings_enable_opinions') == 1)
			{
				$this->registry->library('template')->page()->addTag('opinions_allowed', '1');
			}
			else
			{
				$this->registry->library('template')->page()->addTag('opinions_allowed', '0');
			}
			$this->guests_allowed = 1;
			$this->registry->library('template')->page()->addTag('guests_allowed', $this->guests_allowed);
			$this->guests_opinions_allowed = 0;
			$this->registry->library('template')->page()->addTag('guests_opinions_allowed', $this->guests_opinions_allowed);
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
			$this->registry->library('template')->page()->addTag('no_shops_yet', $this->registry->library('lang')->line('no_shops_yet'));
			$this->registry->library('template')->page()->addTag('new_product', $this->registry->library('lang')->line('new_product'));
			$this->registry->library('template')->page()->addTag('new_opinion', $this->registry->library('lang')->line('new_opinion'));
			$this->registry->library('template')->page()->addTag('title_text', $this->registry->library('lang')->line('title_text'));
			$this->registry->library('template')->page()->addTag('product_text', $this->registry->library('lang')->line('product_text'));
			$this->registry->library('template')->page()->addTag('products_text', $this->registry->library('lang')->line('products_text'));
			$this->registry->library('template')->page()->addTag('opinion_text', $this->registry->library('lang')->line('opinion_text'));
			$this->registry->library('template')->page()->addTag('opinions_text', $this->registry->library('lang')->line('opinions_text'));
			$this->registry->library('template')->page()->addTag('submit', $this->registry->library('lang')->line('submit'));
			$this->registry->library('template')->page()->addTag('price_text', $this->registry->library('lang')->line('price_text'));
			$this->registry->library('template')->page()->addTag('buy', $this->registry->library('lang')->line('buy'));
			$this->registry->library('template')->page()->addTag('successful_transaction', $this->registry->library('lang')->line('successful_transaction'));
			$this->registry->library('template')->page()->addTag('transaction_cancelled', $this->registry->library('lang')->line('transaction_cancelled'));
			$this->registry->library('template')->page()->addTag('not_have_perm_download', $this->registry->library('lang')->line('not_have_perm_download'));
			$this->registry->library('template')->page()->addTag('welcome', $this->registry->library('lang')->line('welcome'));
			$this->registry->library('template')->page()->addTag('registration', $this->registry->library('lang')->line('registration'));
			$this->registry->library('template')->page()->addTag('contact', $this->registry->library('lang')->line('contact'));
			$this->registry->library('template')->addTemplateSegment('top_bar_tpl', 'top_bar_tpl.tpl');
			$this->registry->library('template')->addTemplateSegment('top_menu_tpl', 'top_menu_tpl.tpl');
//
			$w = $this->registry->widget('latest_products_plus_widget')->index(3);
			$this->registry->library('template')->addWidgetTag('latest_products_plus_widget', $w);
//
			$w = $this->registry->widget('accessible_mega_menu_widget')->index();
			$this->registry->library('template')->addWidgetTag('accessible_mega_menu_widget', $w);
//
			$urlSegments = $this->registry->getURLSegments();
			$this->seg_1 = $this->registry->library('db')->sanitizeData($urlSegments[1]);
			$this->seg_2 = $this->registry->library('db')->sanitizeData($urlSegments[2]);
			$this->seg_3 = $this->registry->library('db')->sanitizeData($urlSegments[3]);
			if (true)
			{
				$this->registry->library('template')->page()->addTag('jquery', '<script type="text/javascript" src="' . FWURL . SUBDIR . 'js/jquery/' . $this->registry->setting('settings_jquery') . '"></script>');
			}
			else
			{
				$this->registry->library('template')->page()->addTag('jquery', '');
			}
			if ($this->seg_1 == 'newproduct' || $this->seg_1 == 'edit_product')
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
	plugins : "paste",
	theme_advanced_buttons1 : "bold, italic, underline, separator, undo, redo, separator, link, unlink, separator, image, separator, forecolor, separator, styleselect, removeformat, cleanup, code, separator, syntaxhl",
	theme_advanced_buttons2 : "bullist, numlist, separator, outdent, indent, separator, hr, separator, sub, sup, separator, charmap, codehighlighting, pastetext,pasteword,selectall",
		theme_advanced_buttons3 :"",
	        paste_preprocess : function(pl, o) {
            // Content string containing the HTML from the clipboard
            alert(o.content);
            o.content = "-: CLEANED :-\n" + o.content;
        },
        paste_postprocess : function(pl, o) {
            // Content DOM node containing the DOM structure of the clipboard
            alert(o.node.innerHTML);
            o.node.innerHTML = o.node.innerHTML + "\n-: CLEANED :-";
        },
	remove_linebreaks : false,
	extended_valid_elements : "textarea[cols|rows|disabled|name|readonly|class]"
});
</script>');
				$this->registry->library('template')->page()->addTag('tinybrowser', '<script src="' . FWURL . SUBDIR . 'js/tiny_mce/plugins/tinybrowser/tb_tinymce.js.php" type="text/javascript"></script>');
			}
			else
			{
				$this->registry->library('template')->page()->addTag('editor', '');
				$this->registry->library('template')->page()->addTag('tinybrowser', '');
			}
			if ($this->seg_1 == 'newopinion' && false)
			{
				$this->registry->library('template')->page()->addTag('bbcodeeditor', "<link rel=\"stylesheet\" href=\"" . FWURL . "js/minified/themes/default.min.css\" type=\"text/css\" media=\"all\" />
<script src=\"" . FWURL . "js/minified/jquery.sceditor.bbcode.min.js\"></script>
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
				style: \"" . FWURL . "js/minified/jquery.sceditor.default.min.css\"
			});
		};
		$(\"#theme\").change(function() {
			var theme = \"" . FWURL . "js/minified/themes/default.min.css\";
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
			$this->registry->library('template')->page()->addTag('highlighter', '');

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

					case 'viewshop' :
						$this->viewshop();
						break;

					case 'viewproduct' :
						$this->viewproduct();
						break;

					case 'newproduct' :
						$this->newproduct();
						break;

					case 'creating_product' :
						$this->creating_product();
						break;

					case 'edit_product' :
						$this->edit_product();
						break;

					case 'editing_product' :
						$this->editing_product();
						break;

					case 'newopinion' :
						$this->newopinion();
						break;

					case 'creating_opinion' :
						$this->creating_opinion();
						break;

					case 'captcha' :
						$this->captchaOutput();
						break;

					case 'paypal_success' :
						$this->paypal_success();
						break;

					case 'paypal_cancel' :
						$this->paypal_cancel();
						break;

					case 'paypal_notify' :
						$this->paypal_notify();
						break;

					case 'get_link' :
						$this->get_link();
						break;

					case 'get_file' :
						$this->get_file();
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
			$shops_available = '';
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'shops
			WHERE shops_sys = "' . $this->sys_cms . '"
			ORDER BY f_order DESC';
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
			{
				$sql = 'SELECT *
				FROM ' . $this->prefix . 'shops
				WHERE shops_sys = "' . $this->sys_cms . '"
				ORDER BY f_order ASC';
				$cache = $this->registry->library('db')->cacheQuery($sql);
				if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
				{
					$shops_available = 'y';
					$data = $this->registry->library('db')->rowsFromCache($cache);
					$html = $this->registry->library('helper')->simpleShopList($data);
				}
				$this->registry->library('template')->page()->addTag('simple_shops_list', $html);
			}
			$this->registry->library('template')->page()->addTag('shops_available', $shops_available);
			$this->registry->library('template')->build('header.tpl', $this->registry->setting('settings_shop0') . '/shop_index.tpl', 'footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

	private function viewshop()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isLoggedIn() == true || $this->guests_allowed == 1)
		{
// does the shop exist?
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'shops
			WHERE shops_sys = "' . $this->sys_cms . '"
			AND f_shop_id = "' . $this->seg_2 . '"';
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) == 0)
			{
				$this->pageNotFound();
			}
			else
			{
// to get all shops
				$shops_available = '';
				$sql = 'SELECT *
					FROM ' . $this->prefix . 'shops
					WHERE shops_sys = "' . $this->sys_cms . '"
					ORDER BY f_order DESC';
				$cache = $this->registry->library('db')->cacheQuery($sql);
				if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
				{
					$sql = 'SELECT *
						FROM ' . $this->prefix . 'shops
						WHERE shops_sys = "' . $this->sys_cms . '"
						ORDER BY f_order ASC';
					$cache = $this->registry->library('db')->cacheQuery($sql);
					if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
					{
						$shops_available = 'y';
						$data = $this->registry->library('db')->rowsFromCache($cache);
						$html = $this->registry->library('helper')->simpleShopList($data, $this->seg_2);
					}
					$this->registry->library('template')->page()->addTag('simple_shops_list', $html);
					$this->registry->library('template')->page()->addTag('shops_available', $shops_available);
				}
				$products_available = '';
				$catList = $this->registry->library('helper')->multiCatList($this->seg_2, $this->sys_cms);
				$catList .= $this->seg_2;
				$rows_per_page = $this->registry->setting('settings_shop_rows_per_page');
				$condition = 'WHERE shop_products_sys = "' . $this->sys_cms . '" AND t_shop_id IN(' . $catList . ')';
				if ($this->seg_3 == '')
				{
					$offset = 0;
				}
				else
				{
					$offset = ($this->seg_3 - 1) * $rows_per_page;
				}
				$pagination = $this->registry->library('paginate')->createLinksSys('shop_products', $rows_per_page, $this->seg_3, $this->registry->setting('settings_shop0') . '/viewshop/' . $this->seg_2, $condition);
				$this->registry->library('template')->page()->addTag('pagination', $pagination);
				$shop_name = '';
				$sql = 'SELECT *
					FROM ' . $this->prefix . 'shops
					WHERE shops_sys = "' . $this->sys_cms . '"
					AND ' . $this->prefix . 'shops.f_shop_id = ' . $this->seg_2 . '
					LIMIT 1';
				$cache = $this->registry->library('db')->cacheQuery($sql);
				if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
				{
					$data = $this->registry->library('db')->rowsFromCache($cache);
					foreach ($data as $k => $v)
					{
						$shop_name = $v['f_name'];
						$this->registry->library('template')->page()->addTag('shop_name', $shop_name);
					}
				}
				$sql = 'SELECT *
					FROM ' . $this->prefix . 'shop_products
					LEFT JOIN ' . $this->prefix . 'shops ON ' . $this->prefix . 'shops.f_shop_id = ' . $this->prefix . 'shop_products.t_shop_id
					WHERE shop_products_sys = "' . $this->sys_cms . '"
					AND t_shop_id IN(' . $catList . ')
					ORDER BY t_product_date DESC
					LIMIT ' . $offset . ',' . $rows_per_page;
				$cache = $this->registry->library('db')->cacheQuery($sql);
				if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
				{
					$products_available = 'y';
					$products = array();
					$i = 0;
					$num = $this->registry->library('db')->numRowsFromCache($cache);
					$data = $this->registry->library('db')->rowsFromCache($cache);
					while ($i < $num)
					{
						foreach ($data as $k => $v)
						{
							$products[$i]['product_id'] = $v['t_product_id'];
							$products[$i]['product_title'] = $v['t_title'];
							$i = $i + 1;
						}
					}
				}
				$cache = $this->registry->library('db')->cacheData($products);
				$this->registry->library('template')->page()->addTag('products', array('DATA', $cache));
				$this->registry->library('template')->page()->addTag('shop_id', $this->seg_2);
				$this->registry->library('template')->page()->addTag('products_available', $products_available);
				$this->registry->library('template')->build('header.tpl', $this->registry->setting('settings_shop0') . '/viewshop.tpl', 'footer.tpl');
			}
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

	private function viewproduct()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isLoggedIn() == true || $this->guests_allowed == 1)
		{
// does the product exist?
			$sql = 'SELECT *
				FROM ' . $this->prefix . 'shop_products
				WHERE shop_products_sys = "' . $this->sys_cms . '"
				AND t_product_id = ' . $this->seg_2;
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) == 0)
			{
				$this->pageNotFound();
			}
			else
			{
				$this->registry->library('template')->page()->addTag('product_id', $this->seg_2);
				$shops_available = '';
				$sql = 'SELECT *
					FROM ' . $this->prefix . 'shops
					WHERE shops_sys = "' . $this->sys_cms . '"
					ORDER BY f_order DESC';
				$cache = $this->registry->library('db')->cacheQuery($sql);
				if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
				{
					$sql = 'SELECT *
						FROM ' . $this->prefix . 'shops
						WHERE shops_sys = "' . $this->sys_cms . '"
						ORDER BY f_order ASC';
					$cache = $this->registry->library('db')->cacheQuery($sql);
					if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
					{
						$shops_available = 'y';
						$data = $this->registry->library('db')->rowsFromCache($cache);
						$html = $this->registry->library('helper')->simpleShopList($data, $this->seg_2);
					}
					$this->registry->library('template')->page()->addTag('simple_shops_list', $html);
					$this->registry->library('template')->page()->addTag('shops_available', $shops_available);
				}
				$opinions_available = '';
				$this->registry->library('template')->page()->addTag('item_id', $this->seg_2);
				$rows_per_page = $this->registry->setting('settings_shop_rows_per_page');
				if (true)
//				if ($this->seg_3 == '')
				{
					$offset = 0;
					$condition = '';
				}
				else
				{
					$offset = ($this->seg_3 - 1) * $rows_per_page;
					$condition = 'WHERE shop_opinions_sys = "' . $this->sys_cms . '" AND p_product_id = ' . $this->seg_2;
				}
				$pagination = $this->registry->library('paginate')->createLinksSys('shop_opinions', $rows_per_page, $this->seg_3, $this->registry->setting('settings_shop0') . '/viewproduct/' . $this->seg_2, $condition);
				$this->registry->library('template')->page()->addTag('pagination', $pagination);
				$product_id = $this->seg_2;
				$sql = 'SELECT *
					FROM ' . $this->prefix . 'shop_products
					LEFT JOIN ' . $this->prefix . 'shops ON ' . $this->prefix . 'shops.f_shop_id = ' . $this->prefix . 'shop_products.t_shop_id
					WHERE shop_products_sys = "' . $this->sys_cms . '"
					AND t_product_id = ' . $product_id . '
					ORDER BY t_product_id DESC';
				$this->registry->library('db')->execute($sql);
				if ($this->registry->library('db')->numRows() != 0)
				{
					$arr = $this->registry->library('db')->getRows();
					$this->registry->library('template')->page()->addTag('shop_name', $arr['f_name']);
					$this->registry->library('template')->page()->addTag('title', $arr['t_title']);
					$this->registry->library('template')->page()->addTag('body', $arr['t_body']);
					$this->registry->library('template')->page()->addTag('price', $arr['t_price']);
					$this->registry->library('template')->page()->addTag('business_email', $this->registry->setting('settings_seller_email'));
					$this->registry->library('template')->page()->addTag('product_name', $arr['t_title']);
					$this->registry->library('template')->page()->addTag('product_number', $arr['t_product_id']);
					$this->registry->library('template')->page()->addTag('amount', $arr['t_price']);
					$this->registry->library('template')->page()->addTag('no_shipping', '1');
					$this->registry->library('template')->page()->addTag('filename', $arr['t_filename']);
				}
				$sql = 'SELECT *
					FROM ' . $this->prefix . 'shop_opinions
					WHERE shop_opinions_sys = "' . $this->sys_cms . '"
					AND p_product_id = ' . $this->seg_2;
//					LIMIT ' . $offset . ',' . $rows_per_page;
				$cache = $this->registry->library('db')->cacheQuery($sql);
				if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
				{
					$opinions_available = 'y';
					$opinions = array();
					$i = 0;
					$num = $this->registry->library('db')->numRowsFromCache($cache);
					$data = $this->registry->library('db')->rowsFromCache($cache);
					while ($i < $num)
					{
						foreach ($data as $k => $v)
						{
							$opinions[$i]['opinion_id'] = $v['p_opinion_id'];
							$opinions[$i]['opinion_body'] = $v['p_body'];
							$i = $i + 1;
						}
					}
				}
				$cache = $this->registry->library('db')->cacheData($opinions);
				$this->registry->library('template')->page()->addTag('opinions', array('DATA', $cache));
				$this->registry->library('template')->page()->addTag('shop_id', $this->seg_2);
				$this->registry->library('template')->page()->addTag('opinions_available', $opinions_available);
				if ($this->registry->setting('settings_paypal_sandbox') == 1)
				{
					$this->registry->library('template')->page()->addTag('sandbox_url', 'sandbox.');
				}
				else
				{
					$this->registry->library('template')->page()->addTag('sandbox_url', '');
				}
				$uid = $this->registry->library('authenticate')->getUserID();
				if ($uid < 1)
				{
					$uid = 0;
				}
				$link_available = 0;
				$sql = 'SELECT *
					FROM ' . $this->prefix . 'paypal_trans
				WHERE paypal_trans_sys = "' . $this->sys_cms . '"
				AND item_id = ' . $this->seg_2 . ' AND user_id = ' . $uid;
				$cache = $this->registry->library('db')->cacheQuery($sql);
				if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
				{
					$link_available = 1;
				}
				$this->registry->library('template')->page()->addTag('link_available', $link_available);
				$this->registry->library('template')->build('header.tpl', $this->registry->setting('settings_shop0') . '/viewproduct.tpl', 'footer.tpl');
			}
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

	private function get_link()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true || $this->registry->library('authenticate')->hasPermission('access_premium_content') == true)
		{
// To get $temp that doesn't exist in the table
			$skip = 0;
			while ($skip == 0)
			{
				$temp = rand(10000, 90000) . rand(10000, 50000);
				$sql = 'SELECT *
				FROM ' . $this->prefix . 'files
				WHERE files_sys = "' . $this->sys_cms . '"
				AND dl_protection = ' . $temp;
				$cache = $this->registry->library('db')->cacheQuery($sql);
				$data = $this->registry->library('db')->getRows();
				if ($this->registry->library('db')->numRowsFromCache($cache) == 0)
				{
					$skip = 1;
				}
			}
// To get "secret" filename (as URL part)
			$file_url = '';
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'shop_products
			WHERE shop_products_sys = "' . $this->sys_cms . '"
			AND t_product_id ="' . $this->seg_2 . '"';
			$this->registry->library('db')->execute($sql);
			if ($this->registry->library('db')->numRows() != 0)
			{
				$data = $this->registry->library('db')->getRows();
				$file_url = $data['t_filename'];
			}
// To get the current dl_datetime
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'files
			WHERE files_sys = "' . $this->sys_cms . '"
			AND file_url ="' . $file_url . '"';
			$this->registry->library('db')->execute($sql);
			if ($this->registry->library('db')->numRows() != 0)
			{
				$arr = $this->registry->library('db')->getRows();
				$dl_datetime = $arr['dl_datetime'];
			}
			$delta = strtotime(date("Y-m-d H:i:s")) - strtotime($dl_datetime);
// If too old, to update dl_datetime
			if ($delta > $this->registry->setting('settings_dl_period'))
			{
// Restore CacheOn & Delete Cache
				$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
				if ($this->registry->setting('settings_cached') == 1)
				{
					$this->registry->library('db')->deleteCache('cache_', true);
				}
				$data = array('dl_protection' => $temp, 'dl_datetime' => date("Y-m-d H:i:s", time()));
				$this->registry->library('db')->updateRecordsSys('files', $data, 'file_url="' . $file_url . '"');
			}
// To get file data (based on file_url)
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'files
			WHERE files_sys = "' . $this->sys_cms . '"
			AND file_url ="' . $file_url . '"';
			$this->registry->library('db')->execute($sql);
			if ($this->registry->library('db')->numRows() != 0)
			{
				$arr = $this->registry->library('db')->getRows();
				$this->registry->library('template')->page()->addTag('file_url', $arr['file_url']);
				$this->registry->library('template')->page()->addTag('file_name', $arr['file_name']);
				$this->registry->library('template')->page()->addTag('code', $arr['dl_protection']);
			}
			$this->registry->library('template')->page()->addTag('item_id', $this->seg_2);
			$this->registry->library('template')->build('header.tpl', $this->registry->setting('settings_shop0') . '/download.tpl', 'footer.tpl');
		}
		else
		{
// Failed
			$this->registry->redirectUser($this->registry->setting('settings_shop0') . '/viewproduct/2', $this->registry->library('lang')->line('not_have_perm_download'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

	private function get_file()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true || $this->registry->library('authenticate')->hasPermission('access_premium_content') == true)
		{
			$sql = 'SELECT COUNT(trans_id) AS `trans_count`
			FROM ' . $this->prefix . 'paypal_trans
			WHERE paypal_trans_sys = "' . $this->sys_cms . '"
			AND item_id = ' . $this->seg_2 . ' AND user_id = ' . $this->registry->library('authenticate')->getUserID();
			$this->registry->library('db')->execute($sql);
			if ($this->registry->library('db')->numRows() != 0)
			{
				$sql = 'SELECT *
				FROM ' . $this->prefix . 'files
				WHERE files_sys = "' . $this->sys_cms . '"
				AND dl_protection = "' . $this->seg_3 . '"';
				$this->registry->library('db')->execute($sql);
				if ($this->registry->library('db')->numRows() != 0)
				{
					$data = $this->registry->library('db')->getRows();
					$dl_datetime = $data['dl_datetime'];
					$file_url = $data['file_url'];
				}
				$delta = strtotime(date("Y-m-d H:i:s")) - strtotime($dl_datetime);
				if ($delta < $this->registry->setting('settings_dl_period'))
				{
// Success
					$file_extension = strtolower(substr(strrchr(FWPATH . 'files/' . $file_url, "."), 1));
					switch ($file_extension)
					{

						case "pdf" :
							$ctype = "application/pdf";
							break;

						case "exe" :
							$ctype = "application/octet-stream";
							break;

						case "zip" :
							$ctype = "application/zip";
							break;

						case "doc" :
							$ctype = "application/msword";
							break;

						case "xls" :
							$ctype = "application/vnd.ms-excel";
							break;

						case "ppt" :
							$ctype = "application/vnd.ms-powerpoint";
							break;

						case "gif" :
							$ctype = "image/gif";
							break;

						case "png" :
							$ctype = "image/png";
							break;

						case "jpeg" :
						case "jpg" :
							$ctype = "image/jpg";
							break;

						default :
							$ctype = "application/force-download";
					}
					header('Content-Description: File Transfer');
					header("Content-Type: $ctype");
					header('Content-Disposition: attachment; filename=' . $file_url);
					header('Content-Transfer-Encoding: binary');
					header('Expires: 0');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Pragma: public');
					header('Content-Length: ' . filesize(FWPATH . 'files/' . $file_url));
					ob_clean();
					flush();
					readfile(FWPATH . 'files/' . $file_url);
					exit;
				}
				else
				{
					$this->registry->redirectUser($this->registry->setting('settings_shop0') . '/viewproduct/' . $this->seg_2, $this->registry->library('lang')->line('download_expired'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
				}
			}
		}
		else
		{
// Failed
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

	private function newproduct()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true || $this->registry->library('authenticate')->hasPermission('limited_admin') == true)
		{
			$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
			$this->registry->library('template')->page()->addTag('author_id', $this->registry->library('authenticate')->getUserID());
			$this->registry->library('template')->page()->addTag('error_message', '');
			$this->registry->library('template')->page()->addTag('author_id', '');
			$this->registry->library('template')->page()->addTag('product_title', '');
			$this->registry->library('template')->page()->addTag('product_body', '');
			$this->registry->library('template')->page()->addTag('price', '');
			$this->registry->library('template')->page()->addTag('filename', '');
			$this->registry->library('template')->page()->addTag('shop_id', $this->seg_2);
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('new_product'));
			$this->registry->library('template')->build('header.tpl', $this->registry->setting('settings_shop0') . '/products_create.tpl', 'footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

	private function creating_product()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			if ($_POST['product_title'] != '' && $_POST['product_body'] != '')
			{
// Caching OFF
				$this->registry->library('db')->setCacheOn(0);
				$data['t_shop_id'] = $this->registry->library('db')->sanitizeData($_POST['shopID']);
				$data['t_user_id'] = $this->registry->library('authenticate')->getUserID();
				$data['t_title'] = $this->registry->library('db')->sanitizeData($_POST['product_title']);
				$data['t_body'] = $this->registry->library('db')->sanitizeData($_POST['product_body']);
				$data['t_filename'] = $this->registry->library('db')->sanitizeData($_POST['t_filename']);
				$data['t_product_date'] = date("Y-m-d H:i:s", time());
				$data['t_price'] = $this->registry->library('db')->sanitizeData($_POST['price']);
				$this->registry->library('db')->insertRecordsSys('shop_products', $data);
// Restore CacheOn & Delete Cache
				$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
				if ($this->registry->setting('settings_cached') == 1)
				{
					$this->registry->library('db')->deleteCache('cache_', true);
				}
				$this->registry->redirectUser($this->registry->setting('settings_shop0') . '/viewshop/' . $this->seg_2, $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
			}
			else
			{
				$this->registry->library('template')->page()->addTag('product_title', $_POST['product_title']);
				$this->registry->library('template')->page()->addTag('product_body', $_POST['product_body']);
				$this->registry->library('template')->page()->addTag('shop_id', $_POST['shopID']);
				$this->registry->library('template')->page()->addTag('price', $_POST['price']);
				$this->registry->library('template')->page()->addTag('filename', $_POST['filename']);
				$this->registry->library('template')->page()->addTag('error_message', $this->registry->library('lang')->line('insufficient_data'));
				$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('new_product'));
				$this->registry->library('template')->build('header.tpl', $this->registry->setting('settings_shop0') . '/products_create.tpl', 'footer.tpl');
			}
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

	private function edit_product()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$this->registry->library('template')->page()->addTag('error_message', '');
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'shop_products
			WHERE shop_products_sys = "' . $this->sys_cms . '"
			AND t_product_id = ' . $this->seg_2;
			$this->registry->library('db')->execute($sql);
			if ($this->registry->library('db')->numRows() != 0)
			{
				$data = $this->registry->library('db')->getRows();
				$this->registry->library('template')->page()->addTag('product_title', $data['t_title']);
				$this->registry->library('template')->page()->addTag('product_body', $data['t_body']);
				$this->registry->library('template')->page()->addTag('shop_id', $data['t_shop_id']);
				$this->registry->library('template')->page()->addTag('product_id', $data['t_product_id']);
				$this->registry->library('template')->page()->addTag('price', $data['t_price']);
				$this->registry->library('template')->page()->addTag('filename', $data['t_filename']);
				$this->registry->library('template')->page()->addTag('error_message', '');
				$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('edit'));
				$this->registry->library('template')->build('header.tpl', $this->registry->setting('settings_shop0') . '/products_edit.tpl', 'footer.tpl');
			}
			;
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

	private function editing_product()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			if ($_POST['product_title'] != '' && $_POST['product_body'] != '')
			{
// Caching OFF
				$this->registry->library('db')->setCacheOn(0);
				$data['t_shop_id'] = $this->registry->library('db')->sanitizeData($_POST['shopID']);
				$data['t_user_id'] = $this->registry->library('authenticate')->getUserID();
				$data['t_title'] = $this->registry->library('db')->sanitizeData($_POST['product_title']);
				$data['t_body'] = $this->registry->library('db')->sanitizeData($_POST['product_body']);
				$data['t_filename'] = $this->registry->library('db')->sanitizeData($_POST['t_filename']);
				$data['t_product_date'] = date("Y-m-d H:i:s", time());
				$data['t_price'] = $this->registry->library('db')->sanitizeData($_POST['price']);
				$product_id = $this->registry->library('db')->sanitizeData($_POST['productID']);
				$this->registry->library('db')->updateRecordsSys('shop_products', $data, 't_product_id="' . $product_id . '"');
// Restore CacheOn & Delete Cache
				$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
				if ($this->registry->setting('settings_cached') == 1)
				{
					$this->registry->library('db')->deleteCache('cache_', true);
				}
				$this->registry->redirectUser($this->registry->setting('settings_shop0') . '/edit_product/' . $product_id, $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
			}
			else
			{
				$this->registry->library('template')->page()->addTag('product_title', $_POST['product_title']);
				$this->registry->library('template')->page()->addTag('product_body', $_POST['product_body']);
				$this->registry->library('template')->page()->addTag('shop_id', $_POST['shopID']);
				$this->registry->library('template')->page()->addTag('product_id', $_POST['productID']);
				$this->registry->library('template')->page()->addTag('price', $_POST['price']);
				$this->registry->library('template')->page()->addTag('filename', $_POST['filename']);
				$this->registry->library('template')->page()->addTag('error_message', $this->registry->library('lang')->line('insufficient_data'));
				$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('edit'));
				$this->registry->library('template')->build('header.tpl', $this->registry->setting('settings_shop0') . '/products_edit.tpl', 'footer.tpl');
			}
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

	private function newopinion()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isLoggedIn() == true || $this->guests_opinions_allowed == 1)
		{
			$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
			$this->registry->library('template')->page()->addTag('author_id', $this->registry->library('authenticate')->getUserID());
			$this->registry->library('template')->page()->addTag('product_id', $this->seg_2);
			$this->registry->library('template')->page()->addTag('error_message', '');
			if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true || $this->registry->library('authenticate')->hasPermission('limited_admin') == true)
			{
				$this->registry->library('template')->page()->addTag('author_id', '');
				$this->registry->library('template')->page()->addTag('opinion_title', '');
				$this->registry->library('template')->page()->addTag('opinion_body', '');
				$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('new_opinion'));
				$this->registry->library('template')->build('header.tpl', $this->registry->setting('settings_shop0') . '/opinions_create.tpl', 'footer.tpl');
			}
			else
			{
				$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
			}
		}
	}

	private function creating_opinion()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isLoggedIn() == true || $this->guests_opinions_allowed == 1)
		{
			if ($_POST['body'] != '')
			{
// Caching OFF
				$this->registry->library('db')->setCacheOn(0);
				$product_id = $this->registry->library('db')->sanitizeData($_POST['productID']);
				$data['p_product_id'] = $product_id;
				$data['p_user_id'] = $this->registry->library('authenticate')->getUserID();
				$data['p_body'] = $this->registry->library('db')->sanitizeData($_POST['body']);
				$data['p_opinion_date'] = date("Y-m-d H:i:s", time());
				$sql = 'SELECT *
				FROM ' . $this->prefix . 'shop_products
				WHERE shop_products_sys = "' . $this->sys_cms . '"
				AND t_product_id = ' . $product_id;
				$this->registry->library('db')->execute($sql);
				if ($this->registry->library('db')->numRows() != 0)
				{
					$arr = $this->registry->library('db')->getRows();
					$data['p_shop_id'] = $arr['t_shop_id'];
					$data['p_ip_address'] = getenv('REMOTE_ADDR');
				}
				$this->registry->library('db')->insertRecordsSys('shop_opinions', $data);
// Restore CacheOn & Delete Cache
				$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
				if ($this->registry->setting('settings_cached') == 1)
				{
					$this->registry->library('db')->deleteCache('cache_', true);
				}
				$this->registry->redirectUser($this->registry->setting('settings_shop0') . '/viewproduct/' . $this->seg_2, $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
			}
			else
			{
				$this->registry->library('template')->page()->addTag('opinion_body', $_POST['body']);
				$this->registry->library('template')->page()->addTag('error_message', $this->registry->library('lang')->line('insufficient_data'));
				$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('new_opinion'));
				$this->registry->library('template')->build('header.tpl', $this->registry->setting('settings_shop0') . '/opinions_create.tpl', 'footer.tpl');
			}
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

	private function login()
	{
		$this->registry->library('template')->page()->addTag('after_login', FWURL . $this->registry->setting('settings_site0') . '/loggedin');
		$this->registry->library('template')->page()->addTag('username', $this->registry->library('lang')->line('username'));
		$this->registry->library('template')->page()->addTag('password', $this->registry->library('lang')->line('password'));
		$this->registry->library('template')->page()->addTag('register', $this->registry->library('lang')->line('register'));
		$this->registry->library('template')->page()->addTag('forgot_pass', $this->registry->library('lang')->line('forgot_pass'));
		$this->registry->library('template')->page()->addTag('sitename', $this->registry->setting('settings_cms_title'));
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->library('lang')->line('login'));
		$this->registry->library('template')->build('header.tpl', 'account/login.tpl', 'footer.tpl');
	}

	private function captchaOutput()
	{
		$this->registry->library('authenticate')->getCaptchaImage($this->seg_2);
	}

	private function paypal_notify()
	{
//		$notify_email = $this->registry->setting('settings_seller_email');
		$notify_email = $this->registry->setting('settings_admin_email');
		$req = 'cmd=_notify-validate';
		foreach ($_POST as $key => $value)
		{
			$value = urlencode(stripslashes($value));
			$req .= "&$key=$value";
		}
		$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
//
		if ($this->registry->setting('settings_paypal_sandbox') == 1)
		{
			$fp = fsockopen('www.sandbox.paypal.com', 80, $errno, $errstr, 30);
		}
		else
		{
			$fp = fsockopen('www.paypal.com', 80, $errno, $errstr, 30);
//	$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);
		}
		if (!$fp)
		{
			$mail_From = "From: Shop";
			$mail_To = $notify_email;
			$mail_Subject = "HTTP ERROR";
			$mail_Body = "Shop PayPal Connection Error";
			mail($mail_To, $mail_Subject, $mail_Body, $mail_From);
		}
		else
		{
			fputs($fp, $header . $req);
			while (!feof($fp))
			{
				$res = fgets($fp, 1024);
				if (strcmp($res, "VERIFIED") == 0)
				{
					$item_name = $_POST['item_name'];
					$item_number = $_POST['item_number'];
					$item_colour = $_POST['custom'];
					$payment_status = $_POST['payment_status'];
					$payment_amount = $_POST['mc_gross'];
					$payment_currency = $_POST['mc_currency'];
					$txn_id = $_POST['txn_id'];
					$receiver_email = $_POST['receiver_email'];
					$payer_email = $_POST['payer_email'];
//
					$custom = $_POST['custom'];
//
					if (($payment_status == 'Completed') && ($receiver_email == $this->registry->setting('settings_seller_email')) && ($payment_currency == "USD"))
					{
// Caching OFF
						$this->registry->library('db')->setCacheOn(0);
						$un = $this->registry->library('authenticate')->getUsernameFromID($custom);
						$data = array();
						$data['user_id'] = $this->registry->library('db')->sanitizeData($_POST['custom']);
						$data['username'] = $un;
						$data['item_id'] = $item_number;
						$data['item_name'] = $item_name;
						$data['amount'] = $payment_amount;
						$data['currency'] = $payment_currency;
						$data['trans_unixtime'] = time();
						$this->registry->library('db')->insertRecordsSys('paypal_trans', $data);
						$userID = $data['user_id'];
						$permID = 7;
						$v = 1;
						$sql = sprintf("REPLACE INTO `user_perms` SET `up_user_id` = %u, `up_perm_id` = %u, `up_value` = %u, `up_add_date` = '%s'", $userID, $permID, $v, date("Y-m-d H:i:s"));
						$cache = $this->registry->library('db')->cacheQuery($sql);
//
						$subject = "111_111_222 1";
						$message = "Transaction successfuly completed. Item name: " . $item_name . " User ID: " . $custom . " Username: " . $un;
						$headers = "333 \r\n";
						$to = "si@apollo.lv";
						mail($to, $subject, $message, $headers);
//
//
						$subject = "From: Shop";
						$message = "Transaction successfuly completed. Item name: " . $item_name . " User ID: " . $custom . " Username: " . $un;
						$headers = "From: Shop. TRANSACTION COMPLETED \r\n";
						$to = $notify_email;
						mail($to, $subject, $message, $headers);
//
// Restore CacheOn & Delete Cache
						$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
						if ($this->registry->setting('settings_cached') == 1)
						{
							$this->registry->library('db')->deleteCache('cache_', true);
						}
					}
					else
					{
//
						$subject = "From: Shop";
						$message = "Transaction successfuly completed. Item name: " . $item_name;
						$headers = "From: Shop. TRANSACTION WRONG \r\n";
						$to = $notify_email;
						mail($to, $subject, $message, $headers);
//
					}
				}
				elseif (strcmp($res, "INVALID") == 0)
				{
//
					$subject = "From: Shop";
					$message = "Transaction successfuly completed. Item name: " . $item_name;
					$headers = "From: Shop. TRANSACTION INVALID \r\n";
					$to = $notify_email;
					mail($to, $subject, $message, $headers);
//
				}
			}
//end of while
			fclose($fp);
		}
	}

	private function paypal_success()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->library('lang')->line('successful_transaction'));
		$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('successful_transaction'));
		$this->registry->library('template')->page()->addTag('message', $this->registry->library('lang')->line('successful_transaction'));
		$this->registry->library('template')->build('header.tpl', $this->registry->setting('settings_shop0') . '/paypal_message.tpl', 'footer.tpl');
	}

	private function paypal_cancel()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->library('lang')->line('transaction_cancelled'));
		$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('transaction_cancelled'));
		$this->registry->library('template')->page()->addTag('message', $this->registry->library('lang')->line('transaction_cancelled'));
		$this->registry->library('template')->build('header.tpl', $this->registry->setting('settings_shop0') . '/paypal_message.tpl', 'footer.tpl');
	}

}
?>