<?php

/**
* SparkFrame CMS - by Igors Kreknins
*
* @package		SparkFrame CMS
* @author		Igors Kreknins
* @copyright	Copyright (c) 2010, Igors Kreknins
* @license		GNU GPL v3
* @link			http://sparkframe.id.lv
* @since		Version 3
*/
session_start();
error_reporting(0);
define('FWURL', 'http://localhost/sparkframe/');
define('SUBDIR', '');
define('APPDIR', SUBDIR . 'application');
define('SYSDIR', SUBDIR . 'system');
define("FWPATH", dirname(__file__) . "/");
define('APPPATH', FWPATH . APPDIR . '/');
define('SYSPATH', FWPATH . SYSDIR . '/');
define("FW", true);
date_default_timezone_set("Europe/Riga");
require_once (SYSPATH . 'registry.php');
$registry = Registry :: singleton();
$registry->loadWorkingLanguages(array('english', 'russian'));
$registry->load('database', 'db');
$registry->load('template', 'template');
$registry->load('authentication', 'authenticate');
$registry->load('language', 'lang');
$registry->load('pagination', 'paginate');
$registry->load('helper', 'helper');
$registry->load('hook', 'hook');
$registry->load('crypter', 'crypter');
$registry->loadWidget('nivoslider_widget', 'nivoslider_widget');
$registry->loadWidget('ajaxemailsignup_widget', 'ajaxemailsignup_widget');
$registry->loadWidget('pages_menu_vertical_widget', 'pages_menu_vertical_widget');
$registry->loadWidget('latest_articles_widget', 'latest_articles_widget');
$registry->loadWidget('latest_articles_plus_widget', 'latest_articles_plus_widget');
$registry->loadWidget('latest_products_plus_widget', 'latest_products_plus_widget');
$registry->loadWidget('latest_comments_plus_widget', 'latest_comments_plus_widget');
$registry->loadWidget('latest_topics_plus_widget', 'latest_topics_plus_widget');
$registry->loadWidget('latest_posts_plus_widget', 'latest_posts_plus_widget');
$registry->loadWidget('latest_opinions_plus_widget', 'latest_opinions_plus_widget');
$registry->loadWidget('piecemaker_widget', 'piecemaker_widget');
$registry->loadWidget('googlemaps_widget', 'googlemaps_widget');
$registry->loadWidget('monthly_archive_widget', 'monthly_archive_widget');
$registry->loadWidget('wdsolutions_slider_widget', 'wdsolutions_slider_widget');
$registry->loadWidget('poll_widget', 'poll_widget');
$registry->loadWidget('slidedeck_widget', 'slidedeck_widget');
$registry->loadWidget('jtabsrss_widget', 'jtabsrss_widget');
$registry->loadWidget('latest_articles_frontpage_widget', 'latest_articles_frontpage_widget');
$registry->loadWidget('latest_tweets_widget', 'latest_tweets_widget');
$registry->loadWidget('elastislide_widget', 'elastislide_widget');
$registry->loadWidget('accessible_mega_menu_widget', 'accessible_mega_menu_widget');
$registry->loadWidget('jssorslider_widget', 'jssorslider_widget');
	$registry->loadWidget('article_tags_widget', 'article_tags_widget');
	$registry->loadWidget('tagcloud_widget', 'tagcloud_widget');

$sys_cms = '1';
if ($_SESSION['cms_sys'] != '')
{
	$sys_cms = $_SESSION['cms_sys'];
}
include (APPPATH . 'config/config.php');
if ($config['db_prefix'] == '')
{
	$prefix = null;
}
else
{
	$prefix = $config['db_prefix'];
}
$registry->library('db')->newConnection($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name'], $prefix, $sys_cms);
if ((isset ($_COOKIE['username'])) && (isset ($_COOKIE['password'])))
{
	$registry->library('authenticate')->cookieAuthentication($_COOKIE['username'], $_COOKIE['password']);
}
else
{
	$registry->library('authenticate')->checkAuthentication();
}
$sql = 'SELECT * FROM ' . $prefix . 'settings WHERE settings_sys = "' . $sys_cms . '"';
$registry->library('db')->execute($sql);
if ($registry->library('db')->numRows() == 1)
{
	$data = $registry->library('db')->getRows();
	foreach ($data as $k => $v)
	{
		$registry->set($v, $k);
	}
}
$registry->library('db')->setCacheOn($registry->setting('settings_cached'));
$registry->set('responsive', 'theme');
$registry->set('simple', 'admintheme');
$registry->getURLData();
$activeControllers = array();
$activeControllers[] = $registry->setting('settings_site0');
$activeControllers[] = 'admin';
$activeControllers[] = 'user';
$activeControllers[] = 'users';
$activeControllers[] = 'useraccount';
$activeControllers[] = $registry->setting('settings_forum0');
$activeControllers[] = $registry->setting('settings_shop0');
$activeControllers[] = 'cart';
$activeControllers[] = $registry->setting('settings_saef0');
$activeControllers[] = 'tag';
$m = opendir(APPPATH . 'modules') or die($php_errormsg);
while (false !== ($mf = readdir($m)))
{
	if (!is_dir($mf))
	{
		$activeControllers[] = $mf;
	}
}
$e = opendir(APPPATH . 'extensions') or die($php_errormsg);
while (false !== ($ef = readdir($e)))
{
	if (!is_dir($ef))
	{
		$activeControllers[] = $ef;
	}
}
$currentController = $registry->segment(0);
if (in_array($currentController, $activeControllers) && $currentController != '')
{
	if (substr($currentController, - 7, 7) == '_module')
	{
		require_once (APPPATH . 'modules/' . $currentController . '/' . $currentController . '.php');
		$controllerInc = $currentController . 'controller';
		$controller = new $controllerInc($registry, true);
	}
	elseif (substr($currentController, - 10, 10) == '_extension')
	{
		require_once (APPPATH . 'extensions/' . $currentController . '/' . $currentController . '.php');
		$controllerInc = $currentController;
		$controller = new $controllerInc($registry, true);
	}
	else
	{
		require_once (APPPATH . 'controllers/' . $currentController . '.php');
		$controllerInc = $currentController . 'controller';
		$controller = new $controllerInc($registry, true);
	}
}
else
{
	require_once (APPPATH . 'controllers/page.php');
	$controller = new Pagecontroller($registry, true);
}
$registry->library('template')->parser();
print $registry->library('template')->page()->content();
exit ();
?>