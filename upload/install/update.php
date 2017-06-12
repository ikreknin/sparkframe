<?php
/**
 * SparkFrame CMS - by Igor Kreknin
 *
 * @package		SparkFrame CMS
 * @author		Igor Kreknin
 * @copyright	Copyright (c) 2010, Igor Kreknin
 * @license		GNU GPL v3
 * @link		http://sparkframe.com
 * @since		Version 2.0
 */

session_start();

define('FWURL', 'http://sparkframe.id.lv/');
define('SUBDIR', '');
define('APPDIR', SUBDIR . 'application');
define('SYSDIR', SUBDIR . 'system');
$dirname = (substr(dirname(__FILE__), 0, -8));
define("FWPATH", $dirname . "/");
define('APPPATH', FWPATH . APPDIR . '/');
define('SYSPATH', FWPATH . SYSDIR . '/');
define("FW", true);

require_once(SYSPATH . 'registry.php');
$registry = Registry::singleton();

$registry->loadWorkingLanguages(array('english', 'russian'));

$registry->load('database', 'db');
$registry->load('template', 'template');
$registry->load('authentication', 'authenticate');
$registry->load('language', 'lang');
$registry->load('pagination', 'paginate');
$registry->load('helper', 'helper');
$registry->load('hook', 'hook');

$registry->set('default', 'theme');

$registry->getURLData();
$currentController = $registry->segment(0);

