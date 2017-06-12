<?php

class Registry
{
	private static $libraries = array();
	private static $widgets = array();
	private static $extensions = array();
	private static $settings = array();
	private static $instance;
	private static $urlPath;
	private static $urlSegments = array();
	private static $workingLanguages = array();

	private function __construct()
	{
	}

	public static function singleton()
	{
		if (!isset (self :: $instance))
		{
			$c = __class__;
			self :: $instance = new $c;
		}
		return self :: $instance;
	}

	public function __clone()
	{
		trigger_error('Cloning the registry is not allowed', E_USER_ERROR);
	}

	public function load($library, $key)
	{
		if (strpos($library, 'database') !== false)
		{
			require_once ('database/' . $library . '.php');
		}
		else
		{
			require_once ('libraries/' . $library . '.php');
		}
		self :: $libraries[$key] = new $library(self :: $instance);
	}

	public function library($key)
	{
		if (is_object(self :: $libraries[$key]))
		{
			return self :: $libraries[$key];
		}
	}

	public function loadWidget($widget, $key)
	{
		require_once (APPDIR . '/widgets/' . $widget . '/' . $widget . '.php');
		self :: $widgets[$key] = new $widget(self :: $instance);
	}

	public function widget($key)
	{
		if (is_object(self :: $widgets[$key]))
		{
			return self :: $widgets[$key];
		}
	}

	public function loadExtension($extension, $key)
	{
		require_once (APPDIR . '/extensions/' . $extension . '/' . $extension . '.php');
		self :: $extensions[$key] = new $extension(self :: $instance);
	}

	public function extension($key)
	{
		if (is_object(self :: $extensions[$key]))
		{
			return self :: $extensions[$key];
		}
	}

	public function set($data, $key)
	{
		self :: $settings[$key] = $data;
	}

	public function setting($key)
	{
		return self :: $settings[$key];
	}

	public function getURLData()
	{
		$urldata = (isset ($_GET['page'])) ? $_GET['page'] : '';
		self :: $urlPath = $urldata;
		if ($urldata == '')
		{
			self :: $urlSegments[] = self :: $settings['settings_start_seg_1'];
			self :: $urlPath = self :: $settings['settings_start_seg_1'];
		}
		else
		{
			$data = explode('/', $urldata);
			while (!empty ($data) && strlen(reset($data)) === 0)
			{
				array_shift($data);
			}
			while (!empty ($data) && strlen(end($data)) === 0)
			{
				array_pop($data);
			}
			self :: $urlSegments = $this->array_trim($data);
		}
	}

	public function getURLSegments()
	{
		return self :: $urlSegments;
	}

	public function segment($whichSegment)
	{
		return self :: $urlSegments[$whichSegment];
	}

	private function array_trim($array)
	{
		while (!empty ($array) and strlen(reset($array)) === 0)
		{
			array_shift($array);
		}
		while (!empty ($array) and strlen(end($array)) === 0)
		{
			array_pop($array);
		}
		return $array;
	}

	public function redirectUser($urlPath, $header, $message)
	{
		self :: library('template')->build('redirect.tpl');
		self :: library('template')->page()->addTag('url', FWURL . $urlPath);
		self :: library('template')->page()->addTag('header', $header);
		self :: library('template')->page()->addTag('message', $message);
	}

	public function loadWorkingLanguages($workingLanguages)
	{
		self :: $workingLanguages = $workingLanguages;
	}

	public function getWorkingLanguages()
	{
		return self :: $workingLanguages;
	}

}
?>