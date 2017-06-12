<?php
if (!defined('FW'))
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit ();
}

class Tagcloud_widget
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

		$sql = 'SELECT *
			FROM ' . $prefix . 'tags
			WHERE tags_sys = "' . $sys_cms . '"';
		$cache = Registry :: library('db')->cacheQuery($sql);
		$num = Registry :: library('db')->numRowsFromCache($cache);
		
		$result = '<link rel="stylesheet" href="' . FWURL . 'application/widgets/tagcloud_widget/css/tagcloud.css">';
		$result .= '<h3>' . $tags_text . ':</h3>';
		$result .= '<div class=\"wrapper-tagcloud-widget\">';

		if ($num != 0)
		{
			$data = Registry :: library('db')->rowsFromCache($cache);
			foreach ($data as $k => $v)
			{
				$tag_name = $v['tag_name'];
				$tag_name_safe = urlencode($tag_name);
				$result .= '<a href=\"' . FWURL . 'tag/' . $tag_name_safe . '\" class=\"tag-tagcloud-widget\">
<span class=\"arrow\"></span>
<span class=\"text\">' . $tag_name . '</span>
<span class=\"end\"></span>
</a>';
			}
		}

		$result .= '</div>';

		return $result;
	}

}
?>