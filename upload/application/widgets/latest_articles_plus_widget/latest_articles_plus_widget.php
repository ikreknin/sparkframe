<?php
if (!defined('FW'))
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit ();
}

class Latest_articles_plus_widget
{

	function __construct()
	{
	}

	public function index($number_of_articles = 15, $message_length = 100, $min_words = 3)
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
				$sub = '';
				$len = 0;
				$processing = array("/<img[^>]+\>/i" => " ");
				$v["article"] = preg_replace(array_keys($processing), array_values($processing), $v["article"]);
				foreach (explode(' ', $v["article"]) as $word)
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
				<h4><a href="' . FWURL . $settings_site0 . '/more/' . $v["article_id"] . '">' . $v["title"] . '</a></h4>
				' . $sub . (($len < strlen($v["article"])) ? '...' : '') . '<br />
				</li>';
			}
			$result .= '</ul>';
		}
		$bbcode_w = array("/\[youtube\](.*?)\[\/youtube\]/is" => "<object width=\"142\" height=\"115\"><param name=\"movie\" value=\"http://www.youtube.com/v/$1\"></param><param name=\"allowFullScreen\" value=\"true\"></param><param name=\"allowscriptaccess\" value=\"always\"></param><param name=\"wmode>\" value=\"transparent\"></param><embed src=\"http://www.youtube.com/v/$1\" type=\"application/x-shockwave-flash\" wmode=\"transparent\" allowscriptaccess=\"always\" allowfullscreen=\"true\" width=\"142\" height=\"115\"></embed></object>", 
			"/\[rutube\](.*?)\[\/rutube\]/is" => "<object width=\"142\" height=\"115\"><param name=\"movie\" value=\"http://video.rutube.ru/$1\"></param><param name=\"allowFullScreen\" value=\"true\"></param><param name=\"allowscriptaccess\" value=\"always\"></param><param name=\"wmode>\" value=\"transparent\"></param><embed src=\"http://video.rutube.ru/$1\" type=\"application/x-shockwave-flash\" wmode=\"transparent\" allowscriptaccess=\"always\" allowfullscreen=\"true\" width=\"142\" height=\"115\"></embed></object>", 
			"/\[vimeo\](.*?)\[\/vimeo\]/is" => "<iframe src=\"http://player.vimeo.com/video/$1?title=0&amp;byline=0&amp;portrait=0\" width=\"142\" height=\"80\" frameborder=\"0\" webkitAllowFullScreen allowFullScreen></iframe>", 
			"/\[video\](.*?)\[\/video\]/is" => "<object
  classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\"
  codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,45,2\"
  width=\"213\" height=\"120\"
>
<param name=\"allowFullscreen\" value=\"true\">
<param name=\"allowScriptAccess\" value=\"always\">
<param name=\"movie\" value=\"" . FWURL . "js/JarisFLVPlayer/JarisFLVPlayer.swf\">
<param name=\"bgcolor\" value=\"#000000\">
<param name=\"quality\" value=\"high\">
<param name=\"scale\" value=\"noscale\">
<param name=\"wmode\" value=\"opaque\">
<param name=\"flashvars\" value=\"source=$1&type=video&duration=52&streamtype=file&poster=" . FWURL . "js/JarisFLVPlayer/poster.png&autostart=false&logo=" . FWURL . "js/JarisFLVPlayer/logo.png&logoposition=top left&logoalpha=30&logowidth=130&logolink=" . FWURL . "&hardwarescaling=false&darkcolor=000000&brightcolor=4c4c4c&controlcolor=FFFFFF&hovercolor=67A8C1\">

<param name=\"seamlesstabbing\" value=\"false\">
<embed
  type=\"application/x-shockwave-flash\"
  pluginspage=\"http://www.adobe.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash\"
  width=\"213\" height=\"120\"
  src=\"" . FWURL . "js/JarisFLVPlayer/JarisFLVPlayer.swf\"
  allowfullscreen=\"true\"
  allowscriptaccess=\"always\"
  bgcolor=\"#000000\"
  quality=\"high\"
  scale=\"noscale\"
  wmode=\"opaque\"
  flashvars=\"source=$1&type=video&duration=52&streamtype=file&poster=" . FWURL . "js/JarisFLVPlayer/poster.png&autostart=false&logo=" . FWURL . "js/JarisFLVPlayer/logo.png&logoposition=top left&logoalpha=30&logowidth=130&logolink=" . FWURL . "&hardwarescaling=false\"

  seamlesstabbing=\"false\"
>
  <noembed>
  </noembed>
</embed>
</object>");
		$result = preg_replace(array_keys($bbcode_w), array_values($bbcode_w), $result);
		return $result;
	}

}
?>