<?php

class Cartcontroller
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

					case 'add' :
						$this->add();
						break;

					case 'remove' :
						$this->remove();
						break;

					case 'empty' :
						$this->empty_product();
						break;

					case 'empty_cart' :
						$this->empty_cart();
						break;

					case 'order' :
						$this->order();
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
// shops
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
			$this->registry->library('template')->page()->addTag('shopping_cart', $this->registry->library('lang')->line('shopping_cart'));
			$this->registry->library('template')->page()->addTag('q-ty', $this->registry->library('lang')->line('q-ty'));
			$this->registry->library('template')->page()->addTag('currency', $this->registry->library('lang')->line('currency'));
			$this->registry->library('template')->page()->addTag('shopping_cart', $this->registry->library('lang')->line('shopping_cart'));
			$this->registry->library('template')->page()->addTag('total_text', $this->registry->library('lang')->line('total_text'));
			$this->registry->library('template')->page()->addTag('send_order', $this->registry->library('lang')->line('send_order'));
			$total = 0;
// if not empty
			if (isset ($_SESSION['cart']))
			{
				$stringProd = '';
// products ids string
				foreach ($_SESSION['cart'] as $k => $v)
				{
					$stringProd .= '"' . $k . '",';
				}
				$stringProd = substr($stringProd, 0, - 1);
// get data for string
				$sql = 'SELECT *
				FROM ' . $this->prefix . 'shop_products
				LEFT JOIN ' . $this->prefix . 'shops ON ' . $this->prefix . 'shops.f_shop_id = ' . $this->prefix . 'shop_products.t_shop_id
				WHERE t_product_id IN (' . $stringProd . ')
				AND t_status = "o"
				AND t_product_visible = "yes"
				ORDER BY t_product_id DESC';
				$cache = $this->registry->library('db')->cacheQuery($sql);
				if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
				{
					$products = array();
					$i = 0;
					$num = $this->registry->library('db')->numRowsFromCache($cache);
					$data = $this->registry->library('db')->rowsFromCache($cache);
// get all data
// 1. get MySQL data array
					foreach ($data as $k => $v)
					{
						$cartArray[$i]['product_id'] = $v['t_product_id'];
						$cartArray[$i]['product_shop_id'] = $v['t_shop_id'];
						$cartArray[$i]['product_shop_name'] = $v['f_name'];
						$cartArray[$i]['product_price'] = $v['t_price'];
						$cartArray[$i]['product_name'] = $v['t_title'];
						$cartArray[$i]['product_description'] = $v['t_body'];
// 2. plus SESSION data array
						foreach ($_SESSION['cart'] as $x => $y)
						{
							if ($v['t_product_id'] == $x)
							{
								$cartArray[$i]['product_qty'] = $y;
								$cartArray[$i]['product_currency'] = 'USD';
								$cartArray[$i]['product_price'] = $v['t_price'] * $y;
								$total = $total + $cartArray[$i]['product_price'];
							}
						}
						$i = $i + 1;
					}
				}
				$cache = $this->registry->library('db')->cacheData($cartArray);
				$this->registry->library('template')->page()->addTag('cart', array('DATA', $cache));
				$this->registry->library('template')->page()->addTag('cart_total', $total);
				$this->registry->library('template')->page()->addTag('products_available', 'y');
			}
			else
			{
				$cartArray[] = array('product_id' => '', 'product_name' => '', 'product_shop_name' => '', 'product_qty' => '', 'product_currency' => '', 'product_price' => '');
				$cache = $this->registry->library('db')->cacheData($cartArray);
				$this->registry->library('template')->page()->addTag('cart', array('DATA', $cache));
				$this->registry->library('template')->page()->addTag('cart_total', 0);
				$this->registry->library('template')->page()->addTag('products_available', '');
			}
			$this->registry->library('template')->build('header.tpl', $this->registry->setting('settings_shop0') . '/cart.tpl', 'footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

	private function add()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isLoggedIn() == true || $this->guests_allowed == 1)
		{
			if ($this->seg_2 < 1 || $this->seg_2 < 1)
			{
				$this->index();
			}
			else
			{
				if (isset ($_SESSION['cart'][$this->seg_2]))
				{
					$_SESSION['cart'][$this->seg_2]++;
				}
				else
				{
					$_SESSION['cart'][$this->seg_2] = 1;
				}
			}
			$this->registry->redirectUser('cart', $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

	private function remove()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isLoggedIn() == true || $this->guests_allowed == 1)
		{
			if (isset ($_SESSION['cart'][$this->seg_2]))
			{
				$_SESSION['cart'][$this->seg_2]--;
				if ($_SESSION['cart'][$this->seg_2] == 0)
				{
					unset ($_SESSION['cart'][$this->seg_2]);
				}
				if (count($_SESSION['cart']) == 0)
				{
					unset ($_SESSION['cart']);
				}
			}
			$this->registry->redirectUser('cart', $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

	private function empty_product()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isLoggedIn() == true || $this->guests_allowed == 1)
		{
			unset ($_SESSION['cart'][$this->seg_2]);
			$this->registry->redirectUser('cart', $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

	private function empty_cart()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isLoggedIn() == true || $this->guests_allowed == 1)
		{
			unset ($_SESSION['cart']);
			$this->registry->redirectUser('cart', $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

	private function order()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if (($this->registry->library('authenticate')->isLoggedIn() == true || $this->guests_allowed == 1) && $_POST['sending_order'] == 'sending_order')
		{
			$message = '';
			$total = 0;
// if not empty
			if (isset ($_SESSION['cart']))
			{
				$stringProd = '';
// products ids string
				foreach ($_SESSION['cart'] as $k => $v)
				{
					$stringProd .= '"' . $k . '",';
				}
				$stringProd = substr($stringProd, 0, - 1);
// get data for string
				$sql = 'SELECT *
				FROM ' . $this->prefix . 'shop_products
				LEFT JOIN ' . $this->prefix . 'shops ON ' . $this->prefix . 'shops.f_shop_id = ' . $this->prefix . 'shop_products.t_shop_id
				WHERE t_product_id IN (' . $stringProd . ')
				AND t_status = "o"
				AND t_product_visible = "yes"
				ORDER BY t_product_id DESC';
				$cache = $this->registry->library('db')->cacheQuery($sql);
				if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
				{
					$products = array();
					$i = 0;
					$num = $this->registry->library('db')->numRowsFromCache($cache);
					$data = $this->registry->library('db')->rowsFromCache($cache);
// get all data
// 1. get MySQL data array
					foreach ($data as $k => $v)
					{
						$message .= 'Customer ID: ' . $this->registry->library('authenticate')->getUserID() . '
';
						$message .= 'Customer Name: ' . $this->registry->library('authenticate')->getUsername() . '
';
						$message .= 'Product ID: ' . $v['t_product_id'] . '
';
						$message .= 'Product Name: ' . $v['t_title'] . '
';
						$message .= 'Product Description: ' . $v['t_body'] . '
';
						$message .= 'Shop ID: ' . $v['t_shop_id'] . '
';
						$message .= 'Shop Name: ' . $v['f_name'] . '
';
						$message .= 'Price: USD ' . $v['t_price'] . '
';
// 2. plus SESSION data array
						foreach ($_SESSION['cart'] as $x => $y)
						{
							if ($v['t_product_id'] == $x)
							{
								$message .= 'Quantity: ' . $y . '
';
								$message .= 'Subtotal: USD ' . $v['t_price'] * $y . '


';
								$total = $total + $v['t_price'] * $y;
							}
						}
						$i = $i + 1;
					}
				}
				$message .= 'Total: USD ' . $total . '
';
			}
			$subject = 'Order From: ' . FWURL;
			$headers = 'From: ' . 'no-reply@' . substr(substr(FWURL, 7), 0, - 1);
			$to = $this->registry->setting('settings_admin_email');
			mail($to, $subject, $message, $headers);
			unset ($_SESSION['cart']);
			$this->registry->redirectUser($this->registry->setting('settings_shop0'), $this->registry->library('lang')->line('email_sent_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

}
?>