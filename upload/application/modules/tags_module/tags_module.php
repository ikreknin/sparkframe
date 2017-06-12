<?php
if (!defined('FW'))
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit ();
}

class Tags_modulecontroller
{
	private $registry;
	private $prefix;
	private $sys_cms;
	private $data = array('mod_name' => 'Tags Module', 'mod_description' => 'Tags Module for Blog', 'mod_version' => '1.0', 'mod_enabled' => '1', 'mod_file_name' => 'tags_module');

	public function __construct(Registry $registry, $directCall)
	{
		$this->registry = $registry;
		if ($directCall == true)
		{
			$this->prefix = $this->registry->library('db')->getPrefix();
			$this->sys_cms = $this->registry->library('db')->getSys();
			$this->registry->library('lang')->setLanguage($this->registry->setting('settings_lang_full'));
			$this->registry->library('lang')->loadLanguage('site');
			$this->registry->library('template')->page()->addTag('click_here_if', $this->registry->library('lang')->line('click_here_if'));
			$urlSegments = $this->registry->getURLSegments();
			if (!isset ($urlSegments[1]))
			{
				$this->index();
			}
			else
			{
				switch ($urlSegments[1])
				{

					case 'install' :
						$this->install();
						break;

					case 'uninstall' :
						$this->uninstall();
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
		echo '<meta http-equiv="Refresh" content="0; url=' . FWURL . '">';
	}

	public function install()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true || $this->registry->library('authenticate')->hasPermission('install_modules') == true)
		{
			$urlSegments = $this->registry->getURLSegments();
			$seg_0 = $urlSegments[0];
			$sql = 'SELECT *, COUNT(mod_id) AS `modules_count` FROM ' . $this->prefix . 'modules WHERE mod_file_name = "' . $this->data['mod_file_name'] . '" GROUP BY mod_id';
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) == 0)
			{
				$sql2 = "ALTER TABLE `" . $this->prefix . "articles` ADD `art_tags` text character set utf8 collate utf8_unicode_ci";
				$this->registry->library('db')->execute($sql2);
				
				$sql = 'CREATE TABLE `' . $this->prefix . 'tagged` (
					`tagged_id` int(10) unsigned NOT NULL auto_increment,
					`article_id` int(10) unsigned NOT NULL default "0",
					`tag_id` int(10) unsigned NOT NULL default "0",
					`tagged_sys` varchar(10) character set utf8 collate utf8_unicode_ci NOT NULL,
					PRIMARY KEY (`tagged_id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;';
				$cache = $this->registry->library('db')->cacheQuery($sql);
				
				$sql = 'CREATE TABLE `' . $this->prefix . 'tags` (
					`tag_id` int(10) unsigned NOT NULL auto_increment,
					`tag_name` varchar(100) NOT NULL default "",
					`tag_char` varchar(5) NOT NULL default "",
					`tag_total` int(10) NOT NULL default "0",
					`tags_sys` varchar(10) character set utf8 collate utf8_unicode_ci NOT NULL,
					PRIMARY KEY (`tag_id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;';
				$cache = $this->registry->library('db')->cacheQuery($sql);
				
				$this->registry->library('db')->insertRecords('modules', $this->data);
			}
			$this->registry->redirectUser('admin/modules', $this->registry->library('lang')->line('installed_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'), false);
		}
		else
		{
			$this->pageNotFound();
		}
	}

	public function uninstall()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true || $this->registry->library('authenticate')->hasPermission('install_modules') == true)
		{
			$sql = "ALTER TABLE `" . $this->prefix . "articles` DROP COLUMN `art_tags`";
			$cache = $this->registry->library('db')->cacheQuery($sql);
			
			$sql = sprintf("DELETE FROM `" . $this->prefix . "modules` WHERE `mod_file_name` = '%s' LIMIT 1", $this->data['mod_file_name']);
			$cache = $this->registry->library('db')->cacheQuery($sql);

			$sql = 'DROP TABLE ' . $this->prefix . 'tagged';
			$cache = $this->registry->library('db')->cacheQuery($sql);
			
			$sql = 'DROP TABLE ' . $this->prefix . 'tags';
			$cache = $this->registry->library('db')->cacheQuery($sql);

			$this->registry->redirectUser('admin/modules', $this->registry->library('lang')->line('uninstalled_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'), false);
		}
		else
		{
			$this->pageNotFound();
		}
	}

	public function index()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true || $this->registry->library('authenticate')->hasPermission('install_modules') == true)
		{
			echo '<META http-equiv="refresh" content="0;URL=' . FWURL . 'admin/modules">';
		}
		else
		{
			$this->pageNotFound();
		}
	}

}
?>