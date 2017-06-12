<?php
if (!defined('FW'))
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit ();
}

class Articles_list_modulecontroller
{
	private $registry;
	private $prefix;
	private $sys_cms;
	private $data = array('mod_name' => 'Articles List Module', 'mod_description' => 'Articles List Module', 'mod_version' => '1.0', 'mod_enabled' => '1', 'mod_file_name' => 'articles_list_module');
	private $entries_per_page = 100;

	public function __construct(Registry $registry, $directCall)
	{
		$this->registry = $registry;
		if ($directCall == true)
		{
			$this->prefix = $this->registry->library('db')->getPrefix();
			$this->sys_cms = $this->registry->library('db')->getSys();
			$this->registry->library('lang')->setLanguage($this->registry->setting('settings_lang_full'));
			$this->registry->library('lang')->loadLanguage('site');
			$this->registry->library('template')->page()->addTag('click_here_if', $this->registry->library('lang')->line('click_here_if'));
			$urlSegments = $this->registry->getURLSegments();
// OR Is Numeric for pagination
			if (!isset ($urlSegments[1]) || is_numeric($urlSegments[1]))
			{
				$this->index();
			}
			else
			{
				switch ($urlSegments[1])
				{

					case 'install' :
						$this->install();
						break;

					case 'uninstall' :
						$this->uninstall();
						break;

					case 'delete' :
						$this->delete();
						break;

					default :
						$this->pageNotFound();
						break;
				}
			}
		}
	}

	private function pageNotFound()
	{
		$this->registry->library('template')->build('header.tpl', '404.tpl', 'footer.tpl');
	}

