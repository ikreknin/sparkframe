<?php
if (!defined('FW'))
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit ();
}

class Poll_modulecontroller
{
	private $registry;
	private $prefix;
	private $sys_cms;
	private $data = array('mod_name' => 'Poll Module', 'mod_description' => 'Poll Module', 'mod_version' => '1.0', 'mod_enabled' => '1', 'mod_file_name' => 'poll_module');
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
			if ($_SESSION['language'] != '')
			{
				$this->registry->library('lang')->setLanguage($_SESSION['language']);
			}
			else
			{
				$this->registry->library('lang')->setLanguage($this->registry->setting('settings_lang_full'));
			}
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

					case 'add_poll' :
						$this->add_poll();
						break;

					case 'edit_poll' :
						$this->edit_poll();
						break;

					case 'update_poll' :
						$this->update_poll();
						break;

					case 'save_poll' :
						$this->save_poll();
						break;

					case 'delete_poll' :
						$this->delete_poll();
						break;

					case 'add_group' :
						$this->add_group();
						break;

					case 'delete_group' :
						$this->delete_group();

					case 'vote' :
						$this->vote();

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
				$sql = "CREATE TABLE IF NOT EXISTS `" . $this->prefix . "poll` (
  `pollid` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(255) DEFAULT NULL,
  `answer0` varchar(255) DEFAULT NULL,
  `answer1` varchar(255) DEFAULT NULL,
  `answer2` varchar(255) DEFAULT NULL,
  `answer3` varchar(255) DEFAULT NULL,
  `answer4` varchar(255) DEFAULT NULL,
  `answer5` varchar(255) DEFAULT NULL,
  `answer6` varchar(255) DEFAULT NULL,
  `answer7` varchar(255) DEFAULT NULL,
  `answer8` varchar(255) DEFAULT NULL,
  `answer9` varchar(255) DEFAULT NULL,
  `visible` enum('y','n') NOT NULL DEFAULT 'y',
  `poll_group` int(9) NOT NULL,
  `poll_sys` varchar(10) character set utf8 collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`pollid`),
  KEY `poll_group` (`poll_group`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
				$this->registry->library('db')->execute($sql);
				$sql = "CREATE TABLE IF NOT EXISTS `" . $this->prefix . "poll_group` (
  `groupid` int(11) NOT NULL AUTO_INCREMENT,
  `group` varchar(255) NOT NULL,
  `poll_group_sys` varchar(10) character set utf8 collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`groupid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
				$this->registry->library('db')->execute($sql);
				$sql = "CREATE TABLE IF NOT EXISTS `" . $this->prefix . "poll_results` (
  `poll_id` int(11) NOT NULL,
  `choices` varchar(20) DEFAULT NULL,
  `votes` int(11) DEFAULT NULL,
  `poll_results_sys` varchar(10) character set utf8 collate utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8";
				$this->registry->library('db')->execute($sql);
				$sql = "CREATE TABLE IF NOT EXISTS `" . $this->prefix . "poll_vote` (
  `voteid` int(11) NOT NULL AUTO_INCREMENT,
  `pollid` int(11) NOT NULL,
  `userip` varchar(15) NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `poll_vote_sys` varchar(10) character set utf8 collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`voteid`),
  KEY `pollid` (`pollid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
				$this->registry->library('db')->execute($sql);
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
			$sql = 'DROP TABLE ' . $this->prefix . 'poll';
			$this->registry->library('db')->execute($sql);
			$sql = 'DROP TABLE ' . $this->prefix . 'poll_group';
			$this->registry->library('db')->execute($sql);
			$sql = 'DROP TABLE ' . $this->prefix . 'poll_results';
			$this->registry->library('db')->execute($sql);
			$sql = 'DROP TABLE ' . $this->prefix . 'poll_vote';
			$this->registry->library('db')->execute($sql);
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
			echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>' . $this->registry->library('lang')->line('polls') . '</title>';
			$this->css_js();
			echo '</head>
<body>

<div class="dialogframe" title="Dialog Window"><span class="loadingshown"></span><iframe src="poll_module" width="100%" height="100%">' . $this->registry->library('lang')->line('error_occurred') . '</iframe></div>
<div class="confirm" title="' . $this->registry->library('lang')->line('r_u_sure') . '">' . $this->registry->library('lang')->line('r_u_sure_delete_this') . '</div>
<div class="confirmmultiple" title="' . $this->registry->library('lang')->line('r_u_sure') . '">' . $this->registry->library('lang')->line('r_u_sure_delete_these') . '</div>

<div class="wrap">
<div class="widget">
<div class="sfpoll widget-content module leftcolumn">
  <div class="module-title">' . $this->registry->library('lang')->line('polls') . '<span class="loading"></span><span class="ui-state-default ui-corner-all add"><a class="ui-icon ui-icon-circle-plus frameopen" href="poll_module/add_poll" title="Add Poll"></a></span></div>
  <ul class="sfpoll-groups">
    <li class="group"><span class="active">' . $this->registry->library('lang')->line('all_polls') . '</span></li>';
			$sql = 'SELECT *
	FROM ' . $this->prefix . 'poll_group
	WHERE poll_group_sys = "' . $this->sys_cms . '"
	ORDER BY `group` ASC';
			$cache = $this->registry->library('db')->cacheQuery($sql);
			$numGrroups = $this->registry->library('db')->numRowsFromCache($cache);
			if ($numGrroups != 0)
			{
				$dataGroups = $this->registry->library('db')->rowsFromCache($cache);
				foreach ($dataGroups as $k => $v)
				{
					echo '<li class="group' . $v['groupid'] . '"><span>' . $v['group'] . '</span></li>';
				}
			}
			echo '    </ul>

  <div class="poll-column">
    <ul class="group-list group all-polls">';
			$sql = 'SELECT *
	FROM ' . $this->prefix . 'poll
	WHERE poll_sys = "' . $this->sys_cms . '"
	ORDER BY `pollid` DESC';
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
			{
				$dataPolls = $this->registry->library('db')->rowsFromCache($cache);
				foreach ($dataPolls as $k => $v)
				{
					echo '<li class="group' . $v['groupid'] . '"><span>' . $v['group'] . '</span></li>';
					echo '      <li class="poll' . $v['pollid'] . '">
        <input type="checkbox" class="selectbox"/>
        <p>' . $v['question'] . '<a class="edit frameopen" href="poll_module/edit_poll/' . $v['pollid'] . '" title="Edit This Poll"><img src="' . FWURL . APPDIR . '/modules/poll_module/css/images/edit-trans.png" alt="' . $this->registry->library('lang')->line('edit') . '" /></a> <a class="delete" href="poll_module/delete_poll/' . $v['pollid'] . '" title="' . $this->registry->library('lang')->line('delete_this_poll') . '"><img src="' . FWURL . APPDIR . '/modules/poll_module/css/images/delete-trans.png" alt="' . $this->registry->library('lang')->line('delete') . '" /></a></p>
      </li>';
				}
			}
			echo '    </ul>';
			foreach ($dataGroups as $kg => $vg)
			{
				echo '     <ul class="group-list group' . $vg['groupid'] . '">';
				if ($dataPolls != null)
				{
					foreach ($dataPolls as $kp => $vp)
					{
						if ($vp['poll_group'] == $vg['groupid'])
						{
							echo '      <li class="poll' . $vp['pollid'] . '">
        <input type="checkbox" />
        <p>' . $vp['question'] . '<a class="edit frameopen" href="poll_module/edit_poll/' . $vp['pollid'] . '" title="Click here to edit this task"><img src="' . FWURL . APPDIR . '/modules/poll_module/css/images/edit-trans.png" alt="' . $this->registry->library('lang')->line('edit') . '" /></a> <a class="delete" href="poll_module/delete_poll/' . $vp['pollid'] . '" title="Click here to delete this task"><img src="' . FWURL . APPDIR . '/modules/poll_module/css/images/delete-trans.png" alt="' . $this->registry->library('lang')->line('edit') . '" /></a></p>
      </li>';
						}
					}
				}
				echo '    </ul>';
			}
			echo '  </div>
	  <div class="poll-info">
    <ul>
      <li class="showfirst"><br />
        <h1 class="sub-text">' . $this->registry->library('lang')->line('click_poll_view') . '</h1>
      </li>';
			if ($dataPolls != null)
			{
				foreach ($dataPolls as $kp => $vp)
				{
					echo '      <li class="poll' . $vp['pollid'] . '">
        	<h2>' . $vp['question'] . '</h2>
        	<br />';
					if ($vp['answer0'] != '')
					{
						echo '<p><h3>' . $this->registry->library('lang')->line('answer') . ' 1:</h3> ' . $vp['answer0'] . '</p><br />';
					}
					if ($vp['answer1'] != '')
					{
						echo '<p><h3>' . $this->registry->library('lang')->line('answer') . ' 2:</h3> ' . $vp['answer1'] . '</p><br />';
					}
					if ($vp['answer2'] != '')
					{
						echo '<p><h3>' . $this->registry->library('lang')->line('answer') . ' 3:</h3> ' . $vp['answer2'] . '</p><br />';
					}
					if ($vp['answer3'] != '')
					{
						echo '<p><h3>' . $this->registry->library('lang')->line('answer') . ' 4:</h3> ' . $vp['answer3'] . '</p><br />';
					}
					if ($vp['answer4'] != '')
					{
						echo '<p><h3>' . $this->registry->library('lang')->line('answer') . ' 5:</h3> ' . $vp['answer4'] . '</p><br />';
					}
					if ($vp['answer5'] != '')
					{
						echo '<p><h3>' . $this->registry->library('lang')->line('answer') . ' 6:</h3> ' . $vp['answer5'] . '</p><br />';
					}
					if ($vp['answer6'] != '')
					{
						echo '<p><h3>' . $this->registry->library('lang')->line('answer') . ' 7:</h3> ' . $vp['answer6'] . '</p><br />';
					}
					if ($vp['answer7'] != '')
					{
						echo '<p><h3>' . $this->registry->library('lang')->line('answer') . ' 8:</h3> ' . $vp['answer7'] . '</p><br />';
					}
					if ($vp['answer8'] != '')
					{
						echo '<p><h3>' . $this->registry->library('lang')->line('answer') . ' 9:</h3> ' . $vp['answer8'] . '</p><br />';
					}
					if ($vp['answer9'] != '')
					{
						echo '<p><h3>' . $this->registry->library('lang')->line('answer') . ' 10:</h3> ' . $vp['answer9'] . '</p><br />';
					}
					echo '        <p class="sub-text">' . $this->registry->library('lang')->line('visible') . ': ' . $this->registry->library('lang')->line($vp['visible']) . '</p>
    	    <br />
      	</li>';
				}
			}
			echo '  </div>

</div>


<div class="widget-content rightcolumn">

<div class="white-module ui-corner-all">
	<a href="admin" title="Click to Return Admin CP"><div style="color:black; borders:none">Admin CP</div></a>
</div>

<div class="rightcolumn small">
	<ul class="side-nav">
		<li><a href="#" class="ui-corner-all expandable">' . $this->registry->library('lang')->line('add_poll_group') . '<span class="nav-icons ui-state-default"><span class="nav-icons ui-icon ui-icon-triangle-2-n-s"></span></span></a>
			<div class="module rightcolumn small expand-content">
				<div class="group-add">
					<form action="' . FWURL . 'poll_module/add_group" method="post" class="validate">
						<p>Group:</p><input type="text" name="Group">
						<button type="submit" class="save_group"></button>
            		</form>
				</div>
        	</div>
		</li>
			<li><a href="poll_module/add_poll" class="frameopen ui-corner-all notexpandable dialog-link" title="Add Poll"><span class="nav-icons ui-state-default"><span class="nav-icons ui-icon ui-icon-circle-plus"></span></span>' . $this->registry->library('lang')->line('add_poll') . '</a>
			</li>
			<li><a href="#" class="ui-corner-all expandable"><span class="nav-icons ui-state-default"><span class="nav-icons ui-icon ui-icon-triangle-2-n-s"></span></span>' . $this->registry->library('lang')->line('edit_poll_groups') . '</a>
				<div class="module rightcolumn small expand-content">
            		<div class="group-edit">';
			if ($numGrroups != 0)
			{
				foreach ($dataGroups as $k => $v)
				{
					echo '<div class="row"><a class="delete" href="poll_module/delete_group/' . $v['groupid'] . '" title="Click here to delete this group"><img src="' . FWURL . APPDIR . '/modules/poll_module/css/images/delete-trans.png" alt="' . $this->registry->library('lang')->line('delete') . '"></a> <span>' . $v['group'] . '</span></div>';
				}
			}
			else
			{
				echo '<p>' . $this->registry->library('lang')->line('no groups_yet') . '</p>';
			}
			echo '
            		</div>
            	</div>
			</li>
			<li><a href="#" class="ui-corner-all notexpandable edit-poll-dialog frameopen edit" title="Edit the selected poll">' . $this->registry->library('lang')->line('edit_this_poll') . '<span class="nav-icons ui-state-default"><span class="nav-icons ui-icon ui-icon-circle-plus"></span></span></a>
			</li>
			<li><a href="#" class="ui-corner-all notexpandable delete-selected-dialog dialog-link edit" title="Delete Selected Items">' . $this->registry->library('lang')->line('delete_selected') . '<span class="nav-icons ui-state-default"><span class="nav-icons ui-icon ui-icon-circle-plus"></span></span></a>
			</li>
	</ul>
</div>
</div>
</div>
</div>

</body>
</html>';
		}
		else
		{
			$this->pageNotFound();
		}
	}

	public function add_poll()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true || $this->registry->library('authenticate')->hasPermission('install_modules') == true)
		{
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
			$this->css_js();
			echo '<div class="module fullwidth">
	<h2 class="module-title">' . $this->registry->library('lang')->line('add_poll') . '</h2>
	<div class="poll-add">
		<form action="' . FWURL . 'poll_module/save_poll" method="post" class="validate">
			<p>' . $this->registry->library('lang')->line('question') . ':</p><input type="text" name="question" class="required">
            <p>' . $this->registry->library('lang')->line('answer') . ' 0:</p><input type="text" name="answer0"  class="required">
            <p>' . $this->registry->library('lang')->line('answer') . ' 1:</p><input type="text" name="answer1"  class="required">
            <p>' . $this->registry->library('lang')->line('answer') . ' 2:</p><input type="text" name="answer2">
            <p>' . $this->registry->library('lang')->line('answer') . ' 3:</p><input type="text" name="answer3">
            <p>' . $this->registry->library('lang')->line('answer') . ' 4:</p><input type="text" name="answer4">
            <p>' . $this->registry->library('lang')->line('answer') . ' 5:</p><input type="text" name="answer5">
            <p>' . $this->registry->library('lang')->line('answer') . ' 6:</p><input type="text" name="answer6">
            <p>' . $this->registry->library('lang')->line('answer') . ' 7:</p><input type="text" name="answer7">
            <p>' . $this->registry->library('lang')->line('answer') . ' 8:</p><input type="text" name="answer8">
            <p>' . $this->registry->library('lang')->line('answer') . ' 9:</p><input type="text" name="answer9">
			<p>' . $this->registry->library('lang')->line('visible') . ':</p>

			<select name="visible">
				<option value="y" selected="selected">' . $this->registry->library('lang')->line('yes') . '</option>
				<option value="n">' . $this->registry->library('lang')->line('no') . '</option>
			</select><br />

			<select name="poll_group">
			';
			$sql = 'SELECT *
	FROM ' . $this->prefix . 'poll_group
	WHERE poll_group_sys = "' . $this->sys_cms . '"
	ORDER BY `group` ASC';
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
			{
				$dataGroups = $this->registry->library('db')->rowsFromCache($cache);
				foreach ($dataGroups as $k => $v)
				{
					echo '	<option value="' . $v['groupid'] . '">' . $v['group'] . '</option>
				';
				}
			}
			echo '	</select>

			<button type="submit" class="save"></button>

		</form>
	</div>
</div>
';
		}
	}

	private function save_poll()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true || $this->registry->library('authenticate')->hasPermission('install_modules') == true)
		{
			$data = array();
			$data['question'] = $this->registry->library('db')->sanitizeData($_POST['question']);
			$data['answer0'] = $this->registry->library('db')->sanitizeData($_POST['answer0']);
			$data['answer1'] = $this->registry->library('db')->sanitizeData($_POST['answer1']);
			$data['answer2'] = $this->registry->library('db')->sanitizeData($_POST['answer2']);
			$data['answer3'] = $this->registry->library('db')->sanitizeData($_POST['answer3']);
			$data['answer4'] = $this->registry->library('db')->sanitizeData($_POST['answer4']);
			$data['answer5'] = $this->registry->library('db')->sanitizeData($_POST['answer5']);
			$data['answer6'] = $this->registry->library('db')->sanitizeData($_POST['answer6']);
			$data['answer7'] = $this->registry->library('db')->sanitizeData($_POST['answer7']);
			$data['answer8'] = $this->registry->library('db')->sanitizeData($_POST['answer8']);
			$data['answer9'] = $this->registry->library('db')->sanitizeData($_POST['answer9']);
			$data['visible'] = $this->registry->library('db')->sanitizeData($_POST['visible']);
			$data['poll_group'] = $this->registry->library('db')->sanitizeData($_POST['poll_group']);
			$this->registry->library('db')->insertRecordsSys('poll', $data);
//			$this->registry->redirectUser('poll_module', $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	public function edit_poll()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true || $this->registry->library('authenticate')->hasPermission('install_modules') == true)
		{
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
			$this->css_js();
			$urlSegments = $this->registry->getURLSegments();
			$sql = 'SELECT *
	FROM ' . $this->prefix . 'poll
	WHERE poll_sys = "' . $this->sys_cms . '"
		AND pollid = "' . $this->registry->library('db')->sanitizeData($urlSegments[2]) . '"
	ORDER BY `pollid` DESC';
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
			{
				$dataGroups = $this->registry->library('db')->rowsFromCache($cache);
				foreach ($dataGroups as $kp => $vp)
				{
					echo '<div class="module fullwidth">
	<h2 class="module-title">' . $this->registry->library('lang')->line('edit_poll') . '</h2>
	<div class="poll-add">
		<form action="' . FWURL . 'poll_module/update_poll/' . $vp['pollid'] . '" method="post" class="validate">
			<p>' . $this->registry->library('lang')->line('question') . ':</p><input value="' . $vp['question'] . '" type="text" name="question" class="required">
            <p>' . $this->registry->library('lang')->line('answer') . ' 0:</p><input value="' . $vp['answer0'] . '" type="text" name="answer0"  class="required">
            <p>' . $this->registry->library('lang')->line('answer') . ' 1:</p><input value="' . $vp['answer1'] . '" type="text" name="answer1"  class="required">
            <p>' . $this->registry->library('lang')->line('answer') . ' 2:</p><input value="' . $vp['answer2'] . '" type="text" name="answer2">
            <p>' . $this->registry->library('lang')->line('answer') . ' 3:</p><input value="' . $vp['answer3'] . '" type="text" name="answer3">
            <p>' . $this->registry->library('lang')->line('answer') . ' 4:</p><input value="' . $vp['answer4'] . '" type="text" name="answer4">
            <p>' . $this->registry->library('lang')->line('answer') . ' 5:</p><input value="' . $vp['answer5'] . '" type="text" name="answer5">
            <p>' . $this->registry->library('lang')->line('answer') . ' 6:</p><input value="' . $vp['answer6'] . '" type="text" name="answer6">
            <p>' . $this->registry->library('lang')->line('answer') . ' 7:</p><input value="' . $vp['answer7'] . '" type="text" name="answer7">
            <p>' . $this->registry->library('lang')->line('answer') . ' 8:</p><input value="' . $vp['answer8'] . '" type="text" name="answer8">
            <p>' . $this->registry->library('lang')->line('answer') . ' 9:</p><input value="' . $vp['answer9'] . '" type="text" name="answer9">
			<p>' . $this->registry->library('lang')->line('visible') . ':</p>

			<select name="visible">
				<option value="y"';
					if ($vp['visible'] == 'y')
					{
						echo ' selected="selected"';
					}
					echo '>' . $this->registry->library('lang')->line('yes') . '</option>
				<option value="n"';
					if ($vp['visible'] == 'n')
					{
						echo ' selected="selected"';
					}
					echo '>' . $this->registry->library('lang')->line('no') . '</option>
			</select><br />

			<select name="poll_group">
			';
				}
			}
			$sql = 'SELECT *
	FROM ' . $this->prefix . 'poll_group
	WHERE poll_group_sys = "' . $this->sys_cms . '"
	ORDER BY `group` ASC';
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
			{
				$dataGroups = $this->registry->library('db')->rowsFromCache($cache);
				foreach ($dataGroups as $kg => $vg)
				{
					echo '	<option value="' . $vg['groupid'] . '"';
					if ($vg['groupid'] == $vp['poll_group'])
					{
						echo ' selected="selected"';
					}
					echo '>' . $vg['group'] . '</option>
				';
				}
			}
			echo '	</select>

			<button type="submit" class="edit"></button>

		</form>
	</div>
</div>
';
		}
	}

	private function update_poll()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true || $this->registry->library('authenticate')->hasPermission('install_modules') == true)
		{
			$data = array();
			$data['question'] = $this->registry->library('db')->sanitizeData($_POST['question']);
			$data['answer0'] = $this->registry->library('db')->sanitizeData($_POST['answer0']);
			$data['answer1'] = $this->registry->library('db')->sanitizeData($_POST['answer1']);
			$data['answer2'] = $this->registry->library('db')->sanitizeData($_POST['answer2']);
			$data['answer3'] = $this->registry->library('db')->sanitizeData($_POST['answer3']);
			$data['answer4'] = $this->registry->library('db')->sanitizeData($_POST['answer4']);
			$data['answer5'] = $this->registry->library('db')->sanitizeData($_POST['answer5']);
			$data['answer6'] = $this->registry->library('db')->sanitizeData($_POST['answer6']);
			$data['answer7'] = $this->registry->library('db')->sanitizeData($_POST['answer7']);
			$data['answer8'] = $this->registry->library('db')->sanitizeData($_POST['answer8']);
			$data['answer9'] = $this->registry->library('db')->sanitizeData($_POST['answer9']);
			$data['visible'] = $this->registry->library('db')->sanitizeData($_POST['visible']);
			$data['poll_group'] = $this->registry->library('db')->sanitizeData($_POST['poll_group']);
			$urlSegments = $this->registry->getURLSegments();
			$this->registry->library('db')->updateRecordsSys('poll', $data, 'pollid=' . $this->registry->library('db')->sanitizeData($urlSegments[2]));
//			$this->registry->redirectUser('poll_module', $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	public function delete_poll()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true || $this->registry->library('authenticate')->hasPermission('install_modules') == true)
		{
			$urlSegments = $this->registry->getURLSegments();
			$this->registry->library('db')->deleteRecordsSys('poll', 'pollid=' . $this->registry->library('db')->sanitizeData($urlSegments[2]), '1');
//			$this->registry->redirectUser('poll_module', $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	public function add_group()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true || $this->registry->library('authenticate')->hasPermission('install_modules') == true)
		{
			$data = array();
			$data['group'] = $this->registry->library('db')->sanitizeData($_POST['Group']);
			$this->registry->library('db')->insertRecordsSys('poll_group', $data);
//			$this->registry->redirectUser('poll_module', $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	public function delete_group()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true || $this->registry->library('authenticate')->hasPermission('install_modules') == true)
		{
			$urlSegments = $this->registry->getURLSegments();
			$this->registry->library('db')->deleteRecordsSys('poll_group', 'groupid=' . $this->registry->library('db')->sanitizeData($urlSegments[2]), '1');
//			$this->registry->redirectUser('poll_module', $this->registry->library('lang')->line('changes_saved_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	private function css_js()
	{
		echo '<style>
/* RESET */
/* ----------------------------------------- */

/* Global reset */
/* Based upon \'reset.css\' in the Yahoo! User Interface Library: http://developer.yahoo.com/yui */
*, html, body, div, dl, dt, dd, ul, ol, li, h1, h2, h3, h4, h5, h6, pre, form, label, fieldset, input, p, blockquote, th, td { margin:0; padding:0 }
table { border-collapse:collapse; border-spacing:0 }
fieldset, img { border:0 }
address, caption, cite, code, dfn, em, strong, th, var { font-style:normal; font-weight:normal }
ol, ul, li { list-style:none }
caption, th { text-align:left }
h1, h2, h3, h4, h5, h6 { font-size:100%; font-weight:normal }
q:before, q:after { content:\'\'}

/* Global reset-RESET */
/* The below restores some sensible defaults */
strong { font-weight: bold }
em { font-style: italic }
a img { border:none } /* Gets rid of IE\'s blue borders */
html{
	height: 100%;
}
h1{
	font-size: 30px;
}
h2{
	font-size: 24px;
	font-weight: bold;
}
h3{
	font-size: 14px;
	font-weight: bold;
}
a{
	text-decoration: none;
}
a:hover{
	text-decoration: underline;
}
body{
	font-family: Arial, Helvetica, sans-serif;
	text-align: center;
	margin: 10px;
}
.wrap{
	width: 960px;
	margin-right: auto;
	margin-left: auto;
	min-width: 1000px;
	max-width: 2000px;
}
	.company-brand{
		text-align: right;
	}
		.company-brand .logo{
			float: left;
		}
.top-nav, .top-nav li{
	display: inline;
}
.top-nav{
	margin-top: 20px;
}
	.main-nav{
		clear: both;
		float: left;
	}
	.special-nav{
		float: right;
		margin-right: -20px;
	}
		.top-nav li a{
			display: inline-block;
			padding: 12px 15px 12px 15px;
			font-size: 14px;
			text-transform: uppercase;
			font-weight: bold;
		}
		.top-nav li a:hover{
			text-decoration: none;
			padding-bottom: 20px;
			position: relative;
			top: -8px;
			margin-bottom: -8px;
		}
.page{
	width: 100%;
	min-height: 300px;
	background: #fff;
	clear: both;
	text-align: left;
	padding: 20px 10px 10px 10px;
	position: relative;
}


.module{
	position: relative;
	background: #f6f6f6;
	overflow: hidden;
	border: 1px solid #c1c1c1;
	margin-bottom: 10px;
}
.white-module{
	position: relative;
	background: #fff;
	overflow: hidden;
	padding: 10px 0px 10px 0px;
	border: 1px solid #c1c1c1;
	text-align: center;
	margin-bottom: 10px;
}
.sfpoll{
	min-height: 300px;
	width: 650px;
	float: left;
}
.module .module-title{
	display: block;
	width: 100%;
	background: #f3f3f3;
	border: 1px solid #c1c1c1;
	padding: 5px 0px 5px 5px;
	margin-left: -3px;
	margin-top: -1px;
	font-size: 24px;
	font-weight: bold;
}
.poll-column{
	border-left: #c1c1c1 solid 1px;
	border-right: #c1c1c1 solid 1px;
	width: 180px;
	height: 256px;
	overflow-x: hidden;
	overflow-y: auto;
	position: absolute;
	left: 150px;
	text-align: left;
}
.poll-column li{
	position: relative;
}
.poll-column li p a.delete{
	position: absolute;
	right: 5px;
	top: 3px;
	display: none;
}
.poll-column li p a.edit{
	position: absolute;
	right: 25px;
	top: 3px;
	display: none;
}
.group-list{
	display: none;
	margin-left: -1px;
	margin-right: -1px;
}
li.all-polls, ul.all-polls{
	display: block;
}
.sfpoll-groups{
	width: 152px;
	display: inline-block;
	float: left;
	margin-left: -1px;
	text-align: left;
	position: absolute;
	overflow-x: hidden;
	overflow-y: auto;
}
.sfpoll-groups, .group-list, .poll-info{
	font-size: 12px;
	color: #2e2e2e;
	font-weight: bold;
}
.sfpoll-groups li span{
	background: #f6f6f6;
	border: 1px solid #c1c1c1;
	width: 140px;
	display: inline-block;
	padding: 5px;
	margin-top: -1px;
}
ul.group-list li p{
	display: inline-block;
}
.sfpoll-groups span:hover, ul.group-list li:hover{
	background: #dcdcdc;
	cursor: pointer;
}
.sfpoll-groups span:active, .sfpoll-groups span.active, ul.group-list li:active, ul.group-list li.active{
	background: #3180d0;
}

		ul.group-list li{
			background: #f6f6f6;
			border: 1px solid #c1c1c1;
			padding: 5px;
			margin-top: -1px;
		}
			ul.group-list li input{
				display: inline;
				margin-right: 5px;
				position: relative;
				top: 1px;
			}
.poll-info{
	display: inline-block;
	height: 200px;
	text-align: left;
	position: absolute;
	left: 340px;
	width: 300px;
}
.poll-info *{
	display: inline;
}
.poll-info ul li{
	text-align: left;
	display: none;
}
.poll-info ul li.showfirst{
	display: block;
}
.poll-info p{
	line-height: 20px;
}
/*FORMS*/
select{
	min-width: 150px;
}
form{
	margin: 10px;
}
form p{
	font-size: 12px;
	color: #2e2e2e;
	font-weight: bold;
}
form input{
	font-size: 18px;
	padding: 5px 1px 5px 1px;
	font-weight: bold;
	color: #2e2e2e;
	margin: 5px 0px 5px 0px;
}

button.save, button.edit{
	margin: 20px 20px 0px 0px;
	background: url(' . FWURL . APPDIR . '/modules/poll_module/css/images/save-trans.png) no-repeat;
	width: 130px;
	height: 40px;
	border: 0px;
	cursor: pointer;
}
button.save:hover, button.edit:hover{
	background: url(' . FWURL . APPDIR . '/modules/poll_module/css/images/save-hover-trans.png) no-repeat;
}

button.save_group{
	margin: 20px 20px 0px 0px;
	background: url(' . FWURL . APPDIR . '/modules/poll_module/css/images/save-trans.png) no-repeat;
	width: 130px;
	height: 40px;
	border: 0px;
	cursor: pointer;
}
button.save_group:hover{
	background: url(' . FWURL . APPDIR . '/modules/poll_module/css/images/save-hover-trans.png) no-repeat;
}

/*Columns*/
.leftcolumn{
	float: left;
	width: 650px;
	margin-right: 10px;
}
.rightcolumn{
	/*float: right;
	display: inline;
	clear: right;*/
	min-height:650px; /* for modern browsers */
	height:auto !important; /* for modern browsers */
	height:650px; /* for IE5.x and IE6 */
	float: right;
	width: 300px;
}
.fullwidth{
	width: 100%;
	text-align: left;
}
.equal{
	width: 47%;
}
.clear{
	clear: both;
}
.small{
	width: 300px;
}
.large{
	width: 975px;
}
/*Shoutbox & Task Manager*/
.tasks{
	min-width: 600px;
	position: relative;
}
.shouts{

}
.shout, .tasks li{
	display: inline-block;
	background: #f3f3f3;
	border: 1px solid #c1c1c1;
	width: 90%;
	margin-top: -1px;
	padding: 8px 10px 8px 10px;
	position: relative;
}
	.shouts img{
		float: left;
	}
	.shout p, .tasks li p{
		display: inline;
	}
	.shoutname, .tasks li p.taskdate{
		font-size: 12px;
		color: #bababa;
		font-style: italic;
	}
	.shoutmessage, .tasks li p.taskname{
		font-size: 14px;
		color: #2e2e2e;
	}
	p.taskname{
		font-weight: bold;
	}
	li.none{
		border-left: 5px solid #78bde0;
	}
	li.upcoming{
		border-left: 5px solid #5ae053;
	}
	li.urgent{
		border-left: 5px solid #e0432f;
	}
	.tasks li a.edit{
		position: absolute;
		right: 10px;
	}
	.tasks li a.edit{
		position: absolute;
		right: 35px;
	}
	.tasks li a.delete{
		position: absolute;
		right: 10px;
	}

/*Notification Boxes */
.success{
	background: #aeec92;
	border: 1px solid #8bbd75;
	font-weight: bold;
	width: 95%;
	padding: 10px;
	font-size: 12px;
	display: block;
	margin: 20px;
}
.notification p{
	font-family: "Trebuchet MS";
	font-size: 12px;
	padding: 10px;
}
.notification{
	margin-bottom: 20px;
	background-image:url(' . FWURL . APPDIR . '/modules/poll_module/css/ui-theme/images/ui-icons_ffffff_256x240.png);
	background-position:-96px -128px;
	position: relative;
}
.close{
	position: absolute;
	right: 10px;
	top: 10px;
	cursor: pointer;
}
.caution{
	border: 1px solid #b32c25;
	background: #ec5951;
	font-weight: bold;
	width: 95%;
	padding: 10px;
	font-size: 12px;
	display: block;
	margin: 20px;
}
.ui-dialog{
	text-align: left;
}
.row{
	width: 95%;
	line-height: 30px;
	font-size: 14px;
	margin-left: 10px;
	text-align: left;
	position: relative;
}
	.row .deletegroup{
		position: relative;
		top: 5px;
		margin-right: 5px;

	}
.module-title{
	position: relative;
}
.module-title .add{
	position: absolute;
	right: 15px;
	top: 12px;
}
/*Side-nav */
.side-nav li a.notexpandable, .side-nav li a.expandable{
	width: 276px;
	margin-left: -2px;
	display: block;
	min-height: 18px;
	font-weight: bold;
	font-size: 13px;
	padding: 12px;
	color: #2e2e2e; /*1c94c4*/
	background: #f9f9f9;
	border: 1px solid #cccccc;
	margin-bottom: 5px;
	outline: none;
	position: relative;
}
.side-nav{
	margin-bottom: 20px;
}
.side-nav li a.notexpandable:hover, .side-nav li a.expandable:hover{
	text-decoration: none;
}
.side-nav li a.expandable:hover{
	background: #fdf9e1 ;
	border: #62a8c4 1px solid;
}
.side-nav li a.notexpandable:hover{
	background: #fdf9e1 ;
	border: #62a8c4 1px solid;
}
.expand-content{
	display: none;
	z-index: 100;
}
.ui-state-default{
	cursor: pointer;
}
.nav-icons{
	position: absolute;
	right: 5px;
}
.loading{
	background: url(' . FWURL . APPDIR . '/modules/poll_module/css/images/ajax-loader.gif) no-repeat;
	height: 16px;
	width: 16px;
	display: inline-block;
	position: absolute;
	right: 49%;
	top: 150px;
	display: none;
}
.loadingshown{
	background: url(' . FWURL . APPDIR . '/modules/poll_module/css/images/ajax-loader.gif) no-repeat;
	height: 16px;
	width: 16px;
	display: inline-block;
	position: absolute;
	left: 50%;
	top: 100px;
	z-index: 50;
}
iframe{
	z-index: 100;
	position: relative;
	border: 0px;
}
.edit-poll-dialog{
	opacity:0.6;filter:alpha(opacity=60);
}
.edit-poll-dialog.alive{
	opacity:1;filter:alpha(opacity=100);
}
input.error{
    border: 1px solid red;
}
label.error{
    color: red;
    margin-left: 3px;
    font-size: 12px;
}
.screen{
	width: 100%;
	height: 100%;
	opacity:0.6;filter:alpha(opacity=60);
	background-color: #f1f1f1;
	position: absolute;
	z-index: 200;

}

.confirmdelete .ui-widget-header{
	background: #B81900 url(' . FWURL . APPDIR . '/modules/poll_module/css/ui-theme/images/ui-bg_diagonals-thick_18_b81900_40x40.png) repeat scroll 50% 50%;
}

.ui-datepicker-trigger{
	position: relative;
	top: 5px;
	left: 2px;
	cursor: pointer;
}
.ui-datepicker{
	z-index: 300;
}


.widget{
	min-height:650px; /* for modern browsers */
	height:auto !important; /* for modern browsers */
	height:650px; /* for IE5.x and IE6 */

}
/*.dhx_cal_data{
	z-index: 1000;
}*/
</style>
<link rel="stylesheet" type="text/css" href="' . FWURL . APPDIR . '/modules/poll_module/css/1.css" media="screen" />
<link rel="stylesheet" type="text/css" href="' . FWURL . APPDIR . '/modules/poll_module/css/ui-theme/ui.css" media="screen" />
<script type="text/javascript" src="' . FWURL . 'js/jquery/' . $this->registry->setting('settings_jquery') . '"></script>
<script type="text/javascript" src="' . FWURL . APPDIR . '/modules/poll_module/js/ui.js"></script>
<script type="text/javascript" src="' . FWURL . APPDIR . '/modules/poll_module/js/val.js"></script>
<script type="text/javascript">
$(document).ready(function(){

	js();

function js(){
	successA = \'<div class="ui-widget notification"><div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>\';
	successB = \'<span class="ui-icon close ui-icon-closethick" unselectable="on" style="-moz-user-select: none;">close</span></p></div></div>\';

	errorA = \'<div class="ui-widget notification"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>\';
	errorB = \'<span class="ui-icon close ui-icon-closethick" unselectable="on" style="-moz-user-select: none;">close</span></p></div></div>\';


	$(".sfpoll-groups li").click(function(){
		$(".sfpoll-groups li span").removeClass("active");
		group = $(this).attr("class");
		group = ".poll-column ul." + group;
		$(".poll-column ul").hide();
		$(this).children("span").addClass("active");
		$(group).fadeIn("slow");
	});

	$("ul.group-list li").click(function(){
		$("ul.group-list li").removeClass("active");
		poll = $(this).attr("class");
		poll = "li." + poll;
		$(".poll-info ul li").hide();
		$(this).addClass("active");
		editLink = $(this).children("p").children("a.edit").attr("href");
		$(".edit-poll-dialog").attr("href",editLink).addClass("alive");
		$(poll).fadeIn("slow");
	});

	$(".poll-column li").hover(function(){
		$(".poll-column li p a").hide();
		$(this).children(\'p\').children(\'a\').show();
	},function(){
		$(this).children(\'p\').children(\'a\').hide();
	});


	function reloadWidget(link){
		$(".loading").fadeIn();
		$(".widget .widget-content").prepend(\'<div class="screen"></div>\');
		$(".screen").fadeIn();
		$(".widget").load(location.href + "# .widget .widget-content",function(){
			$(".screen").fadeOut();
			js();
		});
		$(".loading").fadeOut();
	}

	$("a.delete").click(function(){
		$(".confirm").dialog(\'open\');
		deleteLink = $(this).attr("href");
		reloadWidget();
		return false;
	});

	$(\'.confirm\').dialog({
					autoOpen: false,
					width: 400,
					height: 300,
					minWidth: 400,
					maxWidth: 900,
					minHeight: 300,
					maxHeight: 600,
					dialogClass: \'confirmdelete\',
					buttons: {
						"Delete Forever": function() {
							if(deleteLink !== null){
								$.post(deleteLink);
							}
							$(this).dialog("close");
							deleteLink = "";
							reloadWidget();
						},
						"Cancel": function() {
							$(".confirm").dialog("close");
						}
					},
					modal: true
	});

	$(\'.confirmmultiple\').dialog({
					autoOpen: false,
					width: 400,
					height: 300,
					minWidth: 400,
					maxWidth: 900,
					minHeight: 300,
					maxHeight: 600,
					dialogClass: \'confirmdelete\',
					buttons: {
						"Delete Forever": function() {
							if(checked[0] !== null){
								$.each(checked, function() {
							      $.post(this);
							    });
							}

							$(this).dialog("close");
							deleteLink = "";
							reloadWidget();
						},
						"Cancel": function() {
							$(".confirm").dialog("close");
						}
					},
					modal: true
	});

	$(".side-nav li a, .expand").click(function(){
		$(this).siblings(".expand-content").toggle();
	});

	$("iframe").contents().find("span.close").click(function(){
		$(this).parent().parent().parent().fadeOut().remove();
	});

	$("span.close").click(function(){
		$(this).parent().parent().parent().fadeOut().remove();
	});

	$(\'.frameopen\').click(function(){
			if($(this).attr("href") == "#"){
				alert("Please select an entry to edit first.");
			}else{
			dialogTitle = $(this).attr("title");
			frameLink = $(this).attr("href");
			$(".dialogframe iframe").attr("src", frameLink);
			$(".dialogframe").dialog(\'open\').dialog( \'option\' , \'title\' , dialogTitle );
			return false;
		}
	});

	//Maintain which are selected in Array

	$(".selectbox").change(function () {
			//something = $(this+\':selected\').serializeArray();
          checked = [];
          var size = $(".selectbox:checked").size();
          var i;
          for (i=0;i<size;i++){

            checked[i] = $(".selectbox:checked:eq("+i+")").siblings(\'p\').children("a.delete").attr("href");

    	  }
        })
        .trigger(\'change\');

	$(\'.delete-selected-dialog\').click(function(){
			if(checked[0] == null){
				alert("Please select at least one entry first. Thanks!");
			}else{
			dialogTitle = $(this).attr("title");
			$(".confirmmultiple").dialog(\'open\').dialog( \'option\' , \'title\' , dialogTitle );
			return false;
		}
	});


	function save(){

		var action = $("iframe").contents().find("form").attr("action");
		var fields = $("iframe").contents().find("input, select").serializeArray();
		var valid = $("iframe").contents().find(".validate").valid();

		if(valid == true){

			$.post(action, fields, function(data) {
				$("iframe").contents().find(\'input\').val("");
			});
			$("iframe").contents().find(\'.notification\').slideUp().remove();
			$("iframe").contents().find(\'body\').prepend(successA + "Poll Successfully Edited" + successB);
			reloadWidget();
		}else{
			$("iframe").contents().find(\'.notification\').slideUp().remove();
			$("iframe").contents().find(\'body\').prepend(errorA + "Oops! There appears to be some errors." + errorB);
			js();
		}



		return false;
	}
	function edit(){

		var action = $("iframe").contents().find("form").attr("action");
		var fields = $("iframe").contents().find("input, select").serializeArray();
		var valid = $("iframe").contents().find(".validate").valid();

		if(valid == true){

			$.post(action, fields, function(data) {

			});
			$("iframe").contents().find(\'.notification\').slideUp().remove();
			$("iframe").contents().find(\'body\').prepend(successA + "Poll Successfully Edited" + successB);
			reloadWidget();
		}else{
			$("iframe").contents().find(\'.notification\').slideUp().remove();
			$("iframe").contents().find(\'body\').prepend(errorA + "Please review your entry for errors. Thanks!" + errorB);
			js();
		}



		return false;
	}

	$(".validate").validate();

	$("button.save").click(function(){
		var action = $(this).parent("form").attr("action");
		var fields = $("input, select").serializeArray();
		var valid = $(".validate").valid();
		if(valid == true){
			$.post(action, fields, function(data) {
				$(\'input\').val("");
			});
			$(\'.notification\').slideUp().remove();
	   		$(\'body\').prepend(successA + "Poll Successfully Added" + successB);
	   		reloadWidget();
	   		js();
		}else{
			$(\'.notification\').slideUp().remove();
			$(\'body\').prepend(errorA + "Please review your entry for errors. Thanks!" + errorB);
			js();
		}
		return false;
	});


	$("button.save_group").click(function(){
		var action = $(this).parent("form").attr("action");
		var fields = $("input").serializeArray();
		var valid = $(".validate").valid();
		if(valid == true){
			$.post(action, fields, function(data) {
				$(\'input\').val("");
			});
			$(\'.notification\').slideUp().remove();
	   		$(\'body\').prepend(successA + "Group Successfully Added" + successB);
	   		reloadWidget();
	   		js();
		}else{
			$(\'.notification\').slideUp().remove();
			$(\'body\').prepend(errorA + "Please review your entry for errors. Thanks!" + errorB);
			js();
		}
		return false;
	});


	$("button.edit").click(function(){
		var action = $(this).parent("form").attr("action");
		var fields = $("input, select").serializeArray();
		var valid = $(".validate").valid();
		if(valid == true){
			$.post(action, fields, function(data) {

			});
			$(\'.notification\').slideUp().remove();
	   		$(\'body\').prepend(successA + "Poll Successfully Edited" + successB);
	   		reloadWidget();
	   		js();
		}else{
			$(\'.notification\').slideUp().remove();
			$(\'body\').prepend(errorA + "Please review your entry for errors. Thanks!" + errorB);
			js();
		}
		return false;
	});

	$(\'.dialogframe\').dialog({
					autoOpen: false,
					width: 800,
					height: 550,
					minWidth: 400,
					maxWidth: 900,
					minHeight: 300,
					maxHeight: 600,
					close: function() { reloadWidget(); },
					buttons: {
						"Save": function() {
							if($(".ui-dialog-title:contains(\'Add\')").length > 0){save();}else if($(".ui-dialog-title:contains(\'Edit\')").length > 0){edit();}

							reloadWidget();
						},
						"Close": function() {
							$(this).dialog("close");
							reloadWidget();
						}
					},
					modal: true

	});


	$(\'.dialog\').dialog({
					autoOpen: false,
					width: 600,
					height: 400,
					minWidth: 400,
					maxWidth: 900,
					minHeight: 300,
					maxHeight: 600,
					buttons: {
						"Ok": function() {
							$(this).dialog("close");
							reloadWidget();
						},
						"Cancel": function() {
							$(this).dialog("close");
						}
					},
					modal: true

	});
	// Dialog Link
		$(\'.dialog-link\').click(function(){
			var dialogID = $(this).attr("id");
			dialogID = "." + dialogID;
			$(dialogID).dialog(\'open\');
			return false;
		});

	$(\'#dialog_link, .ui-state-default\').hover(
		function() { $(this).addClass(\'ui-state-hover\'); },
		function() { $(this).removeClass(\'ui-state-hover\'); }
	);

}


});
</script>';
	}
// from Poll Widget

	private function vote()
	{
//get post data
//	$selected = $_POST['choice'];
//	$pieces = explode("|", $selected);
// selected answerID
		$answerID = $this->registry->library('db')->sanitizeData($_POST['answerID']);
// poll ID
		$pollid = $this->registry->library('db')->sanitizeData($_POST['pollid']);
// user IP
		$userip = $this->registry->library('db')->sanitizeData($_POST['userip']);
// Voted ?
		$voted = $this->registry->library('db')->sanitizeData($_POST['voted']);
//
		$userid = $this->registry->library('db')->sanitizeData($_POST['userid']);
//
		$poll_vote_sys = $this->registry->library('db')->sanitizeData($_POST['poll_vote_sys']);
//
		$num_of_answers = $this->registry->library('db')->sanitizeData($_POST['num_of_answers']);
		if ($answerID != null)
		{
			if ($voted == 0)
			{
//insert OR update ?
				$sql = "SELECT * FROM " . $this->prefix . "poll_results WHERE choices = '" . $answerID . "' AND poll_id = '" . $pollid . "' AND poll_results_sys = '" . $this->sys_cms . "'";
				$this->registry->library('db')->execute($sql);
				if ($this->registry->library('db')->numRows() == 0)
				{
					$data1 = array('poll_id' => $pollid, 'choices' => $answerID, 'votes' => '1');
					$this->registry->library('db')->insertRecordsSys(poll_results, $data1);
				}
				else
				{
					$sql = "UPDATE " . $this->prefix . "poll_results SET votes = votes + 1 WHERE choices = '" . $answerID . "' AND poll_id = '" . $pollid . "' AND poll_results_sys = '" . $this->sys_cms . "'";
					$this->registry->library('db')->execute($sql);
				}
				$sql = "INSERT INTO " . $this->prefix . "poll_vote (pollid, userip, userid, poll_vote_sys) VALUES(" . $pollid . ", " . $userip . ", " . $userid . ", '" . $poll_vote_sys . "')";
				$this->registry->library('db')->execute($sql);
			}
		}
//query the database
		$votesTotal = 0;
		$a = array();
		$a[0] = 0;
		$a[1] = 0;
		$a[2] = 0;
		$a[3] = 0;
		$a[4] = 0;
		$a[5] = 0;
		$a[6] = 0;
		$a[7] = 0;
		$a[8] = 0;
		$a[9] = 0;
		$sql = 'SELECT *
				FROM ' . $this->prefix . 'poll_results
				WHERE poll_results_sys = "' . $this->sys_cms . '"
				AND poll_id = "' . $pollid . '"';
		$cache = $this->registry->library('db')->cacheQuery($sql);
		$data = $this->registry->library('db')->rowsFromCache($cache);
		foreach ($data as $k => $v)
		{
			$a[$v['choices']] = $v['votes'];
			$votesTotal = $votesTotal + $v['votes'];
		}
		$percent = array();
		$percentLength = array();
		$percent[0] = 0;
		$percent[1] = 0;
		$percent[2] = 0;
		$percent[3] = 0;
		$percent[4] = 0;
		$percent[5] = 0;
		$percent[6] = 0;
		$percent[7] = 0;
		$percent[8] = 0;
		$percent[9] = 0;
		$percentLength[0] = 0;
		$percentLength[1] = 0;
		$percentLength[2] = 0;
		$percentLength[3] = 0;
		$percentLength[4] = 0;
		$percentLength[5] = 0;
		$percentLength[6] = 0;
		$percentLength[7] = 0;
		$percentLength[8] = 0;
		$percentLength[9] = 0;
		$json = array();
		$x = $num_of_answers;
		while ($x != 0)
		{
			$j = 0;
			$skip = 0;
			$percent[($num_of_answers)] = 0;
			$x--;
			$votes[$x] = 0;
			$percent[$x] = 0;
			$percentLength[$x] = 0;
			foreach ($data as $k => $v)
			{
				if (($x == $v['choices']) && ($skip == 0))
				{
					$votes[$x] = $v['votes'];
					$percent[$x] = round($v['votes'] / $votesTotal * 100);
					$percentLength[$x] = $percent[$v['choices']] * 1.8;
					$skip = 1;
				}
			}
			$json[$x] = array("votes" => $votes[$x], "percent" => $percent[$x], "percentLength" => $percentLength[$x], "votesTotal" => $votesTotal);
		}
//echo results
//			$dt = json_encode($json);
//			$arr = explode("]", $dt);
//			$dt = $arr[0] . ']';
//			echo $dt;
		echo json_encode($json);
	}

}
?>