include(APPPATH . 'config/config.php');
if($config['db_prefix'] == '') { $prefix = NULL; }
else { $prefix = $config['db_prefix']; }
$registry->library('db')->newConnection($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name'], $prefix, $sys_cms);

$registry->library('authenticate')->checkAuthentication();

if($registry->library('authenticate')->isAdmin() == true || $registry->library('authenticate')->hasPermission('access_admin') == true)
{
// Read current version

if($_POST['processing'] != 'processing')
{
	$sql0 = "CREATE TABLE IF NOT EXISTS `' . $prefix . 'cms` (
		`cms_id` int(11) NOT NULL auto_increment,
		`ver` int(3) NOT NULL default '200',
		PRIMARY KEY  (`cms_id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2";
	$registry->library('db')->execute($sql0);

	$created = 0;
	$sql = 'SELECT * FROM ' . $prefix . 'cms WHERE cms_id = "1"';
	$registry->library('db')->execute($sql);
	if($registry->library('db')->numRows() == 1)
	{
		$data = $registry->library('db')->getRows();
		foreach($data as $k => $v)
		{
			$created = 1;
		}
	}
	if ($created == 0)
	{
		$sql0 = "INSERT INTO `' . $prefix . 'cms` (`cms_id`, `ver`) VALUES (1, 200)";
		$registry->library('db')->execute($sql0);
	}
}

$sql = 'SELECT * FROM ' . $prefix . 'cms WHERE cms_id = "1"';
$registry->library('db')->execute($sql);
if($registry->library('db')->numRows() == 1)
{
	$data = $registry->library('db')->getRows();
	foreach($data as $k => $v)
	{
		$registry->set($v, $k);
	}
}
$next_version = $registry->setting('ver') + 1;


// Read all updates

$updateFiles = array();

$string = "";
$fileCount = 0;
$filePath = FWPATH . 'install/';
$dir = opendir($filePath);
while ($file = readdir($dir))
{ 
	if (eregi("\.php",$file))
	{
		if (substr($file,0,1) == 'u' && substr($file,1,1) != 'p')
		{
			$string .= "$file<br />";
			$updateFiles[] = "$file";
			$fileCount++;
		}
	}
}


// Remove previous & current updates

$updateFilesToUse = array();

$i = 0;
while ($i < count($updateFiles))
{
	if (substr($updateFiles[$i],1) >= $next_version)
	{
		$updateFilesToUse[] = $updateFiles[$i];
	}
	$i++;
}


// Install new updates

if (count($updateFilesToUse) !=0)
{
	require_once(FWPATH . 'install/' . $updateFilesToUse[0]);

	if($updateFilesToUse[0] == 'u201.php') { $controller = new u201($registry, true); }
	if($updateFilesToUse[0] == 'u202.php') { $controller = new u202($registry, true); }
	if($updateFilesToUse[0] == 'u203.php') { $controller = new u203($registry, true); }
	if($updateFilesToUse[0] == 'u204.php') { $controller = new u204($registry, true); }
	if($updateFilesToUse[0] == 'u205.php') { $controller = new u205($registry, true); }
	if($updateFilesToUse[0] == 'u206.php') { $controller = new u206($registry, true); }
	if($updateFilesToUse[0] == 'u207.php') { $controller = new u207($registry, true); }
	if($updateFilesToUse[0] == 'u208.php') { $controller = new u208($registry, true); }
	if($updateFilesToUse[0] == 'u209.php') { $controller = new u209($registry, true); }
	if($updateFilesToUse[0] == 'u210.php') { $controller = new u210($registry, true); }
	if($updateFilesToUse[0] == 'u211.php') { $controller = new u211($registry, true); }
	if($updateFilesToUse[0] == 'u212.php') { $controller = new u212($registry, true); }
	if($updateFilesToUse[0] == 'u213.php') { $controller = new u213($registry, true); }
	if($updateFilesToUse[0] == 'u214.php') { $controller = new u214($registry, true); }
	if($updateFilesToUse[0] == 'u215.php') { $controller = new u215($registry, true); }
	if($updateFilesToUse[0] == 'u216.php') { $controller = new u216($registry, true); }
	if($updateFilesToUse[0] == 'u217.php') { $controller = new u217($registry, true); }
	if($updateFilesToUse[0] == 'u218.php') { $controller = new u218($registry, true); }
	if($updateFilesToUse[0] == 'u219.php') { $controller = new u219($registry, true); }
	if($updateFilesToUse[0] == 'u220.php') { $controller = new u220($registry, true); }
	if($updateFilesToUse[0] == 'u221.php') { $controller = new u221($registry, true); }
	if($updateFilesToUse[0] == 'u222.php') { $controller = new u222($registry, true); }
	if($updateFilesToUse[0] == 'u223.php') { $controller = new u223($registry, true); }
	if($updateFilesToUse[0] == 'u224.php') { $controller = new u224($registry, true); }
	if($updateFilesToUse[0] == 'u225.php') { $controller = new u225($registry, true); }
	if($updateFilesToUse[0] == 'u226.php') { $controller = new u226($registry, true); }
	if($updateFilesToUse[0] == 'u227.php') { $controller = new u227($registry, true); }
	if($updateFilesToUse[0] == 'u228.php') { $controller = new u228($registry, true); }
	if($updateFilesToUse[0] == 'u229.php') { $controller = new u229($registry, true); }
	if($updateFilesToUse[0] == 'u230.php') { $controller = new u230($registry, true); }
	if($updateFilesToUse[0] == 'u231.php') { $controller = new u231($registry, true); }
	if($updateFilesToUse[0] == 'u232.php') { $controller = new u232($registry, true); }
	if($updateFilesToUse[0] == 'u233.php') { $controller = new u233($registry, true); }
	if($updateFilesToUse[0] == 'u234.php') { $controller = new u234($registry, true); }
	if($updateFilesToUse[0] == 'u235.php') { $controller = new u235($registry, true); }
	if($updateFilesToUse[0] == 'u236.php') { $controller = new u236($registry, true); }
	if($updateFilesToUse[0] == 'u237.php') { $controller = new u237($registry, true); }
	if($updateFilesToUse[0] == 'u238.php') { $controller = new u238($registry, true); }
	if($updateFilesToUse[0] == 'u239.php') { $controller = new u239($registry, true); }
	if($updateFilesToUse[0] == 'u240.php') { $controller = new u240($registry, true); }
	if($updateFilesToUse[0] == 'u241.php') { $controller = new u241($registry, true); }
	if($updateFilesToUse[0] == 'u242.php') { $controller = new u242($registry, true); }
	if($updateFilesToUse[0] == 'u300.php') { $controller = new u300($registry, true); }
	if($updateFilesToUse[0] == 'u301.php') { $controller = new u301($registry, true); }
	if($updateFilesToUse[0] == 'u302.php') { $controller = new u302($registry, true); }
	if($updateFilesToUse[0] == 'u303.php') { $controller = new u303($registry, true); }
	if($updateFilesToUse[0] == 'u304.php') { $controller = new u304($registry, true); }
	if($updateFilesToUse[0] == 'u305.php') { $controller = new u305($registry, true); }
	if($updateFilesToUse[0] == 'u306.php') { $controller = new u306($registry, true); }
	if($updateFilesToUse[0] == 'u307.php') { $controller = new u307($registry, true); }
}
else
{
	echo 'YOUR SYSTEN IS UP-TO-DATE.<br>
	<h3 style="color:red">!!! DELETE INSTALL DIRECTORY !!!</h3>';
}

$registry->library('template')->parser();
print $registry->library('template')->page()->content();
}
else
{
	echo 'You should be logged in as Admin to update this software';
}


exit();

?>