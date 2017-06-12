<?php
if (!defined('FW'))
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit ();
}

class Block3
{

	function __construct()
	{
	}

	public function index()
	{
		$prefix = Registry :: library('db')->getPrefix();
		$sys_cms = Registry :: library('db')->getSys();
		$sections = Registry :: library('lang')->line('sections_text');
		$result = '';
		$sql = 'SELECT *
			FROM ' . $prefix . 'static
			WHERE static_sys = "' . $sys_cms . '"
			AND page_title = "block3"';
		$cache = Registry :: library('db')->cacheQuery($sql);
		if (Registry :: library('db')->numRowsFromCache($cache) != 0)
		{
			$data = Registry :: library('db')->rowsFromCache($cache);
			foreach ($data as $k => $v)
			{
				$result .= $v['page_content'];
			}
		}
		return $result;
	}

}
?>