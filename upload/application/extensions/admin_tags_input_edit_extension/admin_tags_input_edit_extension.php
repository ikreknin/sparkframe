<?php
if (!defined('FW'))
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit ();
}

class Admin_tags_input_edit_extension
{
	private $registry;
	private $prefix;
	private $data = array('ext_name' => 'Admin Tag Input Edit Extension', 'ext_description' => 'Admin Tag Input Edit Extension', 'ext_version' => '1.0', 'ext_order' => '1', 'ext_file_name' => 'admin_tags_input_edit_extension', 'ext_hook' => 'admin_articles_edit_before_submit_hook');

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
			WHERE ext_file_name = "' . $this->data['ext_file_name'] . '"
			GROUP BY ext_id';
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) == 0)
			{
				$this->registry->library('db')->insertRecords('extensions', $this->data);
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
			$this->registry->library('db')->deleteRecords('extensions', 'ext_file_name = "' . $this->data['ext_file_name'] . '"', '1');
			$this->registry->redirectUser('admin/extensions', $this->registry->library('lang')->line('uninstalled_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'), false);
		}
		else
		{
			$this->pageNotFound();
		}
	}

	public function index()
	{
		$prefix = $this->registry->library('db')->getPrefix();
		$settings_site0 = $this->registry->setting('settings_site0');
		$sys_cms = $this->registry->library('db')->getSys();
		$urlSegments = $this->registry->getURLSegments();
		$seg_2 = $this->registry->library('db')->sanitizeData($urlSegments[2]);
		$int = (int)$seg_2;
		$sql = 'SELECT * 
			FROM ' . $this->prefix . 'articles 
			WHERE articles_sys = "' . $sys_cms . '" AND article_id = ' . $int;
		$cache = $this->registry->library('db')->cacheQuery($sql);
		$num = $this->registry->library('db')->numRowsFromCache($cache);
		if ($num != 0)
		{
			$data = $this->registry->library('db')->rowsFromCache($cache);
			foreach ($data as $k => $v)
			{
				$art_tags = $v["art_tags"];
			}
		}
		$result = $this->registry->library('lang')->line('tags') . ':<br />
<input id="tag_list" style="width: 500px" type=\'text\' name=\'tags\' value=\'' . $art_tags . '\' />
<br />';


		$sql = 'SELECT *
			FROM ' . $prefix . 'tags
			WHERE tags_sys = "' . $sys_cms . '"';

		$cache = $this->registry->library('db')->cacheQuery($sql);
		$num = $this->registry->library('db')->numRowsFromCache($cache);

		$result .= '<div>';

		if ($num != 0)
		{
			$data = $this->registry->library('db')->rowsFromCache($cache);
			foreach ($data as $k => $v)
			{
				$tag_name = $v['tag_name'];
				$tag_name_safe = urlencode($tag_name);
				$result .= '<button id="' . $tag_name . '"> ' . $tag_name . ' </button> ';
			}
		}
		$result .= '</div><br />';

		if ($num != 0)
		{
			$result .= '<script>';

			foreach ($data as $k => $v)
			{
				$tag_name = $v['tag_name'];

$result .= '$(document).ready(function(){
  $(document.getElementById("' . $tag_name . '")).click(function(e){
    $("#tag_list").val(function(i,origText){
		e.preventDefault();

		$del = 0;

		if (origText == "' . $tag_name . '")
		{
			$del = 1;
			$var = "";
		}

		if (origText.indexOf("|' . $tag_name . '|") > -1)
		{
			$del = 2;
			$var = origText.replace("|' . $tag_name . '|", "|");
		}

		$beginning = "' . $tag_name . '|";
		$b = $beginning.length;
		$full = origText.length;
		if($beginning == origText.slice(0, $b))
		{
			$del = 3;
			$var = origText.slice($b, $full);
		}

		$end = "|' . $tag_name . '";
		$e = $end.length;
		$full = origText.length;
		if($end == origText.slice($full - $e, $full))
		{
			$del = 4;
			$var = origText.slice(0, $full - $e);
		}

		if ($del == 0)
		{
    		$var = "|" + "' . $tag_name . '";
	    	$var = origText + $var;
    		if ($var.charAt(0) == "|")
    		{
    			$var = $var.substring(1);
    		}
    	}

		while ($var.indexOf("||") > -1)
  		{
  			$var = $var.replace("||","|");
  		}
    	return $var; 
    });
  });
});';

			}

			$result .= '</script>';
		}

		return $result;
	}

}
?>