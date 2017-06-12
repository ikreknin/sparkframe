<?php
if (!defined('FW'))
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit ();
}

class Template
{
	private $page;
	public $widgetTags = array();

	public function __construct()
	{
		include (SYSPATH . 'libraries/page.php');
		$this->page = new Page();
	}

	public function addTemplateSegment($tag, $segment)
	{
		if (strpos($segment, APPPATH . 'views/') === false)
		{
			if (substr($segment, 0, 5) == 'admin')
			{
				$theme = Registry :: setting('admintheme');
			}
			else
			{
				$theme = Registry :: setting('theme');
			}
			$segment = APPPATH . 'views/' . $theme . '/' . $segment;
		}
		$this->page->addTemplateSegment($tag, $segment);
	}

	private function replaceSegments()
	{
		$segments = $this->page->getSegments();
		foreach ($segments as $tag => $template)
		{
			$templateContent = file_get_contents($template);
			$newContent = str_replace('{' . $tag . '}', $templateContent, $this->page->content());
			$this->page->setContent($newContent);
		}
	}

	private function replaceTags()
	{
		$tags = $this->page->getTags();
		foreach ($tags as $tag => $data)
		{
			if (is_array($data))
			{
				if ($data[0] == 'SQL')
				{
					$this->replaceDBTags($tag, $data[1]);
				}
				elseif ($data[0] == 'DATA')
				{
					$this->replaceDataTags($tag, $data[1]);
				}
			}
			else
			{
				$newContent = str_replace('{' . $tag . '}', $data, $this->page->content());
				$this->page->setContent($newContent);
			}
		}
		$newContent = $this->replaceIf($this->page->content());
		$code = array("/{comment}(.*?){\/comment}/is" => "");
		$newContent = preg_replace(array_keys($code), array_values($code), $newContent);
		$this->page->setContent($newContent);
	}

	private function replaceDBTags($tag, $cacheId)
	{
		$block = '';
		$blockOld = $this->page->getBlock($tag);
		$tags = Registry :: library('db')->resultsFromCache($cacheId);
		for ($i = 0; $i <= count($tags) - 1; $i++)
		{
			$blockNew = $blockOld;
			foreach ($tags[$i] as $ntag => $data)
			{
				$data = str_replace('--', '&mdash;', $data);
				$blockNew = str_replace("{" . $ntag . "}", $data, $blockNew);
			}
			$blockNew = $this->replaceIf($blockNew);
			$block .= $blockNew;
		}
		$pageContent = $this->page->content();
		$newContent = str_replace('<!-- START ' . $tag . ' -->' . $blockOld . '<!-- END ' . $tag . ' -->', $block, $pageContent);
		$this->page->setContent($newContent);
	}

	private function replaceDataTags($tag, $cacheId)
	{
		$block = '';
		$blockOld = $this->page->getBlock($tag);
		$tags = Registry :: library('db')->dataFromCache($cacheId);
		if (isset ($tags))
		{
			foreach ($tags as $tag => $data)
			{
				$blockNew = $blockOld;
				foreach ($data as $tag1 => $data1)
				{
					$data1 = str_replace('--', '&mdash;', $data1);
					$blockNew = str_replace("{" . $tag1 . "}", $data1, $blockNew);
				}
				$blockNew = $this->replaceIf($blockNew);
				$block .= $blockNew;
			}
		}
		$pageContent = $this->page->content();
		$newContent = str_replace($blockOld, $block, $pageContent);
		$this->page->setContent($newContent);
	}

	public function page()
	{
		return $this->page;
	}

	public function build()
	{
		$segments = func_get_args();
		$content = "";
		foreach ($segments as $segment)
		{
			if (substr($segment, 0, 5) == 'admin')
			{
				$theme = Registry :: setting('admintheme');
			}
			else
			{
				$theme = Registry :: setting('theme');
			}
			if (strpos($segment, APPPATH . 'views/') === false)
			{
				$segment = APPPATH . 'views/' . $theme . '/' . $segment;
			}
			if (file_exists($segment) == true)
			{
				$content .= file_get_contents($segment);
			}
		}
		$this->page->setContent($content);
	}

