<?php

class Admincontroller
{
	private $registry;
	private $model;
	private $prefix;
	private $sys_cms;
	private $seg_1;
	private $seg_2;
	private $seg_3;
	private $articles_per_page_in_admin = 20;
	private $users_per_page = 20;

// true if CKFinder installed
	public $ckfinderOn = true;

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
			$this->registry->library('template')->page()->addTag('admin_articles_create_before_submit_hook', '');
			$admin_articles_create_before_submit_hook = $this->registry->library('hook')->call('admin_articles_create_before_submit_hook');
			$this->registry->library('template')->page()->addTag('admin_articles_create_before_submit_hook', $admin_articles_create_before_submit_hook);
			$this->registry->library('template')->page()->addTag('admin_articles_edit_before_submit_hook', '');
			$admin_articles_edit_before_submit_hook = $this->registry->library('hook')->call('admin_articles_edit_before_submit_hook');
			$this->registry->library('template')->page()->addTag('admin_articles_edit_before_submit_hook', $admin_articles_edit_before_submit_hook);
			
			$this->registry->library('template')->page()->addTag('charset', $this->registry->setting('settings_charset'));
			$this->registry->library('template')->page()->addTag('metakeywords', $this->registry->setting('settings_metakeywords'));
			$this->registry->library('template')->page()->addTag('metadescription', $this->registry->setting('settings_metadescription'));
			$this->registry->library('template')->addTemplateSegment('top_bar_tpl', 'admin/admin_top_bar_tpl.tpl');
			$this->registry->library('template')->addTemplateSegment('top_menu_tpl', 'admin/admin_top_menu_tpl.tpl');
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
			$uid = $this->registry->library('authenticate')->getUserID();
			$this->registry->library('authenticate')->buildUserPermissions($uid);
			if ($this->ckfinderOn && ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true))
			{
				$_SESSION['CKFinder'] = true;
				$_SESSION['KCFINDER'] = array('disabled' => false);
			}
			else
			{
				$_SESSION['CKFinder'] = false;
			}
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
			$this->registry->library('template')->page()->addTag('edit_articles', $this->registry->library('lang')->line('edit_articles'));
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
			$this->registry->library('template')->page()->addTag('topic_text', $this->registry->library('lang')->line('topic_text'));
			$this->registry->library('template')->page()->addTag('post_text', $this->registry->library('lang')->line('post_text'));
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
			$this->registry->library('template')->page()->addTag('encrypted_field', $this->registry->library('lang')->line('encrypted_field'));
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
			$this->registry->library('template')->page()->addTag('blocks_text', $this->registry->library('lang')->line('blocks_text'));
			$this->registry->library('template')->page()->addTag('create_block', $this->registry->library('lang')->line('create_block'));
			$this->registry->library('template')->page()->addTag('block_title_text', $this->registry->library('lang')->line('block_title_text'));
			$this->registry->library('template')->page()->addTag('block_order_text', $this->registry->library('lang')->line('block_order_text'));
			$this->registry->library('template')->page()->addTag('block_description_text', $this->registry->library('lang')->line('block_description_text'));
			$this->registry->library('template')->page()->addTag('block_content_text', $this->registry->library('lang')->line('block_content_text'));
			$this->registry->library('template')->page()->addTag('no_blocks_yet', $this->registry->library('lang')->line('no_blocks_yet'));
			$this->registry->library('template')->page()->addTag('static_page_header', $this->registry->library('lang')->line('static_page_header'));
			$this->registry->library('template')->page()->addTag('static_page_main', $this->registry->library('lang')->line('static_page_main'));
			$this->registry->library('template')->page()->addTag('static_page_footer', $this->registry->library('lang')->line('static_page_footer'));
			$this->registry->library('template')->page()->addTag('web_url_text', $this->registry->library('lang')->line('web_url_text'));
			$this->registry->library('template')->page()->addTag('search', $this->registry->library('lang')->line('search'));
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
			if (($this->seg_1 == 'create_article' || $this->seg_1 == 'creating_article' || $this->seg_1 == 'edit_article' || $this->seg_1 == 'editing_article' || ($this->seg_1 == 'edit_page') || ($this->seg_1 == 'editing_page') || ($this->seg_1 == 'create_page') || ($this->seg_1 == 'edit_block') || ($this->seg_1 == 'editing_block') || ($this->seg_1 == 'create_block')) && $this->registry->setting('settings_editor') == 't')
			{
				$this->registry->library('template')->page()->addTag('editor', '<script type="text/javascript" src="' . FWURL . 'js/tinymce/tinymce.min.js"></script>
<script>
tinymce.init({
    file_browser_callback: function(field, url, type, win) {
        tinyMCE.activeEditor.windowManager.open({
            file: \'' . FWURL . 'js/kcfinder/browse.php?opener=tinymce4&field=\' + field + \'&type=\' + type,
            title: \'KCFinder\',
            width: 700,
            height: 500,
            inline: true,
            close_previous: false
        }, {
            window: win,
            input: field
        });
        return false;
    },
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
			if (($this->seg_1 == 'create_article' || $this->seg_1 == 'creating_article' || $this->seg_1 == 'edit_article' || $this->seg_1 == 'editing_article' || ($this->seg_1 == 'edit_page') || ($this->seg_1 == 'editing_page') || ($this->seg_1 == 'create_page') || ($this->seg_1 == 'edit_block') || ($this->seg_1 == 'editing_block') || ($this->seg_1 == 'create_block')) && $this->registry->setting('settings_editor') == 'c')
			{
				$this->registry->library('template')->page()->addTag('editor', '<script type="text/javascript" src="' . FWURL . 'js/ckeditor/ckeditor.js"></script>');
			}
			if ($this->ckfinderOn && ($this->seg_1 == 'create_article' || $this->seg_1 == 'creating_article' || $this->seg_1 == 'edit_article' || $this->seg_1 == 'editing_article' || ($this->seg_1 == 'edit_page') || ($this->seg_1 == 'editing_page') || ($this->seg_1 == 'create_page') || ($this->seg_1 == 'edit_block') || ($this->seg_1 == 'editing_block') || ($this->seg_1 == 'create_block')) && $this->registry->setting('settings_editor') == 'c')
			{
				$this->registry->library('template')->page()->addTag('editor', '<script type="text/javascript" src="' . FWURL . 'js/ckeditor/ckeditor.js"></script>
		<script type="text/javascript" src="' . FWURL . 'js/ckfinder/ckfinder.js"></script>');
			}
			if ($this->ckfinderOn && ($this->seg_1 == 'create_article' || $this->seg_1 == 'creating_article' || $this->seg_1 == 'edit_article' || $this->seg_1 == 'editing_article' || ($this->seg_1 == 'edit_page') || ($this->seg_1 == 'editing_page') || ($this->seg_1 == 'create_page') || ($this->seg_1 == 'edit_block') || ($this->seg_1 == 'editing_block') || ($this->seg_1 == 'create_block')) && $this->registry->setting('settings_editor') == 'c')
			{
				$this->registry->library('template')->page()->addTag('ckfinder_end', '<script type="text/javascript">
if ( typeof CKEDITOR == \'undefined\' )
{
	document.write(
		\'<strong><span style="color: #ff0000">Error</span>: CKEditor not found</strong>.\' +
		\'This sample assumes that CKEditor (not included with CKFinder) is installed in\' +
		\'the "/ckeditor/" path. If you have it installed in a different place, just edit\' +
		\'this file, changing the wrong paths in the &lt;head&gt; (line 5) and the "BasePath"\' +
		\'value (line 32).\' ) ;
}
else
{
	var editor = CKEDITOR.replace( \'article_extended\' );
	CKFinder.setupCKEditor( editor, \'' . FWURL . 'js/ckfinder/\' ) ;
	var editor = CKEDITOR.replace( \'article\' );
	CKFinder.setupCKEditor( editor, \'' . FWURL . 'js/ckfinder/\' ) ;
}
		</script>');
			}
			else
			{
				$this->registry->library('template')->page()->addTag('ckfinder_end', '');
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
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'cms
			WHERE cms_id = 1';
			$this->registry->library('db')->execute($sql);
			if ($this->registry->library('db')->numRows() != 0)
			{
				$data = $this->registry->library('db')->getRows();
				$newString = '';
				$oldString = $data['ver'];
				$length = strlen($data['ver']);
				for ($i = 0; $i < $length; $i++)
				{
					$newString .= $oldString[$i] . '.';
				}
				$newString = substr($newString, 0, $i * 2 - 1);
				$this->registry->library('template')->page()->addTag('current_version', $newString);
			}

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
			if ($this->seg_1 == '')
			{
				$this->index();
			}
			else
			{
				switch ($this->seg_1)
				{

					case 'loggedin' :
						$this->loggedin();
						break;

					case 'logout' :
						$this->logout();
						break;

					case 'users' :
						$this->users();
						break;

					case 'roles' :
						$this->roles();
						break;

					case 'permissions' :
						$this->permissions();
						break;

					case 'user' :
						$this->user();
						break;

					case 'edit_user_roles' :
						$this->edit_user_roles();
						break;

					case 'edit_user_permissions' :
						$this->edit_user_permissions();
						break;

					case 'editing_user_roles' :
						$this->editing_user_roles();
						break;

					case 'editing_user_permissions' :
						$this->editing_user_perms();
						break;

					case 'edit_role' :
						$this->edit_role();
						break;

					case 'editing_role' :
						$this->editing_role();
						break;

					case 'edit_permission' :
						$this->edit_perm();
						break;

					case 'editing_permission' :
						$this->editing_perm();
						break;

					case 'deleting_permission' :
						$this->deleting_perm();
						break;

					case 'create_permission' :
						$this->create_perm();
						break;

					case 'creating_permission' :
						$this->creating_perm();
						break;

					case 'create_role' :
						$this->create_role();
						break;

					case 'creating_role' :
						$this->creating_role();
						break;

					case 'deleting_role' :
						$this->deleting_role();
						break;

					case 'articles_list' :
						$this->articles_list();
						break;

					case 'articles_page' :
						$this->articles_page();
						break;

					case 'create_article' :
						$this->create_article();
						break;

					case 'creating_article' :
						$this->creating_article();
						break;

					case 'edit_article' :
						$this->edit_article();
						break;

					case 'editing_article' :
						$this->editing_article();
						break;

					case 'delete_article' :
						$this->delete_article();
						break;

					case 'modules' :
						$this->modules();
						break;

					case 'extensions' :
						$this->extensions();
						break;

					case 'categories_list' :
						$this->categories_list();
						break;

					case 'categories_page' :
						$this->categories_page();
						break;

					case 'create_category' :
						$this->create_category();
						break;

					case 'creating_category' :
						$this->creating_category();
						break;

					case 'edit_category' :
						$this->edit_category();
						break;

					case 'editing_category' :
						$this->editing_category();
						break;

					case 'delete_category' :
						$this->delete_category();
						break;

					case 'category_up' :
						$this->category_up();
						break;

					case 'category_down' :
						$this->category_down();
						break;

					case 'forum_category_up' :
						$this->forum_category_up();
						break;

					case 'forum_category_down' :
						$this->forum_category_down();
						break;

					case 'forum_up' :
						$this->forum_up();
						break;

					case 'forum_down' :
						$this->forum_down();
						break;

					case 'delete_shop' :
						$this->delete_shop();
						break;

					case 'shop_up' :
						$this->shop_up();
						break;

					case 'shop_down' :
						$this->shop_down();
						break;

					case 'comments_list' :
						$this->comments_list();
						break;

					case 'comments_page' :
						$this->comments_page();
						break;

					case 'create_comment' :
						$this->create_comment();
						break;

					case 'creating_comment' :
						$this->creating_comment();
						break;

					case 'edit_comment' :
						$this->edit_comment();
						break;

					case 'editing_comment' :
						$this->editing_comment();
						break;

					case 'delete_comment' :
						$this->delete_comment();
						break;

					case 'settings' :
						$this->settings();
						break;

					case 'updating_settings' :
						$this->updating_settings();
						break;

					case 'forums_list' :
						$this->forums_list();
						break;

					case 'create_forum' :
						$this->create_forum();
						break;

					case 'creating_forum' :
						$this->creating_forum();
						break;

					case 'edit_forum' :
						$this->edit_forum();
						break;

					case 'editing_forum' :
						$this->editing_forum();
						break;

					case 'delete_forum' :
						$this->delete_forum();
						break;

					case 'shops_list' :
						$this->shops_list();
						break;

					case 'create_shop' :
						$this->create_shop();
						break;

					case 'creating_shop' :
						$this->creating_shop();
						break;

					case 'edit_shop' :
						$this->edit_shop();
						break;

					case 'editing_shop' :
						$this->editing_shop();
						break;

					case 'hide_comment' :
						$this->hide_comment();
						break;

					case 'show_comment' :
						$this->show_comment();
						break;

					case 'forum_categories_list' :
						$this->forum_categories_list();
						break;

					case 'create_forum_category' :
						$this->create_forum_category();
						break;

					case 'creating_forum_category' :
						$this->creating_forum_category();
						break;

					case 'edit_forum_category' :
						$this->edit_forum_category();
						break;

					case 'editing_forum_category' :
						$this->editing_forum_category();
						break;

					case 'delete_forum_category' :
						$this->delete_forum_category();
						break;

					case 'topic_hide' :
						$this->hideTopic();
						break;

					case 'topic_show' :
						$this->showTopic();
						break;

					case 'topic_close' :
						$this->closeTopic();
						break;

					case 'topic_open' :
						$this->openTopic();
						break;

					case 'post_hide' :
						$this->hidePost();
						break;

					case 'post_show' :
						$this->showPost();
						break;

					case 'post_delete' :
						$this->deletePost();
						break;

					case 'topic_delete' :
						$this->deleteTopic();
						break;

					case 'topic_edit' :
						$this->editTopic();
						break;

					case 'editing_topic' :
						$this->editingTopic();
						break;

					case 'post_edit' :
						$this->editPost();
						break;

					case 'editing_post' :
						$this->editingPost();
						break;

					case 'add_field' :
						$this->add_field();
						break;

					case 'adding_field' :
						$this->adding_field();
						break;

					case 'fields_list' :
						$this->fields_list();
						break;

					case 'edit_field' :
						$this->edit_field();
						break;

					case 'editing_field' :
						$this->editing_field();
						break;

					case 'delete_field' :
						$this->delete_field();
						break;

					case 'sites_list' :
						$this->sites_list();
						break;

					case 'add_site' :
						$this->add_site();
						break;

					case 'delete_site' :
						$this->delete_site();
						break;

					case 'adding_site' :
						$this->adding_site();
						break;

					case 'deleting_site' :
						$this->deleting_site();
						break;

					case 'switching_site' :
						$this->switching_site();
						break;

					case 'pages_list' :
						$this->pages_list();
						break;

					case 'create_page' :
						$this->create_page();
						break;

					case 'creating_page' :
						$this->creating_page();
						break;

					case 'edit_page' :
						$this->edit_page();
						break;

					case 'editing_page' :
						$this->editing_page();
						break;

					case 'delete_page' :
						$this->delete_page();
						break;

					case 'page_up' :
						$this->page_up();
						break;

					case 'page_down' :
						$this->page_down();
						break;

					case 'delete_opinion' :
						$this->delete_opinion();
						break;

					case 'delete_product' :
						$this->delete_product();
						break;

					case 'blocks_list' :
						$this->blocks_list();
						break;

					case 'create_block' :
						$this->create_block();
						break;

					case 'creating_block' :
						$this->creating_block();
						break;

					case 'edit_block' :
						$this->edit_block();
						break;

					case 'editing_block' :
						$this->editing_block();
						break;

					case 'delete_block' :
						$this->delete_block();
						break;

					case 'block_up' :
						$this->block_up();
						break;

					case 'block_down' :
						$this->block_down();
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

	private function index()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true || $this->registry->library('authenticate')->hasPermission('limited_admin') == true)
		{
			$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->library('lang')->line('admin_home'));
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('acp'));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_index.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function loggedin()
	{
		$this->registry->redirectUser('admin', $this->registry->library('lang')->line('welcome'), $this->registry->library('lang')->line('please_wait_for_the_redirect'), false);
	}

	private function logout()
	{
		$this->registry->library('authenticate')->logout();
		$this->registry->redirectUser('', 'Logged-out', $this->registry->library('lang')->line('please_wait_for_the_redirect'), false);
	}

	private function users()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->library('lang')->line('users_list'));
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('users_list'));
			$pagination = $this->registry->library('paginate')->createLinks('users', $this->users_per_page, 2, 'admin/users');
			$this->registry->library('template')->page()->addTag('pagination', $pagination);
			if ($this->seg_2 != '')
			{
				$current_page = $this->seg_2;
				$offset = ($current_page - 1) * $this->users_per_page;
				$sql = "SELECT *
					FROM " . $this->prefix . "users
					ORDER BY users_id ASC
					LIMIT " . $offset . "," . $this->users_per_page;
				$cache = $this->registry->library('db')->cacheQuery($sql);
				$this->registry->library('template')->page()->addTag('users', array('SQL', $cache));
			}
			else
			{
				$cache = $this->registry->library('db')->cacheQuery('SELECT * FROM ' . $this->prefix . 'users');
				$this->registry->library('template')->page()->addTag('users', array('SQL', $cache));
			}
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_users.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function roles()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->library('lang')->line('roles_list'));
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('roles_list'));
			$aRoles = $this->registry->library('authenticate')->getAllRoles('full');
			$rolesArray = array();
			foreach ($aRoles as $k => $v)
			{
				$rolesArray[] = array('role_id' => $v['0'], 'role_name' => $v['1'], 'role_locked' => $v['2']);
			}
			$cache = $this->registry->library('db')->cacheData($rolesArray);
			$this->registry->library('template')->page()->addTag('roles', array('DATA', $cache));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_roles.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function permissions()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->library('lang')->line('roles_list'));
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('roles_list'));
			$aPerms = $this->registry->library('authenticate')->getAllPerms('full');
			$permsArray = array();
			foreach ($aPerms as $k => $v)
			{
				$permsArray[] = array('perm_id' => $v['0'], 'perm_name' => $v['2'], 'perm_locked' => $v['3']);
			}
			$cache = $this->registry->library('db')->cacheData($permsArray);
			$this->registry->library('template')->page()->addTag('perms', array('DATA', $cache));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_perms.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function user()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
// Caching OFF
			$this->registry->library('db')->setCacheOn(0);
			if ($this->seg_2 == 'ban')
			{
				$data = array();
				$data['banned'] = 1;
				$this->registry->library('db')->updateRecords('users', $data, 'users_id=' . $this->seg_3);
// Restore CacheOn & Delete Cache
				$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
				if ($this->registry->setting('settings_cached') == 1)
				{
					$this->registry->library('db')->deleteCache('cache_', true);
				}
				$this->registry->redirectUser('admin/users', $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
			}
			elseif ($this->seg_2 == 'unban')
			{
				$data = array();
				$data['banned'] = 0;
				$this->registry->library('db')->updateRecords('users', $data, 'users_id=' . $this->seg_3);
// Restore CacheOn & Delete Cache
				$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
				if ($this->registry->setting('settings_cached') == 1)
				{
					$this->registry->library('db')->deleteCache('cache_', true);
				}
				$this->registry->redirectUser('admin/users', $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
			}
			elseif ($this->seg_2 == 'delete')
			{
				$this->registry->library('db')->deleteRecords('users', 'users_id=' . $this->seg_3, '1');
// Restore CacheOn & Delete Cache
				$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
				if ($this->registry->setting('settings_cached') == 1)
				{
					$this->registry->library('db')->deleteCache('cache_', true);
				}
				$this->registry->redirectUser('admin/users', $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
			}
			else
			{
				$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->library('lang')->line('user'));
				$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('user'));
				$sql = 'SELECT *
			FROM ' . $this->prefix . 'users
			WHERE users_id = ' . $this->seg_2;
				$this->registry->library('db')->execute($sql);
				if ($this->registry->library('db')->numRows() != 0)
				{
					$data = $this->registry->library('db')->getRows();
					$this->registry->library('template')->page()->addTag('username', $data['username']);
				}
				$this->registry->library('template')->page()->addTag('user_id', $this->seg_2);
				$this->registry->library('authenticate')->getUserRoles($this->seg_2);
				$uRoles = $this->registry->library('authenticate')->roles;
				$rolesArray = array();
				foreach ($uRoles as $k => $v)
				{
					$rolesArray[] = array('role_id' => $v, 'role_name' => $this->registry->library('authenticate')->getRoleNameFromID($v));
				}
				$cache = $this->registry->library('db')->cacheData($rolesArray);
				$this->registry->library('template')->page()->addTag('roles', array('DATA', $cache));
				$this->registry->library('authenticate')->buildPermissions($this->seg_2);
				$aPerms = $this->registry->library('authenticate')->getAllPerms('full');
				$permsList = array();
				foreach ($aPerms as $k => $v)
				{
					if ($this->registry->library('authenticate')->hasPermission($v['1']) === true)
					{
						$permsList[] = array('perm_id' => $v['0'], 'perm_name' => $v['2'], 'perm_level' => 'allow', 'perm_alt' => 'Allow');
					}
					else
					{
						$permsList[] = array('perm_id' => $v['0'], 'perm_name' => $v['2'], 'perm_level' => 'deny', 'perm_alt' => 'Deny');
					}
				}
				$cache = $this->registry->library('db')->cacheData($permsList);
				$this->registry->library('template')->page()->addTag('perms', array('DATA', $cache));
// Restore CacheOn NOT Delete Cache
				$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
				$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_user.tpl', 'admin/admin_footer.tpl');
			}
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function edit_user_roles()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->library('lang')->line('user'));
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('user'));
			$this->registry->library('template')->page()->addTag('user_id', $this->seg_2);
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'users
			WHERE users_id = ' . $this->seg_2;
			$this->registry->library('db')->execute($sql);
			if ($this->registry->library('db')->numRows() != 0)
			{
				$data = $this->registry->library('db')->getRows();
				$this->registry->library('template')->page()->addTag('username', $data['username']);
			}
			$aRoles = $this->registry->library('authenticate')->getAllRoles('full');
			$rolesArray = array();
			foreach ($aRoles as $k => $v)
			{
				if ($this->registry->library('authenticate')->userHasRole($v['0'], $this->seg_2) === true)
				{
					$checked_1 = 'checked = "checked"';
					$checked_2 = '';
				}
				else
				{
					$checked_1 = '';
					$checked_2 = 'checked = "checked"';
				}
				$rolesArray[] = array('role_id' => $v['0'], 'role_name' => $v['1'], 'value_1' => 1, 'value_2' => 0, 'checked_1' => $checked_1, 'checked_2' => $checked_2);
			}
			$cache = $this->registry->library('db')->cacheData($rolesArray);
			$this->registry->library('template')->page()->addTag('roles', array('DATA', $cache));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_edit_user_roles.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function editing_user_roles()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
// Caching OFF
			$this->registry->library('db')->setCacheOn(0);
			foreach ($_POST as $k => $v)
			{
				if (substr($k, 0, 5) == "role_")
				{
					$roleID = str_replace("role_", "", $k);
					$userID = $this->registry->library('db')->sanitizeData($_POST['userID']);
					if ($v == '0' || $v == 'x')
					{
						$sql = sprintf("DELETE FROM `" . $this->prefix . "user_roles` WHERE `ur_id` = %u AND `ur_role_id` = %u", $userID, $roleID);
					}
					else
					{
						$sql = sprintf("REPLACE INTO `" . $this->prefix . "user_roles` SET `ur_id` = %u, `ur_role_id` = %u, `ur_add_date` = '%s'", $userID, $roleID, date("Y-m-d H:i:s"));
					}
					$cache = $this->registry->library('db')->cacheQuery($sql);
				}
			}
// Restore CacheOn & Delete Cache
			$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
			if ($this->registry->setting('settings_cached') == 1)
			{
				$this->registry->library('db')->deleteCache('cache_', true);
			}
			$this->registry->redirectUser('admin/edit_user_roles/' . $userID, $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function edit_user_permissions()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->library('lang')->line('user'));
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('user'));
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'users
			WHERE users_id = ' . $this->seg_2;
			$this->registry->library('db')->execute($sql);
			if ($this->registry->library('db')->numRows() != 0)
			{
				$data = $this->registry->library('db')->getRows();
				$this->registry->library('template')->page()->addTag('username', $data['username']);
			}
			$this->registry->library('template')->page()->addTag('user_id', $this->seg_2);
			$this->registry->library('authenticate')->getUserRoles($this->seg_2);
			$this->registry->library('authenticate')->buildPermissions($this->seg_2);
			$aPerms = $this->registry->library('authenticate')->getAllPerms('full');
			$rPerms = $this->registry->library('authenticate')->perms;
			$permsArray = array();
			foreach ($aPerms as $k => $v)
			{
				$selected_1 = '';
				$selected_0 = '';
				$selected_x = '';
				if ($this->registry->library('authenticate')->hasPermission($v['1']) == '1')
				{
					$perm_level = 'allow';
					$perm_alt = 'Allow';
				}
				else
				{
					$perm_level = 'deny';
					$perm_alt = 'Deny';
				}
				if ($rPerms[$v['1']]['value'] == 1 && $rPerms[$v['1']]['inherited'] != 1)
				{
					$selected_1 = 'selected="selected"';
				}
				if ($rPerms[$v['1']]['value'] == 0 && $rPerms[$v['1']]['inherited'] != 1)
				{
					$selected_0 = 'selected="selected"';
				}
				$iVal = '';
				if ($rPerms[$v['1']]['inherited'] == 1 || !array_key_exists($v['1'], $rPerms))
				{
					$selected_x = 'selected="selected"';
					if ($rPerms[$v['1']]['value'] == 1)
					{
						$iVal = '(' . $this->registry->library('lang')->line('allow') . ')';
					}
					else
					{
						$iVal = '(' . $this->registry->library('lang')->line('deny') . ')';
					}
				}
				$permsArray[] = array('perm_id' => $v['0'], 'perm_name' => $v['2'], 'perm_level' => $perm_level, 'perm_alt' => $perm_alt, 'selected_1' => $selected_1, 'selected_0' => $selected_0, 'selected_x' => $selected_x, 'inherited_value' => $iVal);
			}
			$cache = $this->registry->library('db')->cacheData($permsArray);
			$this->registry->library('template')->page()->addTag('perms', array('DATA', $cache));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_edit_user_perms.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function editing_user_perms()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
// Caching OFF
			$this->registry->library('db')->setCacheOn(0);
			foreach ($_POST as $k => $v)
			{
				if (substr($k, 0, 5) == "perm_")
				{
					$permID = str_replace("perm_", "", $k);
					$userID = $this->registry->library('db')->sanitizeData($_POST['userID']);
					if ($v == 'x')
					{
						$sql = sprintf("DELETE FROM `" . $this->prefix . "user_perms` WHERE `up_user_id` = %u AND `up_perm_id` = %u", $userID, $permID);
					}
					else
					{
						$sql = sprintf("REPLACE INTO `" . $this->prefix . "user_perms` SET `up_user_id` = %u, `up_perm_id` = %u, `up_value` = %u, `up_add_date` = '%s'", $userID, $permID, $v, date("Y-m-d H:i:s"));
					}
					$cache = $this->registry->library('db')->cacheQuery($sql);
				}
			}
// Restore CacheOn & Delete Cache
			$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
			if ($this->registry->setting('settings_cached') == 1)
			{
				$this->registry->library('db')->deleteCache('cache_', true);
			}
			$this->registry->redirectUser('admin/edit_user_permissions/' . $userID, $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function edit_role()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->library('lang')->line('role'));
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('role'));
			$this->registry->library('template')->page()->addTag('username', $this->registry->library('authenticate')->getUsername());
			$this->registry->library('template')->page()->addTag('role_id', $this->seg_2);
			$this->registry->library('template')->page()->addTag('role_name', $this->registry->library('authenticate')->getRoleNameFromID($this->seg_2));
			$aPerms = $this->registry->library('authenticate')->getAllPerms('full');
			$rPerms = $this->registry->library('authenticate')->getRolePerms($this->seg_2);
			$permsArray = array();
			foreach ($aPerms as $k => $v)
			{
				$checked_1 = '';
				$checked_0 = '';
				$checked_x = '';
				if ($rPerms[$v['1']]['value'] == '1' && $this->seg_2 != '')
				{
					$checked_1 = 'checked="checked"';
				}
				if ($rPerms[$v['1']]['value'] == '0' && $this->seg_2 != '')
				{
					$checked_0 = 'checked="checked"';
				}
				if ($this->seg_2 == '' || !array_key_exists($v['1'], $rPerms))
				{
					$checked_x = 'checked="checked"';
				}
				$permsArray[] = array('perm_id' => $v['0'], 'perm_name' => $v['2'], 'checked_1' => $checked_1, 'checked_0' => $checked_0, 'checked_x' => $checked_x);
			}
			$cache = $this->registry->library('db')->cacheData($permsArray);
			$this->registry->library('template')->page()->addTag('perms', array('DATA', $cache));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_edit_role.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function editing_role()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
// Caching OFF
			$this->registry->library('db')->setCacheOn(0);
			$roleName = $this->registry->library('db')->sanitizeData($_POST['roleName']);
			$sql = sprintf("REPLACE INTO `" . $this->prefix . "roles` SET `roles_id` = %u, `roles_name` = '%s'", $this->seg_2, $roleName);
			$cache = $this->registry->library('db')->cacheQuery($sql);
			$roleID = $this->seg_2;
			foreach ($_POST as $k => $v)
			{
				if (substr($k, 0, 5) == "perm_")
				{
					$permID = str_replace("perm_", "", $k);
					if ($v == 'x')
					{
						$sql = sprintf("DELETE FROM `" . $this->prefix . "role_perms` WHERE `rp_role_id` = %u AND `rp_perm_id` = %u", $roleID, $permID);
						$this->registry->library('db')->execute($sql);
						continue;
					}
					$sql = sprintf("REPLACE INTO `" . $this->prefix . "role_perms` SET `rp_role_id` = %u, `rp_perm_id` = %u, `rp_value` = %u, `rp_add_date` = '%s'", $roleID, $permID, $v, date("Y-m-d H:i:s"));
					$this->registry->library('db')->execute($sql);
				}
			}
// Restore CacheOn & Delete Cache
			$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
			if ($this->registry->setting('settings_cached') == 1)
			{
				$this->registry->library('db')->deleteCache('cache_', true);
			}
			$this->registry->redirectUser('admin/edit_role/' . $this->seg_2, $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function deleting_role()
	{
		$roleID = $this->registry->library('db')->sanitizeData($_POST['roleID']);
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
// Restore CacheOn & Delete Cache
			$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
			if ($this->registry->setting('settings_cached') == 1)
			{
				$this->registry->library('db')->deleteCache('cache_', true);
			}
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'roles
			WHERE roles_id =' . $roleID;
			$this->registry->library('db')->execute($sql);
			if ($this->registry->library('db')->numRows() != 0)
			{
				$data = $this->registry->library('db')->getRows();
				$locked = $data['roles_locked'];
			}
			if ($locked == 0)
			{
				$sql = sprintf("DELETE FROM `" . $this->prefix . "roles` WHERE `roles_id` = %u LIMIT 1", $roleID);
				$cache = $this->registry->library('db')->cacheQuery($sql);
				$sql = sprintf("DELETE FROM `" . $this->prefix . "user_roles` WHERE `ur_role_id` = %u", $roleID);
				$cache = $this->registry->library('db')->cacheQuery($sql);
				$sql = sprintf("DELETE FROM `" . $this->prefix . "role_perms` WHERE `rp_role_id` = %u", $roleID);
				$cache = $this->registry->library('db')->cacheQuery($sql);
// Restore CacheOn & Delete Cache
				$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
				if ($this->registry->setting('settings_cached') == 1)
				{
					$this->registry->library('db')->deleteCache('cache_', true);
				}
				$this->registry->redirectUser('admin/roles', $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
			}
			else
			{
// Restore CacheOn NOT Delete Cache
				$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
				$this->registry->redirectUser('admin/edit_role/' . $roleID, $this->registry->library('lang')->line('this_role_protected'), $this->registry->library('lang')->line('please_wait_for_the_redirect'), false);
			}
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function edit_perm()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->library('lang')->line('manage_perm'));
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('manage_perm'));
			$this->registry->library('template')->page()->addTag('username', $this->registry->library('authenticate')->getUsername());
			$this->registry->library('template')->page()->addTag('perm_id', $this->seg_2);
			$this->registry->library('template')->page()->addTag('perm_name', $this->registry->library('authenticate')->getPermNameFromID($this->seg_2));
			$this->registry->library('template')->page()->addTag('perm_key', $this->registry->library('authenticate')->getPermKeyFromID($this->seg_2));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_edit_perm.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function editing_perm()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$permID = $this->registry->library('db')->sanitizeData($_POST['permID']);
			$permName = $this->registry->library('db')->sanitizeData($_POST['permName']);
			$permKey = $this->registry->library('db')->sanitizeData($_POST['permKey']);
			$sql = sprintf("REPLACE INTO `" . $this->prefix . "permissions` SET `perm_id` = %u, `perm_name` = '%s', `perm_key` = '%s'", $permID, $permName, $permKey);
			$cache = $this->registry->library('db')->cacheQuery($sql);
			$this->registry->redirectUser('admin/edit_permission/' . $permID, $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function deleting_perm()
	{
		$permID = $this->registry->library('db')->sanitizeData($_POST['permID']);
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'permissions
			WHERE perm_id =' . $permID;
			$this->registry->library('db')->execute($sql);
			if ($this->registry->library('db')->numRows() != 0)
			{
				$data = $this->registry->library('db')->getRows();
				$locked = $data['perm_locked'];
			}
			if ($locked == 0)
			{
				$permID = $this->registry->library('db')->sanitizeData($_POST['permID']);
				$sql = sprintf("DELETE FROM `" . $this->prefix . "permissions` WHERE `perm_id` = %u LIMIT 1", $permID);
				$cache = $this->registry->library('db')->cacheQuery($sql);
				$this->registry->redirectUser('admin/permissions', $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
			}
			else
			{
				$this->registry->redirectUser('admin/edit_permission/' . $permID, $this->registry->library('lang')->line('this_perm_protected'), $this->registry->library('lang')->line('please_wait_for_the_redirect'), false);
			}
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function create_role()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$this->registry->library('template')->page()->addTag('role_id', $this->seg_2);
			$aPerms = $this->registry->library('authenticate')->getAllPerms('full');
			$permsArray = array();
			foreach ($aPerms as $k => $v)
			{
				$permsArray[] = array('perm_id' => $v['0'], 'perm_name' => $v['2']);
			}
			$cache = $this->registry->library('db')->cacheData($permsArray);
			$this->registry->library('template')->page()->addTag('perms', array('DATA', $cache));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_create_role.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function creating_role()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$roleID = $this->registry->library('db')->sanitizeData($_POST['roleID']);
			$roleName = $this->registry->library('db')->sanitizeData($_POST['roleName']);
			$sql = sprintf("REPLACE INTO `" . $this->prefix . "roles` SET `roles_id` = %u, `roles_name` = '%s'", $roleID, $roleName);
			$cache = $this->registry->library('db')->cacheQuery($sql);
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'roles
			ORDER BY roles_id DESC
			LIMIT 1';
			$this->registry->library('db')->execute($sql);
			if ($this->registry->library('db')->numRows() != 0)
			{
				$data = $this->registry->library('db')->getRows();
				$roleID = $data['roles_id'];
			}
			foreach ($_POST as $k => $v)
			{
				if (substr($k, 0, 5) == "perm_" && $v != 'x')
				{
					$sql = sprintf("REPLACE INTO `" . $this->prefix . "role_perms` SET `rp_role_id` = %u, `rp_perm_id` = %u, `rp_value` = %u, `rp_add_date` = '%s'", $roleID, str_replace("perm_", "", $k), $v, date("Y-m-d H:i:s"));
					$this->registry->library('db')->execute($sql);
				}
			}
			$this->registry->redirectUser('admin/roles/' . $permID, $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function create_perm()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$this->registry->library('template')->page()->addTag('perm_id', $this->seg_2);
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_create_perm.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function creating_perm()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$permID = $this->registry->library('db')->sanitizeData($_POST['permID']);
			$permName = $this->registry->library('db')->sanitizeData($_POST['permName']);
			$permKey = $this->registry->library('db')->sanitizeData($_POST['permKey']);
			$sql = sprintf("REPLACE INTO `" . $this->prefix . "permissions` SET `perm_id` = %u, `perm_name` = '%s', `perm_key` = '%s'", $permID, $permName, $permKey);
			$this->registry->library('db')->execute($sql);
			$this->registry->redirectUser('admin/permissions/' . $permID, $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function articles_list()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$current_page = 1;
			$offset = ($current_page - 1) * $this->articles_per_page_in_admin;
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'articles
			LEFT JOIN ' . $this->prefix . 'users ON ' . $this->prefix . 'users.users_id = ' . $this->prefix . 'articles.author_id
			LEFT JOIN ' . $this->prefix . 'categories ON ' . $this->prefix . 'categories.category_id = ' . $this->prefix . 'articles.categories
			AND categories_sys = "' . $this->sys_cms . '"
			WHERE articles_sys = "' . $this->sys_cms . '"
			ORDER BY article_id DESC
			LIMIT ' . $offset . ',' . $this->articles_per_page_in_admin;
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
						$i = $i + 1;
					}
				}
			}
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('articles'));
			$cache = $this->registry->library('db')->cacheData($articles);
			$this->registry->library('template')->page()->addTag('articles', array('DATA', $cache));
			$pagination = $this->registry->library('paginate')->createLinksSys('articles', $this->articles_per_page_in_admin, 3, 'admin/articles_page');
			$this->registry->library('template')->page()->addTag('pagination', $pagination);
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_articles_list.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function articles_page()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$pagination = $this->registry->library('paginate')->createLinksSys('articles', $this->articles_per_page_in_admin, 2, 'admin/articles_page');
			$this->registry->library('template')->page()->addTag('pagination', $pagination);
			$current_page = $this->seg_2;
			$offset = ($current_page - 1) * $this->articles_per_page_in_admin;
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'articles
			LEFT JOIN ' . $this->prefix . 'users ON ' . $this->prefix . 'users.users_id = ' . $this->prefix . 'articles.author_id
			LEFT JOIN ' . $this->prefix . 'categories ON ' . $this->prefix . 'categories.category_id = ' . $this->prefix . 'articles.categories
			AND categories_sys = "' . $this->sys_cms . '"
			WHERE articles_sys = "' . $this->sys_cms . '"
			ORDER BY article_id DESC
			LIMIT ' . $offset . ',' . $this->articles_per_page_in_admin;
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
						$i = $i + 1;
					}
				}
			}
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('articles'));
			$cache = $this->registry->library('db')->cacheData($articles);
			$this->registry->library('template')->page()->addTag('articles', array('DATA', $cache));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_articles_list.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function create_article()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		$this->registry->library('template')->page()->addTag('author_id', $this->registry->library('authenticate')->getUserID());
		$this->registry->library('template')->page()->addTag('error_message', '');
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true || $this->registry->library('authenticate')->hasPermission('limited_admin') == true)
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
			AND (c_created_type = 1 OR c_created_type = 2)
			AND c_created_site_section = "b"');
			$this->registry->library('template')->page()->addTag('custom_fields_12', array('SQL', $cache));
			$stringField3 = '';
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'c_fields_created
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
						$stringField3 .= '<option value="' . $value . '">' . $value . '</option>';
					}
				}
				$stringField3 .= '</select>';
			}
			$this->registry->library('template')->page()->addTag('stringField3', $stringField3);
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('new_article'));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_articles_create.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function creating_article()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
// Caching OFF
			$this->registry->library('db')->setCacheOn(0);
			$this->registry->library('template')->page()->addTag('author_id', $this->registry->library('authenticate')->getUserID());
