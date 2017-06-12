<?php

class Database
{
	private $connections = array();
	private $activeConnection = 0;
	private $prefix;
	private $sys_cms;
	private $queryCache = array();
	private $dataCache = array();
	private $queryCounter = 0;
	private $last;
	private $lastInsertID;
	private $charset = 'utf8';
	private $executedQueriesNumber = 0;
	private $cacheDir = 'cache/';
	private $cacheFile = '';
	private $cacheOn = 0;
	private $cacheTime = 3600;
	private $debugDatabase = 0;

	public function __construct()
	{
	}

	public function getPrefix()
	{
		return $this->prefix;
	}

	public function getSys()
	{
		return $this->sys_cms;
	}

	public function getCacheOn()
	{
		return $this->cacheOn;
	}

	public function setCacheOn($value)
	{
		return $this->cacheOn = $value;
	}

	public function newConnection($host, $user, $password, $database, $prefix, $sys_cms)
	{
		$this->prefix = $prefix;
		$this->sys_cms = $sys_cms;
		$this->connections[] = new mysqli($host, $user, $password, $database);
		$connection_id = count($this->connections) - 1;
		$this->connections[$connection_id]->query("SET NAMES " . $this->charset);
		if (mysqli_connect_errno())
		{
			if ($this->debugDatabase == 1)
			{
				trigger_error('Error connecting to host. ' . $this->connections[$connection_id]->error, E_USER_ERROR);
			}
			else
			{
				$this->pageNotFound();
			}
		}
		$sql = "SET SESSION group_concat_max_len = 1024000";
		$this->connections[$connection_id]->query($sql);
		if (mysqli_connect_errno())
		{
			if ($this->debugDatabase == 1)
			{
				trigger_error('Error connecting to host. ' . $this->connections[$connection_id]->error, E_USER_ERROR);
			}
			else
			{
				$this->pageNotFound();
			}
		}
		return $connection_id;
	}

	public function closeConnection()
	{
		$this->connections[$this->activeConnection]->close();
	}

	public function setActiveConnection(int $new)
	{
		$this->activeConnection = $new;
		mysql_query("SET NAMES " . $this->charset);
	}

	public function cacheQuery($queryStr)
	{
// echo $queryStr . "<br><br>";
		if ($this->cacheOn == 0)
		{
// Caching OFF
			if (!$result = $this->connections[$this->activeConnection]->query($queryStr))
			{
				if ($this->debugDatabase == 1)
				{
					trigger_error('Error executing and caching query: ' . $this->connections[$this->activeConnection]->error, E_USER_ERROR);
				}
				else
				{
					$this->pageNotFound();
				}
				return - 1;
			}
			else
			{
				$temp = explode(" ", trim($queryStr));
				;
				if ($temp[0] == 'SELECT' || $temp[0] == 'select')
				{
					$rows = array();
					while ($row = $result->fetch_array(MYSQLI_ASSOC))
					{
						$rows[] = $row;
					}
					$this->queryCache[] = $rows;
				}
				else
				{
					$this->queryCache[] = $result;
				}
				return count($this->queryCache) - 1;
			}
		}
		else
		{
// Caching ON
			if (strlen(trim($queryStr)))
			{
				$this->cacheFile = md5($queryStr);
			}
			$this->cacheFile = dirname(__file__) . '/' . $this->cacheDir . 'cache_c_' . $this->cacheFile;
			$timestamp = file_exists($this->cacheFile) ? filemtime($this->cacheFile) : 0;
			if ((time() - $timestamp) >= $this->cacheTime)
// execute MySQL & save Cache
			{
				if (!$result = $this->connections[$this->activeConnection]->query($queryStr))
				{
					if ($this->debugDatabase == 1)
					{
						trigger_error('Error executing and caching query: ' . $this->connections[$this->activeConnection]->error, E_USER_ERROR);
					}
					else
					{
						$this->pageNotFound();
					}
					return - 1;
				}
				else
				{
					$temp = explode(" ", trim($queryStr));
					;
					if ($temp[0] == 'SELECT' || $temp[0] == 'select')
					{
						$rows = array();
						while ($row = $result->fetch_array(MYSQLI_ASSOC))
						{
							$rows[] = $row;
						}
						$this->queryCache[] = $rows;
					}
					else
					{
						$this->queryCache[] = $result;
					}
// save Cache
					if (!$this->saveCache($rows))
					{
						return false;
					}
					return count($this->queryCache) - 1;
				}
			}
// get Cache
			else
			{
				$this->queryCache[] = $this->getCache();
				return count($this->queryCache) - 1;
			}
		}
	}

	public function numRowsFromCache($cache_id)
	{
		return count($this->queryCache[$cache_id]);
	}

	public function resultsFromCache($cache_id)
	{
		return $this->queryCache[$cache_id];
	}

