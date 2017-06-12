<?php

class I300{
	
	private $registry;
	private $prefix;
	private $cms_sys;
	private $seg_1;
	private $db_host;
	private $db_user;
	private $db_pass;
	private $db_name;
	
	public function __construct(Registry $registry, $directCall)
	{
		$this->registry = $registry;
		if($directCall == true)
		{
			$this->prefix = $this->registry->library('db')->getPrefix();
			$this->sys_cms = '1';

			include(APPPATH . 'config/config.php');
			if($config['db_prefix'] == '') { $prefix = NULL; }
			else { $prefix = $config['db_prefix']; }
			$registry->library('db')->newConnection($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name'], $prefix, $sys_cms);

			$this->db_host = $config['db_host'];
			$this->db_user = $config['db_user'];
			$this->db_pass = $config['db_pass'];
			$this->db_name = $config['db_name'];
			$this->prefix = $config['db_prefix'];

			$urlSegments = $this->registry->getURLSegments();
			$this->seg_1 = $this->registry->library('db')->sanitizeData($urlSegments[1]);

			$this->registry->library('template')->page()->addTag('charset', 'utf-8');

			$this->registry->library('template')->page()->addTag('name_text', 'User Name');
			$this->registry->library('template')->page()->addTag('pass_text', 'Password');

			$this->registry->library('template')->page()->addTag('fullname_text', 'Full Name');
			$this->registry->library('template')->page()->addTag('email_text', 'E-mail');
			$this->registry->library('template')->page()->addTag('ppemail_text', 'PayPal E-mail');

			if($_POST['processing'] != 'processing')
			{
				$this->index();
			}
			else
			{
				$this->processing();
			}
		}
	}

	private function index()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', 'SparkFrame Installation');
		$this->registry->library('template')->page()->addTag('heading', 'SparkFrame Installation');
		
		$this->registry->library('template')->page()->addTag('db_host_text', 'Database Host');
		$this->registry->library('template')->page()->addTag('db_user_text', 'Database User');
		$this->registry->library('template')->page()->addTag('db_pass_text', 'Database Password');
		$this->registry->library('template')->page()->addTag('db_name_text', 'Database Name');
		$this->registry->library('template')->page()->addTag('prefix_text', 'Database Table Prefix');
		$this->registry->library('template')->page()->addTag('sys_cms_text', 'CMS Number');
		
		$this->registry->library('template')->page()->addTag('db_host', $this->db_host);
		$this->registry->library('template')->page()->addTag('db_user', $this->db_user);
		$this->registry->library('template')->page()->addTag('db_pass', $this->db_pass);
		$this->registry->library('template')->page()->addTag('db_name', $this->db_name);
		$this->registry->library('template')->page()->addTag('prefix', $this->prefix);
		$this->registry->library('template')->page()->addTag('sys_cms', $this->sys_cms);
		
		$this->registry->library('template')->page()->addTag('stage', '1');

		$this->registry->library('template')->build('/admin/install.tpl');
	}


	private function processing()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', 'Processing');
		$this->registry->library('template')->page()->addTag('heading', 'Processing...');

		$this->registry->library('template')->page()->addTag('name', $_POST['name']);
		$this->registry->library('template')->page()->addTag('pass', $_POST['pass']);
		
		$this->registry->library('template')->page()->addTag('fullname', $_POST['fullname']);
		$this->registry->library('template')->page()->addTag('email', $_POST['email']);
		$this->registry->library('template')->page()->addTag('ppemail', $_POST['ppemail']);
		
		$this->registry->library('template')->page()->addTag('delete_install', 'DELETE INSTALL DIRECTORY');
		