/// URL check (USED before?)
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'articles
			WHERE articles_sys = "' . $this->sys_cms . '"
			AND url_title = "' . $this->registry->library('db')->sanitizeData($_POST['url_title']) . '"';
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) != 0 && $this->registry->library('db')->sanitizeData($_POST['url_title']) != '')
			{
				$this->registry->library('template')->page()->addTag('error_message', $this->registry->library('lang')->line('url_title_used'));
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
			AND (c_created_type = 1 OR c_created_type = 2)
			AND c_created_site_section = "b"');
				$this->registry->library('template')->page()->addTag('custom_fields_12', array('SQL', $cache));
				$stringField3 = '';
				$sql = 'SELECT *
			FROM ' . $this->prefix . 'c_fields_created
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
				$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_articles_create.tpl', 'admin/admin_footer.tpl');
			}

//			if($_POST['title'] == '' || $_POST['url_title'] == '' || $_POST['article'] == '')
			elseif ($_POST['title'] == '' || $_POST['article'] == '')
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
			AND (c_created_type = 1 OR c_created_type = 2)
			AND c_created_site_section = "b"');
				$this->registry->library('template')->page()->addTag('custom_fields_12', array('SQL', $cache));
				$stringField3 = '';
				$sql = 'SELECT *
			FROM ' . $this->prefix . 'c_fields_created
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
				$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_articles_create.tpl', 'admin/admin_footer.tpl');
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
			AND (c_created_type = 1 OR c_created_type = 2)
			AND c_created_site_section = "b"');
				$this->registry->library('template')->page()->addTag('custom_fields_12', array('SQL', $cache));
				$stringField3 = '';
				$sql = 'SELECT *
			FROM ' . $this->prefix . 'c_fields_created
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
				$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_articles_create.tpl', 'admin/admin_footer.tpl');
			}
			else
			{
// To add Article
				$data = array();

// php hook: creating_article_before_insertRecordsSys_articles_hook
				$resulthook = '';
				$resulthook = $this->registry->library('hook')->call('creating_article_before_insertRecordsSys_articles_hook');
// reading RETURN as $data
				if ($resulthook != '')
				{
					$pieces = explode("  ", $resulthook);
					$length = count($pieces);
					for ($i = 0; $i < $length / 2; $i++)
					{
  						$data[$pieces[$i * 2]] = $pieces[$i * 2 + 1];
					}
				}


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

// php hook: creating_article_after_insertRecordsSys_articles_hook
				$this->registry->library('hook')->call('creating_article_after_insertRecordsSys_articles_hook');

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
							if ($v['c_created_encrypted'] == 'y')
							{
								$arr[$k]['c_body'] = $this->registry->library('crypter')->encrypt($_POST['custom_field_' . $v['c_created_id']]);
							}
							else
							{
								$arr[$k]['c_body'] = $_POST['custom_field_' . $v['c_created_id']];
							}
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
				$this->registry->redirectUser('admin/articles_list/', $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
			}
// Restore CacheOn NOT Delete Cache
			$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
		}
		else
		{
// Restore CacheOn NOT Delete Cache
			$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function edit_article()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
// Caching OFF
			$this->registry->library('db')->setCacheOn(0);
			$this->registry->library('template')->page()->addTag('error_message', '');
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'articles
			LEFT JOIN ' . $this->prefix . 'users ON ' . $this->prefix . 'users.users_id = ' . $this->prefix . 'articles.author_id
			LEFT JOIN ' . $this->prefix . 'categories ON ' . $this->prefix . 'categories.category_id = ' . $this->prefix . 'articles.categories
			AND categories_sys = "' . $this->sys_cms . '"
			WHERE articles_sys = "' . $this->sys_cms . '"
			AND article_id = ' . $this->seg_2;
			$this->registry->library('db')->execute($sql);
			if ($this->registry->library('db')->numRows() != 0)
			{
				$data = $this->registry->library('db')->getRows();
				$this->registry->library('template')->page()->addTag('article_id', $data['article_id']);
				$this->registry->library('template')->page()->addTag('title', $data['title']);
				$this->registry->library('template')->page()->addTag('url_title', $data['url_title']);
				$this->registry->library('template')->page()->addTag('article', $data['article']);
				$this->registry->library('template')->page()->addTag('article_extended', $data['article_extended']);
				$this->registry->library('template')->page()->addTag('art_created', $data['art_created']);
				$this->registry->library('template')->page()->addTag('username', $data['username']);
				$this->registry->library('template')->page()->addTag('article_visible', $data['article_visible']);
				$this->registry->library('template')->page()->addTag('pinned', $data['pinned']);
			}
			$sql = 'SELECT *
FROM ' . $this->prefix . 'art_cats
WHERE art_cats_sys = "' . $this->sys_cms . '"
AND ac_art_id = ' . $data['article_id'];
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
			{
				$checked = array();
				$num = $this->registry->library('db')->numRowsFromCache($cache);
				$cats = $this->registry->library('db')->rowsFromCache($cache);
				foreach ($cats as $k => $v)
				{
					$checked[] = $v['ac_cats_id'];
				}
			}
// echo count($checked) . '/';
// if (in_array(2, $checked)) {
//    echo "ZZZ";
// }
// echo $data['article_id'] . ' <hr> ' . $sql . ' <hr> ' . $num . ' <hr> ';
// echo '<pre>' . print_r($checked, true) . '</pre>';
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
					$html = $this->registry->library('helper')->adminCatCheckBoxList($data, $checked);
				}
				else
				{
					$html = $this->registry->library('helper')->adminCatDropDownList($data, $checked);
				}
			}
			$this->registry->library('template')->page()->addTag('adminCatCheckBoxList', $html);
			$this->registry->library('template')->page()->addTag('categories_available', $categories_available);
