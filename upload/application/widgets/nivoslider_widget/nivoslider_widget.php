<?php
if (!defined('FW'))
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit ();
}

class nivoslider_widget
{

	function __construct()
	{
	}

	public function index($string = '')
	{
		$result = '';
//		$result .= '<link rel="stylesheet" href="' . FWURL . 'sparkframe/application/widgets/nivoslider_widget/css/nivo-slider.css" type="text/css" media="screen" />';
		$result .= '<script src="' . FWURL . 'application/widgets/nivoslider_widget/js/jquery.nivo.slider.pack.js" type="text/javascript"></script>';
		$result .= '<link rel="stylesheet" href="' . FWURL . 'application/widgets/nivoslider_widget/themes/default/default.css" type="text/css" />';
		$result .= '
<script type="text/javascript">
$(window).load(function() {
	$("#slider1").nivoSlider({
		pauseTime:5000,
		pauseOnHover:false,
		effect:"fold,fade",
		manualAdvance: false,
		randomStart: false
	});
});
</script>';
		$result .= '<div class="content">
<div class="slider-wrapper theme-default">
    <div class="ribbon"></div>
		<div id="slider1" class="nivoSlider">
			<img src="' . FWURL . 'application/widgets/nivoslider_widget/images/slide1.jpg" alt="" />
			<img src="' . FWURL . 'application/widgets/nivoslider_widget/images/slide2.jpg" alt="" />
			<img src="' . FWURL . 'application/widgets/nivoslider_widget/images/slide3.jpg" alt="" />
			<img src="' . FWURL . 'application/widgets/nivoslider_widget/images/slide4.jpg" alt="" />
		</div>
	</div>
</div>';
		return $result;
	}

}
?>