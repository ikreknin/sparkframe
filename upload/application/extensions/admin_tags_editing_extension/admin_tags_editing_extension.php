<?php
if (!defined('FW'))
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit ();
}

class Admin_tags_editing_extension
{
	private $registry;
	private $prefix;
	private $dataext = array('ext_name' => 'Admin Tags Editing Extension', 'ext_description' => 'Admin Tags Editing Extension after insertRecordsSys for Articles', 'ext_version' => '1.0', 'ext_order' => '1', 'ext_file_name' => 'admin_tags_editing_extension', 'ext_hook' => 'editing_article_beginning_hook');

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
		$seg_2 = $this->registry->library('db')->sanitizeData($_POST['articleID']);

// DELETING/INCREMENTING TAGS
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

// CREATING TAGS in Articles
		$result = '';
		$result = $this->registry->library('db')->sanitizeData($_POST['tags']);
		$result = preg_replace('/\s+/', ' ', $result);
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
// for CREATING
		$art_tags = $result;

		$result = 'art_tags' . '  ' . $result;
		if ($result != '')
		$pieces = explode("  ", $result);
		$length = count($pieces);
		for ($i = 0; $i < $length / 2; $i++)
		{
			$data[$pieces[$i * 2]] = $pieces[$i * 2 + 1];
		}
// CREATING TAGS in Tags & Tagged
		if ($art_tags != '')
		{
			$res = explode("|", $art_tags);
			$length = count($res);
			$datatag = array();
			$datatagged = array();
			for ($i = 0; $i < $length; $i++) 
			{
// tags table
  				$res[$i] = trim($res[$i]);
  				if ($res[$i] != '')
		  		{
					$sql = 'SELECT *
						FROM ' . $this->prefix . 'tags
						WHERE tags_sys = "' . $sys_cms . '"
						AND 	tag_name = "' . $res[$i] . '"';
					$cache = $this->registry->library('db')->cacheQuery($sql);
					$num = $this->registry->library('db')->numRowsFromCache($cache);
					if ($num == 0)
					{
						$datatag[$i]['tag_name'] = $res[$i];
						$datatag[$i]['tag_char'] = mb_substr($res[$i], 0, 1, "UTF-8");
						$datatag[$i]['tag_total'] = 1;
						$datatag[$i]['tags_sys'] = $sys_cms;
						if ($i == $i)
						{
							$this->registry->library('db')->insertRecords('tags', $datatag[$i]);
							$tag_id = $this->registry->library('db')->lastInsertID();
						}
					}
					else
					{
						$data = $this->registry->library('db')->rowsFromCache($cache);
						foreach ($data as $k => $v)
						{
							$tag_id = $v["tag_id"];
							$tag_total = $v["tag_total"];
						}
						$tag_total = $tag_total + 1;
						$sql = 'UPDATE ' . $this->prefix . 'tags SET tag_total=' . $tag_total . ' WHERE tag_id=' . $tag_id;
						$this->registry->library('db')->execute($sql);
					}

  				}
// tagged table
				$datatagged[$i]['article_id'] = $seg_2;;
				$datatagged[$i]['tag_id'] = $tag_id;
				$datatagged[$i]['tagged_sys'] = $sys_cms;
				$this->registry->library('db')->insertRecords('tagged', $datatagged[$i]);
			}
		}

// and finally updating art_tags in Articles
		$dataart = array();
		$dataart['art_tags'] = $art_tags;
		$this->registry->library('db')->updateRecordsSys('articles', $dataart, 'article_id=' . $seg_2);

		return;
	}

}
?>