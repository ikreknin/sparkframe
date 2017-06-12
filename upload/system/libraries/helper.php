<?php
if (!defined('FW'))
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit ();
}

class Helper
{

	function __construct()
	{
	}

	public function convertDate($date)
	{
		$arr = explode('-', substr($date, 0, 10));
// long year: 2001
		$long_year = $arr[0];
// short year: 01
		$short_year = substr($arr[0], 2);
// long_month: 01
		$long_month = $arr[1];
// short month: 1
		if (substr($arr[1], 0, 1) == '0')
		{
			$short_month = (substr($arr[1], 1));
		}
		else
		{
			$short_month = $arr[1];
		}
// month name: January
		if ($arr[1] == '01')
		{
			$month_name = 'january';
		}
		elseif ($arr[1] == '02')
		{
			$month_name = 'february';
		}
		elseif ($arr[1] == '03')
		{
			$month_name = 'march';
		}
		elseif ($arr[1] == '04')
		{
			$month_name = 'april';
		}
		elseif ($arr[1] == '05')
		{
			$month_name = 'may';
		}
		elseif ($arr[1] == '06')
		{
			$month_name = 'june';
		}
		elseif ($arr[1] == '07')
		{
			$month_name = 'july';
		}
		elseif ($arr[1] == '08')
		{
			$month_name = 'august';
		}
		elseif ($arr[1] == '09')
		{
			$month_name = 'september';
		}
		elseif ($arr[1] == '10')
		{
			$month_name = 'october';
		}
		elseif ($arr[1] == '11')
		{
			$month_name = 'november';
		}
		elseif ($arr[1] == '12')
		{
			$month_name = 'december';
		}
		else
		{
			$month_name = '';
		}
		$month_name = $month_name . '_1';
		$month_name = Registry :: library('lang')->line($month_name);
// long date: 01
		$long_date = $arr[2];
// short date: 1
		if (substr($arr[2], 0, 1) == '0')
		{
			$short_date = (substr($arr[2], 1));
		}
		else
		{
			$short_date = $arr[2];
		}
// additional year ending for localization
		$year_ending = '';
		if (Registry :: library('lang')->getLanguage() == 'russian')
		{
			$year_ending = Registry :: library('lang')->line('year_ending');
		}
// final date
		$convertedDate = $short_date . ' ' . $month_name . ' ' . $long_year . $year_ending;
		return $convertedDate;
	}

	public function convertTime($time)
	{
		$convertedTime = substr($time, 11);
		$convertedTime = substr($convertedTime, 0, - 3);
		return $convertedTime;
	}

	private function dayOfWeek($datetime)
	{
		$datetime = strtotime($datetime);
		$dw = date("w", $datetime);
		if ($dw == '0')
		{
			$dws = 'Sun';
		}
		elseif ($dw == '1')
		{
			$dws = 'Mon';
		}
		elseif ($dw == '2')
		{
			$dws = 'Tue';
		}
		elseif ($dw == '3')
		{
			$dws = 'Wen';
		}
		elseif ($dw == '4')
		{
			$dws = 'Thu';
		}
		elseif ($dw == '5')
		{
			$dws = 'Fri';
		}
		elseif ($dw == '6')
		{
			$dws = 'Sat';
		}
		else
		{
			$dws = '';
		}
		return $dws;
	}

	public function rssDate($date)
	{
// Wed, 02 Oct 2002 13:00:00 GMT
		$arr = explode('-', substr($date, 0, 10));
// long year: 2001
		$long_year = $arr[0];
// long_month: 01
		$long_month = $arr[1];
// month name: January
		if ($arr[1] == '01')
		{
			$month_name = 'Jan';
		}
		elseif ($arr[1] == '02')
		{
			$month_name = 'Feb';
		}
		elseif ($arr[1] == '03')
		{
			$month_name = 'Mar';
		}
		elseif ($arr[1] == '04')
		{
			$month_name = 'Apr';
		}
		elseif ($arr[1] == '05')
		{
			$month_name = 'May';
		}
		elseif ($arr[1] == '06')
		{
			$month_name = 'Jun';
		}
		elseif ($arr[1] == '07')
		{
			$month_name = 'Jul';
		}
		elseif ($arr[1] == '08')
		{
			$month_name = 'Aug';
		}
		elseif ($arr[1] == '09')
		{
			$month_name = 'Sep';
		}
		elseif ($arr[1] == '10')
		{
			$month_name = 'Oct';
		}
		elseif ($arr[1] == '11')
		{
			$month_name = 'Nov';
		}
		elseif ($arr[1] == '12')
		{
			$month_name = 'Dec';
		}
		else
		{
			$month_name = '';
		}
// long date: 01
		$long_date = $arr[2];
		$dw = $this->dayOfWeek($date);
		$t = substr($date, - 8);
// final date
// Wed, 02 Oct 2002 13:00:00 GMT
		$rssDate = $dw . ', ' . $long_date . ' ' . $month_name . ' ' . $long_year . ' ' . $t . ' GMT';
		return $rssDate;
	}

