<?php

class Authentication
{
	public $userID;
	public $loggedIn = false;
	private $admin = false;
	public $roles = array();
	public $resp = array();
	public $perms = array();
	public $permsm = array();
	private $banned = false;
	private $username;
	private $justProcessed = false;
	private $captcha;
	private $prefix;

	public function __construct()
	{
	}

	public function cookieAuthentication($username, $password)
	{
		$usernameOld = $username;
		$username = Registry :: library('crypter')->decrypt($username);
		$passwordOld = $password;
		$password = Registry :: library('crypter')->decrypt($password);
		$this->prefix = Registry :: library('db')->getPrefix();
		$sql = 'SELECT *
		FROM ' . $this->prefix . 'users
		WHERE username = "' . $username . '" and password = "' . $password . '"';
		Registry :: library('db')->execute($sql);
		if (Registry :: library('db')->numRows() != 0)
		{
			$time = time();
			setcookie("username", $usernameOld, $time + 3600 * 24 * 366 * 2, '/');
			setcookie("password", $passwordOld, $time + 3600 * 24 * 366 * 2, '/');
			if (isset ($_SESSION['auth_session_uid']) && intval($_SESSION['auth_session_uid']) > 0)
			{
				$this->sessionAuthenticate(intval($_SESSION['auth_session_uid']));
			}
			else
			{
				$this->postAuthenticate(Registry :: library('db')->sanitizeData($username), Registry :: library('db')->sanitizeData($password));
				$this->sessionAuthenticate(intval($_SESSION['auth_session_uid']));
			}
		}
	}

	public function checkAuthentication()
	{
		if (isset ($_SESSION['auth_session_uid']) && intval($_SESSION['auth_session_uid']) > 0)
		{
			$this->sessionAuthenticate(intval($_SESSION['auth_session_uid']));
		}
		elseif (isset ($_POST['auth_user']) && $_POST['auth_user'] != '' && isset ($_POST['auth_pass']) && $_POST['auth_pass'] != '')
		{
			$this->postAuthenticate(Registry :: library('db')->sanitizeData($_POST['auth_user']), md5($_POST['auth_pass']));
		}
	}

	private function sessionAuthenticate($uid)
	{
		$this->prefix = Registry :: library('db')->getPrefix();
		$sql = "SELECT u.users_id, u.username, u.active, u.email, u.admin, u.banned, u.name
    	FROM " . $this->prefix . "users u
    	WHERE u.users_id={$uid}";
		Registry :: library('db')->execute($sql);
		if (Registry :: library('db')->numRows() == 1)
		{
			$userData = Registry :: library('db')->getRows();
			if ($userData['active'] == 0)
			{
				$this->loggedIn = false;
				$this->loginFailureReason = 'inactive';
				$this->active = false;
			}
			elseif ($userData['banned'] != 0)
			{
				$this->loggedIn = false;
				$this->loginFailureReason = 'banned';
				$this->banned = false;
			}
			else
			{
				$this->loggedIn = true;
				$this->userID = $uid;
				$this->admin = ($userData['admin'] == 1) ? true : false;
				$this->username = $userData['username'];
				$this->name = $userData['name'];
				$roles = $this->getUserRoles($uid);
				$this->roles = $roles;
			}
		}
		else
		{
			$this->loggedIn = false;
			$this->loginFailureReason = 'nouser';
		}
		if ($this->loggedIn == false)
		{
			$this->logout();
		}
	}

	public function postAuthenticate($u, $p)
	{
		$this->prefix = Registry :: library('db')->getPrefix();
		$this->justProcessed = true;
		$sql = "SELECT u.users_id, u.username, u.email, u.admin, u.banned, u.active, u.name
    	FROM " . $this->prefix . "users u
    	WHERE u.username='{$u}' AND u.password='{$p}'";
		Registry :: library('db')->execute($sql);
		if (Registry :: library('db')->numRows() == 1)
		{
			$userData = Registry :: library('db')->getRows();
			if ($userData['active'] == 0)
			{
				$this->loggedIn = false;
				$this->loginFailureReason = 'inactive';
				$this->active = false;
			}
			elseif ($userData['banned'] != 0)
			{
				$this->loggedIn = false;
				$this->loginFailureReason = 'banned';
				$this->banned = false;
			}
			else
			{
				$this->loggedIn = true;
				$this->userID = $userData['users_id'];
				$this->admin = ($userData['admin'] == 1) ? true : false;
				$_SESSION['auth_session_uid'] = $userData['users_id'];
				$roles = $this->getUserRoles($uid);
				$this->roles = $roles;
			}
		}
		else
		{
			$this->loggedIn = false;
			$this->loginFailureReason = 'invalidcredentials';
		}
	}

