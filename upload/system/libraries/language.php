<?php
if (!defined('FW'))
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit ();
}

class Language
{
	private $language = '';
	private $lang = array();

	function __construct()
	{
	}

	public function getLanguage()
	{
		return $this->language;
	}

	public function setLanguage($language)
	{
		$this->language = $language;
	}

	public function loadLanguage($langFile)
	{
		include (APPPATH . 'language/' . $this->language . '/' . $langFile . '_lang.php');
	}

	public function loadLanguageWidget($langFile)
	{
		include (APPPATH . 'widgets/' . $langFile . '/language/' . $this->language . '/' . $langFile . '_lang.php');
	}

	public function loadLanguageModule($langFile)
	{
		include (APPPATH . 'modules/' . $langFile . '/language/' . $this->language . '/' . $langFile . '_lang.php');
	}

	public function loadLanguageExtension($langFile)
	{
		include (APPPATH . 'extensions/' . $langFile . '/language/' . $this->language . '/' . $langFile . '_lang.php');
	}

	public function line($line)
	{
		return $this->lang[$line];
	}

	public function langToTemplate($langFile)
	{
		if ($langFile == '')
		{
			foreach ($this->lang as $key => $text)
			{
				Registry :: library('template')->page()->addTag($key, $text);
			}
		}
		else
		{
			include (APPPATH . 'language/' . $this->language . '/' . $langFile . '_lang.php');
			Registry :: library('template')->page()->addTag($key, $text);
		}
	}

}
?>