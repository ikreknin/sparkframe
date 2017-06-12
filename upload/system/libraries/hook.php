<?php
if (!defined('FW'))
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit ();
}

class Hook
{
	private $ExtsInDb = array();
	public $parameter;
	public $resultArray = array();

	function __construct()
	{
	}

	public function init()
	{
		$prefix = Registry :: library('db')->getPrefix();
		$sql = 'SELECT *
		FROM ' . $prefix . 'extensions
		ORDER BY ext_order ASC';
		$cache = Registry :: library('db')->cacheQuery($sql);
		if (Registry :: library('db')->numRowsFromCache($cache) != 0)
		{
			$totalResult = '';
			$i = 0;
			$num = Registry :: library('db')->numRowsFromCache($cache);
			$data = Registry :: library('db')->rowsFromCache($cache);
			while ($i < $num)
			{
				foreach ($data as $k => $v)
				{
					$this->ExtsInDb[$i]['ext_file_name'] = $v['ext_file_name'];
					$this->ExtsInDb[$i]['ext_hook'] = $v['ext_hook'];
					$this->ExtsInDb[$i]['ext_order'] = $v['ext_order'];
					$i = $i + 1;
				}
			}
		}
	}

	public function call($hookName, $parameter = '')
	{
		$totalResult = '';
		$this->parameter = $parameter;
		foreach ($this->ExtsInDb as $k => $v)
		{
			if ($v['ext_hook'] == $hookName)
			{
				$ext_file_name = $v['ext_file_name'];
				$ext_hook = $v['ext_hook'];
				$ext_order = $v['ext_order'];
				Registry :: loadExtension($ext_file_name, $ext_file_name);
				$result[$k] = Registry :: extension($ext_file_name)->index();
			}
			$totalResult .= $result[$k];
		}
		return $totalResult;
	}

}
?>