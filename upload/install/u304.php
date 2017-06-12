<?php
//
class U304{
	
	private $registry;
	private $prefix;
	private $cms_sys;
	private $seg_1;
	private $db_host;
	private $db_user;
	private $db_pass;
	private $db_name;
	
	public function __construct(Registry $registry, $directCall)
	{
		$this->registry = $registry;
		if($directCall == true)
		{
			$this->prefix = $this->registry->library('db')->getPrefix();
			$this->sys_cms = '1';

			include(APPPATH . 'config/config.php');
			if($config['db_prefix'] == '') { $prefix = NULL; }
			else { $prefix = $config['db_prefix']; }
			$registry->library('db')->newConnection($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name'], $prefix, $sys_cms);

			$this->db_host = $config['db_host'];
			$this->db_user = $config['db_user'];
			$this->db_pass = $config['db_pass'];
			$this->db_name = $config['db_name'];
			$this->prefix = $config['db_prefix'];

			$urlSegments = $this->registry->getURLSegments();
			$this->seg_1 = $this->registry->library('db')->sanitizeData($urlSegments[1]);

			$this->registry->library('template')->page()->addTag('charset', 'utf-8');

			if($_POST['processing'] != 'processing')
			{
				$this->index();
			}
			else
			{
				$this->processing();
			}
		}
	}

	private function index()
	{
//
		$text = 'SparkFrame Update from 3.0.3 to 3.0.4';
		$this->registry->library('template')->page()->addTag('pagetitle', $text);
		$this->registry->library('template')->page()->addTag('heading', $text);
		
		$this->registry->library('template')->page()->addTag('stage', '1');

		$this->registry->library('template')->build('/admin/update.tpl');
	}


	private function processing()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', 'Processing');
		$this->registry->library('template')->page()->addTag('heading', 'Processing...');
		
		$stage = 2;
		$this->registry->library('template')->page()->addTag('stage', $stage);

$prefix = $this->prefix;

$message = '';

$sql2 = "ALTER TABLE `" . $this->prefix . "articles` DROP COLUMN `art_tags`";
$this->registry->library('db')->execute($sql2);

//
$sql2 = "UPDATE `{$prefix}cms` SET ver='304' WHERE cms_id='1'";
$this->registry->library('db')->execute($sql2);

$message .= 'Updated successfully.<br />Click NEXT button.<br /><br />
	<FORM action="" method="post">
	<INPUT type="submit" value="Next">
</FORM>';

$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/update.tpl');

	}



}


?>