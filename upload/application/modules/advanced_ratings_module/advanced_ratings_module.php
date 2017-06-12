<?php
if (!defined('FW'))
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit ();
}

class Advanced_ratings_modulecontroller
{
	private $registry;
	private $prefix;
	private $sys_cms;
	private $data = array('mod_name' => 'Advanced Ratings Module', 'mod_description' => 'Advanced 5 Star Ratings Module', 'mod_version' => '1.0', 'mod_enabled' => '1', 'mod_file_name' => 'advanced_ratings_module');
	private $widget_id;
	private $dt = array();
	private $result = array();
	private $info = array();
	private $arr = array();

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

					case 'ratings' :
						$this->ratings();
						break;

					case 'save' :
						$this->save();
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
				$sql = 'CREATE TABLE `' . $this->prefix . 'art_ratings` (
`art_ratings_id` smallint(5) unsigned NOT NULL auto_increment,
`art_ratings_art_id` int(11) NOT NULL,
`art_ratings_votes` mediumint(9) unsigned NOT NULL default "0",
`art_ratings_vsum` int(11) unsigned NOT NULL default "0",
`art_ratings_rating` double NOT NULL default "0",
`art_ratings_sys` varchar(10) character set utf8 collate utf8_unicode_ci NOT NULL,
PRIMARY KEY  (`art_ratings_id`),
KEY `rating` (`art_ratings_rating`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;';
				$cache = $this->registry->library('db')->cacheQuery($sql);
				$sql = 'CREATE TABLE `' . $this->prefix . 'votes_ratings` (
`votes_ratings_id` mediumint(9) unsigned NOT NULL auto_increment,
`votes_ratings_art_id` smallint(6) unsigned NOT NULL default "0",
`votes_ratings_ip` int(10) NOT NULL default "0",
`votes_ratings_vote` tinyint(1) NOT NULL default "0",
`votes_ratings_date_submit` date NOT NULL default "0000-00-00",
`votes_ratings_sys` varchar(10) character set utf8 collate utf8_unicode_ci NOT NULL,
PRIMARY KEY  (`votes_ratings_id`),
UNIQUE KEY `votes_ratings_art_id` (`votes_ratings_art_id`,`votes_ratings_ip`,`votes_ratings_date_submit`)
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
			$sql = 'DROP TABLE ' . $this->prefix . 'art_ratings';
			$cache = $this->registry->library('db')->cacheQuery($sql);
			$sql = 'DROP TABLE ' . $this->prefix . 'votes_ratings';
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
				FROM " . $this->prefix . "ratings
				WHERE ratings_sys = '$this->sys_cms'
			";
//			$cache = $this->registry->library('db')->cacheQuery($sql);
			$num = $this->registry->library('db')->numRowsFromCache($cache);
			if ($num != 0)
			{
				$data = $this->registry->library('db')->rowsFromCache($cache);
				foreach ($data as $k => $v)
				{
					echo $v['ratings_ip'] . '<br />';
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

	public function ratings()
	{
		$this->registry->library('lang')->setLanguage($this->registry->setting('settings_lang_full'));
		$this->registry->library('lang')->loadLanguage('site');
//sanitize data
		$widgets = $this->registry->library('db')->sanitizeData($_POST['temp']);
		$sql = "SELECT *
			FROM " . $this->prefix . "art_ratings
			WHERE art_ratings_sys = '$this->sys_cms'
			AND art_ratings_art_id IN ($widgets)
		";
		$cache = $this->registry->library('db')->cacheQuery($sql);
		if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
		{
			$i = 0;
			$num = $this->registry->library('db')->numRowsFromCache($cache);
			$result = $this->registry->library('db')->rowsFromCache($cache);
			while ($i < $num)
			{
				foreach ($result as $k => $v)
				{
					$dt[$i]['widget_id'] = $v['art_ratings_art_id'];
					$dt[$i]['number_votes'] = $v['art_ratings_votes'];
					$dt[$i]['total_points'] = $v['art_ratings_vsum'];
					$dt[$i]['dec_avg'] = round($v['art_ratings_rating'], 1);
					$tempString = '';
					$tempString .= round($v['art_ratings_rating']);
					$dt[$i]['whole_avg'] = $tempString;
					$i++;
				}
			}
		}
		else
		{
			$dt['widget_id'] = $widgets;
			$dt['number_votes'] = 0;
			$dt['total_points'] = 0;
			$dt['dec_avg'] = 0;
			$dt['whole_avg'] = 0;
		}
		echo json_encode($dt);
	}

	public function save()
	{
		$this->registry->library('lang')->setLanguage($this->registry->setting('settings_lang_full'));
		$this->registry->library('lang')->loadLanguage('site');
//sanitize data
		$widgets = $this->registry->library('db')->sanitizeData($_POST['temp']);
		$click = $this->registry->library('db')->sanitizeData($_POST['click']);
		$star = $this->registry->library('db')->sanitizeData($_POST['star']);
		$star = substr($star, 5, 1);
		$ip = ip2long($_SERVER['REMOTE_ADDR']);
		$today = date("Y-m-d");
// IP Voted ?
		$sqlVoted = "SELECT *
			FROM " . $this->prefix . "votes_ratings
			WHERE votes_ratings_sys = '$this->sys_cms'
			AND votes_ratings_art_id = '$click'
			AND votes_ratings_ip = '$ip'
		";
		$this->registry->library('db')->execute($sqlVoted);
		if ($this->registry->library('db')->numRows() != 0)
		{
		}
		else
		{
			$sqlStart = "SELECT *
					FROM " . $this->prefix . "art_ratings
					WHERE art_ratings_sys = '$this->sys_cms'
					AND art_ratings_art_id = '$click'
				";
			$cache = $this->registry->library('db')->cacheQuery($sqlStart);
			if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
			{
				$result = $this->registry->library('db')->rowsFromCache($cache);
				foreach ($result as $k => $v)
				;
				{
					$upd['art_ratings_art_id'] = $v['art_ratings_art_id'];
					$upd['art_ratings_votes'] = $v['art_ratings_votes'] + 1;
					$upd['art_ratings_vsum'] = $v['art_ratings_vsum'] + $star;
					$upd['art_ratings_rating'] = $upd['art_ratings_vsum'] / $upd['art_ratings_votes'];
				}
				$this->registry->library('db')->updateRecordsSys('art_ratings', $upd, 'art_ratings_art_id=' . $click);
			}
			else
			{
				$ins['art_ratings_art_id'] = $click;
				$ins['art_ratings_votes'] = 1;
				$ins['art_ratings_vsum'] = $star;
				$ins['art_ratings_rating'] = $star;
				$this->registry->library('db')->insertRecordsSys('art_ratings', $ins);
			}
			$info['votes_ratings_art_id'] = $click;
			$info['votes_ratings_ip'] = $ip;
			$info['votes_ratings_vote'] = $star;
			$info['votes_ratings_date_submit'] = $today;
			$this->registry->library('db')->insertRecordsSys('votes_ratings', $info);
		}
// Get Rating
		$sql = "SELECT *
			FROM " . $this->prefix . "art_ratings
			WHERE art_ratings_sys = '$this->sys_cms'
			AND art_ratings_art_id IN ($widgets)
		";
		$cache = $this->registry->library('db')->cacheQuery($sql);
		if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
		{
			$i = 0;
			$num = $this->registry->library('db')->numRowsFromCache($cache);
			$result = $this->registry->library('db')->rowsFromCache($cache);
			while ($i < $num)
			{
				foreach ($result as $k => $v)
				{
					$dt[$i]['widget_id'] = $v['art_ratings_art_id'];
					$dt[$i]['number_votes'] = $v['art_ratings_votes'];
					$dt[$i]['total_points'] = $v['art_ratings_vsum'];
					$dt[$i]['dec_avg'] = $v['art_ratings_rating'];
					$tempString = '';
					$tempString .= round($v['art_ratings_rating']);
					$dt[$i]['whole_avg'] = $tempString;
					$i++;
				}
			}
		}
		echo json_encode($dt);
	}

}
?>