	public function install()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true || $this->registry->library('authenticate')->hasPermission('install_modules') == true)
		{
			$urlSegments = $this->registry->getURLSegments();
			$seg_0 = $urlSegments[0];
			$sql = 'SELECT *, COUNT(mod_id) AS `modules_count` FROM ' . $this->prefix . 'modules WHERE mod_file_name = "' . $this->data['mod_file_name'] . '" GROUP BY mod_id';
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) == 0)
			{
				$this->registry->library('db')->insertRecords('modules', $this->data);
			}
			$this->registry->redirectUser('admin/modules', $this->registry->library('lang')->line('installed_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'), false);
		}
		else
		{
			$this->pageNotFound();
		}
	}

	public function uninstall()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true || $this->registry->library('authenticate')->hasPermission('install_modules') == true)
		{
			$sql = sprintf("DELETE FROM `" . $this->prefix . "modules` WHERE `mod_file_name` = '%s' LIMIT 1", $this->data['mod_file_name']);
			$cache = $this->registry->library('db')->cacheQuery($sql);
			$this->registry->redirectUser('admin/modules', $this->registry->library('lang')->line('uninstalled_successfully'), $this->registry->library('lang')->line('please_wait_for_the_redirect'), false);
		}
		else
		{
			$this->pageNotFound();
		}
	}

	public function index()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true)
		{
			$urlSegments = $this->registry->getURLSegments();
			$seg_0 = $urlSegments[0];
			$seg_1 = $urlSegments[1];
			if ($seg_1 == '')
			{
				$current_page = 1;
			}
			else
			{
				$current_page = $seg_1;
			}
			$offset = ($current_page - 1) * 10;
			$sql = 'SELECT *, COUNT(article_id) AS `articles_count`
			FROM ' . $this->prefix . 'articles
			LEFT JOIN ' . $this->prefix . 'users ON ' . $this->prefix . 'users.users_id = ' . $this->prefix . 'articles.author_id
			WHERE articles_sys = "' . $this->sys_cms . '"
			GROUP BY article_id
			ORDER BY article_id DESC LIMIT ' . $offset . ',' . $this->entries_per_page;
			$cache = $this->registry->library('db')->cacheQuery($sql);
			if ($this->registry->library('db')->numRowsFromCache($cache) != 0)
			{
				$pagination = $this->registry->library('paginate')->createLinksSys('articles', $this->entries_per_page, 1, 'articles_list_module');
				echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />

		<link rel="stylesheet" type="text/css" href="' . FWURL . APPDIR . '/modules/articles_list_module/css/styles.css"/>

		<script type="text/javascript" language="javascript" src="' . FWURL . 'js/jquery/' . $this->registry->setting('settings_jquery') . '"></script>
		<script type="text/javascript" language="javascript" src="' . FWURL . 'js/datatables/media/js/jquery.dataTables.js"></script>


		<script type="text/javascript" charset="utf-8">
		/* Define two custom functions (asc and desc) for string sorting */
		jQuery.fn.dataTableExt.oSort[\'string-case-asc\']  = function(x,y) {
			return ((x < y) ? -1 : ((x > y) ?  1 : 0));
		};

		jQuery.fn.dataTableExt.oSort[\'string-case-desc\'] = function(x,y) {
			return ((x < y) ?  1 : ((x > y) ? -1 : 0));
		};

		$(document).ready(function() {
		/* Build the DataTable with third column using our custom sort functions */
			$(\'#articles_table\').dataTable( {
				"aaSorting": [ [0,\'desc\'], [1,\'asc\'] ],
				"aoColumns": [
					null,
					null,
					{ "sType": \'string-case\' },
					null,
					null
				]
			} );


			$(\'.select_all\').toggle(function(){
				$(\'#articles_table input:checkbox\').each(function(i, val) {
					var $checkbox = $(this);
					$checkbox.attr(\'checked\',true);
				});
				},function(){
					$(\'#articles_table input:checkbox\').each(function(i, val) {
						var $checkbox = $(this);
						$checkbox.attr(\'checked\',false);
					});
				});


			$(\'select.options\').change(function(){
				var $function = $(\'select.options option:selected\').attr(\'class\');
				if($function == "delete")
				{
					if(confirm(\'Are you sure you want to delete these entries?\'))
					{
						var $type = $(\'select.options option:selected\').attr(\'id\');
						var $id = new Array();
						var $i = 0;
						$(\'#articles_table input:checkbox\').each(function(i, val) {
							var $checkbox = $(this);
							if($checkbox.attr(\'checked\') == true)
							{
								$id[$i] = $checkbox.val();
								$(\'#articles_table tr#\' + $id[$i]).fadeOut();
							$i++;
						}
					});

					if($i > 0)
					{
						$(\'<span class="loader"><img src="' . FWURL . APPDIR . '/modules/articles_list_module/images/ajax-loader.gif"/></span>\').insertBefore(\'#articles_table_length\');

$.post("' . FWURL . 'articles_list_module/delete", {id: $id}, function(data){

});

					}
				}
			}
			else
			{

			}

			return false;
}).change();




		} );
</script>

	</head>
	<body>

<p><center>' . $pagination . '</center></p>

<form>

<span style="float:right;">
	<a href="#" id="options" class="select_all">Select All Fields</a>

	<select class="options">
		<option>Choose Option</option>
		<option class="delete" id="entries">Delete Selected</option>
	</select>
</span>

<table class="display" id="articles_table">
	<thead>
		<tr>
			<th>#</th>
			<th>Author</th>
			<th>Title</th>
			<th>Created</th>
			<th>Updated</th>
			<th>Comments Allowed</th>
			<th>Comments Closed</th>
			<th>Pinned</th>
			<th>Status</th>
			<th>Visible</th>
			<th>System</th>
			<th>Action</th>
			<th>Select</th>
		</tr>
	</thead>
	<tbody>';
				$data = $this->registry->library('db')->rowsFromCache($cache);
				foreach ($data as $k => $v)
				{
					if ($v['allow_comments'] == 1)
					{
						$v['allow_comments'] = 'y';
					}
					else
					{
						$v['allow_comments'] = 'n';
					}
					if ($v['pinned'] == 0)
					{
						$v['pinned'] = 'n';
					}
					else
					{
						$v['pinned'] = 'y';
					}
					if ($v['article_visible'] == 1)
					{
						$v['article_visible'] = 'y';
					}
					else
					{
						$v['article_visible'] = 'n';
					}
					echo '		<tr id=' . $v['article_id'] . '>
						<td>' . $v['article_id'] . '</td>
						<td><a href="' . FWURL . 'user/id/' . $v['author_id'] . '">' . $v['username'] . '</a></td>
						<td><a href="' . FWURL . 'site/more/' . $v['article_id'] . '">' . $v['title'] . '</a></td>
						<td>' . $v['art_created'] . '</td>
						<td>' . $v['art_updated'] . '</td>
						<td>' . $v['allow_comments'] . '</td>
						<td>' . $v['close_comments'] . '</td>
						<td>' . $v['pinned'] . '</td>
						<td>' . $v['status'] . '</td>
						<td>' . $v['article_visible'] . '</td>
						<td>' . $v['articles_sys'] . '</td>
						<td><a href="' . FWURL . 'admin/edit_article/' . $v['article_id'] . '">Edit</a></td>
						<td><input type="checkbox" value="' . $v['article_id'] . '" id="checkGroup"></td>
					</tr>';
				}
				echo '	</tbody>
</table>
</form>
</body>
</html>';
			}
			else
			{
				$this->pageNotFound();
			}
		}
		else
		{
			$this->registry->redirectUser('./login', $this->registry->library('lang')->line('you_are_not_authorized'), $this->registry->library('lang')->line('please_wait_for_the_redirect'));
		}
	}

	public function delete()
	{
		if ($this->registry->library('authenticate')->isAdmin() == true || $this->registry->library('authenticate')->hasPermission('access_admin') == true || $this->registry->library('authenticate')->hasPermission('install_modules') == true)
		{
			foreach ($_POST['id'] as $field)
			{
				$this->registry->library('db')->deleteRecordsSys('articles', 'article_id=' . $this->registry->library('db')->sanitizeData($field), '1');
				$this->registry->library('db')->deleteRecordsSys('art_cats', 'ac_art_id=' . $this->registry->library('db')->sanitizeData($field), '1');
				$this->registry->library('db')->deleteRecordsSys('c_fields', 'c_art_id=' . $this->registry->library('db')->sanitizeData($field), '1');
			}
		}
		else
		{
			$this->pageNotFound();
		}
	}

}
?>