//
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'c_fields_created
			LEFT JOIN ' . $this->prefix . 'c_fields_types ON ' . $this->prefix . 'c_fields_created.c_created_type = ' . $this->prefix . 'c_fields_types.c_types_id
			LEFT JOIN ' . $this->prefix . 'c_fields ON c_created_id = c_name_id
			AND c_fields_sys = "' . $this->sys_cms . '"
			WHERE c_fields_created_sys = "' . $this->sys_cms . '"
			AND (c_created_type = 1 OR c_created_type = 2)
			AND c_art_id = "' . $this->seg_2 . '"
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
						$data12New[] = array('c_created_id' => $v['c_created_id'], 'c_created_name' => $v['c_created_name'], 'c_created_url_title' => $v['c_created_url_title'], 'c_created_description' => $v['c_created_description'], 'c_created_type' => $v['c_created_type'], 'c_created_site_section' => $v['c_created_site_section'], 'c_created_obligatory' => $v['c_created_obligatory'], 'c_type_default_value' => $v['c_type_default_value'], 'c_fields_created_sys' => $v['c_fields_created_sys'], 'c_created_encrypted' => $v['c_created_encrypted'], 'c_type_name' => $v['c_type_name'], 'c_fields_id' => $v['c_fields_id'], 'c_name_id' => $v['c_name_id'], 'c_body' => $v['c_body'], 'c_art_id' => $v['c_art_id'], 'c_fields_sys' => $v['c_fields_sys']);
				}


			}
 
// Add empty fields for editing
			$sqlFields = 'SELECT *
			FROM ' . $this->prefix . 'c_fields_created
			LEFT JOIN ' . $this->prefix . 'c_fields_types ON ' . $this->prefix . 'c_fields_created.c_created_type = ' . $this->prefix . 'c_fields_types.c_types_id
			WHERE c_fields_created_sys = "' . $this->sys_cms . '"
			AND (c_created_type = 1 OR c_created_type = 2)
			AND c_created_site_section = "b"';
			$cacheFields = $this->registry->library('db')->cacheQuery($sqlFields);
			if ($this->registry->library('db')->numRowsFromCache($cacheFields) != 0)
			{
				$data12Fields = array();
				$data12NewFields = array();
				$data12Fields = $this->registry->library('db')->rowsFromCache($cacheFields);
				foreach ($data12Fields as $kFields => $vFields)
				{
					$compare = 0;
					foreach ($data12 as $k => $v)
					{
						if ($v['c_created_id'] == $vFields['c_created_id'])
						{
							$compare = 1;
						}
					}
					if($compare == 0)
					{
						$data12NewFields[] = array('c_created_id' => $vFields['c_created_id'], 'c_created_name' => $vFields['c_created_name'], 'c_created_url_title' => $vFields['c_created_url_title'], 'c_created_description' => $vFields['c_created_description'], 'c_created_type' => $vFields['c_created_type'], 'c_created_site_section' => $vFields['c_created_site_section'], 'c_created_obligatory' => $vFields['c_created_obligatory'], 'c_type_default_value' => $vFields['c_type_default_value'], 'c_fields_created_sys' => $vFields['c_fields_created_sys'], 'c_created_encrypted' => $vFields['c_created_encrypted'], 'c_type_name' => $vFields['c_type_name'], 'c_fields_id' => '', 'c_name_id' => '', 'c_body' => '', 'c_art_id' => '', 'c_fields_sys' => '');
					}
				}
			}
// Filled & empty fields
$result = array_merge((array)$data12New, (array)$data12NewFields);
$cache = $this->registry->library('db')->cacheData($result);



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
			$this->registry->library('template')->page()->addTag('stringField3', $stringField3);
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('article'));
// Restore CacheOn & Delete Cache
			$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
			if ($this->registry->setting('settings_cached') == 1)
			{
				$this->registry->library('db')->deleteCache('cache_', true);
			}
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_articles_edit.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function editing_article()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
// php hook: editing_article_beginning_hook
			$resulthook = '';
			$resulthook = $this->registry->library('hook')->call('editing_article_beginning_hook');

// Caching OFF
			$this->registry->library('db')->setCacheOn(0);
			$articleID = $this->registry->library('db')->sanitizeData($_POST['articleID']);
			$sql = 'SELECT *
FROM ' . $this->prefix . 'art_cats
WHERE art_cats_sys = "' . $this->sys_cms . '"
AND ac_art_id = ' . $articleID;
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
			{
				$checked = array();
				$num = $this->registry->library('db')->numRowsFromCache($cache);
				$cats = $this->registry->library('db')->rowsFromCache($cache);
				foreach ($cats as $k => $v)
				{
					$checked[] = $v['ac_cats_id'];
				}
			}
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
					$html = $this->registry->library('helper')->adminCatCheckBoxList($data, $checked);
				}
				else
				{
					$html = $this->registry->library('helper')->adminCatDropDownList($data, $checked);
				}
			}
			$this->registry->library('template')->page()->addTag('adminCatCheckBoxList', $html);
			$this->registry->library('template')->page()->addTag('categories_available', $categories_available);
//
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'c_fields_created
			LEFT JOIN ' . $this->prefix . 'c_fields_types ON ' . $this->prefix . 'c_fields_created.c_created_type = ' . $this->prefix . 'c_fields_types.c_types_id
			LEFT JOIN ' . $this->prefix . 'c_fields ON c_created_id = c_name_id
			AND c_fields_sys = "' . $this->sys_cms . '"
			WHERE c_fields_created_sys = "' . $this->sys_cms . '"
			AND (c_created_type = 1 OR c_created_type = 2)
			AND c_created_site_section = "b"';
			$cache = $this->registry->library('db')->cacheQuery($sql);
			$this->registry->library('template')->page()->addTag('custom_fields_12', array('SQL', $cache));
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
			$this->registry->library('template')->page()->addTag('stringField3', $stringField3);

/// URL check (USED before?)
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'articles
			WHERE articles_sys = "' . $this->sys_cms . '"
			AND 	article_id != ' . $this->registry->library('db')->sanitizeData($_POST['articleID']) . '
			AND url_title = "' . $this->registry->library('db')->sanitizeData($_POST['url_title']) . '"';
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) != 0 && $this->registry->library('db')->sanitizeData($_POST['url_title']) != '')
			{
				$this->registry->library('template')->page()->addTag('article_id', $this->registry->library('db')->sanitizeData($_POST['articleID']));
				$this->registry->library('template')->page()->addTag('error_message', $this->registry->library('lang')->line('url_title_used'));
				$this->registry->library('template')->page()->addTag('art_created', $this->registry->library('db')->sanitizeData($_POST['art_created']));
				$this->registry->library('template')->page()->addTag('title', $this->registry->library('db')->sanitizeData($_POST['title']));
				$this->registry->library('template')->page()->addTag('url_title', $this->registry->library('db')->sanitizeData($_POST['url_title']));
				$this->registry->library('template')->page()->addTag('article', $this->registry->library('db')->sanitizeData($_POST['article']));
				$this->registry->library('template')->page()->addTag('article_extended', $this->registry->library('db')->sanitizeData($_POST['article_extended']));
				$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('new_article'));
				$this->registry->library('template')->page()->addTag('article_visible', $this->registry->library('db')->sanitizeData($_POST['article_visible']));
				$this->registry->library('template')->page()->addTag('pinned', $this->registry->library('db')->sanitizeData($_POST['pinned']));
// Restore CacheOn NOT Delete Cache
				$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
				$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_articles_edit.tpl', 'admin/admin_footer.tpl');
			}
			elseif ($_POST['title'] == '' || $_POST['article'] == '' || $_POST['art_created'] == '')
			{
				$this->registry->library('template')->page()->addTag('article_id', $this->registry->library('db')->sanitizeData($_POST['articleID']));
				$this->registry->library('template')->page()->addTag('error_message', $this->registry->library('lang')->line('insufficient_data'));
				$this->registry->library('template')->page()->addTag('art_created', $this->registry->library('db')->sanitizeData($_POST['art_created']));
				$this->registry->library('template')->page()->addTag('title', $this->registry->library('db')->sanitizeData($_POST['title']));
				$this->registry->library('template')->page()->addTag('url_title', $this->registry->library('db')->sanitizeData($_POST['url_title']));
				$this->registry->library('template')->page()->addTag('article', $this->registry->library('db')->sanitizeData($_POST['article']));
				$this->registry->library('template')->page()->addTag('article_extended', $this->registry->library('db')->sanitizeData($_POST['article_extended']));
				$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('new_article'));
				$this->registry->library('template')->page()->addTag('article_visible', $this->registry->library('db')->sanitizeData($_POST['article_visible']));
				$this->registry->library('template')->page()->addTag('pinned', $this->registry->library('db')->sanitizeData($_POST['pinned']));
// Restore CacheOn NOT Delete Cache
				$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
				$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_articles_edit.tpl', 'admin/admin_footer.tpl');
			}
			elseif ($this->registry->library('helper')->firstCharacterCheck($_POST['url_title']))
			{
				$this->registry->library('template')->page()->addTag('article_id', $this->registry->library('db')->sanitizeData($_POST['articleID']));
				$this->registry->library('template')->page()->addTag('error_message', $this->registry->library('lang')->line('first_character_number'));
				$this->registry->library('template')->page()->addTag('art_created', $this->registry->library('db')->sanitizeData($_POST['art_created']));
				$this->registry->library('template')->page()->addTag('title', $this->registry->library('db')->sanitizeData($_POST['title']));
				$this->registry->library('template')->page()->addTag('url_title', $this->registry->library('db')->sanitizeData($_POST['url_title']));
				$this->registry->library('template')->page()->addTag('article', $this->registry->library('db')->sanitizeData($_POST['article']));
				$this->registry->library('template')->page()->addTag('article_extended', $this->registry->library('db')->sanitizeData($_POST['article_extended']));
				$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('new_article'));
// Restore CacheOn NOT Delete Cache
				$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
				$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_articles_edit.tpl', 'admin/admin_footer.tpl');
			}
			else
			{
				$articleID = $this->registry->library('db')->sanitizeData($_POST['articleID']);
				$data = array();
				$data['article_id'] = $this->registry->library('db')->sanitizeData($_POST['articleID']);
				$data['art_created'] = $this->registry->library('db')->sanitizeData($_POST['art_created']);
				$data['title'] = $this->registry->library('db')->sanitizeData($_POST['title']);
				$data['url_title'] = $this->registry->library('db')->sanitizeData($_POST['url_title']);
				$data['article'] = $this->registry->library('db')->sanitizeData($_POST['article']);
				$data['article_extended'] = $this->registry->library('db')->sanitizeData($_POST['article_extended']);
				$data['art_updated'] = date("Y-m-d H:i:s", time());
				$data['article_visible'] = $this->registry->library('db')->sanitizeData($_POST['article_visible']);
				$data['pinned'] = $this->registry->library('db')->sanitizeData($_POST['pinned']);
				if ($this->registry->setting('settings_one_cat') == 1)
				{
					$data['categories'] = $this->registry->library('db')->sanitizeData($_POST['catOne']);
				}
				$this->registry->library('db')->updateRecordsSys('articles', $data, 'article_id=' . $data['article_id']);
// To delete $articleID Categories
				$sql = sprintf("DELETE
				FROM `" . $this->prefix . "art_cats`
				WHERE art_cats_sys = \"" . $this->sys_cms . "\"
				AND `ac_art_id` = %u", $articleID);
				$cache = $this->registry->library('db')->cacheQuery($sql);
// To add $articleID Categories
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
					$data[$i]['ac_art_id'] = $articleID;
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
// OR to Add or Update content
				$sql = 'SELECT *, c_type_name
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
// To add or update ?
						$sql = 'SELECT *
						FROM ' . $this->prefix . 'c_fields
						WHERE c_fields_sys = "' . $this->sys_cms . '"
						AND c_name_id = ' . $v['c_created_id'] . '
						AND c_art_id = ' . $this->registry->library('db')->sanitizeData($_POST['articleID']);
						$this->registry->library('db')->execute($sql);
						if ($this->registry->library('db')->numRows() != 0)
						{
// update
							if ($_POST['custom_field_' . $v['c_created_id']] != '')
							{
// IS record; to UPDATE
								$arr[$k]['c_name_id'] = $v['c_created_id'];
								if ($v['c_created_encrypted'] == 'y')
								{
									$arr[$k]['c_body'] = $this->registry->library('crypter')->encrypt($_POST['custom_field_' . $v['c_created_id']]);
								}
								else
								{
									$arr[$k]['c_body'] = $_POST['custom_field_' . $v['c_created_id']];
								}
								$this->registry->library('db')->updateRecordsSys('c_fields', $arr[$k], 'c_art_id=' . $this->registry->library('db')->sanitizeData($_POST['articleID']) . ' AND c_name_id = ' . $v['c_created_id']);
							}
// or Delete Record if ''
							else
							{
// $sql = sprintf("DELETE FROM `" . $this->prefix . "c_fields` WHERE `c_name_id` = %u", $v['c_created_id']);
// $cache = $this->registry->library('db')->cacheQuery($sql);
								$this->registry->library('db')->deleteRecordsSys('c_fields', 'c_name_id=' . $v['c_created_id'], '1');
							}
						}
						else
// insert
						{
							if ($_POST['custom_field_' . $v['c_created_id']] != '')
							{
								$arr[$k]['c_name_id'] = $v['c_created_id'];
								if ($v['c_created_encrypted'] == 'y')
								{
									$arr[$k]['c_body'] = $this->registry->library('crypter')->encrypt($_POST['custom_field_' . $v['c_created_id']]);
								}
								else
								{
									$arr[$k]['c_body'] = $_POST['custom_field_' . $v['c_created_id']];
								}
								$arr[$k]['c_art_id'] = $this->registry->library('db')->sanitizeData($_POST['articleID']);
								$this->registry->library('db')->insertRecordsSys('c_fields', $arr[$k]);
							}
						}
					}
// Custom Fields End
				}
// Restore CacheOn & Delete Cache
				$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
				if ($this->registry->setting('settings_cached') == 1)
				{
					$this->registry->library('db')->deleteCache('cache_', true);
				}
				$this->registry->redirectUser('admin/edit_article/' . $_POST['articleID'], $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
			}
// Restore CacheOn NOT Delete Cache
			$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function delete_article()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
