<?php

class Adminmodel
{
	private $registry;
	private $valid = false;

	public function __construct(Registry $registry)
	{
		$this->registry = $registry;
		$adminQuery = "SELECT * FROM settings WHERE settings_id = 1";
		$this->registry->library('db')->execute($adminQuery);
		if ($this->registry->library('db')->numRows() == 1)
		{
			$data = $this->registry->library('db')->getRows();
			$this->charset = $data['settings_charset'];
			$this->metakeywords = $data['settings_metakeywords'];
			$this->metadescription = $data['settings_metadescription'];
		}
		$this->valid = true;
	}

	public function isValid()
	{
		return true;
	}

	public function getData()
	{
		$data = array();
		foreach ($this as $field => $fdata)
		{
			if (!is_object($fdata))
			{
				$data[$field] = $fdata;
			}
		}
		return $data;
	}

}
?>