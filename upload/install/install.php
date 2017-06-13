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

define('FWURL', 'http://localhost/sparkframe/');
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

require_once(FWPATH . 'install/i300.php');
$controller = new i300($registry, true);

$registry->library('template')->parser();
print $registry->library('template')->page()->content();

exit();

?>