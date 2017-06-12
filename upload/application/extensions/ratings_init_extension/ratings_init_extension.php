<?php
if (!defined('FW'))
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit ();
}

class Ratings_init_extension
{
	private $registry;
	private $prefix;
	private $data = array('ext_name' => 'Ratings Init Extension', 'ext_description' => '5 Star Rating Init Extension', 'ext_version' => '1.0', 'ext_order' => '1', 'ext_file_name' => 'ratings_init_extension', 'ext_hook' => 'before_closing_head_tag_hook');

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
		$result .= '<script>

    $(document).ready(function() {

        $(\'.rate_widget\').each(function(i) {
            var widget = this;
            var out_data = {
                widget_id : $(widget).attr(\'id\'),
                fetch: 1
            };
            $.post(
                \'' . FWURL . SUBDIR . APPDIR . '/extensions/ratings_init_extension/ratings.php\',
                out_data,
                function(INFO) {
                    $(widget).data( \'fsr\', INFO );
                    set_votes(widget);
                },
                \'json\'
            );
        });


        $(\'.ratings_stars\').hover(
            function() {
                $(this).prevAll().andSelf().addClass(\'ratings_over\');
                $(this).nextAll().removeClass(\'ratings_vote\');
            },
            function() {
                $(this).prevAll().andSelf().removeClass(\'ratings_over\');
                set_votes($(this).parent());
            }
        );

        $(\'.ratings_stars\').bind(\'click\', function() {
            var star = this;
            var widget = $(this).parent();

            var clicked_data = {
                clicked_on : $(star).attr(\'class\'),
                widget_id : $(star).parent().attr(\'id\')
            };
            $.post(
                \'' . FWURL . SUBDIR . APPDIR . '/extensions/ratings_init_extension/ratings.php\',
                clicked_data,
                function(INFO) {
                    widget.data( \'fsr\', INFO );
                    set_votes(widget);
                },
                \'json\'
            );
        });
    });

    function set_votes(widget) {

        var avg = $(widget).data(\'fsr\').whole_avg;
        var votes = $(widget).data(\'fsr\').number_votes;
        var exact = $(widget).data(\'fsr\').dec_avg;

        window.console && console.log(\'and now in set_votes, it thinks the fsr is \' + $(widget).data(\'fsr\').number_votes);

        $(widget).find(\'.star_\' + avg).prevAll().andSelf().addClass(\'ratings_vote\');
        $(widget).find(\'.star_\' + avg).nextAll().removeClass(\'ratings_vote\');
        $(widget).find(\'.total_votes\').text( votes + \' votes recorded (\' + exact + \' rating)\' );
    }
    </script>

    <style>
        .rate_widget {
            overflow:   visible;
            padding:    5px;
            position:   relative;
            height:     25px;
        }
        .ratings_stars {
            background: url(\'' . FWURL . SUBDIR . APPDIR . '/extensions/ratings_init_extension/star_empty.png\') no-repeat;
            float:      left;
            height:     28px;
            padding:    2px;
            width:      25px;
        }
        .ratings_vote {
            background: url(\'' . FWURL . SUBDIR . APPDIR . '/extensions/ratings_init_extension/star_full.png\') no-repeat;
        }
        .ratings_over {
            background: url(\'' . FWURL . SUBDIR . APPDIR . '/extensions/ratings_init_extension/star_highlight.png\') no-repeat;
        }
        .total_votes {
            margin: 5px;
        }
    </style>';
		return $result;
	}

}
?>