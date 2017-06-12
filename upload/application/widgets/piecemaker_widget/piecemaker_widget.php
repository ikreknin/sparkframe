<?php
if (!defined('FW'))
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit ();
}

class Piecemaker_widget
{

	function __construct()
	{
	}

	public function index()
	{
		$result = '';
		$result .= '    <script type="text/javascript">
      var flashvars = {};
      flashvars.cssSource = "' . FWURL . APPDIR . '/widgets/piecemaker_widget/piecemaker/web/piecemaker.css";
      flashvars.xmlSource = "' . FWURL . APPDIR . '/widgets/piecemaker_widget/piecemaker/web/piecemaker.xml";

      var params = {};
      params.play = "true";
      params.menu = "false";
      params.scale = "showall";
      params.wmode = "transparent";
      params.allowfullscreen = "true";
      params.allowscriptaccess = "always";
      params.allownetworking = "all";

      swfobject.embedSWF("' . FWURL . APPDIR . '/widgets/piecemaker_widget/piecemaker/web/piecemaker.swf", "piecemaker", "550", "350", "10", null, flashvars, params, null);

    </script>

    <div id="piecemaker">
      <p>Put your alternative Non Flash content here.</p>
    </div>';
		return $result;
	}

}
?>