	public function postProcessing()
	{
// admin segment? To avoid the use of BBcodes and &bsp; in Admin Editor
		$urlSegments = Registry :: getURLSegments();
		$seg_1 = Registry :: library('db')->sanitizeData($urlSegments[0]);
		$seg_2 = Registry :: library('db')->sanitizeData($urlSegments[1]);
		$site = Registry :: setting('settings_site0');
		$newContent = str_replace("\'", "'", $this->page->content());
		$newContent = str_replace('\\\"', '"', $newContent);
		$newContent = str_replace('\"', '"', $newContent);
		if ($seg_1 != 'admin')
		{
			$newContent = str_replace('&amp;nbsp;', '&nbsp;', $newContent);
		}
//		$newContent = str_replace('...', '&hellip;', $newContent);

		if ($seg_1 != $site && $seg_1 != 'rss')
		{
			$bbcode_conflict = array("/\:D/is" => "<img src=\"" . FWURL . "js/emoticons/grin.png\" border=\"0\" alt=\"grin\">");
		}
		else
		{
			$bbcode_conflict = array();
		}

		if ($seg_1 != 'admin')
		{
			$bbcode_noconflict = array("/\[youtube\](.*?)\[\/youtube\]/is" => "<object width=\"425\" height=\"344\"><param name=\"movie\" value=\"http://www.youtube.com/v/$1\"></param><param name=\"allowFullScreen\" value=\"true\"></param><param name=\"allowscriptaccess\" value=\"always\"></param><param name=\"wmode>\" value=\"transparent\"></param><embed src=\"http://www.youtube.com/v/$1\" type=\"application/x-shockwave-flash\" wmode=\"transparent\" allowscriptaccess=\"always\" allowfullscreen=\"true\" width=\"425\" height=\"344\"></embed></object>", 
				"/\[vimeo\](.*?)\[\/vimeo\]/is" => "<iframe src=\"http://player.vimeo.com/video/$1?title=0&amp;byline=0&amp;portrait=0\" width=\"400\" height=\"225\" frameborder=\"0\" webkitAllowFullScreen allowFullScreen></iframe>", 
				"/\[video\](.*?)\[\/video\]/is" => "<object
  classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\"
  codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,45,2\"
  width=\"576\" height=\"324\"
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
  width=\"576\" height=\"324\"
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
</object>",
//				"/\[mp3\=(.*?)\](.*?)\[\/mp3\]/is" => "<object type=\"application/x-shockwave-flash\" height=\"15\" width=\"400\" data=\"" . FWURL . "/xspf/xspf_player_slim.swf?song_url=$1&song_title=$2&player_title=$2\"><param name=\"movie\" value=\"" . FWURL . "xspf/xspf_player_slim.swf?song_url=$1&song_title=$2&player_title=$2\" /></object>",
			"/\[mp3\](.*?)\[\/mp3\]/is" => "<object width=\"147\" height=\"45\" data=\"" . FWURL . "emff/emff_standard.swf\" type=\"application/x-shockwave-flash\"><param name=\"quality\" value=\"high\" /><param name=\"FlashVars\" value=\"src=" . FWURL . "$1\" /><param name=\"src\" value=\"" . FWURL . "emff/emff_standard.swf\" />It seems that you do not have a Flash Plugin. Please install the latest <a href=\"http://www.macromedia.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash\">Flash Player</a>.</object>",
			"/\[authorstream\](.*?)\[\/authorstream\]/is" => "<object width=\"425\" height=\"354\" id=\"player\"><param name=\"movie\" value=\"http://www.authorstream.com/player/player.swf?p=$1\" /><param name=\"allowfullscreen\" value=\"true\" /><param name=\"allowScriptAccess\" value=\"always\"/><embed src=\"http://www.authorstream.com/player/player.swf?p=$1\" type=\"application/x-shockwave-flash\" allowscriptaccess=\"always\" allowfullscreen=\"true\" width=\"425\" height=\"354\"></embed></object>",
//				"/\[video\](.*?)\[\/video\]/is" => "<a href=\"$1\" style=\"display:block;width:520px;height:330px\" id=\"player\"></a><script>flowplayer(\"player\", \"" . FWURL . "video/flowplayer-3.1.5.swf\", { clip: {autoPlay: false, autoBuffering: true } });</script>",
			"/\[cut\=(.*?)\](.*?)\[\/cut\]/is" => "<span><a href=\"#\" title=\"click here\" onclick=\"obj=this.parentNode.childNodes[1].style; tmp=(obj.display!='block') ? 'block' : 'none'; obj.display=tmp; return false;\" class=\"tagcutflag\">$1</a><div class=\"tagcut\" style=\"display: none\"><div class=\"alt2\" style=\"margin: 0px; padding: 6px; border: 1px inset;\">$2</div></div></span>", 
			"/\[quote\](.*?)\[\/quote\]/is" => '<blockquote class="style1"><span>$1</span></blockquote>', "/\[code\](.*?)\[\/code\]/is" => '<pre><code>$1</code></pre>', "/\[b\](.*?)\[\/b\]/is" => "<strong>$1</strong>", 
			"/\[u\](.*?)\[\/u\]/is" => "<u>$1</u>", 
			"/\[i\](.*?)\[\/i\]/is" => "<em>$1</em>", 
			"/\[s\](.*?)\[\/s\]/is" => "<span class=\"line-through\">$1</span>", 
			"/\[url\](.*?)\[\/url\]/is" => "<a href='$1'>$1</a>", 
			"/\[url\=(.*?)\](.*?)\[\/url\]/is" => "<a href='$1'>$2</a>", 
			"/\[img\](.*?)\[\/img\]/is" => "<img src='$1' border='0' alt=''>", 
			"/\[img\=(.*?)x(.*?)\](.*?)\[\/img\]/is" => "<img src='$3' height='$2' width='$1' border='0' alt=''>", 
"/\:\)/is" => "<img src=\"" . FWURL . "js/emoticons/smile.png\" border=\"0\" alt=\"smile\">",
"/\:angel\:/is" => "<img src=\"" . FWURL . "js/emoticons/angel.png\" border=\"0\" alt=\"angel\">",
"/\:angry\:/is" => "<img src=\"" . FWURL . "js/emoticons/angry.png\" border=\"0\" alt=\"angry\">",
"/8\-\)/is" => "<img src=\"" . FWURL . "js/emoticons/cool.png\" border=\"0\" alt=\"cool\">",
"/\:\'\(/is" => "<img src=\"" . FWURL . "js/emoticons/cwy.png\" border=\"0\" alt=\"cwy\">",
"/\:ermm\:/is" => "<img src=\"" . FWURL . "js/emoticons/ermm.png\" border=\"0\" alt=\"ermm\">",
// "/\:D/is" => "<img src=\"" . FWURL . "js/emoticons/grin.png\" border=\"0\" alt=\"grin\">",
"/\\<3/is" => "<img src=\"" . FWURL . "js/emoticons/heart.png\" border=\"0\" alt=\"heart\">",
"/\:\(/is" => "<img src=\"" . FWURL . "js/emoticons/sad.png\" border=\"0\" alt=\"shocked\">",
"/\\:O/is" => "<img src=\"" . FWURL . "js/emoticons/shocked.png\" border=\"0\" alt=\"shocked\">",
"/\\:P/is" => "<img src=\"" . FWURL . "js/emoticons/tongue.png\" border=\"0\" alt=\"tongue\">",
"/\;\)/is" => "<img src=\"" . FWURL . "js/emoticons/wink.png\" border=\"0\" alt=\"wink\">",
"/\:alien\:/is" => "<img src=\"" . FWURL . "js/emoticons/alien.png\" border=\"0\" alt=\"alien\">",
"/\:blink\:/is" => "<img src=\"" . FWURL . "js/emoticons/blink.png\" border=\"0\" alt=\"blink\">",
"/\:blush\:/is" => "<img src=\"" . FWURL . "js/emoticons/blush.png\" border=\"0\" alt=\"blush\">",
"/\:cheerful\:/is" => "<img src=\"" . FWURL . "js/emoticons/cheerful.png\" border=\"0\" alt=\"cheerful\">",
"/\:devil\:/is" => "<img src=\"" . FWURL . "js/emoticons/devil.png\" border=\"0\" alt=\"devil\">",
"/\:dizzy\:/is" => "<img src=\"" . FWURL . "js/emoticons/dizzy.png\" border=\"0\" alt=\"dizzy\">",
"/\:getlost\:/is" => "<img src=\"" . FWURL . "js/emoticons/getlost.png\" border=\"0\" alt=\"getlost\">",
"/\:happy\:/is" => "<img src=\"" . FWURL . "js/emoticons/happy.png\" border=\"0\" alt=\"happy\">",
"/\:kissing\:/is" => "<img src=\"" . FWURL . "js/emoticons/kissing.png\" border=\"0\" alt=\"kissing\">",
"/\:ninja\:/is" => "<img src=\"" . FWURL . "js/emoticons/ninja.png\" border=\"0\" alt=\"ninja\">",
"/\:pinch\:/is" => "<img src=\"" . FWURL . "js/emoticons/pinch.png\" border=\"0\" alt=\"pinch\">",
"/\:pouty\:/is" => "<img src=\"" . FWURL . "js/emoticons/pouty.png\" border=\"0\" alt=\"pouty\">",
"/\:sick\:/is" => "<img src=\"" . FWURL . "js/emoticons/sick.png\" border=\"0\" alt=\"sick\">",
"/\:sideways\:/is" => "<img src=\"" . FWURL . "js/emoticons/sideways.png\" border=\"0\" alt=\"sideways\">",
"/\:silly\:/is" => "<img src=\"" . FWURL . "js/emoticons/silly.png\" border=\"0\" alt=\"silly\">",
"/\:sleeping\:/is" => "<img src=\"" . FWURL . "js/emoticons/sleeping.png\" border=\"0\" alt=\"sleeping\">",
"/\:unsure\:/is" => "<img src=\"" . FWURL . "js/emoticons/unsure.png\" border=\"0\" alt=\"unsure\">",
"/\:woot\:/is" => "<img src=\"" . FWURL . "js/emoticons/w00t.png\" border=\"0\" alt=\"w00t\">",
"/\:wassat\:/is" => "<img src=\"" . FWURL . "js/emoticons/wassat.png\" border=\"0\" alt=\"wassat\">",
"/\:whistling\:/is" => "<img src=\"" . FWURL . "js/emoticons/whistling.png\" border=\"0\" alt=\"whistling\">",
"/\:love\:/is" => "<img src=\"" . FWURL . "js/emoticons/wub.png\" border=\"0\" alt=\"wub\">");

			$bbcode = array_merge($bbcode_conflict, $bbcode_noconflict);

			$newContent = preg_replace(array_keys($bbcode), array_values($bbcode), $newContent);
		}
		$newContent = str_replace('&#123;', '{', $newContent);
		$newContent = str_replace('&#125;', '}', $newContent);
		$this->page->setContent($newContent);
	}