		$this->registry->library('template')->page()->addTag('stage', '2');


$prefix = $this->prefix;

$name = $_POST['name'];
$pass = $_POST['pass'];
$fullname = $_POST['fname'];
$email = $_POST['email'];
$ppemail = $_POST['ppemail'];


$encripted_admin_password = md5($pass);
$datetime = date("Y-m-d H:i:s", time());
$year = date("Y", time());

$message = '';


$sql = "CREATE TABLE IF NOT EXISTS `{$prefix}articles` (
  `article_id` int(11) NOT NULL auto_increment,
  `author_id` int(11) NOT NULL,
  `title` varchar(255) character set utf8 collate utf8_unicode_ci default NULL,
  `url_title` varchar(200) character set utf8 collate utf8_unicode_ci default NULL,
  `article` text character set utf8 collate utf8_unicode_ci,
  `article_extended` text character set utf8 collate utf8_unicode_ci,
  `art_tags` text character set utf8 collate utf8_unicode_ci,
  `art_created` datetime NOT NULL default '0000-00-00 00:00:00',
  `art_updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `categories` varchar(255) default NULL,
  `allow_comments` enum('0','1') character set utf8 collate utf8_unicode_ci NOT NULL default '1',
  `close_comments` enum('o','c') character set utf8 collate utf8_unicode_ci NOT NULL default 'o',
  `pinned` enum('0','1') character set utf8 collate utf8_unicode_ci NOT NULL default '0',
  `status` enum('d','p') character set utf8 collate utf8_unicode_ci NOT NULL default 'p',
  `article_visible` enum('0','1') character set utf8 collate utf8_unicode_ci NOT NULL default '1',
  `articles_sys` varchar(10) character set utf8 collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`article_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$this->registry->library('db')->execute($sql);

$message .= "1. Table successfully created.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('admin/install.tpl');



$sql = "CREATE TABLE IF NOT EXISTS `{$prefix}art_cats` (
  `ac_art_id` bigint(20) NOT NULL,
  `ac_cats_id` bigint(20) NOT NULL,
  `art_cats_sys` varchar(10) character set utf8 collate utf8_unicode_ci NOT NULL,
  KEY `ac_art_id` (`ac_art_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$this->registry->library('db')->execute($sql);

$message .= "2. Table successfully created.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('admin/install.tpl');



$sql = "CREATE TABLE IF NOT EXISTS `{$prefix}categories` (
  `category_id` int(11) NOT NULL auto_increment,
  `parent_id` int(9) NOT NULL,
  `category_name` varchar(100) character set utf8 collate utf8_unicode_ci default NULL,
  `category_order` int(9) NOT NULL,
  `category_url_name` varchar(200) character set utf8 collate utf8_unicode_ci default NULL,
  `category_description` varchar(200) character set utf8 collate utf8_unicode_ci default NULL,
  `category_image_name` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL,
  `categories_sys` varchar(10) character set utf8 collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$this->registry->library('db')->execute($sql);

$message .= "3. Table successfully created.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('admin/install.tpl');



$sql = "CREATE TABLE IF NOT EXISTS `{$prefix}categories_file` (
  `cat_file_id` int(11) NOT NULL auto_increment,
  `parent_file_id` int(11) NOT NULL,
  `cat_file_name` varchar(100) character set utf8 collate utf8_unicode_ci default NULL,
  `cat_file_order` int(9) NOT NULL,
  `cat_file_url_name` varchar(200) default NULL,
  `cat_file_description` varchar(200) default NULL,
  `cat_file_image_name` varchar(255) NOT NULL,
  `cat_file_sys` varchar(10) character set utf8 collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`cat_file_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$this->registry->library('db')->execute($sql);

$message .= "4. Table successfully created.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('admin/install.tpl');



$sql = "CREATE TABLE IF NOT EXISTS `{$prefix}categories_image` (
  `cat_image_id` int(11) NOT NULL auto_increment,
  `parent_image_id` int(11) NOT NULL,
  `cat_image_name` varchar(100) character set utf8 collate utf8_unicode_ci default NULL,
  `cat_image_order` int(9) NOT NULL,
  `cat_image_url_name` varchar(200) default NULL,
  `cat_image_description` varchar(200) default NULL,
  `cat_image_image_name` varchar(255) NOT NULL,
  `cat_image_sys` varchar(10) character set utf8 collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`cat_image_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$this->registry->library('db')->execute($sql);

$message .= "5. Table successfully created.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('admin/install.tpl');



$sql = "CREATE TABLE IF NOT EXISTS `{$prefix}comments` (
  `comment_id` int(11) NOT NULL auto_increment,
  `com_article_id` int(11) NOT NULL,
  `user_id` int(11) default NULL,
  `author` varchar(100) character set utf8 collate utf8_unicode_ci default NULL,
  `author_email` varchar(100) character set utf8 collate utf8_unicode_ci default NULL,
  `author_website` varchar(200) character set utf8 collate utf8_unicode_ci default NULL,
  `author_ip` varchar(100) character set utf8 collate utf8_unicode_ci NOT NULL,
  `body` text character set utf8 collate utf8_unicode_ci,
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `comment_approved` enum('y','n') character set utf8 collate utf8_unicode_ci NOT NULL default 'y',
  `comment_visible` enum('y','n') character set utf8 collate utf8_unicode_ci NOT NULL default 'y',
  `comments_sys` varchar(10) character set utf8 collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`comment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$this->registry->library('db')->execute($sql);

$message .= "6. Table successfully created.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('admin/install.tpl');



$sql = "CREATE TABLE IF NOT EXISTS `{$prefix}c_fields` (
  `c_fields_id` int(11) NOT NULL auto_increment,
  `c_name_id` int(11) NOT NULL,
  `c_body` text NOT NULL,
  `c_art_id` int(11) NOT NULL,
  `c_fields_sys` varchar(10) character set utf8 collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`c_fields_id`),
  KEY `c_art_id` (`c_art_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;";

$this->registry->library('db')->execute($sql);

$message .= "7. Table successfully created.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('admin/install.tpl');



$sql = "CREATE TABLE IF NOT EXISTS `{$prefix}c_fields_created` (
  `c_created_id` int(11) NOT NULL auto_increment,
  `c_created_name` varchar(100) NOT NULL,
  `c_created_url_title` varchar(100) default NULL,
  `c_created_description` text NOT NULL,
  `c_created_type` tinyint(4) NOT NULL,
  `c_created_site_section` varchar(50) NOT NULL,
  `c_created_obligatory` enum('y','n') NOT NULL default 'n',
  `c_type_default_value` text NOT NULL,
  `c_fields_created_sys` varchar(10) character set utf8 collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`c_created_id`),
  KEY `c_created_site_section` (`c_created_site_section`),
  KEY `c_created_type` (`c_created_type`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$this->registry->library('db')->execute($sql);

$message .= "8. Table successfully created.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('admin/install.tpl');



$sql = "CREATE TABLE IF NOT EXISTS `{$prefix}c_fields_types` (
  `c_types_id` tinyint(4) NOT NULL auto_increment,
  `c_type_name` varchar(100) NOT NULL,
  PRIMARY KEY  (`c_types_id`),
  UNIQUE KEY `c_type_name` (`c_type_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;";

$this->registry->library('db')->execute($sql);

$sql = "INSERT INTO `{$prefix}c_fields_types` (`c_types_id`, `c_type_name`) VALUES
(1, 'input'),
(2, 'textarea'),
(3, 'list');";

$this->registry->library('db')->execute($sql);

$message .= "9. Table successfully created.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('admin/install.tpl');



$sql = "CREATE TABLE IF NOT EXISTS `{$prefix}extensions` (
  `ext_id` int(11) NOT NULL auto_increment,
  `ext_name` varchar(100) NOT NULL,
  `ext_description` text NOT NULL,
  `ext_version` varchar(20) NOT NULL,
  `ext_order` tinyint(1) NOT NULL,
  `ext_file_name` varchar(100) NOT NULL,
  `ext_hook` varchar(100) character set utf8 collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`ext_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$this->registry->library('db')->execute($sql);

$message .= "10. Table successfully created.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('admin/install.tpl');



$sql = "CREATE TABLE IF NOT EXISTS `{$prefix}files` (
  `file_id` int(11) NOT NULL auto_increment,
  `file_name` varchar(255) default NULL,
  `file_url` varchar(255) default NULL,
  `file_image_url` varchar(255) default NULL,
  `file_description` varchar(255) default NULL,
  `file_visible` enum('yes','no') default 'yes',
  `file_date_add` datetime NOT NULL,
  `file_download_count` bigint(20) NOT NULL,
  `file_cat` int(11) default NULL,
  `dl_protection` varchar(255) NOT NULL,
  `dl_datetime` datetime NOT NULL,
  `files_sys` varchar(10) character set utf8 collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`file_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$this->registry->library('db')->execute($sql);

$message .= "11. Table successfully created.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('admin/install.tpl');



$sql = "CREATE TABLE IF NOT EXISTS `{$prefix}forums` (
  `f_forum_id` int(6) unsigned NOT NULL auto_increment,
  `f_name` varchar(100) NOT NULL,
  `f_description` text NOT NULL,
  `f_order` int(6) unsigned NOT NULL,
  `f_level` int(9) NOT NULL,
  `f_status` char(1) NOT NULL default 'o',
  `f_total_topics` mediumint(8) NOT NULL default '0',
  `f_total_posts` mediumint(8) NOT NULL default '0',
  `f_last_post_id` int(6) unsigned NOT NULL,
  `f_last_post_type` char(1) NOT NULL default 'p',
  `f_last_post_title` varchar(150) NOT NULL,
  `f_last_post_date` int(10) unsigned NOT NULL default '0',
  `f_last_post_user_id` int(10) unsigned NOT NULL default '0',
  `f_last_post_author` varchar(50) NOT NULL,
  `f_topics_per_page` smallint(4) NOT NULL,
  `f_posts_per_page` smallint(4) NOT NULL,
  `f_forum_visible` enum('y','n') NOT NULL default 'y',
  `forums_sys` varchar(10) character set utf8 collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`f_forum_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$this->registry->library('db')->execute($sql);

$message .= "12. Table successfully created.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('admin/install.tpl');



$sql = "CREATE TABLE IF NOT EXISTS `{$prefix}forum_posts` (
  `p_post_id` int(11) unsigned NOT NULL auto_increment,
  `p_topic_id` int(11) unsigned NOT NULL,
  `p_forum_id` int(6) unsigned NOT NULL,
  `p_user_id` int(10) unsigned NOT NULL default '0',
  `p_ip_address` varchar(16) NOT NULL,
  `p_body` text NOT NULL,
  `p_post_date` datetime NOT NULL,
  `p_post_edit_date` datetime NOT NULL,
  `p_post_edit_author` int(10) unsigned NOT NULL default '0',
  `p_notify` char(1) NOT NULL default 'n',
  `p_post_visible` enum('y','n') NOT NULL default 'y',
  `forum_posts_sys` varchar(10) character set utf8 collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`p_post_id`),
  KEY `topic_id` (`p_topic_id`),
  KEY `forum_id` (`p_forum_id`),
  KEY `user_id` (`p_user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$this->registry->library('db')->execute($sql);

$message .= "13. Table successfully created.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('admin/install.tpl');



$sql = "CREATE TABLE IF NOT EXISTS `{$prefix}forum_topics` (
  `t_topic_id` int(11) unsigned NOT NULL auto_increment,
  `t_forum_id` int(6) unsigned NOT NULL,
  `t_moved_to` int(6) unsigned default NULL,
  `t_user_id` int(10) unsigned NOT NULL default '0',
  `t_ip_address` varchar(16) NOT NULL,
  `t_title` varchar(150) NOT NULL,
  `t_body` text NOT NULL,
  `t_status` char(1) NOT NULL default 'o',
  `t_pinned` char(1) NOT NULL default 'n',
  `t_announcement` char(1) NOT NULL default 'n',
  `t_topic_date` datetime NOT NULL,
  `t_topic_edit_date` datetime NOT NULL,
  `t_thread_total` int(5) unsigned NOT NULL default '0',
  `t_thread_views` int(6) unsigned NOT NULL default '0',
  `t_last_post_date` datetime NOT NULL,
  `t_last_post_user_id` int(10) unsigned NOT NULL default '0',
  `t_last_post_id` int(10) unsigned NOT NULL default '0',
  `t_notify` char(1) NOT NULL default 'n',
  `t_topic_visible` enum('y','n') NOT NULL default 'y',
  `forum_topics_sys` varchar(10) character set utf8 collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`t_topic_id`),
  KEY `forum_id` (`t_forum_id`),
  KEY `user_id` (`t_user_id`),
  KEY `last_post_user_id` (`t_last_post_user_id`),
  KEY `topic_date` (`t_topic_date`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$this->registry->library('db')->execute($sql);

$message .= "14. Table successfully created.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('admin/install.tpl');



$sql = "CREATE TABLE IF NOT EXISTS `{$prefix}images` (
  `image_id` int(11) NOT NULL auto_increment,
  `image_title` varchar(100) NOT NULL,
  `image_file_name` varchar(255) NOT NULL,
  `image_thumb_name` varchar(255) NOT NULL,
  `image_description` varchar(255) default NULL,
  `image_visible` enum('yes','no') default 'yes',
  `image_date_add` datetime NOT NULL,
  `image_cat` int(11) default NULL,
  `image_sys` varchar(10) character set utf8 collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`image_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$this->registry->library('db')->execute($sql);

$message .= "15. Table successfully created.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('admin/install.tpl');



$sql = "CREATE TABLE IF NOT EXISTS `{$prefix}modules` (
  `mod_id` int(11) NOT NULL auto_increment,
  `mod_name` varchar(100) NOT NULL,
  `mod_description` text NOT NULL,
  `mod_version` varchar(20) NOT NULL,
  `mod_enabled` tinyint(1) NOT NULL,
  `mod_file_name` varchar(100) NOT NULL,
  PRIMARY KEY  (`mod_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$this->registry->library('db')->execute($sql);

$message .= "16. Table successfully created.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('admin/install.tpl');



$sql = "CREATE TABLE IF NOT EXISTS `{$prefix}paypal_trans` (
  `trans_id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `username` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_name` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL,
  `amount` float(10,2) unsigned default NULL,
  `currency` varchar(3) character set utf8 collate utf8_unicode_ci NOT NULL,
  `trans_unixtime` int(11) NOT NULL,
  `paypal_trans_sys` varchar(10) character set utf8 collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`trans_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$this->registry->library('db')->execute($sql);

$message .= "17. Table successfully created.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('admin/install.tpl');



$sql = "CREATE TABLE IF NOT EXISTS `{$prefix}permissions` (
  `perm_id` bigint(20) unsigned NOT NULL auto_increment,
  `perm_key` varchar(30) character set utf8 collate utf8_unicode_ci NOT NULL,
  `perm_name` varchar(30) character set utf8 collate utf8_unicode_ci NOT NULL,
  `perm_locked` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`perm_id`),
  UNIQUE KEY `permKey` (`perm_key`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;";

$this->registry->library('db')->execute($sql);

$sql = "INSERT INTO `{$prefix}permissions` (`perm_id`, `perm_key`, `perm_name`, `perm_locked`) VALUES
(1, 'access_site', 'Access Site', '1'),
(2, 'access_admin', 'Access Admin System', '1'),
(3, 'publish_articles', 'Publish Articles', '1'),
(4, 'publish_events', 'Publish Events', '1'),
(5, 'install_modules', 'Install Modules', '1'),
(6, 'post_comments', 'Post Comments', '1'),
(7, 'access_premium_content', 'Access Premium Content', '1'),
(8, 'limited_admin', 'Limited Admin', '1');";

$this->registry->library('db')->execute($sql);

$message .= "18. Table successfully created.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('admin/install.tpl');



$sql = "CREATE TABLE IF NOT EXISTS `{$prefix}roles` (
  `roles_id` bigint(20) unsigned NOT NULL auto_increment,
  `roles_name` varchar(50) character set utf8 collate utf8_unicode_ci NOT NULL,
  `roles_locked` enum('0','1') character set utf8 collate utf8_unicode_ci NOT NULL default '0',
  PRIMARY KEY  (`roles_id`),
  UNIQUE KEY `roleName` (`roles_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;";

$this->registry->library('db')->execute($sql);

$sql = "INSERT INTO `{$prefix}roles` (`roles_id`, `roles_name`, `roles_locked`) VALUES
(1, 'Administrators', '1'),
(2, 'Registered Users', '1'),
(3, 'Authors', '1'),
(4, 'Premium Subscribers', '1'),
(5, 'Users Awaiting Email Confirmation', '1'),
(6, 'Banned', '1');";

$this->registry->library('db')->execute($sql);

$message .= "19. Table successfully created.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('admin/install.tpl');



$sql = "CREATE TABLE IF NOT EXISTS `{$prefix}role_perms` (
  `rp_id` bigint(20) unsigned NOT NULL auto_increment,
  `rp_role_id` bigint(20) NOT NULL,
  `rp_perm_id` bigint(20) NOT NULL,
  `rp_value` tinyint(1) NOT NULL default '0',
  `rp_add_date` datetime NOT NULL,
  PRIMARY KEY  (`rp_id`),
  UNIQUE KEY `roleID_2` (`rp_role_id`,`rp_perm_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$this->registry->library('db')->execute($sql);

$message .= "20. Table successfully created.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('admin/install.tpl');



$sql = "CREATE TABLE IF NOT EXISTS `{$prefix}settings` (
  `settings_id` int(11) NOT NULL auto_increment,
  `settings_sys` varchar(255) collate utf8_unicode_ci NOT NULL,
  `settings_metakeywords` varchar(255) collate utf8_unicode_ci NOT NULL,
  `settings_metadescription` varchar(255) collate utf8_unicode_ci NOT NULL,
  `settings_charset` varchar(255) collate utf8_unicode_ci NOT NULL default 'utf-8',
  `settings_lang` varchar(12) collate utf8_unicode_ci NOT NULL default 'en',
  `settings_lang_full` varchar(50) collate utf8_unicode_ci NOT NULL default 'english',
  `settings_cached` enum('0','1') collate utf8_unicode_ci NOT NULL default '0',
  `settings_rows_per_page` tinyint(4) NOT NULL default '20',
  `settings_shop_rows_per_page` tinyint(4) NOT NULL,
  `settings_users_per_page` tinyint(4) NOT NULL,
  `settings_nested_categories` enum('0','1') collate utf8_unicode_ci NOT NULL default '1',
  `settings_shop_nested_categories` enum('0','1') collate utf8_unicode_ci NOT NULL default '0',
  `settings_comments_per_page` tinyint(4) NOT NULL,
  `settings_enable_registration` enum('0','1') collate utf8_unicode_ci NOT NULL default '1',
  `settings_owner_name` varchar(100) collate utf8_unicode_ci NOT NULL,
  `settings_admin_email` varchar(100) collate utf8_unicode_ci NOT NULL,
  `settings_seller_email` varchar(100) collate utf8_unicode_ci NOT NULL,
  `settings_forum_topics_per_page` tinyint(4) NOT NULL,
  `settings_forum_posts_per_page` tinyint(4) NOT NULL,
  `settings_cron` datetime NOT NULL,
  `settings_notes` text collate utf8_unicode_ci,
  `settings_email_registration` enum('y','n') collate utf8_unicode_ci NOT NULL default 'y',
  `settings_comments_tree` enum('y','n') collate utf8_unicode_ci NOT NULL default 'n',
  `settings_cron_enabled` enum('y','n') collate utf8_unicode_ci NOT NULL default 'n',
  `settings_cron_period` int(9) NOT NULL,
  `settings_cms_enabled` enum('y','n') collate utf8_unicode_ci NOT NULL default 'n',
  `settings_cms_message` text collate utf8_unicode_ci,
  `settings_dl_period` int(9) NOT NULL,
  `settings_banned_emails` text collate utf8_unicode_ci NOT NULL,
  `settings_ban_masks` enum('y','n') collate utf8_unicode_ci NOT NULL default 'n',
  `settings_cms_title` varchar(100) collate utf8_unicode_ci NOT NULL,
  `settings_cms_description` varchar(255) collate utf8_unicode_ci NOT NULL,
  `settings_site0` varchar(50) collate utf8_unicode_ci NOT NULL,
  `settings_enable_comments` enum('0','1') collate utf8_unicode_ci NOT NULL default '0',
  `settings_forum0` varchar(50) collate utf8_unicode_ci NOT NULL,
  `settings_shop0` varchar(50) collate utf8_unicode_ci NOT NULL,
  `settings_paypal_sandbox` enum('0','1') collate utf8_unicode_ci NOT NULL default '0',
  `settings_one_cat` enum('0','1') collate utf8_unicode_ci NOT NULL default '1',
  `settings_guests_allowed` enum('0','1') collate utf8_unicode_ci NOT NULL default '1',
  `settings_guests_comments_allowed` enum('0','1') collate utf8_unicode_ci NOT NULL default '0',
  `settings_start_seg_1` varchar(255) collate utf8_unicode_ci NOT NULL,
  `settings_jquery` varchar(20) collate utf8_unicode_ci NOT NULL,
  `settings_startyear` int(4) NOT NULL,
  `settings_st_header` varchar(100) collate utf8_unicode_ci NOT NULL default 'header',
  `settings_st_main` varchar(100) collate utf8_unicode_ci NOT NULL default 'static',
  `settings_st_footer` varchar(100) collate utf8_unicode_ci NOT NULL default 'footer',
  `menuhide` enum('y','n') character set utf8 collate utf8_unicode_ci NOT NULL default 'n',
  PRIMARY KEY  (`settings_id`),
  UNIQUE KEY `settings_page` (`settings_sys`),
  UNIQUE KEY `settings_sys` (`settings_sys`),
  KEY `settings_sys_2` (`settings_sys`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;";

$this->registry->library('db')->execute($sql);

$sql = "INSERT INTO `{$prefix}settings` (`settings_id`, `settings_sys`, `settings_metakeywords`, `settings_metadescription`, `settings_charset`, `settings_lang`, `settings_lang_full`, `settings_cached`, `settings_rows_per_page`, `settings_shop_rows_per_page`, `settings_users_per_page`, `settings_nested_categories`, `settings_shop_nested_categories`, `settings_comments_per_page`, `settings_enable_registration`, `settings_owner_name`, `settings_admin_email`, `settings_seller_email`, `settings_forum_topics_per_page`, `settings_forum_posts_per_page`, `settings_cron`, `settings_notes`, `settings_email_registration`, `settings_comments_tree`, `settings_cron_enabled`, `settings_cron_period`, `settings_cms_enabled`, `settings_cms_message`, `settings_dl_period`, `settings_banned_emails`, `settings_ban_masks`, `settings_cms_title`, `settings_cms_description`, `settings_site0`, `settings_enable_comments`, `settings_forum0`, `settings_shop0`, `settings_paypal_sandbox`, `settings_one_cat`, `settings_guests_allowed`, `settings_guests_comments_allowed`, `settings_start_seg_1`, `settings_jquery`, `settings_startyear`, `settings_st_header`, `settings_st_main`, `settings_st_footer`, `menuhide`) VALUES
(1, '1', 'cms', 'CMS', 'utf-8', 'en', 'english', '0', 7, 10, 20, '1', '0', 0, '1', '{$fullname}', '{$email}', '{$ppemail}', 7, 7, '{$datetime}', '', 'y', 'n', 'n', 86400, 'y', 'Offline', 300, '', 'n', 'WebSite', 'website', 'site', '1', 'forum', 'shop', '1', '0', '1', '0', '', 'jquery-1.4.2.min.js', {$year}, 'header', 'static', 'footer', 'n');";

$this->registry->library('db')->execute($sql);

$message .= "21. Table successfully created.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('admin/install.tpl');



$sql = "CREATE TABLE IF NOT EXISTS `{$prefix}shops` (
  `f_shop_id` int(11) unsigned NOT NULL auto_increment,
  `f_parent_shop_id` int(11) NOT NULL,
  `f_name` varchar(100) NOT NULL,
  `f_url_name` varchar(100) NOT NULL,
  `f_description` text NOT NULL,
  `f_order` int(6) unsigned NOT NULL,
  `f_status` char(1) NOT NULL default 'o',
  `f_total_departtments` mediumint(8) NOT NULL default '0',
  `f_total_opinions` mediumint(8) NOT NULL default '0',
  `f_last_opinion_id` int(6) unsigned NOT NULL,
  `f_last_opinion_type` char(1) NOT NULL default 'p',
  `f_last_opinion_title` varchar(150) NOT NULL,
  `p_opinion_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `f_last_opinion_user_id` int(10) unsigned NOT NULL default '0',
  `f_last_opinion_author` varchar(50) NOT NULL,
  `f_articles_per_page` smallint(4) NOT NULL,
  `f_opinions_per_page` smallint(4) NOT NULL,
  `f_shop_visible` enum('yes','no') NOT NULL default 'yes',
  `shops_sys` varchar(10) character set utf8 collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`f_shop_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;";

$this->registry->library('db')->execute($sql);

$message .= "22. Table successfully created.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('admin/install.tpl');



$sql = "CREATE TABLE IF NOT EXISTS `{$prefix}shop_opinions` (
  `p_opinion_id` int(11) unsigned NOT NULL auto_increment,
  `p_product_id` int(11) unsigned NOT NULL,
  `p_shop_id` int(6) unsigned NOT NULL,
  `p_user_id` int(10) unsigned NOT NULL default '0',
  `p_ip_address` varchar(16) NOT NULL,
  `p_body` text NOT NULL,
  `p_opinion_date` int(10) NOT NULL,
  `p_opinion_edit_date` int(10) NOT NULL default '0',
  `p_opinion_edit_author` int(10) unsigned NOT NULL default '0',
  `p_notify` char(1) NOT NULL default 'n',
  `p_opinion_visible` enum('yes','no') NOT NULL default 'yes',
  `shop_opinions_sys` varchar(10) character set utf8 collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`p_opinion_id`),
  KEY `article_id` (`p_product_id`),
  KEY `shop_id` (`p_shop_id`),
  KEY `user_id` (`p_user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;";

$this->registry->library('db')->execute($sql);

$message .= "23. Table successfully created.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('admin/install.tpl');



$sql = "CREATE TABLE IF NOT EXISTS `{$prefix}shop_products` (
  `t_product_id` int(11) unsigned NOT NULL auto_increment,
  `t_shop_id` int(6) unsigned NOT NULL,
  `t_price` float(10,2) unsigned default NULL,
  `t_user_id` int(10) unsigned NOT NULL default '0',
  `t_ip_address` varchar(16) NOT NULL,
  `t_title` varchar(150) NOT NULL,
  `t_body` text NOT NULL,
  `t_status` char(1) NOT NULL default 'o',
  `t_pinned` char(1) NOT NULL default 'n',
  `t_announcement` char(1) NOT NULL default 'n',
  `t_product_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `t_thread_total` int(5) unsigned NOT NULL default '0',
  `t_thread_views` int(6) unsigned NOT NULL default '0',
  `t_last_opinion_date` int(10) unsigned NOT NULL default '0',
  `t_last_opinion_user_id` int(10) unsigned NOT NULL default '0',
  `t_last_opinion_id` int(10) unsigned NOT NULL default '0',
  `t_notify` char(1) NOT NULL default 'n',
  `t_product_visible` enum('yes','no') NOT NULL default 'yes',
  `t_filename` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL,
  `shop_products_sys` varchar(10) character set utf8 collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`t_product_id`),
  KEY `shop_id` (`t_shop_id`),
  KEY `user_id` (`t_user_id`),
  KEY `last_opinion_user_id` (`t_last_opinion_user_id`),
  KEY `article_date` (`t_product_date`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;";

$this->registry->library('db')->execute($sql);

$message .= "24. Table successfully created.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('admin/install.tpl');



$sql = "CREATE TABLE IF NOT EXISTS `{$prefix}static` (
  `page_id` int(11) NOT NULL auto_increment,
  `parent_id` int(9) NOT NULL,
  `page_order` int(9) NOT NULL,
  `page_url_1` varchar(200) NOT NULL,
  `page_url_2` varchar(200) NOT NULL,
  `page_url_3` varchar(200) NOT NULL,
  `page_url_4` varchar(200) NOT NULL,
  `page_url_5` varchar(200) NOT NULL,
  `page_url_6` varchar(200) NOT NULL,
  `page_url_7` varchar(200) NOT NULL,
  `page_url_8` varchar(200) NOT NULL,
  `page_title` varchar(200) character set utf8 collate utf8_unicode_ci default NULL,
  `page_description` varchar(200) character set utf8 collate utf8_unicode_ci default NULL,
  `page_content` text character set utf8 collate utf8_unicode_ci,
  `static_sys` varchar(10) character set utf8 collate utf8_unicode_ci NOT NULL,
  `web_url` varchar(250) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `st_header` varchar(100) character set utf8 collate utf8_unicode_ci NOT NULL default 'header',
  `st_main` varchar(100) character set utf8 collate utf8_unicode_ci NOT NULL default 'static',
  `st_footer` varchar(100) character set utf8 collate utf8_unicode_ci NOT NULL default 'footer',
  PRIMARY KEY  (`page_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$this->registry->library('db')->execute($sql);

$message .= "25. Table successfully created.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('admin/install.tpl');


$sql = "CREATE TABLE IF NOT EXISTS `{$prefix}users` (
  `users_id` int(11) NOT NULL auto_increment,
  `username` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL,
  `user_created` datetime NOT NULL default '0000-00-00 00:00:00',
  `password` varchar(40) character set utf8 collate utf8_unicode_ci NOT NULL,
  `email` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL default '0',
  `admin` tinyint(1) NOT NULL default '0',
  `banned` tinyint(1) NOT NULL default '0',
  `pwd_reset_key` varchar(40) character set utf8 collate utf8_unicode_ci NOT NULL,
  `name` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`users_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=63 ;";

$this->registry->library('db')->execute($sql);

$sql = "INSERT INTO `{$prefix}users` (`users_id`, `username`, `user_created`, `password`, `email`, `active`, `admin`, `banned`, `pwd_reset_key`, `name`) VALUES
(1, '{$name}', '{$datetime}', '{$encripted_admin_password}', '{$email}', 1, 1, 0, '', '{$fullname}');";

$this->registry->library('db')->execute($sql);

$message .= "26. Table successfully created.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('admin/install.tpl');



$sql = "CREATE TABLE IF NOT EXISTS `{$prefix}user_perms` (
  `up_id` bigint(20) unsigned NOT NULL auto_increment,
  `up_user_id` bigint(20) NOT NULL,
  `up_perm_id` bigint(20) NOT NULL,
  `up_value` tinyint(1) NOT NULL default '0',
  `up_add_date` datetime NOT NULL,
  PRIMARY KEY  (`up_id`),
  UNIQUE KEY `userID` (`up_user_id`,`up_perm_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

$this->registry->library('db')->execute($sql);

$message .= "27. Table successfully created.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('admin/install.tpl');


$sql = "CREATE TABLE IF NOT EXISTS `{$prefix}user_roles` (
  `ur_id` bigint(20) NOT NULL,
  `ur_role_id` bigint(20) NOT NULL,
  `ur_add_date` datetime NOT NULL,
  UNIQUE KEY `userID` (`ur_id`,`ur_role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$this->registry->library('db')->execute($sql);

$message .= "28. Table successfully created.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/install.tpl');


// 201
$sql = "CREATE TABLE IF NOT EXISTS `{$prefix}cms` (
  `cms_id` int(11) NOT NULL auto_increment,
  `ver` int(3) NOT NULL default '200',
  PRIMARY KEY  (`cms_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;";
$this->registry->library('db')->execute($sql);

$sql = "INSERT INTO `{$prefix}cms` (`cms_id`, `ver`) VALUES (1, 300);";
$this->registry->library('db')->execute($sql);
$message .= "Tables updated from 2.0.0 to 2.0.1.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/install.tpl');

// 202
$sql = "UPDATE `{$prefix}cms` SET ver='202' WHERE cms_id='1'";
$this->registry->library('db')->execute($sql);
$message .= "Tables updated from 2.0.1 to 2.0.2.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/install.tpl');

// 203
$sql = "UPDATE `{$prefix}cms` SET ver='203' WHERE cms_id='1'";
$this->registry->library('db')->execute($sql);
$message .= "Tables updated from 2.0.2 to 2.0.3.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/install.tpl');

// 204
$sql = "UPDATE `{$prefix}cms` SET ver='204' WHERE cms_id='1'";
$this->registry->library('db')->execute($sql);
$message .= "Tables updated from 2.0.3 to 2.0.4.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/install.tpl');

// 205
$sql = "UPDATE `{$prefix}cms` SET ver='205' WHERE cms_id='1'";
$this->registry->library('db')->execute($sql);
$message .= "Tables updated from 2.0.4 to 2.0.5.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/install.tpl');

// 206
$sql = "UPDATE `{$prefix}cms` SET ver='206' WHERE cms_id='1'";
$this->registry->library('db')->execute($sql);
$message .= "Tables updated from 2.0.5 to 2.0.6.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/install.tpl');

// 207
$sql = "ALTER TABLE `{$prefix}settings` ADD `spam_api_key` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL";
$this->registry->library('db')->execute($sql);
$sql = "ALTER TABLE `{$prefix}comments` ADD `spam` ENUM( 'y', 'n' ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n' AFTER `comment_visible`";
$this->registry->library('db')->execute($sql);

$sql = "UPDATE `{$prefix}cms` SET ver='207' WHERE cms_id='1'";
$this->registry->library('db')->execute($sql);
$message .= "Tables updated from 2.0.6 to 2.0.7.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/install.tpl');

// 208
$sql = "UPDATE `{$prefix}cms` SET ver='208' WHERE cms_id='1'";
$this->registry->library('db')->execute($sql);
$message .= "Tables updated from 2.0.7 to 2.0.8.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/install.tpl');

// 209
$sql = "UPDATE `{$prefix}cms` SET ver='209' WHERE cms_id='1'";
$this->registry->library('db')->execute($sql);
$message .= "Tables updated from 2.0.8 to 2.0.9.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/install.tpl');

// 210
$sql = "UPDATE `{$prefix}cms` SET ver='210' WHERE cms_id='1'";
$this->registry->library('db')->execute($sql);
$message .= "Tables updated from 2.0.9 to 2.1.0.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/install.tpl');

// 211
$sql = "ALTER TABLE `{$prefix}settings` ADD `pp_av` ENUM( 'y', 'n' ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n'";
$this->registry->library('db')->execute($sql);
$sql = "ALTER TABLE `{$prefix}settings` ADD `cart_av` ENUM( 'y', 'n' ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n'";
$this->registry->library('db')->execute($sql);

$sql = "UPDATE `{$prefix}cms` SET ver='211' WHERE cms_id='1'";
$this->registry->library('db')->execute($sql);
$message .= "Tables updated from 2.1.0 to 2.1.1.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/install.tpl');

// 212
$sql = "UPDATE `{$prefix}cms` SET ver='212' WHERE cms_id='1'";
$this->registry->library('db')->execute($sql);
$message .= "Tables updated from 2.1.1 to 2.1.2.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/install.tpl');

// 213
$sql = "UPDATE `{$prefix}cms` SET ver='213' WHERE cms_id='1'";
$this->registry->library('db')->execute($sql);
$message .= "Tables updated from 2.1.2 to 2.1.3.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/install.tpl');

// 214
$sql = "ALTER TABLE `{$prefix}settings` ADD `settings_editor` ENUM( 'n', 't', 'c' ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 't'";
$this->registry->library('db')->execute($sql);

$sql = "UPDATE `{$prefix}cms` SET ver='214' WHERE cms_id='1'";
$this->registry->library('db')->execute($sql);
$message .= "Tables updated from 2.1.3 to 2.1.4.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/install.tpl');

// 215
$sql = "UPDATE `{$prefix}cms` SET ver='215' WHERE cms_id='1'";
$this->registry->library('db')->execute($sql);
$message .= "Tables updated from 2.1.4 to 2.1.5.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/install.tpl');

// 216
$sql = "UPDATE `{$prefix}cms` SET ver='216' WHERE cms_id='1'";
$this->registry->library('db')->execute($sql);
$message .= "Tables updated from 2.1.5 to 2.1.6.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/install.tpl');

// 217
$sql = "ALTER TABLE `{$prefix}settings` ADD `settings_saef0` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'saef'";
$this->registry->library('db')->execute($sql);

$sql = "UPDATE `{$prefix}cms` SET ver='217' WHERE cms_id='1'";
$this->registry->library('db')->execute($sql);
$message .= "Tables updated from 2.1.6 to 2.1.7.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/install.tpl');

// 218
$sql = "CREATE TABLE `{$prefix}blocks` (
  `block_id` int(11) NOT NULL auto_increment,
  `block_order` int(9) NOT NULL,
  `block_title` varchar(200) character set utf8 collate utf8_unicode_ci default NULL,
  `block_description` varchar(200) character set utf8 collate utf8_unicode_ci default NULL,
  `block_content` text character set utf8 collate utf8_unicode_ci,
  `blocks_sys` varchar(10) character set utf8 collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`block_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
$this->registry->library('db')->execute($sql);

$sql = "UPDATE `{$prefix}cms` SET ver='218' WHERE cms_id='1'";
$this->registry->library('db')->execute($sql);
$message .= "Tables updated from 2.1.7 to 2.1.8.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/install.tpl');

// 219
$sql = "UPDATE `{$prefix}cms` SET ver='219' WHERE cms_id='1'";
$this->registry->library('db')->execute($sql);
$message .= "Tables updated from 2.1.8 to 2.1.9.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/install.tpl');

// 220
$sql = "UPDATE `{$prefix}cms` SET ver='220' WHERE cms_id='1'";
$this->registry->library('db')->execute($sql);
$message .= "Tables updated from 2.1.9 to 2.2.0.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/install.tpl');

// 221
$sql = "UPDATE `{$prefix}cms` SET ver='221' WHERE cms_id='1'";
$this->registry->library('db')->execute($sql);
$message .= "Tables updated from 2.2.0 to 2.2.1.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/install.tpl');

// 222
$sql = "UPDATE `{$prefix}cms` SET ver='222' WHERE cms_id='1'";
$this->registry->library('db')->execute($sql);
$message .= "Tables updated from 2.2.1 to 2.2.2.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/install.tpl');

// 223
$sql = "UPDATE `{$prefix}cms` SET ver='223' WHERE cms_id='1'";
$this->registry->library('db')->execute($sql);
$message .= "Tables updated from 2.2.2 to 2.2.3.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/install.tpl');

// 224
$sql = "UPDATE `{$prefix}settings` SET settings_jquery='jquery-1.5.2.min.js'";
$this->registry->library('db')->execute($sql);

$sql = "UPDATE `{$prefix}cms` SET ver='224' WHERE cms_id='1'";
$this->registry->library('db')->execute($sql);
$message .= "Tables updated from 2.2.3 to 2.2.4.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/install.tpl');

// 225
$sql = "UPDATE `{$prefix}cms` SET ver='225' WHERE cms_id='1'";
$this->registry->library('db')->execute($sql);
$message .= "Tables updated from 2.2.4 to 2.2.5.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/install.tpl');

// 226
$sql = "UPDATE `{$prefix}cms` SET ver='226' WHERE cms_id='1'";
$this->registry->library('db')->execute($sql);
$message .= "Tables updated from 2.2.5 to 2.2.6.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/install.tpl');

// 227
$sql = "UPDATE `{$prefix}cms` SET ver='227' WHERE cms_id='1'";
$this->registry->library('db')->execute($sql);
$message .= "Tables updated from 2.2.6 to 2.2.7.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/install.tpl');

// 228
$sql = "UPDATE `{$prefix}cms` SET ver='228' WHERE cms_id='1'";
$this->registry->library('db')->execute($sql);
$message .= "Tables updated from 2.2.7 to 2.2.8.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/install.tpl');

// 229
$sql = "UPDATE `{$prefix}cms` SET ver='229' WHERE cms_id='1'";
$this->registry->library('db')->execute($sql);
$message .= "Tables updated from 2.2.8 to 2.2.9.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/install.tpl');

// 230
$sql = "UPDATE `{$prefix}cms` SET ver='230' WHERE cms_id='1'";
$this->registry->library('db')->execute($sql);
$message .= "Tables updated from 2.2.9 to 2.3.0.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/install.tpl');

// 231
$sql = "UPDATE `{$prefix}cms` SET ver='231' WHERE cms_id='1'";
$this->registry->library('db')->execute($sql);
$message .= "Tables updated from 2.3.0 to 2.3.1.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/install.tpl');

// 232
$sql = "UPDATE `{$prefix}cms` SET ver='232' WHERE cms_id='1'";
$this->registry->library('db')->execute($sql);
$message .= "Tables updated from 2.3.1 to 2.3.2.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/install.tpl');

// 233
$sql = "UPDATE `{$prefix}cms` SET ver='233' WHERE cms_id='1'";
$this->registry->library('db')->execute($sql);
$message .= "Tables updated from 2.3.2 to 2.3.3.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/install.tpl');

// 234
$sql = "UPDATE `{$prefix}cms` SET ver='234' WHERE cms_id='1'";
$this->registry->library('db')->execute($sql);
$message .= "Tables updated from 2.3.3 to 2.3.4.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/install.tpl');

// 235
$sql = "UPDATE `{$prefix}cms` SET ver='235' WHERE cms_id='1'";
$this->registry->library('db')->execute($sql);
$message .= "Tables updated from 2.3.4 to 2.3.5.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/install.tpl');

// 236
$sql = "UPDATE `{$prefix}settings` SET settings_jquery='jquery-1.11.1.min.js'";
$this->registry->library('db')->execute($sql);

$sql = "UPDATE `{$prefix}cms` SET ver='236' WHERE cms_id='1'";
$this->registry->library('db')->execute($sql);
$message .= "Tables updated from 2.3.5 to 2.3.6.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/install.tpl');

// 237
$sql = "UPDATE `{$prefix}cms` SET ver='237' WHERE cms_id='1'";
$this->registry->library('db')->execute($sql);
$message .= "Tables updated from 2.3.6 to 2.3.7.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/install.tpl');

// 238
$sql = "UPDATE `{$prefix}cms` SET ver='238' WHERE cms_id='1'";
$this->registry->library('db')->execute($sql);
$message .= "Tables updated from 2.3.7 to 2.3.8.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/install.tpl');

// 239
$sql = "UPDATE `{$prefix}cms` SET ver='239' WHERE cms_id='1'";
$this->registry->library('db')->execute($sql);
$message .= "Tables updated from 2.3.8 to 2.3.9.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/install.tpl');

// 240
$sql = "ALTER TABLE `{$prefix}c_fields_created` ADD `c_created_encrypted` enum('n','y') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n'";
$this->registry->library('db')->execute($sql);

$sql = "UPDATE `{$prefix}cms` SET ver='240' WHERE cms_id='1'";
$this->registry->library('db')->execute($sql);
$message .= "Tables updated from 2.3.9 to 2.4.0.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/install.tpl');

// 241
$sql = "UPDATE `{$prefix}cms` SET ver='241' WHERE cms_id='1'";
$this->registry->library('db')->execute($sql);
$message .= "Tables updated from 2.4.0 to 2.4.1.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/install.tpl');

// 242
$sql = "UPDATE `{$prefix}cms` SET ver='242' WHERE cms_id='1'";
$this->registry->library('db')->execute($sql);
$message .= "Tables updated from 2.4.1 to 2.4.2.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/install.tpl');

// 300
$sql = "UPDATE `{$prefix}cms` SET ver='300' WHERE cms_id='1'";
$this->registry->library('db')->execute($sql);
$message .= "Tables updated from 2.4.2 to 3.0.0.<br />";
$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/install.tpl');

// END



	}



}


?>