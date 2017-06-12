<?php
if (!defined('FW'))
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit ();
}

class Latest_articles_widget
{

	function __construct()
	{
	}

	public function index($number_of_articles = 15)
	{
		$prefix = Registry :: library('db')->getPrefix();
		$sys_cms = Registry :: library('db')->getSys();
		$settings_site0 = Registry :: setting('settings_site0');
		$latest_articles_text = Registry :: library('lang')->line('latest_articles_text');
		$result = '';
		$sql = 'SELECT *
    	FROM ' . $prefix . 'articles
    	WHERE article_visible = 2
    	AND articles_sys = "' . $sys_cms . '"
    	ORDER BY article_id DESC
    	LIMIT ' . $number_of_articles;
		$cache = Registry :: library('db')->cacheQuery($sql);
		$num = Registry :: library('db')->numRowsFromCache($cache);
		if ($num != 0)
		{
			$data = Registry :: library('db')->rowsFromCache($cache);
			$result .= '<h3>' . $latest_articles_text . '</h3>';
			$result .= '<ul class="uli">';
			foreach ($data as $k => $v)
			{
				$result .= '<li><a href="' . FWURL . $settings_site0 . '/more/' . $v["article_id"] . '">' . $v["title"] . '</a></li>';
			}
			$result .= '</ul>';
		}
		$result .= '';
		return $result;
	}

}
?>