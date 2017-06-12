<?php
if (!defined('FW'))
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit ();
}

class Monthly_archive_widget
{

	function __construct()
	{
	}

	public function index()
	{
		$prefix = Registry :: library('db')->getPrefix();
		$sys_cms = Registry :: library('db')->getSys();
		$settings_site0 = Registry :: setting('settings_site0');
		$monthly_archive_text = Registry :: library('lang')->line('monthly_archive_text');
		$result = '';
		$sql = 'SELECT COUNT(*), YEAR(art_created) AS year, MONTH(art_created) AS month
    	FROM ' . $prefix . 'articles
    	WHERE article_visible = 2
    	AND articles_sys = "' . $sys_cms . '"
    	GROUP BY year, month
    	ORDER BY year DESC, month DESC';
		$cache = Registry :: library('db')->cacheQuery($sql);
		$num = Registry :: library('db')->numRowsFromCache($cache);
		if ($num != 0)
		{
			$data = Registry :: library('db')->rowsFromCache($cache);
			$result .= '<h3>' . $monthly_archive_text . '</h3>';
			$result .= '<ul class="uli">';
			foreach ($data as $k => $v)
			{
				$result .= '<li><a href="' . FWURL . $settings_site0 . '/calendar/' . $v["year"] . '/' . $v["month"] . '">' . Registry :: library('lang')->line('month_' . $v["month"]) . ' ' . $v["year"] . '</a></li>';
			}
			$result .= '</ul>';
		}
		$result .= '';
		return $result;
	}

}
?>