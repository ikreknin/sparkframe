<?php
if (!defined('FW'))
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit ();
}

class Advanced_ratings_init_extension
{
	private $registry;
	private $prefix;
	private $data = array('ext_name' => 'Advanced Ratings Init Extension', 'ext_description' => 'Advanced 5 Star Rating Init Extension', 'ext_version' => '1.0', 'ext_order' => '1', 'ext_file_name' => 'advanced_ratings_init_extension', 'ext_hook' => 'before_closing_head_tag_hook');

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

var temp = "";

    $(document).ready(function() {

        $(\'.rate_widget\').each(function(i) {
            var widget = this;
            var out_dt = {
                widget_id : $(widget).attr(\'id\')
            };
temp = temp + "," + ($(widget).attr(\'id\'));
        });

temp = temp.substr(1);

$.post("' . FWURL . SUBDIR . 'advanced_ratings_module/ratings",
		{ temp: temp },
		function(reply){

var arr = temp.split(",");

var objFull = jQuery.parseJSON(reply);

j = 0;

        $(\'.rate_widget\').each(function(i) {
            var widget = this;

i = 0;
skip = 0;

	while ( i < objFull.length )
	{

		if ( arr[j] == objFull[i].widget_id )
		{
			widget_id = arr[j];
			whole_avg = objFull[i].whole_avg;
			number_votes = objFull[i].number_votes;
			dec_avg = objFull[i].dec_avg;

			skip = 1;
		}
		i++;
	}

	if ( skip == 0 )
	{
		widget_id = arr[j];
		whole_avg = 0;
		number_votes = 0;
		dec_avg = 0;

	}

		j++;

$(widget).data( \'fsr\', {"widget_id": arr[j], "whole_avg" : whole_avg, "number_votes" : number_votes, "dec_avg" : dec_avg} );
set_stars(widget, whole_avg, number_votes, dec_avg);

});

});


        $(\'.ratings_stars\').hover(
            function() {
                $(this).prevAll().andSelf().addClass(\'ratings_over\');
                $(this).nextAll().removeClass(\'ratings_vote\');
            },
            function() {
                $(this).prevAll().andSelf().removeClass(\'ratings_over\');
                set_stars($(this).parent());
            }
        );


        $(\'.ratings_stars\').bind(\'click\', function() {
            var star = this;
            var widget = $(this).parent();

			var click = $(star).parent().attr(\'id\');
            $.post("' . FWURL . SUBDIR . 'advanced_ratings_module/save",
                { temp: temp, click: click, star: $(star).attr("class") },
                function(reply) {


var arr = temp.split(",");

var objFull = jQuery.parseJSON(reply);

j = 0;

        $(\'.rate_widget\').each(function(i) {
            var widget = this;

i = 0;
skip = 0;

	while ( i < objFull.length )
	{

		if ( arr[j] == objFull[i].widget_id )
		{
			widget_id = arr[j];
			whole_avg = objFull[i].whole_avg;
			number_votes = objFull[i].number_votes;
			dec_avg = objFull[i].dec_avg;

			skip = 1;
		}
		i++;
	}

	if ( skip == 0 )
	{
		widget_id = arr[j];
		whole_avg = 0;
		number_votes = 0;
		dec_avg = 0;

	}

		j++;

$(widget).data( \'fsr\', {"widget_id": arr[j], "whole_avg" : whole_avg, "number_votes" : number_votes, "dec_avg" : dec_avg} );
set_stars(widget, whole_avg, number_votes, dec_avg);

});
                }
            );
        });
    });


    function set_stars(widget, whole_avg, number_votes, dec_avg) {

        var avg = $(widget).data(\'fsr\').whole_avg;
        var votes = $(widget).data(\'fsr\').number_votes;
        var exact = $(widget).data(\'fsr\').dec_avg;

        $(widget).find(\'.star_\' + avg).prevAll().andSelf().addClass(\'ratings_vote\');
        $(widget).find(\'.star_\' + avg).nextAll().removeClass(\'ratings_vote\');
        $(widget).find(\'.total_votes\').text( \' ' . $this->registry->library('lang')->line('votes') . ': \' + votes + \' (' . $this->registry->library('lang')->line('rating') . ': \' + exact + \')\' );
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
            background: url(\'' . FWURL . SUBDIR . APPDIR . '/extensions/advanced_ratings_init_extension/star_empty.png\') no-repeat;
            float:      left;
            height:     28px;
            padding:    2px;
            width:      25px;
        }
        .ratings_vote {
            background: url(\'' . FWURL . SUBDIR . APPDIR . '/extensions/advanced_ratings_init_extension/star_full.png\') no-repeat;
        }
        .ratings_over {
            background: url(\'' . FWURL . SUBDIR . APPDIR . '/extensions/advanced_ratings_init_extension/star_highlight.png\') no-repeat;
        }
        .total_votes {
            margin: 5px;
        }
    </style>';
		return $result;
	}

}
?>