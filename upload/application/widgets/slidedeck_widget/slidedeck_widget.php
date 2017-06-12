<?php
if (!defined('FW'))
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit ();
}

class Slidedeck_widget
{

	function __construct()
	{
	}

	public function index($string = '')
	{
		$result = '';
		$result .= '<link rel="stylesheet" href="' . FWURL . SUBDIR . APPDIR . '/widgets/slidedeck_widget/css/style.css" type="text/css" media="screen" />
					';
		$result .= '<script src="' . FWURL . SUBDIR . 'js/slidedeck/slidedeck.jquery.lite.pack.js" type="text/javascript"></script>';
		$result .= '<script src="' . FWURL . SUBDIR . 'js/slidedeck/functions.js" type="text/javascript"></script>';
		$result .= '
        <style type="text/css">
            #slidedeck_frame {
                width: 901px;
                height: 300px;
            }
        </style>
		';
		$result .= '
	<div id="sliderSection">
		<div id="slidedeckFrame" class="skin-slidedeck-sf">
			<dl class="slidedeck">
			    <dt>Title 1 Here</dt>
			    <dd>
			    	<a href="#"><img src="http://lorempixum.com/190/190/abstract/" alt="Abstract" style="float: left; margin-right: 10px" /></a>
			    	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
			    	<div class="blankSeparator"><!-- --></div>
			    	<p><a href="#" class="linkSlideDeckButton">read more&nbsp;&raquo;</a></p>
			    </dd>

			    <dt>Title 2 Here</dt>
			    <dd>
			    	<a href="#"><img src="http://lorempixum.com/190/190/technics/" alt="Technics" style="float: left; margin-right: 10px" /></a>
			    	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
			    	<div class="blankSeparator"><!-- --></div>
			    	<p><a href="#" class="linkSlideDeckButton">read more&nbsp;&raquo;</a></p>
			    </dd>

			    <dt>Title 3 Here</dt>
			    <dd>
			    	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
			    	<div class="blankSeparator"><!-- --></div>
			    	<p><a href="#" class="linkSlideDeckButton">read more&nbsp;&raquo;</a></p>
			    </dd>

			    <dt>Title 4 Here</dt>
			    <dd>
			    	<a href="#"><img src="http://lorempixum.com/120/120/abstract/" alt="Abstract" style="float: left; margin-right: 10px" /></a>
			    	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
			    	<div class="blankSeparator"><!-- --></div>
			    	<p><a href="#" class="linkSlideDeckButton">read more&nbsp;&raquo;</a></p>
			    </dd>
			</dl>

			<script type="text/javascript">
				$(\'.slidedeck\').slidedeck();
			</script>
		</div>
	</div>
';
		return $result;
	}

}
?>