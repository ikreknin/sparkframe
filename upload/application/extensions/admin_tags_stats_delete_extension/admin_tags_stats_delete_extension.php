<?php
if (!defined('FW'))
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit ();
}

class Admin_tags_stats_delete_extension
{
	private $registry;
	private $prefix;
	private $dataext = array('ext_name' => 'Admin Tags Stats Deleting Extension', 'ext_description' => 'Admin Tags Statistics Deleting Extension after insertRecordsSys for Articles', 'ext_version' => '1.0', 'ext_order' => '1', 'ext_file_name' => 'admin_tags_stats_delete_extension', 'ext_hook' => 'delete_article_after_hook');

	public function __construct(Registry $registry)
	{
		$this->registry = $registry;
		$this->prefix = $this->registry->library('db')->getPrefix();
		$this->registry->library('lang')->setLanguage($this->registry->setting('settings_lang_full'));
		$this->registry->library('lang')->loadLanguage('site');
		$this->registry->library('template')->page()->addTag('click_here_if', $this->registry->library('lang')->line('click_here_if'));
		$urlSegments = $this->registry->getURLSegments();
		if (isset ($urlSegments[1]))
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

	private function pageNotFound()
	{
		$this->registry->library('template')->build('header.tpl', '404.tpl', 'footer.tpl');
	}

	public function install()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true || $this->registry->library('authenticate')->hasPermission('install_extensions') == true)
		{
			$urlSegments = $this->registry->getURLSegments();
			$seg_0 = $urlSegments[0];
			$sql = 'SELECT *, COUNT(ext_id) AS `extensions_count`
			FROM ' . $this->prefix . 'extensions
			WHERE ext_file_name = "' . $this->dataext['ext_file_name'] . '"
			GROUP BY ext_id';
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) == 0)
			{
				$this->registry->library('db')->insertRecords('extensions', $this->dataext);
			}
			$this->registry->redirectUser('admin/extensions', $this->registry->library('lang')->line('installed_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'), false);
		}
		else
		{
			$this->pageNotFound();
		}
	}

	public function uninstall()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true || $this->registry->library('authenticate')->hasPermission('install_extensions') == true)
		{
			$this->registry->library('db')->deleteRecords('extensions', 'ext_file_name = "' . $this->dataext['ext_file_name'] . '"', '1');
			$this->registry->redirectUser('admin/extensions', $this->registry->library('lang')->line('uninstalled_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'), false);
		}
		else
		{
			$this->pageNotFound();
		}
	}

	public function index()
	{
		$sys_cms = $this->registry->library('db')->getSys();
		$urlSegments = $this->registry->getURLSegments();
		$seg_2 = $this->registry->library('db')->sanitizeData($urlSegments[2]);
		$sql = 'SELECT *
			FROM ' . $this->prefix . 'tagged
			WHERE tagged_sys = "' . $sys_cms . '"
			AND article_id = ' . $seg_2;
		$cache = $this->registry->library('db')->cacheQuery($sql);
		$num = $this->registry->library('db')->numRowsFromCache($cache);
// if there are tags
		if ($num != 0)
		{
// for esch tag_id in TAGGED
			$data = $this->registry->library('db')->rowsFromCache($cache);
			foreach ($data as $k => $v)
			{
				$tag_id = $v["tag_id"];
// to find tag_id in TAGS
				$sql = 'SELECT *
					FROM ' . $this->prefix . 'tags
					WHERE tags_sys = "' . $sys_cms . '"
					AND tag_id = ' . $tag_id;
					$cache = $this->registry->library('db')->cacheQuery($sql);
					$num = $this->registry->library('db')->numRowsFromCache($cache);
// and decrement tag_total or delete record
					if ($num != 0)
					{
						$data = $this->registry->library('db')->rowsFromCache($cache);
						foreach ($data as $k => $v)
						{
							$tag_total = $v["tag_total"];
							if ($tag_total == 1)
							{
								$sql = 'DELETE FROM ' . $this->prefix . 'tags 
									WHERE tag_id=' . $tag_id;
								$this->registry->library('db')->execute($sql);
							}
							else
							{
								$tag_total = $tag_total - 1;
								$sql = 'UPDATE ' . $this->prefix . 'tags 
									SET tag_total=' . $tag_total . ' 
									WHERE tag_id=' . $tag_id;
								$this->registry->library('db')->execute($sql);
							}
						}
					}
				
			}
		}
// and delete ALL records in TAGGED with article_id
		$sql = 'DELETE FROM ' . $this->prefix . 'tagged 
			WHERE tagged_sys = "' . $sys_cms . '"
			AND article_id=' . $seg_2;
		$this->registry->library('db')->execute($sql);

		return;
	}

}
?>