// Caching OFF
			$this->registry->library('db')->setCacheOn(0);
			$sql = sprintf("DELETE
			FROM `" . $this->prefix . "articles`
			WHERE articles_sys = \"" . $this->sys_cms . "\"
			AND `article_id` = %u LIMIT 1", $this->seg_2);
			$cache = $this->registry->library('db')->cacheQuery($sql);
			$sql = sprintf("DELETE
			FROM `" . $this->prefix . "art_cats`
			WHERE art_cats_sys = \"" . $this->sys_cms . "\"
			AND `ac_art_id` = %u", $this->seg_2);
			$cache = $this->registry->library('db')->cacheQuery($sql);
			$sql = sprintf("DELETE
			FROM `" . $this->prefix . "c_fields`
			WHERE c_fields_sys = \"" . $this->sys_cms . "\"
			AND `c_art_id` = %u", $this->seg_2);
			$cache = $this->registry->library('db')->cacheQuery($sql);

// php hook: delete_article_after_hook
			$this->registry->library('hook')->call('delete_article_after_hook');

// Restore CacheOn & Delete Cache
			$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
			if ($this->registry->setting('settings_cached') == 1)
			{
				$this->registry->library('db')->deleteCache('cache_', true);
			}
			$this->registry->redirectUser('admin/articles_list', $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function categories_list()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
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
				$html = $this->registry->library('helper')->adminCatList($data);
			}
			$this->registry->library('template')->page()->addTag('admin_categories_list', $html);
			$this->registry->library('template')->page()->addTag('categories_available', $categories_available);
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('categories_text'));
			$cache = $this->registry->library('db')->cacheData($categories);
			$this->registry->library('template')->page()->addTag('categories', array('DATA', $cache));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_categories_list.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function create_category()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		$this->registry->library('template')->page()->addTag('error_message', '');
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'categories
			WHERE categories_sys = "' . $this->sys_cms . '"
			ORDER BY category_order ASC';
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
			{
				$data = $this->registry->library('db')->rowsFromCache($cache);
				$html = $this->registry->library('helper')->adminCatList($data);
			}
			$this->registry->library('template')->page()->addTag('admin_categories_list', $html);
			if ($this->seg_2 == '')
			{
				$parentID = 0;
			}
			else
			{
				$parentID = $this->seg_2;
			}
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'categories
			WHERE categories_sys = "' . $this->sys_cms . '"
			AND category_id = ' . $parentID;
			$this->registry->library('db')->execute($sql);
			$this->registry->library('template')->page()->addTag('parent_category_name', '-');
			if ($this->registry->library('db')->numRows() != 0)
			{
				$data = $this->registry->library('db')->getRows();
				$this->registry->library('template')->page()->addTag('parent_category_name', $data['category_name']);
			}
			$this->registry->library('template')->page()->addTag('parent_id', $parentID);
			$this->registry->library('template')->page()->addTag('category_name', '');
			$this->registry->library('template')->page()->addTag('category_url_name', '');
			$this->registry->library('template')->page()->addTag('category_description', '');
			$this->registry->library('template')->page()->addTag('category_image_name', '');
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('new_category'));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_categories_create.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function creating_category()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			if ($_POST['parent_id'] == '' || $_POST['category_name'] == '' || $_POST['category_url_name'] == '')
			{
				$this->registry->library('template')->page()->addTag('error_message', $this->registry->library('lang')->line('insufficient_data'));
				$this->registry->library('template')->page()->addTag('parent_id', $_POST['parent_id']);
				$this->registry->library('template')->page()->addTag('category_name', $_POST['category_name']);
				$this->registry->library('template')->page()->addTag('category_url_name', $_POST['category_url_name']);
				$this->registry->library('template')->page()->addTag('category_description', $_POST['category_description']);
				$this->registry->library('template')->page()->addTag('category_image_name', $_POST['category_image_name']);
				$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('new_category'));
				$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_categories_create.tpl', 'admin/admin_footer.tpl');
			}
			else
			{
// Caching OFF
				$this->registry->library('db')->setCacheOn(0);
				$data = array();
				$data['parent_id'] = $this->registry->library('db')->sanitizeData($_POST['parent_id']);
				$data['category_name'] = $this->registry->library('db')->sanitizeData($_POST['category_name']);
				$data['category_url_name'] = $this->registry->library('db')->sanitizeData($_POST['category_url_name']);
				$data['category_description'] = $this->registry->library('db')->sanitizeData($_POST['category_description']);
				$data['category_image_name'] = $this->registry->library('db')->sanitizeData($_POST['category_image_name']);
				$this->registry->library('db')->insertRecordsSys('categories', $data);
				$this->siteReorder();
// Restore CacheOn & Delete Cache
				$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
				if ($this->registry->setting('settings_cached') == 1)
				{
					$this->registry->library('db')->deleteCache('cache_', true);
				}
				$this->registry->redirectUser('admin/categories_list', $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
			}
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function edit_category()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$this->registry->library('template')->page()->addTag('error_message', '');
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'categories
			WHERE categories_sys = "' . $this->sys_cms . '"
			AND category_id = ' . $this->seg_2;
			$this->registry->library('db')->execute($sql);
			if ($this->registry->library('db')->numRows() != 0)
			{
				$data = $this->registry->library('db')->getRows();
				$this->registry->library('template')->page()->addTag('category_id', $data['category_id']);
				$this->registry->library('template')->page()->addTag('parent_id', $data['parent_id']);
				$this->registry->library('template')->page()->addTag('category_name', $data['category_name']);
				$this->registry->library('template')->page()->addTag('category_url_name', $data['category_url_name']);
				$this->registry->library('template')->page()->addTag('category_description', $data['category_description']);
				$this->registry->library('template')->page()->addTag('category_image_name', $data['category_image_name']);
			}
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('category'));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_categories_edit.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function editing_category()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			if ($_POST['parent_id'] == '' || $_POST['category_name'] == '' || $_POST['category_url_name'] == '')
			{
				$this->registry->library('template')->page()->addTag('category_id', $this->registry->library('db')->sanitizeData($_POST['categoryID']));
				$this->registry->library('template')->page()->addTag('error_message', $this->registry->library('lang')->line('insufficient_data'));
				$this->registry->library('template')->page()->addTag('parent_id', $this->registry->library('db')->sanitizeData($_POST['parent_id']));
				$this->registry->library('template')->page()->addTag('category_name', $this->registry->library('db')->sanitizeData($_POST['category_name']));
				$this->registry->library('template')->page()->addTag('category_url_name', $this->registry->library('db')->sanitizeData($_POST['category_url_name']));
				$this->registry->library('template')->page()->addTag('category_description', $this->registry->library('db')->sanitizeData($_POST['category_description']));
				$this->registry->library('template')->page()->addTag('category_image_name', $this->registry->library('db')->sanitizeData($_POST['category_image_name']));
				$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('new_category'));
				$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_categories_edit.tpl', 'admin/admin_footer.tpl');
			}
			else
			{
				$categoryID = $this->registry->library('db')->sanitizeData($_POST['categoryID']);
				$data = array();
				$data['parent_id'] = $this->registry->library('db')->sanitizeData($_POST['parent_id']);
				$data['category_name'] = $this->registry->library('db')->sanitizeData($_POST['category_name']);
				$data['category_url_name'] = $this->registry->library('db')->sanitizeData($_POST['category_url_name']);
				$data['category_description'] = $this->registry->library('db')->sanitizeData($_POST['category_description']);
				$data['category_image_name'] = $this->registry->library('db')->sanitizeData($_POST['category_image_name']);
				$this->registry->library('db')->updateRecordsSys('categories', $data, 'category_id = ' . $categoryID);
				$this->registry->redirectUser('admin/edit_category/' . $_POST['categoryID'], $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
			}
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function delete_category()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
// Caching OFF
			$this->registry->library('db')->setCacheOn(0);
// Are there children categories?
			$sql = "SELECT *
				FROM " . $this->prefix . "categories
				WHERE categories_sys = '" . $this->sys_cms . "'
				AND parent_id = '" . $this->seg_2 . "'";
			$this->registry->library('db')->execute($sql);
			if ($this->registry->library('db')->numRows() != 0)
			{
				$this->registry->redirectUser('admin/categories_list', $this->registry->library('lang')->line('is_children_category'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
			}
			else
			{
				if ($this->registry->setting('settings_one_cat') == 0)
				{
					$sql = sprintf("DELETE
						FROM `" . $this->prefix . "art_cats`
						WHERE art_cats_sys = \"" . $this->sys_cms . "\"
						AND `ac_cats_id` = %u LIMIT 1", $this->seg_2);
					$cache = $this->registry->library('db')->cacheQuery($sql);
				}
				else
				{
					$sql = sprintf("DELETE
						FROM `" . $this->prefix . "categories`
						WHERE categories_sys = \"" . $this->sys_cms . "\"
						AND `category_id` = %u LIMIT 1", $this->seg_2);
					$cache = $this->registry->library('db')->cacheQuery($sql);
				}
			}
			$this->siteReorder();
// Restore CacheOn & Delete Cache
			$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
			if ($this->registry->setting('settings_cached') == 1)
			{
				$this->registry->library('db')->deleteCache('cache_', true);
			}
			$this->registry->redirectUser('admin/categories_list', $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function siteReorder()
	{
// category re-ordering
		$reorder = array();
		$reordering = array();
		$i = 0;
		$sql = 'SELECT *
			FROM ' . $this->prefix . 'categories
			WHERE categories_sys = "' . $this->sys_cms . '"
			ORDER BY category_order ASC';
		$old = $this->registry->library('db')->cacheQuery($sql);
		if ($this->registry->library('db')->numRowsFromCache($old) != 0)
		{
			$reorder = $this->registry->library('db')->rowsFromCache($old);
			foreach ($reorder as $k => $v)
			{
				$reordering['category_order'] = $i * 2;
				$this->registry->library('db')->updateRecords('categories', $reordering, 'category_id=' . $v['category_id']);
				$i = $i + 1;
			}
		}
	}

	private function forumReorder()
	{
// category re-ordering
		$reorder = array();
		$reordering = array();
		$i = 0;
		$sql = 'SELECT *
			FROM ' . $this->prefix . 'forums
			WHERE forums_sys = "' . $this->sys_cms . '"
			ORDER BY f_order ASC';
		$old = $this->registry->library('db')->cacheQuery($sql);
		if ($this->registry->library('db')->numRowsFromCache($old) != 0)
		{
			$reorder = $this->registry->library('db')->rowsFromCache($old);
			foreach ($reorder as $k => $v)
			{
				$reordering['f_order'] = $i * 2;
				$this->registry->library('db')->updateRecordsSys('forums', $reordering, 'f_forum_id=' . $v['f_forum_id']);
				$i = $i + 1;
			}
		}
	}

	private function category_up()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
// Caching OFF
			$this->registry->library('db')->setCacheOn(0);
// category movement
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'categories
			WHERE category_id = ' . $this->seg_2;
			$this->registry->library('db')->execute($sql);
			if ($this->registry->library('db')->numRows() != 0)
			{
				$oneCat = array();
				$oneCat = $this->registry->library('db')->getRows();
				$newData = array();
				$newData['category_order'] = $oneCat['category_order'] - 3;
				$this->registry->library('db')->updateRecordsSys('categories', $newData, 'category_id=' . $this->seg_2);
			}
// category re-ordering
			$this->siteReorder();
// category list
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
				$html = $this->registry->library('helper')->adminCatList($data);
			}
			$this->registry->library('template')->page()->addTag('admin_categories_list', $html);
			$this->registry->library('template')->page()->addTag('categories_available', $categories_available);
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('categories_text'));
			$cache = $this->registry->library('db')->cacheData($categories);
			$this->registry->library('template')->page()->addTag('categories', array('DATA', $cache));
// Restore CacheOn & Delete Cache
			$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
			if ($this->registry->setting('settings_cached') == 1)
			{
				$this->registry->library('db')->deleteCache('cache_', true);
			}
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_categories_list.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function category_down()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
// category movement
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'categories
			WHERE category_id = ' . $this->seg_2;
			$this->registry->library('db')->execute($sql);
			if ($this->registry->library('db')->numRows() != 0)
			{
				$oneCat = array();
				$oneCat = $this->registry->library('db')->getRows();
				$newData = array();
				$newData['category_order'] = $oneCat['category_order'] + 3;
				$this->registry->library('db')->updateRecordsSys('categories', $newData, 'category_id=' . $this->seg_2);
			}
// category re-ordering
			$this->siteReorder();
// category list
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
				$html = $this->registry->library('helper')->adminCatList($data);
			}
			$this->registry->library('template')->page()->addTag('admin_categories_list', $html);
			$this->registry->library('template')->page()->addTag('categories_available', $categories_available);
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('categories_text'));
			$cache = $this->registry->library('db')->cacheData($categories);
			$this->registry->library('template')->page()->addTag('categories', array('DATA', $cache));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_categories_list.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function forum_category_up()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
// forum cat movement
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'forums
			WHERE f_forum_id = ' . $this->seg_2;
			$this->registry->library('db')->execute($sql);
			if ($this->registry->library('db')->numRows() != 0)
			{
				$oneCat = array();
				$oneCat = $this->registry->library('db')->getRows();
				$newData = array();
				$newData['f_order'] = $oneCat['f_order'] - 3;
				$this->registry->library('db')->updateRecordsSys('forums', $newData, 'f_forum_id=' . $this->seg_2);
			}
// forum cat re-ordering
			$this->forumReorder();
// forumm cat list
			$forums_available = '';
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'forums
			WHERE forums_sys = "' . $this->sys_cms . '"
			AND f_level = 0
			ORDER BY f_order ASC';
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
			{
				$forums_available = 'y';
				$forums = array();
				$i = 0;
				$num = $this->registry->library('db')->numRowsFromCache($cache);
				$data = $this->registry->library('db')->rowsFromCache($cache);
				while ($i < $num)
				{
					foreach ($data as $k => $v)
					{
						$forums[$i]['forum_id'] = $v['f_forum_id'];
						$forums[$i]['forum_category'] = $v['f_name'];
						$forums[$i]['forum_category_description'] = $v['f_description'];
						$i = $i + 1;
					}
				}
			}
			$this->registry->library('template')->page()->addTag('forums_available', $forums_available);
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('forum_categories_text'));
			$cache = $this->registry->library('db')->cacheData($forums);
			$this->registry->library('template')->page()->addTag('forums', array('DATA', $cache));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_forum_category_list.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function forum_category_down()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
// forum cat movement
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'forums
			WHERE f_forum_id = ' . $this->seg_2;
			$this->registry->library('db')->execute($sql);
			if ($this->registry->library('db')->numRows() != 0)
			{
				$oneCat = array();
				$oneCat = $this->registry->library('db')->getRows();
				$newData = array();
				$newData['f_order'] = $oneCat['f_order'] + 3;
				$this->registry->library('db')->updateRecordsSys('forums', $newData, 'f_forum_id=' . $this->seg_2);
			}
// forum cat re-ordering
			$this->forumReorder();
// forumm cat list
			$forums_available = '';
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'forums
			WHERE forums_sys = "' . $this->sys_cms . '"
			AND f_level = 0
			ORDER BY f_order ASC';
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
			{
				$forums_available = 'y';
				$forums = array();
				$i = 0;
				$num = $this->registry->library('db')->numRowsFromCache($cache);
				$data = $this->registry->library('db')->rowsFromCache($cache);
				while ($i < $num)
				{
					foreach ($data as $k => $v)
					{
						$forums[$i]['forum_id'] = $v['f_forum_id'];
						$forums[$i]['forum_category'] = $v['f_name'];
						$forums[$i]['forum_category_description'] = $v['f_description'];
						$i = $i + 1;
					}
				}
			}
			$this->registry->library('template')->page()->addTag('forums_available', $forums_available);
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('forum_categories_text'));
			$cache = $this->registry->library('db')->cacheData($forums);
			$this->registry->library('template')->page()->addTag('forums', array('DATA', $cache));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_forum_category_list.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function forum_up()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
// forum movement
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'forums
			WHERE f_forum_id = ' . $this->seg_2;
			$this->registry->library('db')->execute($sql);
			if ($this->registry->library('db')->numRows() != 0)
			{
				$oneCat = array();
				$oneCat = $this->registry->library('db')->getRows();
				$newData = array();
				$newData['f_order'] = $oneCat['f_order'] - 3;
				$this->registry->library('db')->updateRecordsSys('forums', $newData, 'f_forum_id=' . $this->seg_2);
			}
// forum re-ordering
			$this->forumReorder();
// forumm list
			$forums_available = '';
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'forums
			WHERE forums_sys = "' . $this->sys_cms . '"
			AND f_level = 1
			ORDER BY f_order ASC';
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
			{
				$forums_available = 'y';
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
						$i = $i + 1;
					}
				}
			}
			$this->forumReorder();
			$this->registry->library('template')->page()->addTag('forums_available', $forums_available);
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('forums_text'));
			$cache = $this->registry->library('db')->cacheData($forums);
			$this->registry->library('template')->page()->addTag('forums', array('DATA', $cache));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_forums_list.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function forum_down()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
// forum movement
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'forums
			WHERE f_forum_id = ' . $this->seg_2;
			$this->registry->library('db')->execute($sql);
			if ($this->registry->library('db')->numRows() != 0)
			{
				$oneCat = array();
				$oneCat = $this->registry->library('db')->getRows();
				$newData = array();
				$newData['f_order'] = $oneCat['f_order'] + 3;
				$this->registry->library('db')->updateRecordsSys('forums', $newData, 'f_forum_id=' . $this->seg_2);
			}
// forum re-ordering
			$this->forumReorder();