	public function rowsFromCache($cache_id)
	{
		return $this->queryCache[$cache_id];
	}

	public function cacheData($data)
	{
		$this->dataCache[] = $data;
		return count($this->dataCache) - 1;
	}

	public function dataFromCache($cache_id)
	{
		return $this->dataCache[$cache_id];
	}

	public function deleteRecords($table, $condition, $limit)
	{
		$prefixedTable = $this->prefix . $table;
		$limit = ($limit == '') ? '' : ' LIMIT ' . $limit;
		$delete = "DELETE FROM {$prefixedTable} WHERE {$condition} {$limit}";
		$this->execute($delete);
	}

	public function deleteRecordsSys($table, $condition, $limit)
	{
		$prefixedTable = $this->prefix . $table;
		$limit = ($limit == '') ? '' : ' LIMIT ' . $limit;
		$delete = "DELETE FROM {$prefixedTable} WHERE {$condition} AND {$table}_sys = \"" . $this->sys_cms . "\"  {$limit}";
		$this->execute($delete);
	}

	public function updateRecords($table, $changes, $condition)
	{
		$prefixedTable = $this->prefix . $table;
		$update = "UPDATE " . $prefixedTable . " SET ";
		foreach ($changes as $field => $value)
		{
			$value = str_replace('{', '&#123;', $value);
			$value = str_replace('}', '&#125;', $value);
			$value = str_replace("'", "&#039;", $value);
			$update .= "`" . $field . "`='{$value}',";
		}
		$update = substr($update, 0, - 1);
		if ($condition != '')
		{
			$update .= " WHERE " . $condition;
		}
		$this->execute($update);
		return true;
	}

	public function updateRecordsSys($table, $changes, $condition)
	{
		$prefixedTable = $this->prefix . $table;
		$update = "UPDATE " . $prefixedTable . " SET ";
		foreach ($changes as $field => $value)
		{
			$value = str_replace('{', '&#123;', $value);
			$value = str_replace('}', '&#125;', $value);
			$value = str_replace("'", "&#039;", $value);
//			$value = str_replace("///'", "/'", $value);
			$update .= "`" . $field . "`='{$value}',";
		}
		$update = substr($update, 0, - 1);
		$update .= " WHERE {$table}_sys = \"" . $this->sys_cms . "\"";
		if ($condition != '')
		{
			$update .= " AND " . $condition;
		}
		$this->execute($update);
		return true;
	}

	public function insertRecords($table, $data)
	{
		$prefixedTable = $this->prefix . $table;
		$fields = "";
		$values = "";
		foreach ($data as $f => $v)
		{
			$fields .= "`$f`,";
			$v = str_replace('{', '&#123;', $v);
			$v = str_replace('}', '&#125;', $v);
			$value = str_replace("'", "&#039;", $value);
			$values .= (is_numeric($v) && (intval($v) == $v)) ? $v . "," : "'$v',";
		}
		$fields = substr($fields, 0, - 1);
		$values = substr($values, 0, - 1);
		$insert = "INSERT INTO $prefixedTable ({$fields}) VALUES({$values})";
		$this->execute($insert);
		return true;
	}

	public function insertRecordsSys($table, $data)
	{
		$prefixedTable = $this->prefix . $table;
		$fields = "";
		$values = "";
		foreach ($data as $f => $v)
		{
			$fields .= "`$f`,";
			$v = str_replace('{', '&#123;', $v);
			$v = str_replace('}', '&#125;', $v);
			$value = str_replace("'", "&#039;", $value);
			$values .= (is_numeric($v) && (intval($v) == $v)) ? $v . "," : "'$v',";
		}
		$fields .= "`" . $table . "_sys`";
		$values .= "'" . $this->sys_cms . "'";
		$insert = "INSERT INTO $prefixedTable ({$fields}) VALUES({$values})";
		$this->execute($insert);
		return true;
	}

	public function lastInsertID()
	{
		return $this->connections[$this->activeConnection]->insert_id;
	}

