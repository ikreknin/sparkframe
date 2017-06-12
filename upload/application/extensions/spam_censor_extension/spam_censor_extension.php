<?php
if (!defined('FW'))
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit ();
}

class Spam_censor_extension
{
	private $registry;
	private $prefix;
	private $data = array('ext_name' => 'SPAM Censor Extension', 'ext_description' => 'SPAM protection based on specific words', 'ext_version' => '1.0', 'ext_order' => '1', 'ext_file_name' => 'spam_censor_extension', 'ext_hook' => 'before_adding_comment_hook');

	public function __construct(Registry $registry)
	{
		$this->registry = $registry;
		$this->prefix = $this->registry->library('db')->getPrefix();
		$this->registry->library('lang')->setLanguage($this->registry->setting('settings_lang_full'));
		$this->registry->library('lang')->loadLanguage('site');
		$this->registry->library('template')->page()->addTag('click_here_if', $this->registry->library('lang')->line('click_here_if'));
		$urlSegments = $this->registry->getURLSegments();
		if (isset ($urlSegments[1]))
		{
			switch ($urlSegments[1])
			{

				case 'install' :
					$this->install();
					break;

				case 'uninstall' :
					$this->uninstall();
					break;

				default :
					$this->pageNotFound();
					break;
			}
		}
	}

	private function pageNotFound()
	{
		$this->registry->library('template')->build('header.tpl', '404.tpl', 'footer.tpl');
	}

	public function install()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true || $this->registry->library('authenticate')->hasPermission('install_extensions') == true)
		{
			$urlSegments = $this->registry->getURLSegments();
			$seg_0 = $urlSegments[0];
			$sql = 'SELECT *, COUNT(ext_id) AS `extensions_count`
			FROM ' . $this->prefix . 'extensions
			WHERE ext_file_name = "' . $this->data['ext_file_name'] . '"
			GROUP BY ext_id';
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) == 0)
			{
				$this->registry->library('db')->insertRecords('extensions', $this->data);
			}
			$this->registry->redirectUser('admin/extensions', $this->registry->library('lang')->line('installed_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'), false);
		}
		else
		{
			$this->pageNotFound();
		}
	}

	public function uninstall()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true || $this->registry->library('authenticate')->hasPermission('install_extensions') == true)
		{
			$this->registry->library('db')->deleteRecords('extensions', 'ext_file_name = "' . $this->data['ext_file_name'] . '"', '1');
			$this->registry->redirectUser('admin/extensions', $this->registry->library('lang')->line('uninstalled_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'), false);
		}
		else
		{
			$this->pageNotFound();
		}
	}

	public function index()
	{
		$result = 'HAM';
		$parameter = $this->registry->library('hook')->parameter;
		$name = strtolower($parameter['author']);
		$email = strtolower($data['author_email']);
		$url = strtolower($data['author_website']);
		$comment = strtolower($parameter['body']);
		$spamWords = array();
		$spamWords[] = 'viagra';
		$spamWords[] = 'cialis';
// $name
		foreach ($spamWords as $spamWord)
		{
			$pos = strpos($name, $spamWord);
			if ($pos !== false)
			{
// IS SPAM
				$result = 'SPAM';
			}
		}
// $email
		foreach ($spamWords as $spamWord)
		{
			$pos = strpos($email, $spamWord);
			if ($pos !== false)
			{
// IS SPAM
				$result = 'SPAM';
			}
		}
// $url
		foreach ($spamWords as $spamWord)
		{
			$pos = strpos($url, $spamWord);
			if ($pos !== false)
			{
// IS SPAM
				$result = 'SPAM';
			}
		}
// $comment
		foreach ($spamWords as $spamWord)
		{
			$pos = strpos($comment, $spamWord);
			if ($pos !== false)
			{
// IS SPAM
				$result = 'SPAM';
			}
		}
		return $result;
	}

}
?>