	public function parser()
	{
		$this->replaceSegments();
		$this->replaceBlocks();
		$this->replaceTags();
		$this->replaceWidgetTagsInTpl();
		$this->postProcessing();
	}

	public function replaceBlocks()
	{
		$content = $this->page->content();
		preg_match_all("{\{block[\d]+\}}", $content, $matches);
//		print_r($matches);
		$blocksNumbers = array();
		foreach ($matches as $val)
		{
			$arrayLength = count($val);
			for ($i = 0; $i < $arrayLength; $i++)
			{
//				echo $val[$i];
//				echo substr(substr($val[$i], 0, -1), 6) . "<br>";
				$blocksNumbers[] = substr(substr($val[$i], 0, - 1), 6);
			}
//			print_r($blocksNumbers);
			$prefix = $this->prefix = Registry :: library('db')->getPrefix();
			$sys_cms = Registry :: library('db')->getSys();
			$numbers = implode(",", $blocksNumbers);
			if ($numbers != '')
			{
				$sql = 'SELECT *
					FROM ' . $prefix . 'blocks
					WHERE blocks_sys = "' . $sys_cms . '"
					AND block_order IN (' . $numbers . ')';
//				echo $sql;
				$cache = Registry :: library('db')->cacheQuery($sql);
				if (Registry :: library('db')->numRowsFromCache($cache) != 0)
				{
					$data = Registry :: library('db')->rowsFromCache($cache);
//					print_r($data);
					foreach ($data as $k => $v)
					{
						$newContent = str_replace('{block' . $v['block_order'] . '}', $v['block_content'], $this->page->content());
//						echo $k . ' ' . $v['block_title'] . '<br>';
						$this->page->setContent($newContent);
					}
				}
			}
		}
	}

	private function replaceIf($block)
	{
		if (strpos($block, "{if ") !== false)
		{
			$block = preg_replace("#\\{if (.+?)\\}(.*?)\\{/if\\}#ies", "\$this->check_else('\\1', '\\2', false)", $block);
		}
		return $block;
	}

	private function check_else($condition, $block)
	{
		if (is_array($matches = explode("{else}", $block)))
		{
			$block = $matches[0];
			$else
				= $matches[1];
		}
		if (eval (("return $condition;")))
			return str_replace('\"', '"', $block);
		return str_replace('\"', '"', $else
			);
	}

	public function addWidgetTag($key, $data)
	{
		$this->widgetTags[$key] = $data;
	}

	private function getWidgetTags()
	{
		return $this->widgetTags;
	}

	private function replaceWidgetTagsInTpl()
	{
		$tags = $this->getWidgetTags();
		$newContent = $this->page->content();
		foreach ($tags as $tag => $data)
		{
			$newContent = str_replace('{' . $tag . '}', $data, $newContent);
			$this->page->setContent($newContent);
		}
		$this->page->setContent($newContent);
	}

}
?>