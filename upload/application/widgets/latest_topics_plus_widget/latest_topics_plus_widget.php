<?php
if (!defined('FW'))
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit ();
}

class Latest_topics_plus_widget
{

	function __construct()
	{
	}

	public function index($number_of_topics = 5, $message_length = 100, $min_words = 3)
	{
		$prefix = Registry :: library('db')->getPrefix();
		$sys_cms = Registry :: library('db')->getSys();
		$settings_forum0 = Registry :: setting('settings_forum0');
		$latest_topics_text = Registry :: library('lang')->line('latest_topics_text');
		$result = '';
		$sql = 'SELECT *
    	FROM ' . $prefix . 'forum_topics
    		LEFT JOIN ' . $prefix . 'users ON t_user_id = users_id
    	WHERE t_topic_visible = "y"
    	AND forum_topics_sys = "' . $sys_cms . '"
    	ORDER BY t_topic_id DESC
    	LIMIT ' . $number_of_topics;
		$cache = Registry :: library('db')->cacheQuery($sql);
		$num = Registry :: library('db')->numRowsFromCache($cache);
		if ($num != 0)
		{
			$data = Registry :: library('db')->rowsFromCache($cache);
			$result .= '<h3>' . $latest_topics_text . '</h3>';
			$result .= '<ul class="uli">';
			foreach ($data as $k => $v)
			{
				$sub = '';
				$len = 0;
				foreach (explode(' ', $v["t_body"]) as $word)
				{
					$part = (($sub != '') ? ' ' : '') . $word;
					$sub .= $part;
					$len += strlen($part);
					if (strlen($word) > $min_words && strlen($sub) >= $message_length)
					{
						break;
					}
				}
				$result .= '<li>
				<h4><a href="' . FWURL . $settings_forum0 . '/viewtopic/' . $v["t_topic_id"] . '">' . $v["t_title"] . '</a></h4>
				' . $v["username"] . '<br />' . $v["t_topic_date"] . '<br />
				' . $sub . (($len < strlen($v["t_body"])) ? '...' : '') . '<br /><br />

				</li>';
			}
			$result .= '</ul>';
		}
		return $result;
	}

}
?>