	public function execute($queryStr)
	{
		if ($this->cacheOn == 0)
		{
// Caching OFF
			if (!$result = $this->connections[$this->activeConnection]->query($queryStr))
			{
				if ($this->debugDatabase == 1)
				{
					trigger_error('Error executing query: ' . $this->connections[$this->activeConnection]->error, E_USER_ERROR);
				}
				else
				{
					$this->pageNotFound();
				}
			}
			else
			{
				$this->executedQueriesNumber = $this->executedQueriesNumber + 1;
				$temp = explode(" ", trim($queryStr));
				;
				if ($temp[0] == 'SELECT' || $temp[0] == 'select')
				{
					$this->last = $result->fetch_array(MYSQLI_ASSOC);
				}
				else
				{
					$this->last = $result;
				}
			}
		}
		else
		{
// Caching ON
// echo $queryStr . "<br><br>";
			if (strlen(trim($queryStr)))
			{
				$this->cacheFile = md5($queryStr);
			}
			$this->cacheFile = dirname(__file__) . '/' . $this->cacheDir . 'cache_e_' . $this->cacheFile;
			$timestamp = file_exists($this->cacheFile) ? filemtime($this->cacheFile) : 0;
			if ((time() - $timestamp) >= $this->cacheTime)
//execute MySQL & save Cache
			{
				if (!$result = $this->connections[$this->activeConnection]->query($queryStr))
				{
					if ($this->debugDatabase == 1)
					{
						trigger_error('Error executing query: ' . $this->connections[$this->activeConnection]->error, E_USER_ERROR);
					}
					else
					{
						$this->pageNotFound();
					}
				}
				else
				{
					$this->executedQueriesNumber = $this->executedQueriesNumber + 1;
					$temp = explode(" ", trim($queryStr));
					;
					if ($temp[0] == 'SELECT' || $temp[0] == 'select')
					{
						$this->last = $result->fetch_array(MYSQLI_ASSOC);
					}
					else
					{
						$this->last = $result;
					}
// save Cache
					if (!$this->saveCache($this->last))
					{
						return false;
					}
				}
			}
// get Cache
			else
			{
				$this->last = $this->getCache();
				return count($this->last) - 1;
			}
		}
	}

	public function getExecutedQueriesNumber()
	{
		return $this->executedQueriesNumber;
	}

	public function getRows()
	{
		return $this->last;
	}

	public function numRows()
	{
		$num = 0;
		if (count($this->last) > 0)
		{
			$num = 1;
		}
		return $num;
	}

	public function affectedRows()
	{
		return $this->connections[$this->activeConnection]->affected_rows;
	}

	public function sanitizeData($data)
	{
		return $this->connections[$this->activeConnection]->real_escape_string($data);
	}
// XSS
	public function sanitizeDataX($data)
	{
//		$filter = array("<", ">");
//		$data =str_replace ($filter, "|", $data);

		$search  = array('&', '<', '>');
		$replace = array('&amp;','&lt;','&gt;');
		$data = str_replace($search, $replace, $data);

		// Fix &entity\n;
		$data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
		$data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
		$data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
		$data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

		// Remove any attribute starting with "on" or xmlns
		$data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

		// Remove javascript: and vbscript: protocols
        $data = preg_replace('#([a-z]*)[\x00-\x20\/]*=[\x00-\x20\/]*([\`\'\"]*)[\x00-\x20\/]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iUu', '$1=$2nojavascript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20\/]*=[\x00-\x20\/]*([\`\'\"]*)[\x00-\x20\/]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iUu', '$1=$2novbscript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20\/]*=[\x00-\x20\/]*([\`\'\"]*)[\x00-\x20\/]*-moz-binding[\x00-\x20]*:#Uu', '$1=$2nomozbinding...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20\/]*=[\x00-\x20\/]*([\`\'\"]*)[\x00-\x20\/]*data[\x00-\x20]*:#Uu', '$1=$2nodata...', $data);

		// Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
		$data = preg_replace('#(<[^>]+[\x00-\x20\"\'\/])style[^>]*>#iUu', "$1>", $data);

		// Remove namespaced elements (we do not need them)
		$data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

		// Remove really unwanted tags
        do 
        {
			$olddata = $data;
			$data = preg_replace('#</*(applet|meta|xml|blink|link|style|script|embed|object|iframe|frame|frameset|ilayer|layer|bgsound|title|base)[^>]*>#i', "", $data);
        } 
        while ($olddata != $data);

		return $this->connections[$this->activeConnection]->real_escape_string($data);
	}

	public function __deconstruct()
	{
		foreach ($this->connections as $connection)
		{
			$connection->close();
		}
	}

	protected function saveCache($data)
	{
// print_r($data);
		if (!file_put_contents($this->cacheFile, json_encode($data)))
		{
			return false;
		}
		return true;
	}

	protected function getCache()
	{
		if (!$data = json_decode(file_get_contents($this->cacheFile), true))
		{
			return false;
		}
		return $data;
	}

	public function deleteCache($filename, $wildcard = false)
	{
		$filename = dirname(__file__) . '/' . $this->cacheDir . $filename;
		if ($wildcard)
		{
// EXAMPLE:
// $this->deleteCache('cache_', true);
			$glob = glob($filename . "*", GLOB_BRACE);
			if ($glob)
			{
				foreach ($glob as $delFile)
				{
					unlink($delFile);
				}
			}
		}
		else
		{
			if (file_exists($filename))
			{
				unlink($filename);
			}
		}
	}

	private function pageNotFound()
	{
		header('Location: ' . FWURL . SUBDIR . '404');
	}

}
?>