<?php
if (!defined('FW'))
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit ();
}

class Admin_tags_creating_extension
{
	private $registry;
	private $prefix;
	private $dataext = array('ext_name' => 'Admin Tags Creating Extension', 'ext_description' => 'Admin Tags Creating Extension before insertRecordsSys for Articles', 'ext_version' => '1.0', 'ext_order' => '1', 'ext_file_name' => 'admin_tags_creating_extension', 'ext_hook' => 'creating_article_before_insertRecordsSys_articles_hook');

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
		$result = '';
		$result = $this->registry->library('db')->sanitizeData($_POST['tags']);
		$result = preg_replace('/\s+/', ' ', $result);
// remove all ||
		while (strpos($result,'||') !== false)
		{
			$art_tags = str_replace("||", "|", $result);
		}
		$res = explode("|", $result);
		$length = count($res);
		$arr = array();
		for ($i = 0; $i < $length; $i++) 
		{
  			$res[$i] = trim($res[$i]);
  			if ($res[$i] != '')
  			{
  				$arr[] = $res[$i];
  			}
		}
		$result = implode("|", $arr);

		return 'art_tags' . '  ' . $result;
	}

}
?>