// forumm list
			$forums_available = '';
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'forums
			WHERE forums_sys = "' . $this->sys_cms . '"
			AND f_level = 1
			ORDER BY f_order ASC';
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
			{
				$forums_available = 'y';
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
						$i = $i + 1;
					}
				}
			}
			$this->forumReorder();
			$this->registry->library('template')->page()->addTag('forums_available', $forums_available);
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('forums_text'));
			$cache = $this->registry->library('db')->cacheData($forums);
			$this->registry->library('template')->page()->addTag('forums', array('DATA', $cache));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_forums_list.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function comments_list()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true || $this->registry->library('authenticate')->hasPermission('limited_admin') == true)
		{
			$pagination = $this->registry->library('paginate')->createLinksSys('comments', $this->registry->setting('settings_comments_per_page'), 2, 'admin/comments_page');
			$this->registry->library('template')->page()->addTag('pagination', $pagination);
			$current_page = 1;
			$rows_per_page = $this->registry->setting('settings_comments_per_page');
			$offset = ($current_page - 1) * $rows_per_page;
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'comments
			LEFT JOIN ' . $this->prefix . 'users ON ' . $this->prefix . 'users.users_id = ' . $this->prefix . 'comments.user_id
			WHERE comments_sys = "' . $this->sys_cms . '"
			ORDER BY comment_id DESC LIMIT ' . $offset . ',' . $rows_per_page;
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
			{
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
						$comments[$i]['author_id'] = $v['user_id'];
						$comments[$i]['author'] = $v['author'];
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
			$this->registry->library('template')->page()->addTag('approved_text', $this->registry->library('lang')->line('approved'));
			$this->registry->library('template')->page()->addTag('visible_text', $this->registry->library('lang')->line('visible'));
			$this->registry->library('template')->page()->addTag('edit', $this->registry->library('lang')->line('edit'));
			$this->registry->library('template')->page()->addTag('view', $this->registry->library('lang')->line('view'));
			$this->registry->library('template')->page()->addTag('delete', $this->registry->library('lang')->line('delete'));
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('comments_text'));
			$cache = $this->registry->library('db')->cacheData($comments);
			$this->registry->library('template')->page()->addTag('comments', array('DATA', $cache));
			$pagination = $this->registry->library('paginate')->createLinksSys('comments', $this->registry->setting('settings_comments_per_page'), 3, 'admin/comments_page');
			$this->registry->library('template')->page()->addTag('pagination', $pagination);
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_comments_list.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function comments_page()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$pagination = $this->registry->library('paginate')->createLinksSys('comments', $this->registry->setting('settings_comments_per_page'), 2, 'admin/comments_page');
			$this->registry->library('template')->page()->addTag('pagination', $pagination);
			$current_page = $this->seg_2;
			$rows_per_page = $this->registry->setting('settings_comments_per_page');
			$offset = ($current_page - 1) * $rows_per_page;
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'comments
			LEFT JOIN ' . $this->prefix . 'users ON ' . $this->prefix . 'users.users_id = ' . $this->prefix . 'articles.author_id
			WHERE comments_sys = "' . $this->sys_cms . '"
			ORDER BY comment_id DESC
			LIMIT ' . $offset . ',' . $rows_per_page;
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
			{
				$comments = array();
				$i = 0;
				$num = $this->registry->library('db')->numRowsFromCache($cache);
				$data = $this->registry->library('db')->rowsFromCache($cache);
				while ($i < $num)
				{
					foreach ($data as $k => $v)
					{
						$comments[$i]['comment_id'] = $v['comment_id'];
						$comments[$i]['author_id'] = $v['author_id'];
						$comments[$i]['title'] = $v['title'];
						$comments[$i]['url_title'] = $v['url_title'];
						$comments[$i]['comment'] = $v['comment'];
						$comments[$i]['article_extended'] = $v['article_extended'];
						$comments[$i]['create_date'] = $this->registry->library('helper')->convertDate($v['art_created']);
						$comments[$i]['create_time'] = $this->registry->library('helper')->convertTime($v['art_created']);
						$comments[$i]['author_name'] = $v['username'];
						$i = $i + 1;
					}
				}
			}
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('comments_text'));
			$cache = $this->registry->library('db')->cacheData($comments);
			$this->registry->library('template')->page()->addTag('comments', array('DATA', $cache));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_comments_list.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function edit_comment()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$this->registry->library('template')->page()->addTag('error_message', '');
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'comments
			LEFT JOIN ' . $this->prefix . 'users ON ' . $this->prefix . 'users.users_id = ' . $this->prefix . 'comments.user_id
			LEFT JOIN ' . $this->prefix . 'articles ON com_article_id = article_id
			AND articles_sys = "' . $this->sys_cms . '"
			WHERE comments_sys = "' . $this->sys_cms . '"
			AND comment_id = ' . $this->seg_2;
			$this->registry->library('db')->execute($sql);
			if ($this->registry->library('db')->numRows() != 0)
			{
				$data = $this->registry->library('db')->getRows();
				$this->registry->library('template')->page()->addTag('comment_id', $data['comment_id']);
				$this->registry->library('template')->page()->addTag('article_id', $data['com_article_id']);
				$this->registry->library('template')->page()->addTag('more', $data['url_title']);
				$this->registry->library('template')->page()->addTag('author_id', $data['user_id']);
				$this->registry->library('template')->page()->addTag('author', $data['author']);
				$this->registry->library('template')->page()->addTag('author_email', $data['author_email']);
				$this->registry->library('template')->page()->addTag('author_website', $data['author_website']);
				$this->registry->library('template')->page()->addTag('author_ip', $data['author_ip']);
				$this->registry->library('template')->page()->addTag('body', $data['body']);
				$this->registry->library('template')->page()->addTag('updated', $data['updated']);
				$this->registry->library('template')->page()->addTag('approved', $data['comment_approved']);
				$this->registry->library('template')->page()->addTag('visible', $data['comment_visible']);
				$this->registry->library('template')->page()->addTag('create_date', $this->registry->library('helper')->convertDate($data['created']));
				$this->registry->library('template')->page()->addTag('create_time', $this->registry->library('helper')->convertTime($data['created']));
				$this->registry->library('template')->page()->addTag('author_name', $data['username']);
				if ($v['comment_approved'] == 'y')
				{
					$this->registry->library('template')->page()->addTag('approved', $this->registry->library('lang')->line('yes'));
				}
				else
				{
					$this->registry->library('template')->page()->addTag('approved', $this->registry->library('lang')->line('no'));
				}
				if ($v['comment_visible'] == 'y')
				{
					$this->registry->library('template')->page()->addTag('visible', $this->registry->library('lang')->line('yes'));
				}
				else
				{
					$this->registry->library('template')->page()->addTag('visible', $this->registry->library('lang')->line('no'));
				}
			}
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('comment_text'));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_comments_edit.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function editing_comment()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$commentID = $this->registry->library('db')->sanitizeData($_POST['commentID']);
			$data = array();
			$data['body'] = $this->registry->library('db')->sanitizeData($_POST['comment']);
			$this->registry->library('db')->updateRecordsSys('comments', $data, 'comment_id=' . $commentID);
			$this->registry->redirectUser('admin/edit_comment/' . $_POST['commentID'], $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function delete_comment()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
// Caching OFF
			$this->registry->library('db')->setCacheOn(0);
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'comments
			LEFT JOIN ' . $this->prefix . 'articles ON com_article_id = article_id
			AND articles_sys = "' . $this->sys_cms . '"
			WHERE comments_sys = "' . $this->sys_cms . '"
			AND comment_id = ' . $this->seg_2;
			$this->registry->library('db')->execute($sql);
			if ($this->registry->library('db')->numRows() != 0)
			{
				$data = $this->registry->library('db')->getRows();
// id or url?
				if ($data['url_title'] == '')
				{
					$more = $data['article_id'];
				}
				else
				{
					$more = $data['url_title'];
				}
			}
			$sql = sprintf("DELETE
			FROM `" . $this->prefix . "comments`
			WHERE comments_sys = \"" . $this->sys_cms . "\"
			AND `comment_id` = %u LIMIT 1", $this->seg_2);
			$cache = $this->registry->library('db')->cacheQuery($sql);
// Caching OFF
			$this->registry->library('db')->setCacheOn(0);
			$this->registry->redirectUser($this->registry->setting('settings_site0') . '/more/' . $more, $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function settings()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$this->registry->library('template')->page()->addTag('settings_sys_name_text', $this->registry->library('lang')->line('settings_sys_name_text'));
			$this->registry->library('template')->page()->addTag('settings_metakeywords_text', $this->registry->library('lang')->line('settings_metakeywords_text'));
			$this->registry->library('template')->page()->addTag('settings_metadescription_text', $this->registry->library('lang')->line('settings_metadescription_text'));
			$this->registry->library('template')->page()->addTag('settings_charset_text', $this->registry->library('lang')->line('settings_charset_text'));
			$this->registry->library('template')->page()->addTag('settings_lang_text', $this->registry->library('lang')->line('settings_lang_text'));
			$this->registry->library('template')->page()->addTag('settings_cached_text', $this->registry->library('lang')->line('settings_cached_text'));
			$this->registry->library('template')->page()->addTag('settings_rows_per_page_text', $this->registry->library('lang')->line('settings_rows_per_page_text'));
			$this->registry->library('template')->page()->addTag('settings_shop_rows_per_page_text', $this->registry->library('lang')->line('settings_shop_rows_per_page_text'));
			$this->registry->library('template')->page()->addTag('settings_users_per_page_text', $this->registry->library('lang')->line('settings_users_per_page_text'));
			$this->registry->library('template')->page()->addTag('settings_nested_categories_text', $this->registry->library('lang')->line('settings_nested_categories_text'));
			$this->registry->library('template')->page()->addTag('settings_shop_nested_categories_text', $this->registry->library('lang')->line('settings_shop_nested_categories_text'));
			$this->registry->library('template')->page()->addTag('settings_comments_per_page_text', $this->registry->library('lang')->line('settings_comments_per_page_text'));
			$this->registry->library('template')->page()->addTag('settings_enable_registration_text', $this->registry->library('lang')->line('settings_enable_registration_text'));
			$this->registry->library('template')->page()->addTag('settings_owner_name_text', $this->registry->library('lang')->line('settings_owner_name_text'));
			$this->registry->library('template')->page()->addTag('settings_admin_email_text', $this->registry->library('lang')->line('settings_admin_email_text'));
			$this->registry->library('template')->page()->addTag('settings_seller_email_text', $this->registry->library('lang')->line('settings_seller_email_text'));
			$this->registry->library('template')->page()->addTag('settings_forum_topics_per_page_text', $this->registry->library('lang')->line('settings_forum_topics_per_page_text'));
			$this->registry->library('template')->page()->addTag('settings_forum_posts_per_page_text', $this->registry->library('lang')->line('settings_forum_posts_per_page_text'));
			$this->registry->library('template')->page()->addTag('settings_cron_text', $this->registry->library('lang')->line('settings_cron_text'));
			$this->registry->library('template')->page()->addTag('settings_notes_text', $this->registry->library('lang')->line('settings_notes_text'));
			$this->registry->library('template')->page()->addTag('settings_email_registration_text', $this->registry->library('lang')->line('settings_email_registration_text'));
			$this->registry->library('template')->page()->addTag('settings_comments_tree_text', $this->registry->library('lang')->line('settings_comments_tree_text'));
			$this->registry->library('template')->page()->addTag('settings_cron_enabled_text', $this->registry->library('lang')->line('settings_cron_enabled_text'));
			$this->registry->library('template')->page()->addTag('settings_cron_period_text', $this->registry->library('lang')->line('settings_cron_period_text'));
			$this->registry->library('template')->page()->addTag('settings_cms_enabled_text', $this->registry->library('lang')->line('settings_cms_enabled_text'));
			$this->registry->library('template')->page()->addTag('settings_cms_message_text', $this->registry->library('lang')->line('settings_cms_message_text'));
			$this->registry->library('template')->page()->addTag('settings_dl_period_text', $this->registry->library('lang')->line('settings_dl_period_text'));
			$this->registry->library('template')->page()->addTag('settings_banned_emails_text', $this->registry->library('lang')->line('settings_banned_emails_text'));
			$this->registry->library('template')->page()->addTag('settings_ban_masks_text', $this->registry->library('lang')->line('settings_ban_masks_text'));
			$this->registry->library('template')->page()->addTag('settings_cms_title_text', $this->registry->library('lang')->line('settings_cms_title_text'));
			$this->registry->library('template')->page()->addTag('settings_cms_description_text', $this->registry->library('lang')->line('settings_cms_description_text'));
			$this->registry->library('template')->page()->addTag('settings_site_code', $this->registry->library('lang')->line('settings_site_code_text'));
			$this->registry->library('template')->page()->addTag('settings_comments_allowed_text', $this->registry->library('lang')->line('settings_comments_allowed_text'));
			$this->registry->library('template')->page()->addTag('settings_guests_allowed_text', $this->registry->library('lang')->line('settings_guests_allowed_text'));
			$this->registry->library('template')->page()->addTag('settings_guests_comments_allowed_text', $this->registry->library('lang')->line('settings_guests_comments_allowed_text'));
			$this->registry->library('template')->page()->addTag('settings_settings_start_seg_1_text', $this->registry->library('lang')->line('settings_settings_start_seg_1_text'));
			$this->registry->library('template')->page()->addTag('settings_one_cat_text', $this->registry->library('lang')->line('settings_one_cat_text'));
			$this->registry->library('template')->page()->addTag('pp_available_text', $this->registry->library('lang')->line('pp_available_text'));
			$this->registry->library('template')->page()->addTag('cart_available_text', $this->registry->library('lang')->line('cart_available_text'));
			$this->registry->library('template')->page()->addTag('editor_text', $this->registry->library('lang')->line('editor_text'));
			$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->library('lang')->line('settings'));
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('settings'));
			$sql = "SELECT *
			FROM " . $this->prefix . "settings
			WHERE settings_sys = '" . $this->registry->setting('settings_sys') . "'";
			$cache = $this->registry->library('db')->cacheQuery($sql);
			$this->registry->library('template')->page()->addTag('settings', array('SQL', $cache));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_settings.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function updating_settings()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
// Caching OFF
			$this->registry->library('db')->setCacheOn(0);
			$data = array();
			foreach ($_POST as $k => $v)
			{
				$data[$k] = $this->registry->library('db')->sanitizeData($v);
			}
			$this->registry->library('db')->updateRecordsSys('settings', $data, 'settings_id = ' . $data['settings_id']);
// Restore CacheOn & Delete Cache
			$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
			$this->registry->library('db')->deleteCache('cache_', true);
			$this->registry->redirectUser('admin/settings', $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function modules()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->library('lang')->line('modules_text'));
			$allModulesArray = array();
			$sql = 'SELECT mod_file_name FROM ' . $this->prefix . 'modules';
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
			{
				$allModulesArray = array();
				$data = $this->registry->library('db')->rowsFromCache($cache);
				foreach ($data as $k => $v)
				{
					$allModulesArray[] = $v['mod_file_name'];
				}
			}
			$d = opendir(APPPATH . 'modules') or die($php_errormsg);
			$i = 0;
			$modArray = array();
			while (false !== ($f = readdir($d)))
			{
				if (!is_dir($f))
				{
					$modArray[$i]['mod_file_name'] = $f;
					if (in_array($f, $allModulesArray))
					{
						$modArray[$i]['mod_installed'] = 1;
					}
					else
					{
						$modArray[$i]['mod_installed'] = 0;
					}
				}
				$i = $i + 1;
				sort($modArray);
				$cache = $this->registry->library('db')->cacheData($modArray);
				$this->registry->library('template')->page()->addTag('modules', array('DATA', $cache));
			}
			closedir($d);
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('modules_text'));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_modules_list.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function extensions()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->library('lang')->line('extensions'));
			$allExtensionsArray = array();
			$sql = 'SELECT ext_file_name FROM ' . $this->prefix . 'extensions';
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
			{
				$allExtensionsArray = array();
				$data = $this->registry->library('db')->rowsFromCache($cache);
				foreach ($data as $k => $v)
				{
					$allExtensionsArray[] = $v['ext_file_name'];
				}
			}
			$d = opendir(APPPATH . 'extensions') or die($php_errormsg);
			$i = 0;
			$extArray = array();
			while (false !== ($f = readdir($d)))
			{
				if (!is_dir($f))
				{
					$extArray[$i]['ext_file_name'] = $f;
					if (in_array($f, $allExtensionsArray))
					{
						$extArray[$i]['ext_installed'] = 1;
					}
					else
					{
						$extArray[$i]['ext_installed'] = 0;
					}
				}
				sort($extArray);
				$i = $i + 1;
				$cache = $this->registry->library('db')->cacheData($extArray);
				$this->registry->library('template')->page()->addTag('extensions', array('DATA', $cache));
			}
			closedir($d);
			$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->library('lang')->line('extensions_text'));
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('extensions_text'));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_extensions_list.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function forums_list()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$forums_available = '';
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'forums
			WHERE forums_sys = "' . $this->sys_cms . '"
			AND f_level = 1
			ORDER BY f_order ASC';
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
			{
				$forums_available = 'y';
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
						$i = $i + 1;
					}
				}
			}
			$this->forumReorder();
			$this->registry->library('template')->page()->addTag('forums_available', $forums_available);
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('forums_text'));
			$cache = $this->registry->library('db')->cacheData($forums);
			$this->registry->library('template')->page()->addTag('forums', array('DATA', $cache));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_forums_list.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function create_forum()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		$this->registry->library('template')->page()->addTag('error_message', '');
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$this->registry->library('template')->page()->addTag('forum_name', '');
			$this->registry->library('template')->page()->addTag('forum_description', '');
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('new_forum'));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_forums_create.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function creating_forum()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
// Caching OFF
			$this->registry->library('db')->setCacheOn(0);
			if ($_POST['forum_name'] == '')
			{
				$this->registry->library('template')->page()->addTag('error_message', $this->registry->library('lang')->line('insufficient_data'));
				$this->registry->library('template')->page()->addTag('forum_name', $_POST['forum_name']);
				$this->registry->library('template')->page()->addTag('forum_description', $_POST['forum_description']);
				$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('new_forum'));
// Restore CacheOn NOT Delete Cache
				$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
				$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_forums_create.tpl', 'admin/admin_footer.tpl');
			}
			else
			{
				$data = array();
				$data['f_name'] = $this->registry->library('db')->sanitizeData($_POST['forum_name']);
				$data['f_description'] = $this->registry->library('db')->sanitizeData($_POST['forum_description']);
				$data['f_level'] = 1;
				$this->registry->library('db')->insertRecordsSys('forums', $data);
				$this->forumReorder();
// Restore CacheOn & Delete Cache
				$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
				if ($this->registry->setting('settings_cached') == 1)
				{
					$this->registry->library('db')->deleteCache('cache_', true);
				}
				$this->registry->redirectUser('admin/forums_list', $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
			}
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function edit_forum()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$this->registry->library('template')->page()->addTag('error_message', '');
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'forums
			WHERE forums_sys = "' . $this->sys_cms . '"
			AND f_forum_id = ' . $this->seg_2;
			$this->registry->library('db')->execute($sql);
			if ($this->registry->library('db')->numRows() != 0)
			{
				$data = $this->registry->library('db')->getRows();
				$this->registry->library('template')->page()->addTag('forum_id', $data['f_forum_id']);
				$this->registry->library('template')->page()->addTag('forum_name', $data['f_name']);
				$this->registry->library('template')->page()->addTag('forum_description', $data['f_description']);
			}
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('forum'));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_forums_edit.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function editing_forum()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			if ($_POST['forum_name'] == '')
			{
				$this->registry->library('template')->page()->addTag('f_forum_id', $this->registry->library('db')->sanitizeData($_POST['forumID']));
				$this->registry->library('template')->page()->addTag('error_message', $this->registry->library('lang')->line('insufficient_data'));
				$this->registry->library('template')->page()->addTag('forum_name', $this->registry->library('db')->sanitizeData($_POST['forum_name']));
				$this->registry->library('template')->page()->addTag('forum_description', $this->registry->library('db')->sanitizeData($_POST['forum_description']));
				$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('new_forum'));
				$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_forums_edit.tpl', 'admin/admin_footer.tpl');
			}
			else
			{
				$forumID = $this->registry->library('db')->sanitizeData($_POST['forumID']);
				$data = array();
				$data['f_name'] = $this->registry->library('db')->sanitizeData($_POST['forum_name']);
				$data['f_description'] = $this->registry->library('db')->sanitizeData($_POST['forum_description']);
				$this->registry->library('db')->updateRecordsSys('forums', $data, 'f_forum_id = ' . $forumID);
				$this->forumReorder();
				$this->registry->redirectUser('admin/edit_forum/' . $_POST['forumID'], $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
			}
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function delete_forum()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
// Caching OFF
			$this->registry->library('db')->setCacheOn(0);
			$sql = sprintf("DELETE
			FROM `" . $this->prefix . "forums`
			WHERE forums_sys = \"" . $this->sys_cms . "\"
			AND `f_forum_id` = %u LIMIT 1", $this->seg_2);
			$cache = $this->registry->library('db')->cacheQuery($sql);
			$this->forumReorder();
// Restore CacheOn & Delete Cache
			$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
			$this->registry->redirectUser('admin/forums_list', $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function shops_list()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$shops_available = '';
			$this->registry->library('template')->page()->addTag('admin_simple_shops_list', '');
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
					$html = $this->registry->library('helper')->adminSimpleShopList($data);
				}
				$this->registry->library('template')->page()->addTag('admin_simple_shops_list', $html);
			}
			$this->registry->library('template')->page()->addTag('shops_available', $shops_available);
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('shops_text'));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_shops_list.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function create_shop()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		$this->registry->library('template')->page()->addTag('error_message', '');
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$this->registry->library('template')->page()->addTag('shop_name', '');
			$this->registry->library('template')->page()->addTag('shop_description', '');
			$this->registry->library('template')->page()->addTag('parent_id', $this->seg_2);
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('new_shop'));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_shops_create.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function creating_shop()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
// Caching OFF
			$this->registry->library('db')->setCacheOn(0);
			if ($_POST['shop_name'] == '')
			{
				$this->registry->library('template')->page()->addTag('error_message', $this->registry->library('lang')->line('insufficient_data'));
				$this->registry->library('template')->page()->addTag('shop_name', $_POST['shop_name']);
				$this->registry->library('template')->page()->addTag('shop_description', $_POST['shop_description']);
				$this->registry->library('template')->page()->addTag('f_parent_shop_id', $_POST['parent_id']);
				$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('new_shop'));