	public function firstCharacterCheck($str)
	{
		if ($str[0] == '0' || $str[0] == '1' || $str[0] == '2' || $str[0] == '3' || $str[0] == '4' || $str[0] == '5' || $str[0] == '6' || $str[0] == '7' || $str[0] == '8' || $str[0] == '9')
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function minUsernameCheck($str)
	{
		$min = 4;
		if (strlen($str) < $min)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function minPasswordCheck($str)
	{
		$min = 4;
		if (strlen($str) < $min)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function generatePasswordKey($length = 32)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		$string = '';
		for ($i = 0; $i < $length; $i++)
		{
			$string .= $characters[mt_rand(0, strlen($characters) - 1)];
		}
		return $string;
	}

	public function simpleCatList($data, $seg = '')
	{
		$tree = array(0 => array());
		foreach ($data as $k => $v)
		{
			$tree[$v['category_id']][0] = $v['category_name'];
			if (!is_null($v['parent_id']))
			{
				if (!isset ($tree[$v['parent_id']]))
				{
					$tree[$v['parent_id']] = array();
				}
				$tree[$v['parent_id']][$this->findFreeIndex($tree[$v['parent_id']], 1)] = $v['category_id'];
			}
			else
			{
				$tree[0][$this->findFreeIndex($tree[0], 1)] = $v['category_id'];
			}
		}
		ksort($tree, SORT_ASC);
		$html = '<ul>';
		foreach ($tree[0] as $row)
		{
			$html .= $this->simpleDrawBranch($row, $tree, $seg, true);
		}
		$html .= '</ul>';
		return $html;
	}

	public function adminCatList($data)
	{
		$tree = array(0 => array());
		foreach ($data as $k => $v)
		{
			$tree[$v['category_id']][0] = $v['category_name'];
			if (!is_null($v['parent_id']))
			{
				if (!isset ($tree[$v['parent_id']]))
				{
					$tree[$v['parent_id']] = array();
				}
				$tree[$v['parent_id']][$this->findFreeIndex($tree[$v['parent_id']], 1)] = $v['category_id'];
			}
			else
			{
				$tree[0][$this->findFreeIndex($tree[0], 1)] = $v['category_id'];
			}
		}
		ksort($tree, SORT_ASC);
		$html = '<ul>';
		foreach ($tree[0] as $row)
		{
			$html .= $this->adminDrawBranch($row, $tree, true);
		}
		$html .= '</ul>';
		return $html;
	}

	private function findFreeIndex($array, $startInd = 0)
	{
		return (isset ($array [$startInd]) ? $this->findFreeIndex($array, $startInd + 1) : $startInd);
	}

	private function simpleDrawBranch($row, $tree, $seg, $isRoot = false)
	{
		$branch = $tree[$row];
		$name = $branch[0];
		unset ($branch[0]);
		$strong1 = '';
		$strong2 = '';
		if ($row == $seg)
		{
			$strong1 = '<strong>';
			$strong2 = '</strong>';
		}
		$html = '<li><a href="' . FWURL . Registry :: setting('settings_site0') . '/category/' . $row . '">' . $strong1 . $name . $strong2 . '</a>';
		if (count($branch) > 0)
		{
			$html .= '<ul>';
			foreach ($branch as $row)
			{
				$html .= $this->simpleDrawBranch($row, $tree, $seg);
			}
			$html .= '</ul>';
		}
		$html .= '</li>';
		return $html;
	}

	private function adminDrawBranch($row, $tree, $isRoot = false)
	{
		$branch = $tree[$row];
		$name = $branch[0];
		unset ($branch[0]);
		$html = '<li><span class="cat_name"><a href="' . FWURL . Registry :: setting('settings_site0') . 'category/' . $row . '">' . $name . '</a></span> |
			<span class="cat_link"><a href="' . FWURL . 'admin/create_category/' . $row . '">' . Registry :: library('lang')->line('create_subcategory') . '</a></span> |
			<span class="cat_link"><a href="' . FWURL . 'admin/edit_category/' . $row . '">' . Registry :: library('lang')->line('edit') . '</a></span> |
			<span class="cat_link"><a onclick="return deletechecked();" href="' . FWURL . 'admin/delete_category/' . $row . '">' . Registry :: library('lang')->line('delete') . '</a></span> |
			<span class="cat_link"><a href="' . FWURL . 'admin/category_up/' . $row . '">' . Registry :: library('lang')->line('up') . '</a></span> |
			<span class="cat_link"><a href="' . FWURL . 'admin/category_down/' . $row . '">' . Registry :: library('lang')->line('down') . '</a></span>';
		if (count($branch) > 0)
		{
			$html .= '<ul>';
			foreach ($branch as $row)
			{
				$html .= $this->adminDrawBranch($row, $tree);
			}
			$html .= '</ul>';
		}
		$html .= '</li>';
		return $html;
	}

	public function adminCatCheckBoxList($data, $checked = null)
	{
		$tree = array(0 => array());
		foreach ($data as $k => $v)
		{
			$tree[$v['category_id']][0] = $v['category_name'];
			if (!is_null($v['parent_id']))
			{
				if (!isset ($tree[$v['parent_id']]))
				{
					$tree[$v['parent_id']] = array();
				}
				$tree[$v['parent_id']][$this->findFreeIndex($tree[$v['parent_id']], 1)] = $v['category_id'];
			}
			else
			{
				$tree[0][$this->findFreeIndex($tree[0], 1)] = $v['category_id'];
			}
		}
		ksort($tree, SORT_ASC);
		$html = '<ul>';
		foreach ($tree[0] as $row)
		{
			$html .= $this->adminCheckBoxDrawBranch($row, $tree, $checked, true);
		}
		$html .= '</ul>';
		return $html;
	}

	private function adminCheckBoxDrawBranch($row, $tree, $checked, $isRoot = false)
	{
		$checkedString = ' ';
		if (isset ($checked))
		{
			if (in_array($row, $checked))
			{
				$checkedString = 'checked';
			}
		}
		$branch = $tree[$row];
		$name = $branch[0];
		unset ($branch[0]);
		$html = '<li><input type="checkbox" name="catGroup[]" value="' . $row . '" ' . $checkedString . ' >' . $name;
		if (count($branch) > 0)
		{
			$html .= '<ul>';
			foreach ($branch as $row)
			{
				$html .= $this->adminCheckBoxDrawBranch($row, $tree, $checked);
			}
			$html .= '</ul>';
		}
		$html .= '</li>';
		return $html;
	}

	public function adminCatDropDownList($data, $checked = null)
	{
		$tree = array(0 => array());
		foreach ($data as $k => $v)
		{
			$tree[$v['category_id']][0] = $v['category_name'];
			if (!is_null($v['parent_id']))
			{
				if (!isset ($tree[$v['parent_id']]))
				{
					$tree[$v['parent_id']] = array();
				}
				$tree[$v['parent_id']][$this->findFreeIndex($tree[$v['parent_id']], 1)] = $v['category_id'];
			}
			else
			{
				$tree[0][$this->findFreeIndex($tree[0], 1)] = $v['category_id'];
			}
		}
		ksort($tree, SORT_ASC);
		$html = '<select name="catOne">
';
		foreach ($tree[0] as $row)
		{
			$html .= $this->adminDropDownDrawBranch($row, $tree, $checked, true);
		}
		$html .= '</select>
';
		return $html;
	}

	private function adminDropDownDrawBranch($row, $tree, $checked, $isRoot = false)
	{
		$checkedString = '';
		if (isset ($checked))
		{
			if (in_array($row, $checked))
			{
				$checkedString = 'selected="selected"';
			}
		}
		$branch = $tree[$row];
		$name = $branch[0];
		unset ($branch[0]);
		$html = '<option value="' . $row . '" ' . $checkedString . '>' . $name . '</option>';
		if (count($branch) > 0)
		{
			$html .= '';
			foreach ($branch as $row)
			{
				$html .= $this->adminDropDownDrawBranch($row, $tree, $checked);
			}
			$html .= '';
		}
		$html .= '';
		return $html;
	}

	public function simpleShopList($data, $seg = '')
	{
		$tree = array(0 => array());
		foreach ($data as $k => $v)
		{
			$tree[$v['f_shop_id']][0] = $v['f_name'];
			if (!is_null($v['f_parent_shop_id']))
			{
				if (!isset ($tree[$v['f_parent_shop_id']]))
				{
					$tree[$v['f_parent_shop_id']] = array();
				}
				$tree[$v['f_parent_shop_id']][$this->findFreeIndex($tree[$v['f_parent_shop_id']], 1)] = $v['f_shop_id'];
			}
			else
			{
				$tree[0][$this->findFreeIndex($tree[0], 1)] = $v['f_shop_id'];
			}
		}
		ksort($tree, SORT_ASC);
		$html = '<ul>';
		foreach ($tree[0] as $row)
		{
			$html .= $this->simpleShopDrawBranch($row, $tree, $seg, true);
		}
		$html .= '</ul>';
		return $html;
	}

	private function simpleShopDrawBranch($row, $tree, $seg, $isRoot = false)
	{
		$branch = $tree[$row];
		$name = $branch[0];
		unset ($branch[0]);
		$strong1 = '';
		$strong2 = '';
		if ($row == $seg)
		{
			$strong1 = '<strong>';
			$strong2 = '</strong>';
		}
		$html = '<li><a href="' . FWURL . Registry :: setting('settings_shop0') . '/viewshop/' . $row . '">' . $strong1 . $name . $strong2 . '</a>';
		if (count($branch) > 0)
		{
			$html .= '<ul>';
			foreach ($branch as $row)
			{
				$html .= $this->simpleShopDrawBranch($row, $tree, $seg);
			}
			$html .= '</ul>';
		}
		$html .= '</li>';
		return $html;
	}
// To get Parent Cat ID + all Children Cat IDs
// multiCatList(1, 'shops', 'f_shop_id', 'f_parent_shop_id', $seg_2);

	public function multiCatList($ID, $sys_cms)
	{
		$prefix = $this->prefix = Registry :: library('db')->getPrefix();
		$tempTree = $t;
		$sql = 'SELECT *, COUNT(f_shop_id) AS `shop_count_2`
		FROM ' . $prefix . 'shops
		WHERE f_parent_shop_id = ' . $ID . '
		AND shops_sys = "' . $sys_cms . '"
		GROUP BY f_shop_id';
		$cache = Registry :: library('db')->cacheQuery($sql);
		if (Registry :: library('db')->numRowsFromCache($cache) != 0)
		{
			$data = Registry :: library('db')->rowsFromCache($cache);
			foreach ($data as $k => $v)
			{
				if ($v['shop_count_2'] != 0)
				{
					$tempTree .= $v['f_shop_id'] . ",";
					$tempTree .= $this->multiCatList($v['f_shop_id'], $tempTree);
// Add to the temporary local tree
				}
			}
		}
		$tT = explode(",", $tempTree);
		$new_arr = array();
		for ($i = 0; $i < count($tT); $i++)
		{
			$repeated = 0;
			for ($j = $i + 1; $j < count($tT); $j++)
			{
				if ($tT[$i] == $tT[$j])
				{
					$repeated = 1;
				}
			}
			if ($repeated == 0)
			{
				$new_arr[] = $tT[$i];
			}
		}
		$tempTree = implode(",", $new_arr);
		return $tempTree;
// Return the entire child tree
	}

	public function adminSimpleShopList($data, $seg = '')
	{
		$tree = array(0 => array());
		foreach ($data as $k => $v)
		{
			$tree[$v['f_shop_id']][0] = $v['f_name'];
			if (!is_null($v['f_parent_shop_id']))
			{
				if (!isset ($tree[$v['f_parent_shop_id']]))
				{
					$tree[$v['f_parent_shop_id']] = array();
				}
				$tree[$v['f_parent_shop_id']][$this->findFreeIndex($tree[$v['f_parent_shop_id']], 1)] = $v['f_shop_id'];
			}
			else
			{
				$tree[0][$this->findFreeIndex($tree[0], 1)] = $v['f_shop_id'];
			}
		}
		ksort($tree, SORT_ASC);
		$html = '<ul>';
		foreach ($tree[0] as $row)
		{
			$html .= $this->adminSimpleShopDrawBranch($row, $tree, $seg, true);
		}
		$html .= '</ul>';
		return $html;
	}

	private function adminSimpleShopDrawBranch($row, $tree, $seg, $isRoot = false)
	{
		$branch = $tree[$row];
		$name = $branch[0];
		unset ($branch[0]);
		$html = '<li><a href="' . FWURL . Registry :: setting('settings_shop0') . '/viewshop/' . $row . '"><b>' . $name . '</b></a> | <a href="' . FWURL . 'admin/create_shop/' . $row . '">' . Registry :: library('lang')->line('create_department') . '</a> | <a href="' . FWURL . 'admin/edit_shop/' . $row . '">' . Registry :: library('lang')->line('edit') . '</a> | <a onclick="return deletechecked();" href="' . FWURL . 'admin/delete_shop/' . $row . '">' . Registry :: library('lang')->line('delete') . '</a> | <a href="' . FWURL . 'admin/shop_up/' . $row . '">' . Registry :: library('lang')->line('up') . '</a> | <a href="' . FWURL . 'admin/shop_down/' . $row . '">' . Registry :: library('lang')->line('down') . '</a>';
		if (count($branch) > 0)
		{
			$html .= '<ul>';
			foreach ($branch as $row)
			{
				$html .= $this->adminSimpleShopDrawBranch($row, $tree, $seg);
			}
			$html .= '</ul>';
		}
		$html .= '</li>';
		return $html;
	}

	public function copyright_years($startyear = '')
	{
		$result = '';
		$result .= $startyear;
		$current_year = date('Y');
		;
		if ($startyear != $current_year)
		{
			$result .= '&mdash;' . $current_year;
		}
		return $result;
	}

	public function gravatar($email)
	{
		$gravatar = 'http://www.gravatar.com/avatar/';
		if ($email != '')
		{
			$gravatar .= md5(strtolower(trim($email)));
		}
		return $gravatar;
	}

	public function adminPagesList($data)
	{
		$tree = array(0 => array(), 1 => array());
		foreach ($data as $k => $v)
		{
			$url = '';
			if ($v['page_url_1'] != '')
			{
				$url .= $v['page_url_1'] . '/';
			}
			if ($v['page_url_2'] != '')
			{
				$url .= $v['page_url_2'] . '/';
			}
			if ($v['page_url_3'] != '')
			{
				$url .= $v['page_url_3'] . '/';
			}
			if ($v['page_url_4'] != '')
			{
				$url .= $v['page_url_4'] . '/';
			}
			if ($v['page_url_5'] != '')
			{
				$url .= $v['page_url_5'] . '/';
			}
			if ($v['page_url_6'] != '')
			{
				$url .= $v['page_url_6'] . '/';
			}
			if ($v['page_url_7'] != '')
			{
				$url .= $v['page_url_7'] . '/';
			}
			if ($v['page_url_8'] != '')
			{
				$url .= $v['page_url_8'] . '/';
			}
			$temp = array(0 => $v['page_title'], 1 => $url);
			$tree[$v['page_id']][0] = $temp;
			if (!is_null($v['parent_id']))
			{
				if (!isset ($tree[$v['parent_id']]))
				{
					$tree[$v['parent_id']] = array();
				}
				$tree[$v['parent_id']][$this->findFreeIndex($tree[$v['parent_id']], 1)] = $v['page_id'];
			}
			else
			{
				$tree[0][$this->findFreeIndex($tree[0], 1)] = $v['page_id'];
			}
		}
		ksort($tree, SORT_ASC);
		$html = '<ul>';
		foreach ($tree[0] as $row)
		{
			$html .= $this->adminDrawPagesBranch($row, $tree, true);
		}
		$html .= '</ul>';
		return $html;
	}

	private function adminDrawPagesBranch($row, $tree, $isRoot = false)
	{
		$branch = $tree[$row];
		$name = $branch[0][0];
		$url = $branch[0][1];
		unset ($branch[0]);
		$html = '<li><span class="cat_name"><a href="' . FWURL . $url . '">' . $name . '</a></span> |
			<span class="cat_link"><a href="' . FWURL . 'admin/create_page/' . $row . '">' . Registry :: library('lang')->line('create_page') . '</a></span> |
			<span class="cat_link"><a href="' . FWURL . 'admin/edit_page/' . $row . '">' . Registry :: library('lang')->line('edit') . '</a></span> |
			<span class="cat_link"><a onclick="return deletechecked();" href="' . FWURL . 'admin/delete_page/' . $row . '">' . Registry :: library('lang')->line('delete') . '</a></span> |
			<span class="cat_link"><a href="' . FWURL . 'admin/page_up/' . $row . '">' . Registry :: library('lang')->line('up') . '</a></span> |
			<span class="cat_link"><a href="' . FWURL . 'admin/page_down/' . $row . '">' . Registry :: library('lang')->line('down') . '</a></span>';
		if (count($branch) > 0)
		{
			$html .= '<ul>';
			foreach ($branch as $row)
			{
				$html .= $this->adminDrawPagesBranch($row, $tree);
			}
			$html .= '</ul>';
		}
		$html .= '</li>';
		return $html;
	}

	public function simplePagesList($data)
	{
		$tree = array(0 => array());
		foreach ($data as $k => $v)
		{
			if ($v['web_url'] == '')
			{
				$url = '';
				if ($v['page_url_1'] != '')
				{
					$url .= $v['page_url_1'] . '/';
				}
				if ($v['page_url_2'] != '')
				{
					$url .= $v['page_url_2'] . '/';
				}
				if ($v['page_url_3'] != '')
				{
					$url .= $v['page_url_3'] . '/';
				}
				if ($v['page_url_4'] != '')
				{
					$url .= $v['page_url_4'] . '/';
				}
				if ($v['page_url_5'] != '')
				{
					$url .= $v['page_url_5'] . '/';
				}
				if ($v['page_url_6'] != '')
				{
					$url .= $v['page_url_6'] . '/';
				}
				if ($v['page_url_7'] != '')
				{
					$url .= $v['page_url_7'] . '/';
				}
				if ($v['page_url_8'] != '')
				{
					$url .= $v['page_url_8'] . '/';
				}
				$url = FWURL . $url;
			}
			else
			{
				$url = $v['web_url'];
			}
			$temp = array(0 => $v['page_title'], 1 => $url);
			$tree[$v['page_id']][0] = $temp;
			if (!is_null($v['parent_id']))
			{
				if (!isset ($tree[$v['parent_id']]))
				{
					$tree[$v['parent_id']] = array();
				}
				$tree[$v['parent_id']][$this->findFreeIndex($tree[$v['parent_id']], 1)] = $v['page_id'];
			}
			else
			{
				$tree[0][$this->findFreeIndex($tree[0], 1)] = $v['page_id'];
			}
		}
		ksort($tree, SORT_ASC);
		$html = '<ul>';
		foreach ($tree[0] as $row)
		{
			$html .= $this->simpleDrawPagesBranch($row, $tree, true);
		}
		$html .= '</ul>';
		return $html;
	}

	private function simpleDrawPagesBranch($row, $tree, $isRoot = false)
	{
		$branch = $tree[$row];
		$name = $branch[0][0];
		$url = $branch[0][1];
		unset ($branch[0]);
		$html = '<li><a href="' . $url . '">' . $name . '</a>';
		if (count($branch) > 0)
		{
			$html .= '<ul>';
			foreach ($branch as $row)
			{
				$html .= $this->simpleDrawPagesBranch($row, $tree);
			}
			$html .= '</ul>';
		}
		$html .= '</li>';
		return $html;
	}

	public function timeWord($from_time, $to_time = 0, $include_seconds = true)
	{
		if (strpos($from_time, '-'))
		{
			$from_time = strtotime($from_time);
		}
		$html = '';
		if ($to_time == 0)
		{
			$to_time = time();
		}
		else
		{
			if (strpos($to_time, '-'))
			{
				$to_time = strtotime($to_time);
			}
		}
		$time_in_minutes = round(abs($to_time - $from_time) / 60);
		$time_in_seconds = round(abs($to_time - $from_time));
		if ($time_in_minutes >= 0 and $time_in_minutes <= 1)
		{
			if (!$include_seconds)
			{
				if ($time_in_minutes == 0)
				{
					$html .= Registry :: library('lang')->line('less_than_a_minute');
				}
				else
				{
					$html .= Registry :: library('lang')->line('1_minute');
				}
			}
			else
			{
				if ($time_in_seconds >= 0 and $time_in_seconds <= 4)
				{
					$html .= Registry :: library('lang')->line('less_than_5_seconds');
				}
				elseif ($time_in_seconds >= 5 and $time_in_seconds <= 9)
				{
					$html .= Registry :: library('lang')->line('less_than_10_seconds');
				}
				elseif ($time_in_seconds >= 10 and $time_in_seconds <= 19)
				{
					$html .= Registry :: library('lang')->line('less_than_20_seconds');
				}
				elseif ($time_in_seconds >= 20 and $time_in_seconds <= 39)
				{
					$html .= Registry :: library('lang')->line('half_a_minute');
				}
				elseif ($time_in_seconds >= 40 and $time_in_seconds <= 59)
				{
					$html .= Registry :: library('lang')->line('less_than_a_minute');
				}
				else
				{
					$html .= Registry :: library('lang')->line('1_minute');
				}
			}
		}
		elseif ($time_in_minutes >= 2 and $time_in_minutes <= 4)
		{
			$html .= $time_in_minutes . ' ' . Registry :: library('lang')->line('minutes2');
		}
		elseif ($time_in_minutes >= 5 and $time_in_minutes <= 44)
		{
			$html .= $time_in_minutes . ' ' . Registry :: library('lang')->line('minutes');
		}
		elseif ($time_in_minutes >= 45 and $time_in_minutes <= 89)
		{
			$html .= Registry :: library('lang')->line('about_1_hour');
		}
		elseif ($time_in_minutes >= 90 and $time_in_minutes <= 269)
		{
			$html .= Registry :: library('lang')->line('about') . ' ' . round(floatval($time_in_minutes) / 60.0) . ' ' . Registry :: library('lang')->line('hours2');
		}
		elseif ($time_in_minutes >= 270 and $time_in_minutes <= 1439)
		{
			$html .= Registry :: library('lang')->line('about') . ' ' . round(floatval($time_in_minutes) / 60.0) . ' ' . Registry :: library('lang')->line('hours');
		}
		elseif ($time_in_minutes >= 1440 and $time_in_minutes <= 2879)
		{
			$html .= Registry :: library('lang')->line('1_day');
		}
		elseif ($time_in_minutes >= 2880 and $time_in_minutes <= 6479)
		{
			$html .= Registry :: library('lang')->line('about') . ' ' . round(floatval($time_in_minutes) / 1440) . ' ' . Registry :: library('lang')->line('days2');
		}
		elseif ($time_in_minutes >= 6480 and $time_in_minutes <= 43199)
		{
			$html .= Registry :: library('lang')->line('about') . ' ' . round(floatval($time_in_minutes) / 1440) . ' ' . Registry :: library('lang')->line('days');
		}
		elseif ($time_in_minutes >= 43200 and $time_in_minutes <= 86399)
		{
			$html .= Registry :: library('lang')->line('about_1_month');
		}
		elseif ($time_in_minutes >= 86400 and $time_in_minutes <= 194399)
		{
			$html .= round(floatval($time_in_minutes) / 43200) . ' ' . Registry :: library('lang')->line('months2');
		}
		elseif ($time_in_minutes >= 194400 and $time_in_minutes <= 525599)
		{
			$html .= round(floatval($time_in_minutes) / 43200) . ' ' . Registry :: library('lang')->line('months');
		}
		elseif ($time_in_minutes >= 525600 and $time_in_minutes <= 1051199)
		{
			$html .= Registry :: library('lang')->line('about_1_year');
		}
		elseif ($time_in_minutes >= 1051200 and $time_in_minutes <= 2365199)
		{
			$html .= Registry :: library('lang')->line('over') . ' ' . round(floatval($time_in_minutes) / 525600) . ' ' . Registry :: library('lang')->line('years2');
		}
		else
		{
			$html .= Registry :: library('lang')->line('over') . ' ' . round(floatval($time_in_minutes) / 525600) . ' ' . Registry :: library('lang')->line('years');
		}
		$html .= ' ';
		$html .= Registry :: library('lang')->line('ago');
		return $html;
	}

	public function blogCalendarCurrent($firstDay = 0)
	{
		$daysWithArticles = array();
		$prefix = $this->prefix = Registry :: library('db')->getPrefix();
		$startSearchDate = date("Y-m-01 00:00:00", time());
		$endSearchDate = date("Y-m-d H:i:s", time());
		$sys_cms = Registry :: library('db')->getSys();
		$sql = 'SELECT article_id, art_created
		FROM ' . $prefix . 'articles
		WHERE article_visible = "1"
		AND articles_sys = "' . $sys_cms . '"
		AND art_created between "' . $startSearchDate . '" and "' . $endSearchDate . '"';
		$cache = Registry :: library('db')->cacheQuery($sql);
		if (Registry :: library('db')->numRowsFromCache($cache) != 0)
		{
			$data = Registry :: library('db')->rowsFromCache($cache);
			$i = 0;
			foreach ($data as $k => $v)
			{
				$daysWithArticles[$i] = substr($v['art_created'], 8, 2);
				if (substr($daysWithArticles[$i], 0, 1) == '0')
				{
					$daysWithArticles[$i] = substr($daysWithArticles[$i], 1);
				}
				$i++;
			}
		}
		if (Registry :: library('lang')->getLanguage() == 'russian')
		{
			$firstDay = 1;
		}
		$blogCalendar = '';
		$currentDay = date("j", time());
		$currentMonth = date("m", time());
		$currentYear = date("Y", time());
		if (substr($currentMonth, 0, 1) == '0')
		{
			$short_month = (substr($currentMonth, 1));
		}
		else
		{
			$short_month = $currentMonth;
		}
		if (substr($arr[2], 0, 1) == '0')
		{
			$short_date = (substr($arr[2], 1));
		}
		else
		{
			$short_date = $arr[2];
		}
		$jd = cal_to_jd(CAL_GREGORIAN, date("m"), '1', date("Y"));
		$startDay = jddayofweek($jd, 0) - $firstDay;
		if ($startDay == - 1)
		{
			$startDay = 6;
		}
		if ($currentMonth == '01')
		{
			$prevMonth = '12';
			$prevYear = $currentYear - 1;
			$nextMonth = '02';
			$nextYear = $currentYear;
		}
		if ($currentMonth == '02')
		{
			$prevMonth = '01';
			$prevYear = $currentYear;
			$nextMonth = '03';
			$nextYear = $currentYear;
		}
		if ($currentMonth == '03')
		{
			$prevMonth = '02';
			$prevYear = $currentYear;
			$nextMonth = '04';
			$nextYear = $currentYear;
		}
		if ($currentMonth == '04')
		{
			$prevMonth = '03';
			$prevYear = $currentYear;
			$nextMonth = '05';
			$nextYear = $currentYear;
		}
		if ($currentMonth == '05')
		{
			$prevMonth = '04';
			$prevYear = $currentYear;
			$nextMonth = '06';
			$nextYear = $currentYear;
		}
		if ($currentMonth == '06')
		{
			$prevMonth = '05';
			$prevYear = $currentYear;
			$nextMonth = '07';
			$nextYear = $currentYear;
		}
		if ($currentMonth == '07')
		{
			$prevMonth = '06';
			$prevYear = $currentYear;
			$nextMonth = '08';
			$nextYear = $currentYear;
		}
		if ($currentMonth == '08')
		{
			$prevMonth = '07';
			$prevYear = $currentYear;
			$nextMonth = '09';
			$nextYear = $currentYear;
		}
		if ($currentMonth == '09')
		{
			$prevMonth = '08';
			$prevYear = $currentYear;
			$nextMonth = '10';
			$nextYear = $currentYear;
		}
		if ($currentMonth == '10')
		{
			$prevMonth = '09';
			$prevYear = $currentYear;
			$nextMonth = '11';
			$nextYear = $currentYear;
		}
		if ($currentMonth == '11')
		{
			$prevMonth = '10';
			$prevYear = $currentYear;
			$nextMonth = '12';
			$nextYear = $currentYear;
		}
		if ($currentMonth == '12')
		{
			$prevMonth = '11';
			$prevYear = $currentYear;
			$nextMonth = '01';
			$nextYear = $currentYear + 1;
		}
		$daysInMonth = array();
		$daysInMonth[0] = 31;
		if ((($currentYear % 4 == 0) && ($currentYear % 100 != 0)) || ($currentYear % 400 == 0))
		{
			$daysInMonth[1] = 29;
		}
		else
		{
			$daysInMonth[1] = 28;
		}
		$daysInMonth[2] = 31;
		$daysInMonth[3] = 30;
		$daysInMonth[4] = 31;
		$daysInMonth[5] = 30;
		$daysInMonth[6] = 31;
		$daysInMonth[7] = 31;
		$daysInMonth[8] = 30;
		$daysInMonth[9] = 31;
		$daysInMonth[10] = 30;
		$daysInMonth[11] = 31;
// month name: January
		if ($currentMonth == '01')
		{
			$month_name = 'january';
		}
		elseif ($currentMonth == '02')
		{
			$month_name = 'february';
		}
		elseif ($currentMonth == '03')
		{
			$month_name = 'march';
		}
		elseif ($currentMonth == '04')
		{
			$month_name = 'april';
		}
		elseif ($currentMonth == '05')
		{
			$month_name = 'may';
		}
		elseif ($currentMonth == '06')
		{
			$month_name = 'june';
		}
		elseif ($currentMonth == '07')
		{
			$month_name = 'july';
		}
		elseif ($currentMonth == '08')
		{
			$month_name = 'august';
		}
		elseif ($currentMonth == '09')
		{
			$month_name = 'september';
		}
		elseif ($currentMonth == '10')
		{
			$month_name = 'october';
		}
		elseif ($currentMonth == '11')
		{
			$month_name = 'november';
		}
		elseif ($currentMonth == '12')
		{
			$month_name = 'december';
		}
		else
		{
			$month_name = '';
		}
		$month_name = Registry :: library('lang')->line($month_name);
		$blogCalendar .= '<div id="cal">
		<div class="header">
			<span class="left button-calendar" id="prev"><a href="' . FWURL . Registry :: setting("settings_site0") . '/calendar/' . $prevYear . '/' . $prevMonth . '"> &lang; </a></span>
			<span class="left hook"></span>
			<span class="month-year" id="label">' . $month_name . ' ' . $currentYear . '</span>
			<span class="right hook"></span>
			<span class="right button-calendar" id="next"><a href="' . FWURL . Registry :: setting("settings_site0") . '/calendar/' . $nextYear . '/' . $nextMonth . '"> &rang; </a></span>
		</div>
		<table id="days">
			<tr>';
		if ($firstDay == 0)
		{
			$blogCalendar .= '<td>' . Registry :: library('lang')->line('sun') . '</td>
				<td>' . Registry :: library('lang')->line('mon') . '</td>
				<td>' . Registry :: library('lang')->line('tue') . '</td>
				<td>' . Registry :: library('lang')->line('wed') . '</td>
				<td>' . Registry :: library('lang')->line('thu') . '</td>
				<td>' . Registry :: library('lang')->line('fri') . '</td>
				<td>' . Registry :: library('lang')->line('sat') . '</td>';
		}
		else
		{
			$blogCalendar .= '<td>' . Registry :: library('lang')->line('mon') . '</td>
				<td>' . Registry :: library('lang')->line('tue') . '</td>
				<td>' . Registry :: library('lang')->line('wed') . '</td>
				<td>' . Registry :: library('lang')->line('thu') . '</td>
				<td>' . Registry :: library('lang')->line('fri') . '</td>
				<td>' . Registry :: library('lang')->line('sat') . '</td>
				<td>' . Registry :: library('lang')->line('sun') . '</td>';
		}
		$day = 1;
		$calendar = array();
		$haveDays = true;
		$i = 0;
		while ($haveDays)
		{
			for ($j = 0; $j < 7; $j++)
			{
				if ($i == 0)
				{
					if ($j == $startDay)
					{
						$calendar[$i][$j] = $day++;
						$startDay++;
					}
					else
					{
						$calendar[$i][$j] = "";
					}
				}
				elseif ($day <= $daysInMonth[$short_month - 1])
				{
					$calendar[$i][$j] = $day++;
				}
				else
				{
					$calendar[$i][$j] = "";
					$haveDays = false;
				}
				if ($day > $daysInMonth[$short_month - 1])
				{
					$haveDays = false;
				}
			}
			$i++;
		}
		if ($calendar[5])
		{
			for ($i = 0; $i < count($calendar[5]); $i++)
			{
				if ($calendar[5][$i] != "")
				{
					$calendar[4][$i] = "<span>" . $calendar[4][$i] . "</span><span>" . $calendar[5][$i] . "</span>";
				}
			}
			$last_element = array_pop($calendar);
		}
		for ($i = 0; $i < count($calendar); $i++)
		{
			$stringFromArr = implode('</td><td>', $calendar[$i]);
			$calendar[$i] = '<tr><td>' . $stringFromArr . '</td></tr>';
		}
		$stringFromArr = implode('', $calendar);
		$calendar = '<table class="curr">' . $stringFromArr . '</table>';
		$calendar = str_replace('<td></td>', '<td class="nil"></td>', $calendar);
		$calendar = str_replace('<td>' . $currentDay . '</td>', '<td class="today">' . $currentDay . '</td>', $calendar);
		$calendar = str_replace('<td><span>' . $currentDay . '</span>', '<td class="today"><span>' . $currentDay . '</span>', $calendar);
		$calendar = str_replace('<td><span>' . ($currentDay - 7) . '</span>', '<td class="today"><span>' . ($currentDay - 7) . '</span>', $calendar);
		$calendar = str_replace('<td><span>' . $currentDay . '</span>', '<td class="today"><span>' . $currentDay . '</span>', $calendar);
		$num = count($daysWithArticles);
		for ($i = 0; $i < $num; $i++)
		{
			$calendar = str_replace('>' . $daysWithArticles[$i] . '</td>', '><a href="' . FWURL . Registry :: setting("settings_site0") . '/calendar/' . $currentYear . '/' . $currentMonth . '/' . $daysWithArticles[$i] . '">' . $daysWithArticles[$i] . '</a></td>', $calendar);
			$calendar = str_replace('<span>' . $daysWithArticles[$i] . '</span>', '<span><a href="' . FWURL . Registry :: setting("settings_site0") . '/calendar/' . $currentYear . '/' . $currentMonth . '/' . $daysWithArticles[$i] . '">' . $daysWithArticles[$i] . '</a></span>', $calendar);
		}
		$blogCalendar .= '</tr>
		</table>
		<div id="cal-frame">' . $calendar . '</div>
	</div>';
		return $blogCalendar;
	}

	public function blogCalendar($year, $month, $day, $firstDay = 0)
	{
		$daysWithArticles = array();
		$prefix = $this->prefix = Registry :: library('db')->getPrefix();
		$startSearchDate = $year . '-' . $month . '-01 00:00:00';
		$endSearchDate = $year . '-' . $month . '-31 23:59:59';
		$sys_cms = Registry :: library('db')->getSys();
		$sql = 'SELECT article_id, art_created
		FROM ' . $prefix . 'articles
		WHERE article_visible = "1"
		AND articles_sys = "' . $sys_cms . '"
		AND art_created between "' . $startSearchDate . '" and "' . $endSearchDate . '"';
		$cache = Registry :: library('db')->cacheQuery($sql);
		if (Registry :: library('db')->numRowsFromCache($cache) != 0)
		{
			$data = Registry :: library('db')->rowsFromCache($cache);
			$i = 0;
			foreach ($data as $k => $v)
			{
				$daysWithArticles[$i] = substr($v['art_created'], 8, 2);
				if (substr($daysWithArticles[$i], 0, 1) == '0')
				{
					$daysWithArticles[$i] = substr($daysWithArticles[$i], 1);
				}
				$i++;
			}
		}
		if (Registry :: library('lang')->getLanguage() == 'russian')
		{
			$firstDay = 1;
		}
		$blogCalendar = '';
		$currentDay = $day;
		$currentMonth = $month;
		$currentYear = $year;
		if (substr($currentMonth, 0, 1) == '0')
		{
			$short_month = (substr($currentMonth, 1));
		}
		else
		{
			$short_month = $currentMonth;
		}
		if (substr($arr[2], 0, 1) == '0')
		{
			$short_date = (substr($arr[2], 1));
		}
		else
		{
			$short_date = $arr[2];
		}
		$jd = cal_to_jd(CAL_GREGORIAN, $month, '1', $year);
		$startDay = jddayofweek($jd, 0) - $firstDay;
		if ($startDay == - 1)
		{
			$startDay = 6;
		}
		if ($currentMonth == '01')
		{
			$prevMonth = '12';
			$prevYear = $currentYear - 1;
			$nextMonth = '02';
			$nextYear = $currentYear;
		}
		if ($currentMonth == '02')
		{
			$prevMonth = '01';
			$prevYear = $currentYear;
			$nextMonth = '03';
			$nextYear = $currentYear;
		}
		if ($currentMonth == '03')
		{
			$prevMonth = '02';
			$prevYear = $currentYear;
			$nextMonth = '04';
			$nextYear = $currentYear;
		}
		if ($currentMonth == '04')
		{
			$prevMonth = '03';
			$prevYear = $currentYear;
			$nextMonth = '05';
			$nextYear = $currentYear;
		}
		if ($currentMonth == '05')
		{
			$prevMonth = '04';
			$prevYear = $currentYear;
			$nextMonth = '06';
			$nextYear = $currentYear;
		}
		if ($currentMonth == '06')
		{
			$prevMonth = '05';
			$prevYear = $currentYear;
			$nextMonth = '07';
			$nextYear = $currentYear;
		}
		if ($currentMonth == '07')
		{
			$prevMonth = '06';
			$prevYear = $currentYear;
			$nextMonth = '08';
			$nextYear = $currentYear;
		}
		if ($currentMonth == '08')
		{
			$prevMonth = '07';
			$prevYear = $currentYear;
			$nextMonth = '09';
			$nextYear = $currentYear;
		}
		if ($currentMonth == '09')
		{
			$prevMonth = '08';
			$prevYear = $currentYear;
			$nextMonth = '10';
			$nextYear = $currentYear;
		}
		if ($currentMonth == '10')
		{
			$prevMonth = '09';
			$prevYear = $currentYear;
			$nextMonth = '11';
			$nextYear = $currentYear;
		}
		if ($currentMonth == '11')
		{
			$prevMonth = '10';
			$prevYear = $currentYear;
			$nextMonth = '12';
			$nextYear = $currentYear;
		}
		if ($currentMonth == '12')
		{
			$prevMonth = '11';
			$prevYear = $currentYear;
			$nextMonth = '01';
			$nextYear = $currentYear + 1;
		}
		$daysInMonth = array();
		$daysInMonth[0] = 31;
		if ((($currentYear % 4 == 0) && ($currentYear % 100 != 0)) || ($currentYear % 400 == 0))
		{
			$daysInMonth[1] = 29;
		}
		else
		{
			$daysInMonth[1] = 28;
		}
		$daysInMonth[2] = 31;
		$daysInMonth[3] = 30;
		$daysInMonth[4] = 31;
		$daysInMonth[5] = 30;
		$daysInMonth[6] = 31;
		$daysInMonth[7] = 31;
		$daysInMonth[8] = 30;
		$daysInMonth[9] = 31;
		$daysInMonth[10] = 30;
		$daysInMonth[11] = 31;
// month name: January
		if ($currentMonth == '01')
		{
			$month_name = 'january';
		}
		elseif ($currentMonth == '02')
		{
			$month_name = 'february';
		}
		elseif ($currentMonth == '03')
		{
			$month_name = 'march';
		}
		elseif ($currentMonth == '04')
		{
			$month_name = 'april';
		}
		elseif ($currentMonth == '05')
		{
			$month_name = 'may';
		}
		elseif ($currentMonth == '06')
		{
			$month_name = 'june';
		}
		elseif ($currentMonth == '07')
		{
			$month_name = 'july';
		}
		elseif ($currentMonth == '08')
		{
			$month_name = 'august';
		}
		elseif ($currentMonth == '09')
		{
			$month_name = 'september';
		}
		elseif ($currentMonth == '10')
		{
			$month_name = 'october';
		}
		elseif ($currentMonth == '11')
		{
			$month_name = 'november';
		}
		elseif ($currentMonth == '12')
		{
			$month_name = 'december';
		}
		else
		{
			$month_name = '';
		}
		$month_name = Registry :: library('lang')->line($month_name);
		$blogCalendar .= '<div id="cal">
		<div class="header">
			<span class="left button-calendar" id="prev"><a href="' . FWURL . Registry :: setting("settings_site0") . '/calendar/' . $prevYear . '/' . $prevMonth . '"> &lang; </a></span>
			<span class="left hook"></span>
			<span class="month-year" id="label">' . $month_name . ' ' . $currentYear . '</span>
			<span class="right hook"></span>
			<span class="right button-calendar" id="next"><a href="' . FWURL . Registry :: setting("settings_site0") . '/calendar/' . $nextYear . '/' . $nextMonth . '"> &rang; </a></span>
		</div>
		<table id="days">
			<tr>';
		if ($firstDay == 0)
		{
			$blogCalendar .= '<td>' . Registry :: library('lang')->line('sun') . '</td>
				<td>' . Registry :: library('lang')->line('mon') . '</td>
				<td>' . Registry :: library('lang')->line('tue') . '</td>
				<td>' . Registry :: library('lang')->line('wed') . '</td>
				<td>' . Registry :: library('lang')->line('thu') . '</td>
				<td>' . Registry :: library('lang')->line('fri') . '</td>
				<td>' . Registry :: library('lang')->line('sat') . '</td>';
		}
		else
		{
			$blogCalendar .= '<td>' . Registry :: library('lang')->line('mon') . '</td>
				<td>' . Registry :: library('lang')->line('tue') . '</td>
				<td>' . Registry :: library('lang')->line('wed') . '</td>
				<td>' . Registry :: library('lang')->line('thu') . '</td>
				<td>' . Registry :: library('lang')->line('fri') . '</td>
				<td>' . Registry :: library('lang')->line('sat') . '</td>
				<td>' . Registry :: library('lang')->line('sun') . '</td>';
		}
		$day = 1;
		$calendar = array();
		$haveDays = true;
		$i = 0;
		while ($haveDays)
		{
			for ($j = 0; $j < 7; $j++)
			{
				if ($i == 0)
				{
					if ($j == $startDay)
					{
						$calendar[$i][$j] = $day++;
						$startDay++;
					}
					else
					{
						$calendar[$i][$j] = "";
					}
				}
				elseif ($day <= $daysInMonth[$short_month - 1])
				{
					$calendar[$i][$j] = $day++;
				}
				else
				{
					$calendar[$i][$j] = "";
					$haveDays = false;
				}
				if ($day > $daysInMonth[$short_month - 1])
				{
					$haveDays = false;
				}
			}
			$i++;
		}
// echo '<pre>';
// print_r($calendar);
// echo '</pre>';
		if ($calendar[5])
		{
			for ($i = 0; $i < count($calendar[5]); $i++)
			{
				if ($calendar[5][$i] != "")
				{
					$calendar[4][$i] = "<span>" . $calendar[4][$i] . "</span><span>" . $calendar[5][$i] . "</span>";
				}
			}
			$last_element = array_pop($calendar);
		}
		for ($i = 0; $i < count($calendar); $i++)
		{
			$stringFromArr = implode('</td><td>', $calendar[$i]);
			$calendar[$i] = '<tr><td>' . $stringFromArr . '</td></tr>';
		}
		$stringFromArr = implode('', $calendar);
		$calendar = '<table class="curr">' . $stringFromArr . '</table>';
		$calendar = str_replace('<td></td>', '<td class="nil"></td>', $calendar);
		$calendar = str_replace('<td>' . $currentDay . '</td>', '<td class="today">' . $currentDay . '</td>', $calendar);
		$num = count($daysWithArticles);
		for ($i = 0; $i < $num; $i++)
		{
			$calendar = str_replace('>' . $daysWithArticles[$i] . '</td>', '><a href="' . FWURL . Registry :: setting("settings_site0") . '/calendar/' . $currentYear . '/' . $currentMonth . '/' . $daysWithArticles[$i] . '">' . $daysWithArticles[$i] . '</a></td>', $calendar);
			$calendar = str_replace('<span>' . $daysWithArticles[$i] . '</span>', '<span><a href="' . FWURL . Registry :: setting("settings_site0") . '/calendar/' . $currentYear . '/' . $currentMonth . '/' . $daysWithArticles[$i] . '">' . $daysWithArticles[$i] . '</a></span>', $calendar);
		}
		$blogCalendar .= '</tr>
		</table>
		<div id="cal-frame">' . $calendar . '</div>
	</div>';
		return $blogCalendar;
	}

	public function adminBlocksList($data)
	{
		$tree = array(0 => array(), 1 => array());
		foreach ($data as $k => $v)
		{
			$temp = array(0 => $v['block_title'], 1 => $v['block_order']);
			$tree[$v['block_id']][0] = $temp;
			if (!is_null($v['parent_id']))
			{
				if (!isset ($tree[$v['parent_id']]))
				{
					$tree[$v['parent_id']] = array();
				}
				$tree[$v['parent_id']][$this->findFreeIndex($tree[$v['parent_id']], 1)] = $v['block_id'];
			}
			else
			{
				$tree[0][$this->findFreeIndex($tree[0], 1)] = $v['block_id'];
			}
		}
		ksort($tree, SORT_ASC);
		$html = '<ul>';
		foreach ($tree[0] as $row)
		{
			$html .= $this->adminDrawBlocksBranch($row, $tree, true);
		}
		$html .= '</ul>';
		return $html;
	}

	private function adminDrawBlocksBranch($row, $tree, $isRoot = false)
	{
		$branch = $tree[$row];
		$name = $branch[0][0];
		$block_order = $branch[0][1];
		unset ($branch[0]);
		$html = '<li>#' . $block_order . ' | <span class="cat_name">' . $name . '</span> |
			<span class="cat_link"><a href="' . FWURL . 'admin/edit_block/' . $row . '">' . Registry :: library('lang')->line('edit') . '</a></span> |
			<span class="cat_link"><a onclick="return deletechecked();" href="' . FWURL . 'admin/delete_block/' . $row . '">' . Registry :: library('lang')->line('delete') . '</a></span> |
			<span class="cat_link"><a href="' . FWURL . 'admin/block_up/' . $row . '">' . Registry :: library('lang')->line('up') . '</a></span> |
			<span class="cat_link"><a href="' . FWURL . 'admin/block_down/' . $row . '">' . Registry :: library('lang')->line('down') . '</a></span>';
		if (count($branch) > 0)
		{
			$html .= '<ul>';
			foreach ($branch as $row)
			{
				$html .= $this->adminDrawBlocksBranch($row, $tree);
			}
			$html .= '</ul>';
		}
		$html .= '</li>';
		return $html;
	}

	public function simpleBlocksList($data)
	{
		$tree = array(0 => array());
		foreach ($data as $k => $v)
		{
			if ($v['web_url'] == '')
			{
				$url = '';
				$url = FWURL . $url;
			}
			else
			{
				$url = $v['web_url'];
			}
			$temp = array(0 => $v['block_title'], 1 => $url);
			$tree[$v['block_id']][0] = $temp;
			if (!is_null($v['parent_id']))
			{
				if (!isset ($tree[$v['parent_id']]))
				{
					$tree[$v['parent_id']] = array();
				}
				$tree[$v['parent_id']][$this->findFreeIndex($tree[$v['parent_id']], 1)] = $v['block_id'];
			}
			else
			{
				$tree[0][$this->findFreeIndex($tree[0], 1)] = $v['block_id'];
			}
		}
		ksort($tree, SORT_ASC);
		$html = '<ul>';
		foreach ($tree[0] as $row)
		{
			$html .= $this->simpleDrawBlocksBranch($row, $tree, true);
		}
		$html .= '</ul>';
		return $html;
	}

	private function simpleDrawBlocksBranch($row, $tree, $isRoot = false)
	{
		$branch = $tree[$row];
		$name = $branch[0][0];
		$url = $branch[0][1];
		unset ($branch[0]);
		$html = '<li><a href="' . $url . '">' . $name . '</a>';
		if (count($branch) > 0)
		{
			$html .= '<ul>';
			foreach ($branch as $row)
			{
				$html .= $this->simpleDrawBlocksBranch($row, $tree);
			}
			$html .= '</ul>';
		}
		$html .= '</li>';
		return $html;
	}

}
?>