	public function logout()
	{
//		$_SESSION['auth_session_uid'] = '';
//		$_SESSION['cms_sys'] = '';
		$_SESSION = array();
		session_destroy();
	}

	public function getUserID()
	{
		return $this->userID;
	}

	public function isLoggedIn()
	{
		return $this->loggedIn;
	}

	public function isAdmin()
	{
		return $this->admin;
	}

	public function getUsername()
	{
		return $this->username;
	}

	public function isMemberOfGroup($role)
	{
		if (in_array($role, $this->roles))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function getCaptcha()
	{
		$captcha = $this->generateCaptcha(4);
		return $captcha;
	}

	public function getCaptchaImage()
	{
		$captcha = $_SESSION['captcha'];
		$cap_width = 100;
		$cap_height = 30;
		$cap_quality = 100;
// 100%
		$canvas = imagecreatetruecolor($cap_width, $cap_height);
		$c = imagecolorallocate($canvas, 255, 255, 255);
		imagefilledrectangle($canvas, 0, 0, $cap_width, $cap_height, $c);
		$count = strlen($captcha);
		$color_text = imagecolorallocate($canvas, 0, 0, 0);
		for ($i = 0; $i < $count; $i++)
		{
			$letter = $captcha[$i];
			$color_text = imagecolorallocate($canvas, rand(0, 255), rand(0, 255), rand(0, 255));
			imagestring($canvas, 6, (10 * $i + 20), $cap_height / 4, $letter, $color_text);
		}
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0', false);
		header('Pragma: no-cache');
		header('Content-Type: image/jpeg');
		ob_start();
		ob_implicit_flush(0);
		imagejpeg($canvas, null, $cap_quality);
		$captchaImage = ob_get_contents();
		ob_end_clean();
		imagedestroy($canvas);
		print $captchaImage;
	}

	private function generateCaptcha($length = 4)
	{
		$characters = '23456789abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';
		$string = '';
		for ($i = 0; $i < $length; $i++)
		{
			$string .= $characters[mt_rand(0, strlen($characters) - 1)];
		}
		return $string;
	}
// To get User's Roles

	public function getUserRoles($uid)
	{
		$this->prefix = Registry :: library('db')->getPrefix();
//        $sql = "SET SESSION group_concat_max_len = 1024000";
//        Registry::library('db')->execute($sql);
		$sql = "SELECT GROUP_CONCAT(ur.ur_role_id SEPARATOR '---SEPARATOR---') AS groupmemberships
        FROM " . $this->prefix . "user_roles ur
        WHERE ur_id='{$uid}' ORDER BY ur_add_date ASC";
		Registry :: library('db')->execute($sql);
		if (Registry :: library('db')->numRows() == 1)
		{
			$rolesData = Registry :: library('db')->getRows();
			$roles = explode('---SEPARATOR---', $rolesData['groupmemberships']);
			$this->roles = $roles;
		}
		else
		{
			$this->roles = '';
		}
	}
// To get List of All Roles

	public function getAllRoles($format = 'ids')
	{
		$this->prefix = Registry :: library('db')->getPrefix();
//        $sql = "SET SESSION group_concat_max_len = 1024000";
//        Registry::library('db')->execute($sql);
		$format = strtolower($format);
		$sql = "SELECT GROUP_CONCAT(roles_id, '---SEPARATOR1---', roles_name, '---SEPARATOR1---', roles_locked SEPARATOR '---SEPARATOR2---') AS allroles
        FROM " . $this->prefix . "roles ORDER BY roles_name ASC";
		Registry :: library('db')->execute($sql);
		if (Registry :: library('db')->numRows() == 1)
		{
			$rolesData = Registry :: library('db')->getRows();
			if ($rolesData['allroles'] != '')
			{
				$arr = array();
				$arr = explode('---SEPARATOR2---', $rolesData['allroles']);
				foreach ($arr as $key)
				{
					$value = explode('---SEPARATOR1---', $key);
					if ($format == 'full')
					{
						$resp[] = array("0" => $value[0], "1" => $value[1], "2" => $value[2]);
					}
					else
					{
						$resp[] = $value[0];
					}
				}
			}
		}
		$this->resp = $resp;
		return $this->resp;
	}

	public function buildPermissions($userID)
	{
		if (count($this->roles) > 0)
		{
			$this->perms = array_merge($this->perms, $this->getRolePerms($this->roles));
// echo '1: <pre>' . print_r($this->perms, true) . '</pre> 1|';
		}
// echo '2: <pre>' . print_r($this->getUserPerms(2), true) . '</pre> 2|';
		$this->perms = array_merge($this->perms, $this->getUserPerms($userID));
// echo '3: <pre>' . print_r($this->perms, true) . '</pre> 3|';
	}

	public function buildUserPermissions($userID)
	{
		$this->getUserRoles($userID);
		$this->buildPermissions($userID);
	}
// To get 'perm_key' and 'perm_name' for One Permission ID :: 1 -> access_site

	public function getPermKeyFromID($permID)
	{
		$this->prefix = Registry :: library('db')->getPrefix();
		$sql = "SELECT perm_key
        FROM " . $this->prefix . "permissions WHERE perm_id='{$permID}' LIMIT 1";
		Registry :: library('db')->execute($sql);
		if (Registry :: library('db')->numRows() == 1)
		{
			$data = Registry :: library('db')->getRows();
			$perm_key = $data['perm_key'];
		}
		return $perm_key;
	}

	public function getPermNameFromID($permID)
	{
		$this->prefix = Registry :: library('db')->getPrefix();
		$sql = "SELECT perm_name
        FROM " . $this->prefix . "permissions
        WHERE perm_id='{$permID}' LIMIT 1";
		Registry :: library('db')->execute($sql);
		if (Registry :: library('db')->numRows() == 1)
		{
			$data = Registry :: library('db')->getRows();
			$perm_name = $data['perm_name'];
		}
		return $perm_name;
	}

	public function getRoleNameFromID($roleID)
	{
		$this->prefix = Registry :: library('db')->getPrefix();
		$sql = "SELECT roles_name
        FROM " . $this->prefix . "roles
        WHERE roles_id='{$roleID}' LIMIT 1";
		Registry :: library('db')->execute($sql);
		if (Registry :: library('db')->numRows() == 1)
		{
			$data = Registry :: library('db')->getRows();
			$roles_name = $data['roles_name'];
		}
		return $roles_name;
	}
// $role is User RoleS

	public function getRolePerms($role)
	{
		$this->prefix = Registry :: library('db')->getPrefix();
//        $sql = "SET SESSION group_concat_max_len = 1024000";
//        Registry::library('db')->execute($sql);
		if (is_array($role))
		{
			$role = implode(",", $role);
			if ($role == '')
			{
				$role = 0;
			}
			$sql = "SELECT GROUP_CONCAT(rp_id, '---SEPARATOR1---', rp_role_id, '---SEPARATOR1---', rp_perm_id, '---SEPARATOR1---', rp_value, '---SEPARATOR1---', rp_add_date SEPARATOR '---SEPARATOR2---') AS userperms
			FROM " . $this->prefix . "role_perms
			WHERE rp_role_id IN ($role)
			ORDER BY rp_value DESC";
// echo '<pre>' . print_r($sql, true) . '</pre>';
		}
		else
		{
			$sql = "SELECT GROUP_CONCAT(rp_id, '---SEPARATOR1---', rp_role_id, '---SEPARATOR1---', rp_perm_id, '---SEPARATOR1---', rp_value, '---SEPARATOR1---', rp_add_date SEPARATOR '---SEPARATOR2---') AS userperms
			FROM " . $this->prefix . "role_perms
			WHERE rp_role_id=$role
			ORDER BY rp_value DESC";
		}
		$perms = array();
		Registry :: library('db')->execute($sql);
		if (Registry :: library('db')->numRows() == 1)
		{
			$rolesData = Registry :: library('db')->getRows();
			$arr = array();
			$arr = explode('---SEPARATOR2---', $rolesData['userperms']);
			foreach ($arr as $key)
			{
				$value = explode('---SEPARATOR1---', $key);
				$pK = strtolower($this->getPermKeyFromID($value[2]));
				if ($pK == '')
				{
					continue;
				}
				if ($value[3] === '1')
				{
					$hP = true;
				}
				else
				{
					$hP = false;
				}
				$perms[$pK] = array('perm' => $pK, 'inherited' => '1', 'value' => $hP, 'Name' => $this->getPermNameFromID($value[2]), 'ID' => $value[2]);
			}
		}
		$this->perms = $perms;
		return $this->perms;
	}
// To get User's Permissions

	public function getUserPerms($userID)
	{
		$this->prefix = Registry :: library('db')->getPrefix();
//        $sql = "SET SESSION group_concat_max_len = 1024000";
//        Registry::library('db')->execute($sql);
		$sql = "SELECT GROUP_CONCAT(up.up_id, '---SEPARATOR1---', up.up_user_id, '---SEPARATOR1---', up.up_perm_id, '---SEPARATOR1---', up.up_value, '---SEPARATOR1---', up.up_add_date SEPARATOR '---SEPARATOR2---') AS userpermissions
        FROM " . $this->prefix . "user_perms up
        WHERE up_user_id='{$userID}'
        ORDER BY up_add_date ASC";
		$perms = array();
		Registry :: library('db')->execute($sql);
		if (Registry :: library('db')->numRows() == 1)
		{
			$permsData = Registry :: library('db')->getRows();
			if ($permsData['userpermissions'] != '')
			{
				$arr = array();
				$arr = explode('---SEPARATOR2---', $permsData['userpermissions']);
				foreach ($arr as $key)
				{
					$value = explode('---SEPARATOR1---', $key);
					$pK = strtolower($this->getPermKeyFromID($value[2]));
					if ($pK == '')
					{
						continue;
					}
					if ($value[3] == '1')
					{
						$hP = 1;
					}
					else
					{
						$hP = 0;
					}
					$perms[$pK] = array('perm' => $pK, 'inherited' => '0', 'value' => $hP, 'Name' => $this->getPermNameFromID($value[2]), 'ID' => $value[2]);
				}
			}
		}
		$this->permsm = $perms;
		return $this->permsm;
	}
// To get List of All Permissions

	public function getAllPerms($format = 'ids')
	{
		$this->prefix = Registry :: library('db')->getPrefix();
//        $sql = "SET SESSION group_concat_max_len = 1024000";
//        Registry::library('db')->execute($sql);
		$format = strtolower($format);
		$sql = "SELECT GROUP_CONCAT(perm_id, '---SEPARATOR1---', perm_key, '---SEPARATOR1---', perm_name, '---SEPARATOR1---', perm_locked SEPARATOR '---SEPARATOR2---') AS allpermissions
        FROM " . $this->prefix . "permissions
        ORDER BY perm_name ASC";
		Registry :: library('db')->execute($sql);
		if (Registry :: library('db')->numRows() == 1)
		{
			$permsData = Registry :: library('db')->getRows();
// echo '<pre>' . print_r($permsData, true) . '</pre>';
			if ($permsData['allpermissions'] != '')
			{
				$arr = array();
				$arr = explode('---SEPARATOR2---', $permsData['allpermissions']);
				foreach ($arr as $key)
				{
					$value = explode('---SEPARATOR1---', $key);
					if ($format == 'full')
					{
						$resp[] = array("0" => $value[0], "1" => $value[1], "2" => $value[2], "3" => $value[3]);
					}
					else
					{
						$resp[] = $value[0];
					}
				}
			}
		}
		$this->resp = $resp;
		return $this->resp;
	}

	public function userHasRole($roleID, $userID)
	{
		$roles = $this->getUserRoles($userID);
		foreach ($this->roles as $k => $v)
		{
			if ($v === $roleID)
			{
				return true;
			}
		}
		return false;
	}

	public function hasPermission($permKey)
	{
		$permKey = strtolower($permKey);
		if (array_key_exists($permKey, $this->perms))
		{
			if ($this->perms[$permKey]['value'] == '1' || $this->perms[$permKey]['value'] === true)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	public function getUsernameFromID($uid)
	{
		$this->prefix = Registry :: library('db')->getPrefix();
		$sql = "SELECT u.username
		FROM " . $this->prefix . "users u
		WHERE u.users_id={$uid}";
		Registry :: library('db')->execute($sql);
		if (Registry :: library('db')->numRows() == 1)
		{
			$userData = Registry :: library('db')->getRows();
			return $userData['username'];
		}
	}

}
?>