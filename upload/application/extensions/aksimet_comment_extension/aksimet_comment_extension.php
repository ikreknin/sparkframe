<?php
if (!defined('FW'))
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit ();
}

class Aksimet_comment_extension
{
	private $registry;
	private $prefix;
	private $data = array('ext_name' => 'Aksimet Comment Extension', 'ext_description' => 'SPAM protection for blog comments', 'ext_version' => '1.0', 'ext_order' => '1', 'ext_file_name' => 'aksimet_comment_extension', 'ext_hook' => 'before_adding_comment_hook');

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
		$result = '';
		$parameter = $this->registry->library('hook')->parameter;
		require_once APPPATH . '/libraries/akismet/akismet.class.php';
		$wordpressAPI = $this->registry->setting('spam_api_key');
		$name = $parameter['author'];
		$email = $data['author_email'];
		$url = $data['author_website'];
		$comment = $parameter['body'];
		if ($name && $comment)
		{
			$akismet = new Akismet('http://' . $_SERVER['SERVER_NAME'] . '/', $wordpressAPI);
			if ($akismet->isKeyValid())
			{
				$akismet->setCommentAuthor($name);
				$akismet->setCommentAuthorEmail($email);
				$akismet->setCommentAuthorURL($url);
				$akismet->setCommentContent($comment);
				$akismet->setPermalink($_SERVER['HTTP_REFERER']);
				if ($akismet->isCommentSpam())
				{
// IS SPAM
					$result .= 'SPAM';
				}
				else
				{
// NOT SPAM
					$result .= 'HAM';
				}
			}
		}
		return $result;
	}

}
?>