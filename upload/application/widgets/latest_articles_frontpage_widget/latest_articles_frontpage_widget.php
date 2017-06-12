<?php
if (!defined('FW'))
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit ();
}

class Latest_articles_frontpage_widget
{

	function __construct()
	{
	}

	public function index($number_of_articles = 4, $message_length = 100, $min_words = 3)
	{
		$prefix = Registry :: library('db')->getPrefix();
		$sys_cms = Registry :: library('db')->getSys();
		$settings_site0 = Registry :: setting('settings_site0');
		$one_cat_available = Registry :: setting('settings_one_cat');

		$tags_text = Registry :: library('lang')->line('tags');

		$current_language = 'english';
		if ($_SESSION['language'] != '')
		{
			$current_language = $_SESSION['language'];
		}
		else
		{
			$current_language = Registry :: setting('settings_lang_full');
		}
// Edit for additional languages
		if ($current_language == 'english')
		{
			$read_more = 'Read More...';
		}
		if ($current_language == 'russian')
		{
			$read_more = 'Читать дальше...';
		}
//
		$theme = Registry :: setting('theme');
		$result = '';
		$sql = 'SELECT *, COUNT(com_article_id) AS `comments_count`
    	FROM ' . $prefix . 'articles
			LEFT JOIN ' . $prefix . 'users ON ' . $prefix . 'users.users_id = ' . $prefix . 'articles.author_id
			LEFT JOIN ' . $prefix . 'categories ON ' . $prefix . 'categories.category_id = ' . $prefix . 'articles.categories
			LEFT JOIN ' . $prefix . 'comments ON ' . $prefix . 'comments.com_article_id = ' . $prefix . 'articles.article_id
    	WHERE article_visible = 2
    	AND articles_sys = "' . $sys_cms . '"
			GROUP BY article_id
			ORDER BY pinned DESC, article_id DESC
    	LIMIT ' . $number_of_articles;
		$cache = Registry :: library('db')->cacheQuery($sql);
		$num = Registry :: library('db')->numRowsFromCache($cache);
		if ($num != 0)
		{
			$data = Registry :: library('db')->rowsFromCache($cache);

			foreach ($data as $k => $v)
			{
				
				if ($v['url_title'] == '')
						{
							$more = $v['article_id'];
						}
						else
						{
							$more = $v['url_title'];
						}
				
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
						$create_date = Registry :: library('helper')->convertDate($v['art_created']);
						$create_time = Registry :: library('helper')->convertTime($v['art_created']);
				}
$result .= '	<article class="post clearfix">

<div class="post-body">
		<header class="post-header">
			<h3><a href="' . $v["site_url"] . $v["CMS0"] . 'site/more/' . $more . '">' . $v["title"] . '</a></h3>
			<p class="post-meta">'
. (($one_cat_available != 0) ? 
				'<span class="post-meta-cats"><i class="fa fa-tag"></i><a href="' . $v["site_url"] . $settings_site0 . '/category/' . $v["category_id"] . '">' . $v["category_name"] . '</a></span>'
: '') . 
				'<span class="post-meta-author"><a href="' . $v["site_url"] . 'user/id/' . $v["author_id"] . '"><i class="fa fa-user"></i>' . $v["username"] . '</a></span>
				<span class="post-meta-time"><i class="fa fa-time"></i>' . $create_date . ' ' . $create_time . '</span>
				<span class="post-meta-comments"><i class="fa fa-comment"></i>' . $v["comments_count"] . '</span>
			</p>
		</header>
		<div class="post-excerpt">
			' . $v["article"]; 


// TAGS START
				$show_tags = 1; // TO SHOW TAGS
//				$show_tags = 0; // NOT TO SHOW TAGS
				if($show_tags != 0)
				{
					$art_tags_html = '';
					if($v['art_tags'] != '')
					{
						$art_tags_html .= '<p>' . $tags_text . ': ';
					}
					

					$res = explode("|", $v['art_tags']);
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
					$art_tags_html .= '</p>';
					$result .= $art_tags_html;
				}
// TAGS END


$result .= (($v["article_extended"] != "") ? 
			'<a href="' . $v["site_url"] . $settings_site0 . '/more/' . $v["article_id"] . '" class="btn">' . $read_more . '</a>'
: '') .
		'</div>
	</div>

</article>';
			}

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