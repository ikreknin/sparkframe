<?php
if (!defined('FW'))
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit ();
}

class Ajaxemailsignup_modulecontroller
{
	private $registry;
	private $prefix;
	private $sys_cms;
	private $data = array('mod_name' => 'AJAX Email Signup Module', 'mod_description' => 'AJAX Email Signup', 'mod_version' => '1.0', 'mod_enabled' => '1', 'mod_file_name' => 'ajaxemailsignup_module');

	public function __construct(Registry $registry, $directCall)
	{
		$this->registry = $registry;
		if ($directCall == true)
		{
			$this->prefix = $this->registry->library('db')->getPrefix();
			$this->sys_cms = $this->registry->library('db')->getSys();
			$this->registry->library('lang')->setLanguage($this->registry->setting('settings_lang_full'));
			$this->registry->library('lang')->loadLanguage('site');
			$this->registry->library('template')->page()->addTag('click_here_if', $this->registry->library('lang')->line('click_here_if'));
			$urlSegments = $this->registry->getURLSegments();
			if (!isset ($urlSegments[1]))
			{
				$this->index();
			}
			else
			{
				switch ($urlSegments[1])
				{

					case 'install' :
						$this->install();
						break;

					case 'uninstall' :
						$this->uninstall();
						break;

					case 'add' :
						$this->add();
						break;

					default :
						$this->pageNotFound();
						break;
				}
			}
		}
	}

	private function pageNotFound()
	{
		echo '<meta http-equiv="Refresh" content="0; url=' . FWURL . '">';
	}

	public function install()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true || $this->registry->library('authenticate')->hasPermission('install_modules') == true)
		{
			$urlSegments = $this->registry->getURLSegments();
			$seg_0 = $urlSegments[0];
			$sql = 'SELECT *, COUNT(mod_id) AS `modules_count` FROM ' . $this->prefix . 'modules WHERE mod_file_name = "' . $this->data['mod_file_name'] . '" GROUP BY mod_id';
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) == 0)
			{
				$sql = 'CREATE TABLE `' . $this->prefix . 'signups` (
					`signups_id` int(10) NOT NULL AUTO_INCREMENT,
					`signup_email_address` varchar(250) DEFAULT NULL,
					`signup_date` date DEFAULT NULL,
					`signup_time` time DEFAULT NULL,
					`signups_sys` varchar(10) character set utf8 collate utf8_unicode_ci NOT NULL,
					PRIMARY KEY (`signups_id`)
				) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;';
				$cache = $this->registry->library('db')->cacheQuery($sql);
				$this->registry->library('db')->insertRecords('modules', $this->data);
			}
			$this->registry->redirectUser('admin/modules', $this->registry->library('lang')->line('installed_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'), false);
		}
		else
		{
			$this->pageNotFound();
		}
	}

	public function uninstall()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true || $this->registry->library('authenticate')->hasPermission('install_modules') == true)
		{
			$sql = sprintf("DELETE FROM `" . $this->prefix . "modules` WHERE `mod_file_name` = '%s' LIMIT 1", $this->data['mod_file_name']);
			$cache = $this->registry->library('db')->cacheQuery($sql);
			$sql = 'DROP TABLE ' . $this->prefix . 'signups';
			$cache = $this->registry->library('db')->cacheQuery($sql);
			$this->registry->redirectUser('admin/modules', $this->registry->library('lang')->line('uninstalled_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'), false);
		}
		else
		{
			$this->pageNotFound();
		}
	}

	public function index()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true || $this->registry->library('authenticate')->hasPermission('install_modules') == true)
		{
			$sql = "SELECT *
				FROM " . $this->prefix . "signups
				WHERE signups_sys = '$this->sys_cms'
			";
			$cache = $this->registry->library('db')->cacheQuery($sql);
			$num = $this->registry->library('db')->numRowsFromCache($cache);
			if ($num != 0)
			{
				$data = $this->registry->library('db')->rowsFromCache($cache);
				foreach ($data as $k => $v)
				{
					echo $v['signup_email_address'] . '<br />';
				}
			}
			else
			{
				echo 'No Results';
			}
		}
		else
		{
			$this->pageNotFound();
		}
	}

	public function add()
	{
		$this->registry->library('lang')->setLanguage($this->registry->setting('settings_lang_full'));
		$this->registry->library('lang')->loadLanguage('site');
//sanitize data
		$email = $this->registry->library('db')->sanitizeData($_POST['signup-email']);
//validate email address - check if input was empty
		if (empty ($email))
		{
			$status = "error";
			$message = $this->registry->library('lang')->line('no_email');
		}
		else
			if (!preg_match('/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/', $email))
			{
//validate email address - check if is a valid email address
				$status = "error";
				$message = $this->registry->library('lang')->line('incorrect_email');
			}
			else
			{
				$existingSignup = "SELECT *
					FROM " . $this->prefix . "signups
					WHERE signup_email_address='$email'
					AND signups_sys = '$this->sys_cms'";
				$cache = $this->registry->library('db')->cacheQuery($existingSignup);
				if ($this->registry->library('db')->numRowsFromCache($cache) == 0)
				{
					$date = date('Y-m-d');
					$time = date('H:i:s');
					$data = array();
					$data['signup_email_address'] = $email;
					$data['signup_date'] = $date;
					$data['signup_time'] = $time;
					$this->registry->library('db')->insertRecordsSys('signups', $data);
					if ($this->registry->library('db')->affectedRows() != 0)
					{
//if insert is successful
						$status = "success";
						$message = $this->registry->library('lang')->line('signed');
					}
					else
					{
//if insert fails
						$status = "error";
						$message = $this->registry->library('lang')->line('tech_err');
					}
				}
				else
				{
//if already signed up
					$status = "error";
					$message = $this->registry->library('lang')->line('already_registered_email');
				}
		}
//return json response
		$data = array('status' => $status, 'message' => $message);
		echo json_encode($data);
		exit;
	}

}
?>