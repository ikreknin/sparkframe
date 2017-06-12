<?php
if (!defined('FW'))
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit ();
}

class Latest_comments_plus_widget
{

	function __construct()
	{
	}

	public function index($number_of_comments = 5, $message_length = 100, $min_words = 3)
	{
		$prefix = Registry :: library('db')->getPrefix();
		$sys_cms = Registry :: library('db')->getSys();
		$settings_site0 = Registry :: setting('settings_site0');
		$latest_comments_text = Registry :: library('lang')->line('latest_comments_text');
		$result = '';
		$sql = 'SELECT *
    	FROM ' . $prefix . 'comments
    	WHERE comment_visible = "y"
    	AND comments_sys = "' . $sys_cms . '"
    	ORDER BY comment_id DESC
    	LIMIT ' . $number_of_comments;
		$cache = Registry :: library('db')->cacheQuery($sql);
		$num = Registry :: library('db')->numRowsFromCache($cache);
		if ($num != 0)
		{
			$data = Registry :: library('db')->rowsFromCache($cache);
			$result .= '<h3>' . $latest_comments_text . '</h3>';
			$result .= '<ul class="uli">';
			foreach ($data as $k => $v)
			{
				$sub = '';
				$len = 0;
				foreach (explode(' ', $v["body"]) as $word)
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
				<h4><a href="' . FWURL . $settings_site0 . '/more/' . $v["com_article_id"] . '/#' . $v["comment_id"] . '">' . $v["created"] . '</a></h4>
				' . $v["author"] . '<br />
				' . $sub . (($len < strlen($v["body"])) ? '...' : '') . '<br /><br />
				</li>';
			}
			$result .= '</ul>';
		}
		$bbcode_w = array("/\[youtube\](.*?)\[\/youtube\]/is" => "<object width=\"425\" height=\"344\"><param name=\"movie\" value=\"http://www.youtube.com/v/$1\"></param><param name=\"allowFullScreen\" value=\"true\"></param><param name=\"allowscriptaccess\" value=\"always\"></param><param name=\"wmode>\" value=\"transparent\"></param><embed src=\"http://www.youtube.com/v/$1\" type=\"application/x-shockwave-flash\" wmode=\"transparent\" allowscriptaccess=\"always\" allowfullscreen=\"true\" width=\"142\" height=\"115\"></embed></object>");
		$result = preg_replace(array_keys($bbcode_w), array_values($bbcode_w), $result);
		return $result;
	}

}
?>