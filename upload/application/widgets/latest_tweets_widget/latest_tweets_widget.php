<?php
if (!defined('FW'))
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit ();
}

class Latest_tweets_widget
{

	function __construct()
	{
	}

	public function index()
	{
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
			$cur_lang_code = 'EN';
		}
		if ($current_language == 'russian')
		{
			$cur_lang_code = 'RU';
		}
//
		$result = '';
// EDIT:
// https://twitter.com/ikreknin
// @ikreknin
// 475196067382689792
//CREATE WIDGET HERE: https://twitter.com/settings/widgets
// DOCS: https://dev.twitter.com/docs/embedded-timelines
		$result .= '<a class=\"twitter-timeline\" height=\"200\"  href=\"https://twitter.com/ikreknin\"  data-widget-id=\"475196067382689792\" lang=\"' . $cur_lang_code . '\">Tweets by @ikreknin</a>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?\'http\':\'https\';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+\"://platform.twitter.com/widgets.js\";fjs.parentNode.insertBefore(js,fjs);}}(document,\"script\",\"twitter-wjs\");</script>';
		return $result;
	}

}
?>