// Restore CacheOn NOT Delete Cache
				$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
				$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_shops_create.tpl', 'admin/admin_footer.tpl');
			}
			else
			{
				$data = array();
				$data['f_name'] = $this->registry->library('db')->sanitizeData($_POST['shop_name']);
				$data['f_description'] = $this->registry->library('db')->sanitizeData($_POST['shop_description']);
				if ($_POST['parent_id'] == '')
				{
					$data['f_parent_shop_id'] = 0;
				}
				else
				{
					$data['f_parent_shop_id'] = $this->registry->library('db')->sanitizeData($_POST['parent_id']);
				}
				$this->registry->library('db')->insertRecordsSys('shops', $data);
// Restore CacheOn & Delete Cache
				$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
				if ($this->registry->setting('settings_cached') == 1)
				{
					$this->registry->library('db')->deleteCache('cache_', true);
				}
				$this->registry->redirectUser('admin/shops_list', $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
			}
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function edit_shop()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$this->registry->library('template')->page()->addTag('error_message', '');
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'shops
			WHERE shops_sys = "' . $this->sys_cms . '"
			AND f_shop_id = ' . $this->seg_2;
			$this->registry->library('db')->execute($sql);
			if ($this->registry->library('db')->numRows() != 0)
			{
				$data = $this->registry->library('db')->getRows();
				$this->registry->library('template')->page()->addTag('shop_id', $data['f_shop_id']);
				$this->registry->library('template')->page()->addTag('shop_name', $data['f_name']);
				$this->registry->library('template')->page()->addTag('shop_description', $data['f_description']);
			}
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('shop'));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_shops_edit.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function editing_shop()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			if ($_POST['shop_name'] == '')
			{
				$this->registry->library('template')->page()->addTag('f_shop_id', $this->registry->library('db')->sanitizeData($_POST['shopID']));
				$this->registry->library('template')->page()->addTag('error_message', $this->registry->library('lang')->line('insufficient_data'));
				$this->registry->library('template')->page()->addTag('shop_name', $this->registry->library('db')->sanitizeData($_POST['shop_name']));
				$this->registry->library('template')->page()->addTag('shop_description', $this->registry->library('db')->sanitizeData($_POST['shop_description']));
				$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('new_shop'));
				$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_shops_edit.tpl', 'admin/admin_footer.tpl');
			}
			else
			{
				$shopID = $this->registry->library('db')->sanitizeData($_POST['shopID']);
				$data = array();
				$data['f_name'] = $this->registry->library('db')->sanitizeData($_POST['shop_name']);
				$data['f_description'] = $this->registry->library('db')->sanitizeData($_POST['shop_description']);
				$this->registry->library('db')->updateRecordsSys('shops', $data, 'f_shop_id = ' . $shopID);
				$this->registry->redirectUser('admin/edit_shop/' . $_POST['shopID'], $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
			}
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function delete_shop()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
// Caching OFF
			$this->registry->library('db')->setCacheOn(0);
			$sql = sprintf("DELETE
			FROM `" . $this->prefix . "shops`
			WHERE shops_sys = \"" . $this->sys_cms . "\"
			AND `f_shop_id` = %u LIMIT 1", $this->seg_2);
			$cache = $this->registry->library('db')->cacheQuery($sql);
// Restore CacheOn & Delete Cache
			$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
			if ($this->registry->setting('settings_cached') == 1)
			{
				$this->registry->library('db')->deleteCache('cache_', true);
			}
			$this->registry->redirectUser('admin/shops_list', $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function hide_comment()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true || $this->registry->library('authenticate')->hasPermission('limited_admin') == true)
		{
// Caching OFF
			$this->registry->library('db')->setCacheOn(0);
			$data = array();
			$data['comment_visible'] = 'n';
			$this->registry->library('db')->updateRecordsSys('comments', $data, 'comment_id=' . $this->seg_3);
// Restore CacheOn & Delete Cache
			$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
			if ($this->registry->setting('settings_cached') == 1)
			{
				$this->registry->library('db')->deleteCache('cache_', true);
			}
			$this->registry->redirectUser($this->registry->setting('settings_site0') . '/more/' . $this->seg_2, $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function show_comment()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true || $this->registry->library('authenticate')->hasPermission('limited_admin') == true)
		{
// Caching OFF
			$this->registry->library('db')->setCacheOn(0);
			$data = array();
			$data['comment_visible'] = 'y';
			$data['spam'] = 'n';
			$this->registry->library('db')->updateRecordsSys('comments', $data, 'comment_id=' . $this->seg_3);
// Restore CacheOn & Delete Cache
			$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
			if ($this->registry->setting('settings_cached') == 1)
			{
				$this->registry->library('db')->deleteCache('cache_', true);
			}
			$this->registry->redirectUser($this->registry->setting('settings_site0') . '/more/' . $this->seg_2, $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function forum_categories_list()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$forums_available = '';
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'forums
			WHERE forums_sys = "' . $this->sys_cms . '"
			AND f_level = 0
			ORDER BY f_order ASC';
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
			{
				$forums_available = 'y';
				$forums = array();
				$i = 0;
				$num = $this->registry->library('db')->numRowsFromCache($cache);
				$data = $this->registry->library('db')->rowsFromCache($cache);
				while ($i < $num)
				{
					foreach ($data as $k => $v)
					{
						$forums[$i]['forum_id'] = $v['f_forum_id'];
						$forums[$i]['forum_category'] = $v['f_name'];
						$forums[$i]['forum_category_description'] = $v['f_description'];
						$i = $i + 1;
					}
				}
			}
			$this->registry->library('template')->page()->addTag('forums_available', $forums_available);
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('forum_categories_text'));
			$cache = $this->registry->library('db')->cacheData($forums);
			$this->registry->library('template')->page()->addTag('forums', array('DATA', $cache));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_forum_category_list.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function create_forum_category()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		$this->registry->library('template')->page()->addTag('error_message', '');
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$this->registry->library('template')->page()->addTag('forum_category', '');
			$this->registry->library('template')->page()->addTag('forum_category_description', '');
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('new_forum_category'));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_forum_category_create.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function creating_forum_category()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
// Caching OFF
			$this->registry->library('db')->setCacheOn(0);
			if ($_POST['forum_category'] == '')
			{
				$this->registry->library('template')->page()->addTag('error_message', $this->registry->library('lang')->line('insufficient_data'));
				$this->registry->library('template')->page()->addTag('forum_category', $_POST['forum_category']);
				$this->registry->library('template')->page()->addTag('forum_category_description', $_POST['forum_category_description']);
				$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('new_forum_category'));
// Restore CacheOn NOT Delete Cache
				$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
				$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_forum_category_create.tpl', 'admin/admin_footer.tpl');
			}
			else
			{
				$data = array();
				$data['f_name'] = $this->registry->library('db')->sanitizeData($_POST['forum_category']);
				$data['f_description'] = $this->registry->library('db')->sanitizeData($_POST['forum_category_description']);
				$data['f_level'] = 0;
				$this->registry->library('db')->insertRecordsSys('forums', $data);
// Restore CacheOn & Delete Cache
				$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
				if ($this->registry->setting('settings_cached') == 1)
				{
					$this->registry->library('db')->deleteCache('cache_', true);
				}
				$this->registry->redirectUser('admin/forum_categories_list', $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
			}
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function edit_forum_category()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$this->registry->library('template')->page()->addTag('error_message', '');
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'forums
			WHERE forums_sys = "' . $this->sys_cms . '"
			AND f_forum_id = ' . $this->seg_2;
			$this->registry->library('db')->execute($sql);
			if ($this->registry->library('db')->numRows() != 0)
			{
				$data = $this->registry->library('db')->getRows();
				$this->registry->library('template')->page()->addTag('forum_category_id', $data['f_forum_id']);
				$this->registry->library('template')->page()->addTag('forum_category', $data['f_name']);
				$this->registry->library('template')->page()->addTag('forum_category_description', $data['f_description']);
			}
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('forum'));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_forum_category_edit.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function editing_forum_category()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			if ($_POST['forum_category'] == '')
			{
				$this->registry->library('template')->page()->addTag('f_forum_id', $this->registry->library('db')->sanitizeData($_POST['forumCategoryID']));
				$this->registry->library('template')->page()->addTag('error_message', $this->registry->library('lang')->line('insufficient_data'));
				$this->registry->library('template')->page()->addTag('forum_category', $this->registry->library('db')->sanitizeData($_POST['forum_category']));
				$this->registry->library('template')->page()->addTag('forum_category_description', $this->registry->library('db')->sanitizeData($_POST['forum_category_description']));
				$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('new_forum_category'));
				$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_forum_category_edit.tpl', 'admin/admin_footer.tpl');
			}
			else
			{
				$forumCategoryID = $this->registry->library('db')->sanitizeData($_POST['forumCategoryID']);
				$data = array();
				$data['f_name'] = $this->registry->library('db')->sanitizeData($_POST['forum_category']);
				$data['f_description'] = $this->registry->library('db')->sanitizeData($_POST['forum_category_description']);
				$this->registry->library('db')->updateRecordsSys('forums', $data, 'f_forum_id = ' . $forumCategoryID);
				$this->registry->redirectUser('admin/edit_forum/' . $_POST['forumCategoryID'], $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
			}
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function delete_forum_category()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
// Caching OFF
			$this->registry->library('db')->setCacheOn(0);
			$sql = sprintf("DELETE
			FROM `" . $this->prefix . "forums`
			WHERE forums_sys = \"" . $this->sys_cms . "\"
			AND `f_forum_id` = %u LIMIT 1", $this->seg_2);
			$cache = $this->registry->library('db')->cacheQuery($sql);
// Restore CacheOn & Delete Cache
			$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
			if ($this->registry->setting('settings_cached') == 1)
			{
				$this->registry->library('db')->deleteCache('cache_', true);
			}
			$this->registry->redirectUser('admin/forums_list', $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function hideTopic()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isLoggedIn() == true || $this->guests_allowed == 1)
		{
// Caching OFF
			$this->registry->library('db')->setCacheOn(0);
			$data = array();
			$data['t_topic_visible'] = 'n';
			$this->registry->library('db')->updateRecordsSys('forum_topics', $data, 't_topic_id = ' . $this->seg_2);
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
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

	private function showTopic()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isLoggedIn() == true || $this->guests_allowed == 1)
		{
// Caching OFF
			$this->registry->library('db')->setCacheOn(0);
			$data = array();
			$data['t_topic_visible'] = 'y';
			$this->registry->library('db')->updateRecordsSys('forum_topics', $data, 't_topic_id = ' . $this->seg_2);
// Caching OFF
			$this->registry->library('db')->setCacheOn(0);
			$this->registry->redirectUser($this->registry->setting('settings_forum0') . '/viewtopic/' . $this->seg_2, $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

	private function closeTopic()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isLoggedIn() == true || $this->guests_allowed == 1)
		{
			$data = array();
			$data['t_status'] = 'c';
			$this->registry->library('db')->updateRecordsSys('forum_topics', $data, 't_topic_id = ' . $this->seg_2);
			$this->registry->redirectUser($this->registry->setting('settings_forum0') . '/viewtopic/' . $this->seg_2, $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

	private function openTopic()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isLoggedIn() == true || $this->guests_allowed == 1)
		{
			$data = array();
			$data['t_status'] = 'o';
			$this->registry->library('db')->updateRecordsSys('forum_topics', $data, 't_topic_id = ' . $this->seg_2);
			$this->registry->redirectUser($this->registry->setting('settings_forum0') . '/viewtopic/' . $this->seg_2, $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

	private function hidePost()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isLoggedIn() == true || $this->guests_allowed == 1)
		{
			$data = array();
			$data['p_post_visible'] = 'n';
			$this->registry->library('db')->updateRecordsSys('forum_posts', $data, 'p_post_id  = ' . $this->seg_3);
			$this->registry->redirectUser($this->registry->setting('settings_forum0') . '/viewtopic/' . $this->seg_2, $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

	private function showPost()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isLoggedIn() == true || $this->guests_allowed == 1)
		{
			$data = array();
			$data['p_post_visible'] = 'y';
			$this->registry->library('db')->updateRecordsSys('forum_posts', $data, 'p_post_id  = ' . $this->seg_3);
			$this->registry->redirectUser($this->registry->setting('settings_forum0') . '/viewtopic/' . $this->seg_2, $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

	private function deletePost()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isLoggedIn() == true || $this->guests_allowed == 1)
		{
// Caching OFF
			$this->registry->library('db')->setCacheOn(0);
			$sql = sprintf("DELETE
			FROM `" . $this->prefix . "forum_posts`
			WHERE forum_posts_sys = \"" . $this->sys_cms . "\"
			AND `p_post_id` = %u
			LIMIT 1", $this->seg_3);
			$cache = $this->registry->library('db')->cacheQuery($sql);
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
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

	private function deleteTopic()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isLoggedIn() == true || $this->guests_allowed == 1)
		{
// Caching OFF
			$this->registry->library('db')->setCacheOn(0);
			$sql = sprintf("DELETE
			FROM `" . $this->prefix . "forum_posts`
			WHERE forum_posts_sys = \"" . $this->sys_cms . "\"
			AND `p_topic_id` = %u", $this->seg_2);
			$cache = $this->registry->library('db')->cacheQuery($sql);
			$sql = sprintf("DELETE
			FROM `" . $this->prefix . "forum_topics`
			WHERE forum_topics_sys = \"" . $this->sys_cms . "\"
			AND `t_topic_id` = %u LIMIT 1", $this->seg_2);
			$cache = $this->registry->library('db')->cacheQuery($sql);
// Restore CacheOn & Delete Cache
			$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
			if ($this->registry->setting('settings_cached') == 1)
			{
				$this->registry->library('db')->deleteCache('cache_', true);
			}
			$this->registry->redirectUser($this->registry->setting('settings_forum0'), $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

	private function editTopic()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isLoggedIn() == true || $this->guests_allowed == 1)
		{
			$this->registry->library('template')->page()->addTag('error_message', '');
			$sql = 'SELECT * FROM ' . $this->prefix . 'forum_topics
			LEFT JOIN ' . $this->prefix . 'forums ON t_forum_id = f_forum_id
			AND forums_sys = "' . $this->sys_cms . '"
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
				$this->registry->library('template')->page()->addTag('topic_body', $data['t_body']);
				$this->registry->library('template')->page()->addTag('topic_datetime', $data['t_topic_date']);
				$this->registry->library('template')->page()->addTag('topic_visible', $data['t_topic_visible']);
				$this->registry->library('template')->page()->addTag('status', $data['t_status']);
			}
			$this->registry->library('template')->page()->addTag('forum_id', $this->seg_2);
			$this->registry->library('template')->page()->addTag('heading', 'Edit Topic');
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_topics_edit.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

	private function editingTopic()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isLoggedIn() == true || $this->guests_allowed == 1)
		{
			$this->registry->library('template')->page()->addTag('error_message', '');
			$data = array();
			$data['t_title'] = $this->registry->library('db')->sanitizeData($_POST['topic_title']);
			$data['t_body'] = $this->registry->library('db')->sanitizeData($_POST['topic_body']);
			$data['t_topic_edit_date'] = date("Y-m-d H:i:s", time());
			$this->registry->library('db')->updateRecordsSys('forum_topics', $data, 't_topic_id=' . $this->seg_2);
			$this->registry->redirectUser('admin/topic_edit/' . $this->seg_2, $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

	private function editPost()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isLoggedIn() == true || $this->guests_allowed == 1)
		{
			$this->registry->library('template')->page()->addTag('error_message', '');
			$sql = 'SELECT * FROM ' . $this->prefix . 'forum_posts
			LEFT JOIN ' . $this->prefix . 'users ON users_id = p_user_id
			WHERE forum_posts_sys = "' . $this->sys_cms . '"
			AND p_post_id = ' . $this->seg_3;
			$this->registry->library('db')->execute($sql);
			if ($this->registry->library('db')->numRows() != 0)
			{
				$data = $this->registry->library('db')->getRows();
				$this->registry->library('template')->page()->addTag('post_id', $data['p_post_id']);
				$this->registry->library('template')->page()->addTag('post_body', $data['p_body']);
				$this->registry->library('template')->page()->addTag('post_author_id', $data['p_user_id']);
				$this->registry->library('template')->page()->addTag('post_author', $data['username']);
				$this->registry->library('template')->page()->addTag('post_visible', $data['p_post_visible']);
				$this->registry->library('template')->page()->addTag('post_datetime', $data['p_post_date']);
			}
			$this->registry->library('template')->page()->addTag('topic_id', $this->seg_2);
			$this->registry->library('template')->page()->addTag('heading', 'Edit Post');
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_posts_edit.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

	private function editingPost()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isLoggedIn() == true || $this->guests_allowed == 1)
		{
			$this->registry->library('template')->page()->addTag('error_message', '');
			$data = array();
			$data['p_body'] = $this->registry->library('db')->sanitizeData($_POST['post_body']);
			$data['p_post_edit_date'] = date("Y-m-d H:i:s", time());
			$this->registry->library('db')->updateRecordsSys('forum_posts', $data, 'p_post_id=' . $this->seg_2);
			$this->registry->redirectUser('admin/post_edit/' . $_POST['topicID'] . '/' . $this->seg_2, $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

	private function add_field()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isLoggedIn() == true || $this->guests_allowed == 1)
		{
			$this->registry->library('template')->page()->addTag('error_message', '');
			$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->library('lang')->line('add_cf'));
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('add_cf'));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_field_create.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

	private function adding_field()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isLoggedIn() == true || $this->guests_allowed == 1)
		{
// Caching OFF
			$this->registry->library('db')->setCacheOn(0);
			$data = array();
			$data['c_created_name'] = $this->registry->library('db')->sanitizeData($_POST['field_name']);
			$data['c_created_url_title'] = $this->registry->library('db')->sanitizeData($_POST['field_url_title']);
			$data['c_created_description'] = $this->registry->library('db')->sanitizeData($_POST['field_description']);
			$data['c_created_type'] = $this->registry->library('db')->sanitizeData($_POST['field_type']);
			$data['c_type_default_value'] = $this->registry->library('db')->sanitizeData($_POST['list_items']);
			$data['c_created_site_section'] = $this->registry->library('db')->sanitizeData($_POST['site_section']);
			$data['c_created_obligatory'] = $this->registry->library('db')->sanitizeData($_POST['obligatory']);
			$data['c_created_encrypted'] = $this->registry->library('db')->sanitizeData($_POST['encrypted']);
			$this->registry->library('db')->insertRecordsSys('c_fields_created', $data);
// Caching OFF
			$this->registry->library('db')->setCacheOn(0);
			$this->registry->redirectUser('admin/fields_list', $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

	private function fields_list()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isLoggedIn() == true || $this->guests_allowed == 1)
		{
			$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->library('lang')->line('list_cf'));
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('list_cf'));
			$cache = $this->registry->library('db')->cacheQuery('SELECT * FROM ' . $this->prefix . 'c_fields_created WHERE c_fields_created_sys = "' . $this->sys_cms . '"');
			$this->registry->library('template')->page()->addTag('custom_fields', array('SQL', $cache));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_fields_list.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

	private function delete_field()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isLoggedIn() == true || $this->guests_allowed == 1)
		{
// Caching OFF
			$this->registry->library('db')->setCacheOn(0);
			$sql = sprintf("DELETE
			FROM `" . $this->prefix . "c_fields_created`
			WHERE c_fields_created_sys = \"" . $this->sys_cms . "\"
			AND `c_created_id` = %u LIMIT 1", $this->seg_2);
			$cache = $this->registry->library('db')->cacheQuery($sql);
// Restore CacheOn & Delete Cache
			$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
			if ($this->registry->setting('settings_cached') == 1)
			{
				$this->registry->library('db')->deleteCache('cache_', true);
			}
			$this->registry->redirectUser('admin/fields_list', $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('log_in_or_register'));
		}
	}

	private function edit_field()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$this->registry->library('template')->page()->addTag('error_message', '');
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'c_fields_created
			WHERE c_fields_created_sys = "' . $this->sys_cms . '"
			AND c_created_id = ' . $this->seg_2;
			$this->registry->library('db')->execute($sql);
			if ($this->registry->library('db')->numRows() != 0)
			{
				$data = $this->registry->library('db')->getRows();
				$this->registry->library('template')->page()->addTag('c_field_id', $this->seg_2);
				$this->registry->library('template')->page()->addTag('c_field_name', $data['c_created_name']);
				$this->registry->library('template')->page()->addTag('c_field_url_title', $data['c_created_url_title']);
				$this->registry->library('template')->page()->addTag('c_field_description', $data['c_created_description']);
				$this->registry->library('template')->page()->addTag('c_field_type', $data['c_created_type']);
				$this->registry->library('template')->page()->addTag('c_list_items', $data['c_type_default_value']);
				$this->registry->library('template')->page()->addTag('c_site_section', $data['c_created_site_section']);
				$this->registry->library('template')->page()->addTag('c_obligatory', $data['c_created_obligatory']);
				$this->registry->library('template')->page()->addTag('c_encrypted', $data['c_created_encrypted']);
			}
			$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->library('lang')->line('edit_field'));
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('edit_field'));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_field_edit.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function editing_field()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			if ($_POST['field_name'] == '' || $_POST['field_url_title'] == '')
			{
				$this->registry->library('template')->page()->addTag('error_message', $this->registry->library('lang')->line('insufficient_data'));
				$this->registry->library('template')->page()->addTag('c_field_id', $this->seg_2);
				$this->registry->library('template')->page()->addTag('c_field_name', $this->registry->library('db')->sanitizeData($_POST['field_name']));
				$this->registry->library('template')->page()->addTag('c_field_url_title', $this->registry->library('db')->sanitizeData($_POST['field_url_title']));
				$this->registry->library('template')->page()->addTag('c_field_description', $this->registry->library('db')->sanitizeData($_POST['field_description']));
				$this->registry->library('template')->page()->addTag('c_field_type', $this->registry->library('db')->sanitizeData($_POST['field_type']));
				$this->registry->library('template')->page()->addTag('c_list_items', $this->registry->library('db')->sanitizeData($_POST['list_items']));
				$this->registry->library('template')->page()->addTag('c_site_section', $this->registry->library('db')->sanitizeData($_POST['site_section']));
				$this->registry->library('template')->page()->addTag('c_obligatory', $this->registry->library('db')->sanitizeData($_POST['obligatory']));
				$this->registry->library('template')->page()->addTag('c_encrypted', $this->registry->library('db')->sanitizeData($_POST['encrypted']));
				$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('edit_field'));
				$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_field_edit.tpl', 'admin/admin_footer.tpl');
			}
			else
			{
				$data = array();
				$data['c_created_name'] = $this->registry->library('db')->sanitizeData($_POST['field_name']);
				$data['c_created_url_title'] = $this->registry->library('db')->sanitizeData($_POST['field_url_title']);
				$data['c_created_description'] = $this->registry->library('db')->sanitizeData($_POST['field_description']);
				$data['c_created_type'] = $this->registry->library('db')->sanitizeData($_POST['field_type']);
				$data['c_type_default_value'] = $this->registry->library('db')->sanitizeData($_POST['list_items']);
				$data['c_created_site_section'] = $this->registry->library('db')->sanitizeData($_POST['site_section']);
				$data['c_created_obligatory'] = $this->registry->library('db')->sanitizeData($_POST['obligatory']);
				$data['c_created_encrypted'] = $this->registry->library('db')->sanitizeData($_POST['encrypted']);
				$this->registry->library('db')->updateRecordsSys('c_fields_created', $data, 'c_created_id = ' . $this->seg_2);
				$this->registry->redirectUser('admin/edit_field/' . $_POST['fieldID'], $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
			}
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function sites_list()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$site_selector = '';
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'settings
			ORDER BY settings_id ASC';
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
			{
				$site_selector .= '<select name="site">';
				$i = 0;
				$num = $this->registry->library('db')->numRowsFromCache($cache);
				$data = $this->registry->library('db')->rowsFromCache($cache);
				while ($i < $num)
				{
					foreach ($data as $k => $v)
					{
						if ($this->sys_cms == $v['settings_sys'])
						{
							$selected = 'SELECTED';
						}
						else
						{
							$selected = '';
						}
						$site_selector .= '<option value="' . $v['settings_sys'] . '" ' . $selected . ' >' . $v['settings_cms_title'] . ' :: ' . $v['settings_cms_description'] . '</option>';
						$i = $i + 1;
					}
				}
				$site_selector .= '</select>';
			}
			if ($site_selector == '')
			{
				$this->registry->library('template')->page()->addTag('site_selector', 'No Sites');
			}
			else
			{
				$this->registry->library('template')->page()->addTag('site_selector', $site_selector);
			}
			$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->library('lang')->line('sites'));
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('sites'));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_site_selection.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function add_site()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$site_selector = '';
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'settings
			ORDER BY settings_id ASC';
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
			{
				$site_selector .= '<select name="site">';
				$i = 0;
				$num = $this->registry->library('db')->numRowsFromCache($cache);
				$data = $this->registry->library('db')->rowsFromCache($cache);
				while ($i < $num)
				{
					foreach ($data as $k => $v)
					{
						$site_selector .= '<option value="' . $v['settings_sys'] . '" ' . $selected . ' >' . $v['settings_cms_title'] . ' :: ' . $v['settings_cms_description'] . '</option>';
						$i = $i + 1;
					}
				}
				$site_selector .= '</select>';
			}
			if ($site_selector == '')
			{
				$this->registry->library('template')->page()->addTag('site_selector', 'No Sites');
			}
			else
			{
				$this->registry->library('template')->page()->addTag('site_selector', $site_selector);
			}
			$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->library('lang')->line('clone_site'));
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('clone_site'));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_add_site.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function delete_site()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
// Caching OFF
			$this->registry->library('db')->setCacheOn(0);
			$site_selector = '';
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'settings
			ORDER BY settings_id ASC';
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
			{
				$site_selector .= '<select name="site">';
				$i = 0;
				$num = $this->registry->library('db')->numRowsFromCache($cache);
				$data = $this->registry->library('db')->rowsFromCache($cache);
				while ($i < $num)
				{
					foreach ($data as $k => $v)
					{
						$site_selector .= '<option value="' . $v['settings_sys'] . '">' . $v['settings_cms_title'] . '</option>';
						$i = $i + 1;
					}
				}
				$site_selector .= '</select>';
			}
			if ($site_selector == '')
			{
				$this->registry->library('template')->page()->addTag('site_selector', 'No Sites');
			}
			else
			{
				$this->registry->library('template')->page()->addTag('site_selector', $site_selector);
			}
			$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->library('lang')->line('sites'));
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('sites'));
// Restore CacheOn & Delete Cache
			$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
			if ($this->registry->setting('settings_cached') == 1)
			{
				$this->registry->library('db')->deleteCache('cache_', true);
			}
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_delete_site.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function adding_site()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
// Caching OFF
			$this->registry->library('db')->setCacheOn(0);
			$sql = "SELECT *
			FROM " . $this->prefix . "settings
			ORDER BY settings_id DESC LIMIT 1";
			$this->registry->library('db')->execute($sql);
			if ($this->registry->library('db')->numRows() != 0)
			{
				$data = $this->registry->library('db')->getRows();
				$temp = $data['settings_id'];
			}
			else
			{
//
			}
			$sql = "SELECT *
			FROM " . $this->prefix . "settings
			WHERE settings_sys = '" . $this->registry->library('db')->sanitizeData($_POST['site']) . "'";
			if ($this->registry->library('db')->numRows() != 0)
			{
				$data['settings_id'] = $temp + 1;
				$data['settings_sys'] = $data['settings_id'];
				$this->registry->library('db')->insertRecords('settings', $data);
// Restore CacheOn & Delete Cache
				$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
				if ($this->registry->setting('settings_cached') == 1)
				{
					$this->registry->library('db')->deleteCache('cache_', true);
				}
				$this->registry->redirectUser('admin/sites_list', $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
			}
			else
			{
// Restore CacheOn NOT Delete Cache
				$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
			}
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function deleting_site()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
// Caching OFF
			$this->registry->library('db')->setCacheOn(0);
			$this->registry->library('db')->deleteRecords('settings', 'settings_sys=' . $this->registry->library('db')->sanitizeData($_POST['site']), '1');
// Restore CacheOn & Delete Cache
			$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
			if ($this->registry->setting('settings_cached') == 1)
			{
				$this->registry->library('db')->deleteCache('cache_', true);
			}
			$this->registry->redirectUser('admin/sites_list', $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function switching_site()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$_SESSION['cms_sys'] = $this->registry->library('db')->sanitizeData($_POST['site']);
// echo 'SYSTEM: ' . $_POST['site'];
			$this->registry->library('hook')->init();
			$controller_init_hook = $this->registry->library('hook')->call('admin_switching_site_hook');
			$this->registry->redirectUser('admin/settings/' . $siteSys, $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function shop_up()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
// shop movement
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'shops
			WHERE f_shop_id = ' . $this->seg_2;
			$this->registry->library('db')->execute($sql);
			if ($this->registry->library('db')->numRows() != 0)
			{
				$oneCat = array();
				$oneCat = $this->registry->library('db')->getRows();
				$newData = array();
				$newData['f_order'] = $oneCat['f_order'] - 3;
				$this->registry->library('db')->updateRecordsSys('shops', $newData, 'f_shop_id=' . $this->seg_2);
			}
// shop re-ordering
			$this->shopReorder();
// shop list
			$shops_available = '';
			$this->registry->library('template')->page()->addTag('admin_simple_shops_list', '');
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
					$html = $this->registry->library('helper')->adminSimpleShopList($data);
				}
				$this->registry->library('template')->page()->addTag('admin_simple_shops_list', $html);
			}
			$this->registry->library('template')->page()->addTag('shops_available', $shops_available);
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('shops_text'));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_shops_list.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function shop_down()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
// shop movement
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'shops
			WHERE f_shop_id = ' . $this->seg_2;
			$this->registry->library('db')->execute($sql);
			if ($this->registry->library('db')->numRows() != 0)
			{
				$oneCat = array();
				$oneCat = $this->registry->library('db')->getRows();
				$newData = array();
				$newData['f_order'] = $oneCat['f_order'] + 3;
				$this->registry->library('db')->updateRecordsSys('shops', $newData, 'f_shop_id=' . $this->seg_2);
			}
// shop re-ordering
			$this->shopReorder();
// shop list
			$shops_available = '';
			$this->registry->library('template')->page()->addTag('admin_simple_shops_list', '');
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
					$html = $this->registry->library('helper')->adminSimpleShopList($data);
				}
				$this->registry->library('template')->page()->addTag('admin_simple_shops_list', $html);
			}
			$this->registry->library('template')->page()->addTag('shops_available', $shops_available);
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('shops_text'));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_shops_list.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function shopReorder()
	{
// shop re-ordering
		$reorder = array();
		$reordering = array();
		$i = 0;
		$sql = 'SELECT *
			FROM ' . $this->prefix . 'shops
			WHERE shops_sys = "' . $this->sys_cms . '"
			ORDER BY f_order ASC';
		$old = $this->registry->library('db')->cacheQuery($sql);
		if ($this->registry->library('db')->numRowsFromCache($old) != 0)
		{
			$reorder = $this->registry->library('db')->rowsFromCache($old);
			foreach ($reorder as $k => $v)
			{
				$reordering['f_order'] = $i * 2;
				$this->registry->library('db')->updateRecords('shops', $reordering, 'f_shop_id =' . $v['f_shop_id']);
				$i = $i + 1;
			}
		}
	}

	private function pages_list()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$page_available = '';
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'static
			WHERE static_sys = "' . $this->sys_cms . '"
			ORDER BY page_order ASC';
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
			{
				$pages_available = 'y';
				$data = $this->registry->library('db')->rowsFromCache($cache);
				$html = $this->registry->library('helper')->adminPagesList($data);
			}
			$this->registry->library('template')->page()->addTag('admin_pages_list', $html);
			$this->registry->library('template')->page()->addTag('pages_available', $pages_available);
			$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->library('lang')->line('pages_text'));
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('pages_text'));
			$cache = $this->registry->library('db')->cacheData($pages);
			$this->registry->library('template')->page()->addTag('pages', array('DATA', $cache));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_pages_list.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function create_page()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		$this->registry->library('template')->page()->addTag('error_message', '');
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->library('lang')->line('create_page'));
		$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('create_page'));
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'static
			WHERE static_sys = "' . $this->sys_cms . '"
			ORDER BY page_order ASC';
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
			{
				$data = $this->registry->library('db')->rowsFromCache($cache);
				$html = $this->registry->library('helper')->adminPagesList($data);
			}
			$this->registry->library('template')->page()->addTag('admin_pages_list', $html);
			if ($this->seg_2 == '')
			{
				$parentID = 0;
			}
			else
			{
				$parentID = $this->seg_2;
			}
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'static
			WHERE static_sys = "' . $this->sys_cms . '"
			AND page_id = ' . $parentID;
			$this->registry->library('db')->execute($sql);
			$this->registry->library('template')->page()->addTag('parent_page_name', '-');
			if ($this->registry->library('db')->numRows() != 0)
			{
				$data = $this->registry->library('db')->getRows();
				$this->registry->library('template')->page()->addTag('parent_page_name', $data['page_title']);
			}
			$this->registry->library('template')->page()->addTag('parent_id', $parentID);
			$this->registry->library('template')->page()->addTag('page_title', '');
			$this->registry->library('template')->page()->addTag('page_url_name', '');
			$this->registry->library('template')->page()->addTag('page_description', '');
			$this->registry->library('template')->page()->addTag('page_content', '');
			$this->registry->library('template')->page()->addTag('st_header', $this->registry->setting('settings_st_header'));
			$this->registry->library('template')->page()->addTag('st_main', $this->registry->setting('settings_st_main'));
			$this->registry->library('template')->page()->addTag('st_footer', $this->registry->setting('settings_st_footer'));
			$this->registry->library('template')->page()->addTag('web_url', '');
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_pages_create.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function creating_page()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
// Caching OFF
			$this->registry->library('db')->setCacheOn(0);
			if ($_POST['parent_id'] == '' || $_POST['page_title'] == '' || $_POST['page_url_name'] == '')
			{
				$this->registry->library('template')->page()->addTag('error_message', $this->registry->library('lang')->line('insufficient_data'));
				$this->registry->library('template')->page()->addTag('parent_id', $_POST['parent_id']);
				$this->registry->library('template')->page()->addTag('page_title', $_POST['page_title']);
				$this->registry->library('template')->page()->addTag('page_url_name', $_POST['page_url_name']);
				$this->registry->library('template')->page()->addTag('page_description', $_POST['page_description']);
				$page_content = str_replace('&', '&amp;', $_POST['page_content']);
				$this->registry->library('template')->page()->addTag('page_content', $page_content);
				$this->registry->library('template')->page()->addTag('st_header', $_POST['st_header']);
				$this->registry->library('template')->page()->addTag('st_main', $_POST['st_main']);
				$this->registry->library('template')->page()->addTag('st_footer', $_POST['st_footer']);
				$this->registry->library('template')->page()->addTag('web_url', $_POST['web_url']);
				$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_pages_create.tpl', 'admin/admin_footer.tpl');
			}
			else
			{
				if ($_POST['parent_id'] == 0)
				{
					$data = array();
					$data['parent_id'] = $this->registry->library('db')->sanitizeData($_POST['parent_id']);
					$data['page_title'] = $this->registry->library('db')->sanitizeData($_POST['page_title']);
					$data['page_url_1'] = $this->registry->library('db')->sanitizeData($_POST['page_url_name']);
					$data['page_description'] = $this->registry->library('db')->sanitizeData($_POST['page_description']);
					$page_content = str_replace('&', '&amp;', $this->registry->library('db')->sanitizeData($_POST['page_content']));
					$data['page_content'] = $page_content;
					$data['st_header'] = $this->registry->library('db')->sanitizeData($_POST['st_header']);
					$data['st_main'] = $this->registry->library('db')->sanitizeData($_POST['st_main']);
					$data['st_footer'] = $this->registry->library('db')->sanitizeData($_POST['st_footer']);
					$data['web_url'] = $this->registry->library('db')->sanitizeData($_POST['web_url']);
					$data['page_order'] = '0';
					$this->registry->library('db')->insertRecordsSys('static', $data);
					$this->pagesReorder();
				}
				else
				{
					$parent_id = $this->registry->library('db')->sanitizeData($_POST['parent_id']);
					$page_url_name = $this->registry->library('db')->sanitizeData($_POST['page_url_name']);
					$sql = 'SELECT *
						FROM ' . $this->prefix . 'static
						WHERE page_id =' . $parent_id;
					$this->registry->library('db')->execute($sql);
					if ($this->registry->library('db')->numRows() != 0)
					{
						$data = $this->registry->library('db')->getRows();
						$skip_trigger = 0;
						if ($data['page_url_1'] == '' && $skip_trigger == 0)
						{
							$s1 = $page_url_name;
							$skip_trigger = 1;
						}
						else
						{
							$s1 = $data['page_url_1'];
						}
						if ($data['page_url_2'] == '' && $skip_trigger == 0)
						{
							$s2 = $page_url_name;
							$skip_trigger = 1;
						}
						else
						{
							$s2 = $data['page_url_2'];
						}
						if ($data['page_url_3'] == '' && $skip_trigger == 0)
						{
							$s3 = $page_url_name;
							$skip_trigger = 1;
						}
						else
						{
							$s3 = $data['page_url_3'];
						}
						if ($data['page_url_4'] == '' && $skip_trigger == 0)
						{
							$s4 = $page_url_name;
							$skip_trigger = 1;
						}
						else
						{
							$s4 = $data['page_url_4'];
						}
						if ($data['page_url_5'] == '' && $skip_trigger == 0)
						{
							$s5 = $page_url_name;
							$skip_trigger = 1;
						}
						else
						{
							$s5 = $data['page_url_5'];
						}
						if ($data['page_url_6'] == '' && $skip_trigger == 0)
						{
							$s6 = $page_url_name;
							$skip_trigger = 1;
						}
						else
						{
							$s6 = $data['page_url_6'];
						}
						if ($data['page_url_7'] == '' && $skip_trigger == 0)
						{
							$s7 = $page_url_name;
							$skip_trigger = 1;
						}
						else
						{
							$s7 = $data['page_url_7'];
						}
						if ($data['page_url_8'] == '' && $skip_trigger == 0)
						{
							$s8 = $page_url_name;
							$skip_trigger = 1;
						}
						else
						{
							$s8 = $data['page_url_8'];
						}
						$data = array('parent_id' => $parent_id, 'page_title' => $this->registry->library('db')->sanitizeData($_POST['page_title']), 'page_order' => $data['page_order'] + 1, 'page_url_1' => $s1, 'page_url_2' => $s2, 'page_url_3' => $s3, 'page_url_4' => $s4, 'page_url_5' => $s5, 'page_url_6' => $s6, 'page_url_7' => $s7, 'page_url_8' => $s8);
					}
					$this->registry->library('db')->insertRecordsSys('static', $data);
					$this->pagesReorder();
				}
// Restore CacheOn & Delete Cache
				$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
				if ($this->registry->setting('settings_cached') == 1)
				{
					$this->registry->library('db')->deleteCache('cache_', true);
				}
			}
			$this->registry->redirectUser('admin/pages_list', $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function pagesReorder()
	{
// category re-ordering
		$reorder = array();
		$reordering = array();
		$i = 0;
		$sql = 'SELECT *
			FROM ' . $this->prefix . 'static
			WHERE static_sys = "' . $this->sys_cms . '"
			ORDER BY page_order ASC';
		$old = $this->registry->library('db')->cacheQuery($sql);
		if ($this->registry->library('db')->numRowsFromCache($old) != 0)
		{
			$reorder = $this->registry->library('db')->rowsFromCache($old);
			foreach ($reorder as $k => $v)
			{
				$reordering['page_order'] = $i * 2;
				$this->registry->library('db')->updateRecords('static', $reordering, 'page_id=' . $v['page_id']);
				$i = $i + 1;
			}
		}
	}

	function edit_page()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$this->registry->library('template')->page()->addTag('error_message', '');
			$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->library('lang')->line('edit_page'));
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('edit_page'));
			$sql = 'SELECT *
				FROM ' . $this->prefix . 'static
				WHERE page_id =' . $this->seg_2;
			$this->registry->library('db')->execute($sql);
			if ($this->registry->library('db')->numRows() != 0)
			{
				$data = $this->registry->library('db')->getRows();
				$this->registry->library('template')->page()->addTag('page_id', $data['page_id']);
				$skip_trigger = 0;
				if ($data['page_url_8'] != '' && $skip_trigger == 0)
				{
					$last_url_segment = $data['page_url_8'];
					$skip_trigger = 1;
				}
				if ($data['page_url_7'] != '' && $skip_trigger == 0)
				{
					$last_url_segment = $data['page_url_7'];
					$skip_trigger = 1;
				}
				if ($data['page_url_6'] != '' && $skip_trigger == 0)
				{
					$last_url_segment = $data['page_url_6'];
					$skip_trigger = 1;
				}
				if ($data['page_url_5'] != '' && $skip_trigger == 0)
				{
					$last_url_segment = $data['page_url_5'];
					$skip_trigger = 1;
				}
				if ($data['page_url_4'] != '' && $skip_trigger == 0)
				{
					$last_url_segment = $data['page_url_4'];
					$skip_trigger = 1;
				}
				if ($data['page_url_3'] != '' && $skip_trigger == 0)
				{
					$last_url_segment = $data['page_url_3'];
					$skip_trigger = 1;
				}
				if ($data['page_url_2'] != '' && $skip_trigger == 0)
				{
					$last_url_segment = $data['page_url_2'];
					$skip_trigger = 1;
				}
				if ($data['page_url_1'] != '' && $skip_trigger == 0)
				{
					$last_url_segment = $data['page_url_1'];
					$skip_trigger = 1;
				}
				$this->registry->library('template')->page()->addTag('last_url_segment', $last_url_segment);
				$this->registry->library('template')->page()->addTag('parent_id', $data['parent_id']);
				$this->registry->library('template')->page()->addTag('page_title', $data['page_title']);
				$this->registry->library('template')->page()->addTag('page_description', $data['page_description']);
				$this->registry->library('template')->page()->addTag('page_content', $data['page_content']);
				$this->registry->library('template')->page()->addTag('st_header', $data['st_header']);
				$this->registry->library('template')->page()->addTag('st_main', $data['st_main']);
				$this->registry->library('template')->page()->addTag('st_footer', $data['st_footer']);
				$this->registry->library('template')->page()->addTag('web_url', $data['web_url']);
			}
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_pages_edit.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	function editing_page()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$pageID = $this->registry->library('db')->sanitizeData($_POST['pageID']);
			$last_url_segment = $this->registry->library('db')->sanitizeData($_POST['last_url_segment']);
			$sql = 'SELECT *
				FROM ' . $this->prefix . 'static
				WHERE page_id =' . $pageID;
			$this->registry->library('db')->execute($sql);
			if ($this->registry->library('db')->numRows() != 0)
			{
				$data = $this->registry->library('db')->getRows();
				$this->registry->library('template')->page()->addTag('page_id', $data['page_id']);
				$newData = array();
				$skip_trigger = 0;
				if ($data['page_url_8'] != '' && $skip_trigger == 0)
				{
					$newData['page_url_8'] = $last_url_segment;
					$skip_trigger = 1;
					$previousSegment = $data['page_url_8'];
					$newSegment = array();
					$newSegment['page_url_8'] = $last_url_segment;
					$this->registry->library('db')->updateRecordsSys('static', $newSegment, 'page_url_8="' . $previousSegment . '"');
				}
				if ($data['page_url_7'] != '' && $skip_trigger == 0)
				{
					$newData['page_url_7'] = $last_url_segment;
					$skip_trigger = 1;
					$previousSegment = $data['page_url_7'];
					$newSegment = array();
					$newSegment['page_url_7'] = $last_url_segment;
					$this->registry->library('db')->updateRecordsSys('static', $newSegment, 'page_url_7="' . $previousSegment . '"');
				}
				if ($data['page_url_6'] != '' && $skip_trigger == 0)
				{
					$newData['page_url_6'] = $last_url_segment;
					$skip_trigger = 1;
					$previousSegment = $data['page_url_6'];
					$newSegment = array();
					$newSegment['page_url_6'] = $last_url_segment;
					$this->registry->library('db')->updateRecordsSys('static', $newSegment, 'page_url_6="' . $previousSegment . '"');
				}
				if ($data['page_url_5'] != '' && $skip_trigger == 0)
				{
					$newData['page_url_5'] = $last_url_segment;
					$skip_trigger = 1;
					$previousSegment = $data['page_url_5'];
					$newSegment = array();
					$newSegment['page_url_5'] = $last_url_segment;
					$this->registry->library('db')->updateRecordsSys('static', $newSegment, 'page_url_5="' . $previousSegment . '"');
				}
				if ($data['page_url_4'] != '' && $skip_trigger == 0)
				{
					$newData['page_url_4'] = $last_url_segment;
					$skip_trigger = 1;
					$previousSegment = $data['page_url_4'];
					$newSegment = array();
					$newSegment['page_url_4'] = $last_url_segment;
					$this->registry->library('db')->updateRecordsSys('static', $newSegment, 'page_url_4="' . $previousSegment . '"');
				}
				if ($data['page_url_3'] != '' && $skip_trigger == 0)
				{
					$newData['page_url_3'] = $last_url_segment;
					$skip_trigger = 1;
					$previousSegment = $data['page_url_3'];
					$newSegment = array();
					$newSegment['page_url_3'] = $last_url_segment;
					$this->registry->library('db')->updateRecordsSys('static', $newSegment, 'page_url_3="' . $previousSegment . '"');
				}
				if ($data['page_url_2'] != '' && $skip_trigger == 0)
				{
					$newData['page_url_2'] = $last_url_segment;
					$skip_trigger = 1;
					$previousSegment = $data['page_url_2'];
					$newSegment = array();
					$newSegment['page_url_2'] = $last_url_segment;
					$this->registry->library('db')->updateRecordsSys('static', $newSegment, 'page_url_2="' . $previousSegment . '"');
				}
				if ($data['page_url_1'] != '' && $skip_trigger == 0)
				{
					$newData['page_url_1'] = $last_url_segment;
					$skip_trigger = 1;
					$previousSegment = $data['page_url_1'];
					$newSegment = array();
					$newSegment['page_url_1'] = $last_url_segment;
					$this->registry->library('db')->updateRecordsSys('static', $newSegment, 'page_url_1="' . $previousSegment . '"');
				}
			}
			$newData['page_id'] = $this->registry->library('db')->sanitizeData($_POST['pageID']);
			$newData['parent_id'] = $this->registry->library('db')->sanitizeData($_POST['parent_id']);
			$newData['page_title'] = $this->registry->library('db')->sanitizeData($_POST['page_title']);
			$newData['page_description'] = $this->registry->library('db')->sanitizeData($_POST['page_description']);
			$newData['page_content'] = $this->registry->library('db')->sanitizeData($_POST['page_content']);
			$newData['page_content'] = str_replace('&', '&amp;', $newData['page_content']);
			$newData['st_header'] = $this->registry->library('db')->sanitizeData($_POST['st_header']);
			$newData['st_main'] = $this->registry->library('db')->sanitizeData($_POST['st_main']);
			$newData['st_footer'] = $this->registry->library('db')->sanitizeData($_POST['st_footer']);
			$newData['web_url'] = $this->registry->library('db')->sanitizeData($_POST['web_url']);
			$this->registry->library('db')->updateRecords('static', $newData, 'page_id=' . $newData['page_id']);
			$this->registry->redirectUser('admin/edit_page/' . $newData['page_id'], $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function delete_page()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
// Caching OFF
			$this->registry->library('db')->setCacheOn(0);
// Are there children pages?
			$sql = "SELECT *
				FROM " . $this->prefix . "static
				WHERE static_sys = '" . $this->sys_cms . "'
				AND parent_id = '" . $this->seg_2 . "'";
			$this->registry->library('db')->execute($sql);
			if ($this->registry->library('db')->numRows() != 0)
			{
				$this->registry->redirectUser('admin/pages_list', $this->registry->library('lang')->line('is_children_category'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
			}
			else
			{
				$sql = sprintf("DELETE
					FROM `" . $this->prefix . "static`
					WHERE static_sys = \"" . $this->sys_cms . "\"
					AND `page_id` = %u LIMIT 1", $this->seg_2);
				$cache = $this->registry->library('db')->cacheQuery($sql);
			}
// Restore CacheOn & Delete Cache
			$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
			if ($this->registry->setting('settings_cached') == 1)
			{
				$this->registry->library('db')->deleteCache('cache_', true);
			}
			$this->registry->redirectUser('admin/pages_list', $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function page_up()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
// page movement
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'static
			WHERE page_id = ' . $this->seg_2;
			$this->registry->library('db')->execute($sql);
			if ($this->registry->library('db')->numRows() != 0)
			{
				$oneCat = array();
				$oneCat = $this->registry->library('db')->getRows();
				$newData = array();
				$newData['page_order'] = $oneCat['page_order'] - 3;
				$this->registry->library('db')->updateRecordsSys('static', $newData, 'page_id=' . $this->seg_2);
			}
// pages re-ordering
			$this->pagesReorder();
// pages list
			$pages_available = '';
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'static
			WHERE static_sys = "' . $this->sys_cms . '"
			ORDER BY page_order ASC';
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
			{
				$pages_available = 'y';
				$data = $this->registry->library('db')->rowsFromCache($cache);
				$html = $this->registry->library('helper')->adminPagesList($data);
			}
			$this->registry->library('template')->page()->addTag('admin_pages_list', $html);
			$this->registry->library('template')->page()->addTag('pages_available', $pages_available);
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('pages_text'));
			$cache = $this->registry->library('db')->cacheData($pages);
			$this->registry->library('template')->page()->addTag('static', array('DATA', $cache));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_pages_list.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function page_down()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->setting('settings_cms_title'));
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
// page movement
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'static
			WHERE page_id = ' . $this->seg_2;
			$this->registry->library('db')->execute($sql);
			if ($this->registry->library('db')->numRows() != 0)
			{
				$oneCat = array();
				$oneCat = $this->registry->library('db')->getRows();
				$newData = array();
				$newData['page_order'] = $oneCat['page_order'] + 3;
				$this->registry->library('db')->updateRecordsSys('static', $newData, 'page_id=' . $this->seg_2);
			}
// pages re-ordering
			$this->pagesReorder();
// pages list
			$pages_available = '';
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'static
			WHERE static_sys = "' . $this->sys_cms . '"
			ORDER BY page_order ASC';
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
			{
				$pages_available = 'y';
				$data = $this->registry->library('db')->rowsFromCache($cache);
				$html = $this->registry->library('helper')->adminPagesList($data);
			}
			$this->registry->library('template')->page()->addTag('admin_pages_list', $html);
			$this->registry->library('template')->page()->addTag('pages_available', $pages_available);
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('pages_text'));
			$cache = $this->registry->library('db')->cacheData($pages);
			$this->registry->library('template')->page()->addTag('static', array('DATA', $cache));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_pages_list.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function delete_opinion()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
// Caching OFF
			$this->registry->library('db')->setCacheOn(0);
			$product_id = $this->seg_2;
			$sql = sprintf("DELETE
			FROM `" . $this->prefix . "shop_opinions`
			WHERE shop_opinions_sys = \"" . $this->sys_cms . "\"
			AND `p_opinion_id` = %u LIMIT 1", $this->seg_3);
			$cache = $this->registry->library('db')->cacheQuery($sql);
// Restore CacheOn & Delete Cache
			$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
			if ($this->registry->setting('settings_cached') == 1)
			{
				$this->registry->library('db')->deleteCache('cache_', true);
			}
			$this->registry->redirectUser($this->registry->setting('settings_shop0') . '/viewproduct/' . $product_id, $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function delete_product()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
// Caching OFF
			$this->registry->library('db')->setCacheOn(0);
			$sql = sprintf("DELETE
			FROM `" . $this->prefix . "shop_opinions`
			WHERE shop_opinions_sys = \"" . $this->sys_cms . "\"
			AND `p_product_id` = %u", $this->seg_2);
			$cache = $this->registry->library('db')->cacheQuery($sql);
			$sql = sprintf("DELETE
			FROM `" . $this->prefix . "shop_products`
			WHERE shop_products_sys = \"" . $this->sys_cms . "\"
			AND `t_product_id` = %u LIMIT 1", $this->seg_2);
			$cache = $this->registry->library('db')->cacheQuery($sql);
// Restore CacheOn & Delete Cache
			$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
			if ($this->registry->setting('settings_cached') == 1)
			{
				$this->registry->library('db')->deleteCache('cache_', true);
			}
			$this->registry->redirectUser($this->registry->setting('settings_shop0'), $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function blocks_list()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->library('lang')->line('blocks_text'));
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$block_available = '';
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'blocks
			WHERE blocks_sys = "' . $this->sys_cms . '"
			ORDER BY block_order ASC';
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
			{
				$blocks_available = 'y';
				$data = $this->registry->library('db')->rowsFromCache($cache);
				$html = $this->registry->library('helper')->adminBlocksList($data);
			}
			$this->registry->library('template')->page()->addTag('admin_blocks_list', $html);
			$this->registry->library('template')->page()->addTag('blocks_available', $blocks_available);
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('blocks_text'));
			$cache = $this->registry->library('db')->cacheData($blocks);
			$this->registry->library('template')->page()->addTag('blocks', array('DATA', $cache));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_blocks_list.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function create_block()
	{
		$this->registry->library('template')->page()->addTag('error_message', '');
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->library('lang')->line('create_block'));
		$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('create_block'));
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'blocks
			WHERE blocks_sys = "' . $this->sys_cms . '"
			ORDER BY block_order ASC';
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
			{
				$data = $this->registry->library('db')->rowsFromCache($cache);
				$html = $this->registry->library('helper')->adminBlocksList($data);
			}
			$this->registry->library('template')->page()->addTag('admin_blocks_list', $html);
			$parentID = 0;
			$this->registry->library('template')->page()->addTag('parent_id', $parentID);
			$this->registry->library('template')->page()->addTag('block_title', '');
			$this->registry->library('template')->page()->addTag('block_order', '');
			$this->registry->library('template')->page()->addTag('block_description', '');
			$this->registry->library('template')->page()->addTag('block_content', '');
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_blocks_create.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function creating_block()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			if ($_POST['parent_id'] == '' || $_POST['block_title'] == '' || $_POST['block_order'] == '')
			{
				$this->registry->library('template')->page()->addTag('error_message', $this->registry->library('lang')->line('insufficient_data'));
				$this->registry->library('template')->page()->addTag('block_title', $_POST['block_title']);
				$this->registry->library('template')->page()->addTag('block_order', $_POST['block_order']);
				$this->registry->library('template')->page()->addTag('block_description', $_POST['block_description']);
				$block_content = str_replace('&', '&amp;', $_POST['block_content']);
				$this->registry->library('template')->page()->addTag('block_content', $block_content);
				$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_blocks_create.tpl', 'admin/admin_footer.tpl');
			}
			else
			{
// Caching OFF
				$this->registry->library('db')->setCacheOn(0);
				$data = array();
				$data['block_title'] = $this->registry->library('db')->sanitizeData($_POST['block_title']);
				$data['block_order'] = $this->registry->library('db')->sanitizeData($_POST['block_order']);
				$data['block_description'] = $this->registry->library('db')->sanitizeData($_POST['block_description']);
				$block_content = str_replace('&', '&amp;', $this->registry->library('db')->sanitizeData($_POST['block_content']));
				$data['block_content'] = $block_content;
				$this->registry->library('db')->insertRecordsSys('blocks', $data);
				$this->blocksReorder();
// Restore CacheOn & Delete Cache
				$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
				if ($this->registry->setting('settings_cached') == 1)
				{
					$this->registry->library('db')->deleteCache('cache_', true);
				}
			}
			$this->registry->redirectUser('admin/blocks_list', $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function blocksReorder()
	{
// category re-ordering
		$reorder = array();
		$reordering = array();
		$i = 1;
		$sql = 'SELECT *
			FROM ' . $this->prefix . 'blocks
			WHERE blocks_sys = "' . $this->sys_cms . '"
			ORDER BY block_order ASC';
		$old = $this->registry->library('db')->cacheQuery($sql);
		if ($this->registry->library('db')->numRowsFromCache($old) != 0)
		{
			$reorder = $this->registry->library('db')->rowsFromCache($old);
			foreach ($reorder as $k => $v)
			{
				$reordering['block_order'] = $i;
				$this->registry->library('db')->updateRecords('blocks', $reordering, 'block_id=' . $v['block_id']);
				$i = $i + 1;
			}
		}
	}

	function edit_block()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$this->registry->library('template')->page()->addTag('error_message', '');
			$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->library('lang')->line('edit_block'));
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('edit_block'));
			$sql = 'SELECT *
				FROM ' . $this->prefix . 'blocks
				WHERE block_id =' . $this->seg_2;
			$this->registry->library('db')->execute($sql);
			if ($this->registry->library('db')->numRows() != 0)
			{
				$data = $this->registry->library('db')->getRows();
				$this->registry->library('template')->page()->addTag('block_id', $data['block_id']);
				$skip_trigger = 0;
				$this->registry->library('template')->page()->addTag('block_title', $data['block_title']);
				$this->registry->library('template')->page()->addTag('block_order', $data['block_order']);
				$this->registry->library('template')->page()->addTag('block_description', $data['block_description']);
				$this->registry->library('template')->page()->addTag('block_content', $data['block_content']);
			}
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_blocks_edit.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	function editing_block()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$blockID = $this->registry->library('db')->sanitizeData($_POST['blockID']);
			$sql = 'SELECT *
				FROM ' . $this->prefix . 'blocks
				WHERE block_id =' . $blockID;
			$this->registry->library('db')->execute($sql);
			if ($this->registry->library('db')->numRows() != 0)
			{
				$data = $this->registry->library('db')->getRows();
				$this->registry->library('template')->page()->addTag('block_id', $data['block_id']);
			}
			$newData = array();
			$newData['block_id'] = $this->registry->library('db')->sanitizeData($_POST['blockID']);
			$newData['block_order'] = $this->registry->library('db')->sanitizeData($_POST['block_order']);
			$newData['block_title'] = $this->registry->library('db')->sanitizeData($_POST['block_title']);
			$newData['block_description'] = $this->registry->library('db')->sanitizeData($_POST['block_description']);
			$newData['block_content'] = $this->registry->library('db')->sanitizeData($_POST['block_content']);
			$newData['block_content'] = str_replace('&', '&amp;', $newData['block_content']);
			$this->registry->library('db')->updateRecords('blocks', $newData, 'block_id=' . $newData['block_id']);
			$this->registry->redirectUser('admin/edit_block/' . $newData['block_id'], $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function delete_block()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
// Caching OFF
			$this->registry->library('db')->setCacheOn(0);
			$sql = sprintf("DELETE
				FROM `" . $this->prefix . "blocks`
				WHERE blocks_sys = \"" . $this->sys_cms . "\"
				AND `block_id` = %u LIMIT 1", $this->seg_2);
			$cache = $this->registry->library('db')->cacheQuery($sql);
// Restore CacheOn & Delete Cache
			$this->registry->library('db')->setCacheOn($this->registry->setting('settings_cached'));
			if ($this->registry->setting('settings_cached') == 1)
			{
				$this->registry->library('db')->deleteCache('cache_', true);
			}
			$this->registry->redirectUser('admin/blocks_list', $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function block_up()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->library('lang')->line('blocks_text'));
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
// block movement
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'blocks
			WHERE block_id = ' . $this->seg_2;
			$this->registry->library('db')->execute($sql);
			if ($this->registry->library('db')->numRows() != 0)
			{
				$oneCat = array();
				$oneCat = $this->registry->library('db')->getRows();
				$newData = array();
				$newData['block_order'] = $oneCat['block_order'] - 3;
				$this->registry->library('db')->updateRecordsSys('blocks', $newData, 'block_id=' . $this->seg_2);
			}
// blocks re-ordering
			$this->blocksReorder();
// blocks list
			$blocks_available = '';
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'blocks
			WHERE blocks_sys = "' . $this->sys_cms . '"
			ORDER BY block_order ASC';
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
			{
				$blocks_available = 'y';
				$data = $this->registry->library('db')->rowsFromCache($cache);
				$html = $this->registry->library('helper')->adminBlocksList($data);
			}
			$this->registry->library('template')->page()->addTag('admin_blocks_list', $html);
			$this->registry->library('template')->page()->addTag('blocks_available', $blocks_available);
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('blocks_text'));
			$cache = $this->registry->library('db')->cacheData($blocks);
			$this->registry->library('template')->page()->addTag('blocks', array('DATA', $cache));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_blocks_list.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function block_down()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', $this->registry->library('lang')->line('blocks_text'));
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
// block movement
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'blocks
			WHERE block_id = ' . $this->seg_2;
			$this->registry->library('db')->execute($sql);
			if ($this->registry->library('db')->numRows() != 0)
			{
				$oneCat = array();
				$oneCat = $this->registry->library('db')->getRows();
				$newData = array();
				$newData['block_order'] = $oneCat['block_order'] + 3;
				$this->registry->library('db')->updateRecordsSys('blocks', $newData, 'block_id=' . $this->seg_2);
			}
// blocks re-ordering
			$this->blocksReorder();
// blocks list
			$blocks_available = '';
			$sql = 'SELECT *
			FROM ' . $this->prefix . 'blocks
			WHERE blocks_sys = "' . $this->sys_cms . '"
			ORDER BY block_order ASC';
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
			{
				$blocks_available = 'y';
				$data = $this->registry->library('db')->rowsFromCache($cache);
				$html = $this->registry->library('helper')->adminBlocksList($data);
			}
			$this->registry->library('template')->page()->addTag('admin_blocks_list', $html);
			$this->registry->library('template')->page()->addTag('blocks_available', $blocks_available);
			$this->registry->library('template')->page()->addTag('heading', $this->registry->library('lang')->line('blocks_text'));
			$cache = $this->registry->library('db')->cacheData($blocks);
			$this->registry->library('template')->page()->addTag('blocks', array('DATA', $cache));
			$this->registry->library('template')->build('admin/admin_header.tpl', 'admin/admin_blocks_list.tpl', 'admin/admin_footer.tpl');
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

}
?>