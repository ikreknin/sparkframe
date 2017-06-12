<?php
if (!defined('FW'))
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit ();
}

class Article_tags_widget
{

	function __construct()
	{
	}

	public function index()
	{
		$prefix = Registry :: library('db')->getPrefix();
		$sys_cms = Registry :: library('db')->getSys();
		$settings_site0 = Registry :: setting('settings_site0');
		$tags_text = Registry :: library('lang')->line('tags');

		$urlSegments = Registry :: getURLSegments();
		$seg_2 = $urlSegments[2];

// 1st character - number or letter?
		if (filter_var($seg_2, FILTER_VALIDATE_INT))
		{
// id
			$sql = 'SELECT *
				FROM ' . $prefix . 'articles
				WHERE articles_sys = "' . $sys_cms . '"
				AND article_id = ' . $seg_2;
		}
		else
		{
// url
			$sql = 'SELECT *
				FROM ' . $prefix . 'articles
				WHERE articles_sys = "' . $sys_cms . '"
				AND url_title = "' . $seg_2 . '"';
		}
		$cache = Registry :: library('db')->cacheQuery($sql);
		$num = Registry :: library('db')->numRowsFromCache($cache);
		if ($num != 0)
		{
			$data = Registry :: library('db')->rowsFromCache($cache);
			foreach ($data as $k => $v)
			{
				$art_tags = $v['art_tags'];
			}
		}

		$result = '';
		$result .= $tags_text . ': ';

		$art_tags_html = '';

		$res = explode("|", $art_tags);
		$res_safe = array();
		$length = count($res);
		for ($i = 0; $i < $length; $i++) 
		{
  			$res[$i] = trim($res[$i]);
  			if ($res[$i] != '')
  			{
  				$res_safe[$i] = urlencode($res[$i]);
  				$art_tags_html .= '<a href=\"' . FWURL . 'tag/' . $res_safe[$i] . '">' . $res[$i] . '</a>, ';
  			}
		}
		$art_tags_html = substr_replace($art_tags_html, "", -2);
		$result .= $art_tags_html;

		return $result;
	}

}
?>