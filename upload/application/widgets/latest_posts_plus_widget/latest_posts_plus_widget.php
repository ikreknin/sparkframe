<?php
if (!defined('FW'))
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit ();
}

class Latest_posts_plus_widget
{

	function __construct()
	{
	}

	public function index($number_of_posts = 5, $message_length = 100, $min_words = 3)
	{
		$prefix = Registry :: library('db')->getPrefix();
		$sys_cms = Registry :: library('db')->getSys();
		$settings_forum0 = Registry :: setting('settings_forum0');
		$latest_posts_text = Registry :: library('lang')->line('latest_posts_text');
		$result = '';
		$sql = 'SELECT *
    	FROM ' . $prefix . 'forum_posts
    		LEFT JOIN ' . $prefix . 'users ON p_user_id = users_id
    		LEFT JOIN ' . $prefix . 'forum_topics ON p_topic_id = t_topic_id
    	WHERE p_post_visible = "y"
    	AND forum_posts_sys = "' . $sys_cms . '"
    	ORDER BY p_post_id DESC
    	LIMIT ' . $number_of_posts;
		$cache = Registry :: library('db')->cacheQuery($sql);
		$num = Registry :: library('db')->numRowsFromCache($cache);
		if ($num != 0)
		{
			$data = Registry :: library('db')->rowsFromCache($cache);
			$result .= '<h3>' . $latest_posts_text . '</h3>';
			$result .= '<ul class="uli">';
			foreach ($data as $k => $v)
			{
				$sub = '';
				$len = 0;
				foreach (explode(' ', $v["p_body"]) as $word)
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
				<h4><a href="' . FWURL . $settings_forum0 . '/viewreply/' . $v["p_topic_id"] . '/#' . $v["p_post_id"] . '">' . $v["t_title"] . '</a></h4>
				' . $v["username"] . '<br />' . $v["p_post_date"] . '<br />
				' . $sub . (($len < strlen($v["p_body"])) ? '...' : '') . '<br /><br />
				</li>';
			}
			$result .= '</ul>';
		}
		return $result;
	}

}
?>