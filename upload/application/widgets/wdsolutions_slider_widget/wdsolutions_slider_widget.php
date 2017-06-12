<?php
if (!defined('FW'))
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit ();
}

class Wdsolutions_slider_widget
{

	function __construct()
	{
	}

	public function index($string = '')
	{
		$result = '';
		$result .= '<link rel="stylesheet" href="' . FWURL . SUBDIR . APPDIR . '/widgets/wdsolutions_slider_widget/css/style.css" type="text/css" media="screen" />
					';
		$result .= '<script src="' . FWURL . SUBDIR . APPDIR . '/widgets/wdsolutions_slider_widget/js/scripts.js" type="text/javascript"></script>';
		$result .= '
<style type="text/css">
<!--
#apDiv1 {
	position:absolute;
	width:124px;
	height:70px;
	z-index:41;
	left: 903px;
	top: 505px;
}
-->
 </style>
 	<style type="text/css">
	.style2 {
	margin-left: 0;
	position: relative;
	z-index: 1;
	background-image: url(' . FWURL . SUBDIR . APPDIR . '/widgets/wdsolutions_slider_widget/images/ower-blum.png);
	height:65px;
	}
    .style2 div table tr th a h7 div {
	color: #000;
}
    </style>
  <div id="wdsolutions-header"><div class="wdsolutions-wrap">
   <div id="slide-holder">
<div id="slide-runner">
    <a href=""><img id="slide-img-1" src="' . FWURL . SUBDIR . APPDIR . '/widgets/wdsolutions_slider_widget/images/photo.png" class="slide" alt="http://sparkframe.com" /></a>
    <a href=""><img id="slide-img-2" src="' . FWURL . SUBDIR . APPDIR . '/widgets/wdsolutions_slider_widget/images/photo1.png" class="slide" alt="http://sparkframe.com" /></a>
    <a href=""><img id="slide-img-3" src="' . FWURL . SUBDIR . APPDIR . '/widgets/wdsolutions_slider_widget/images/photo2.png" class="slide" alt="http://sparkframe.com" /></a>
    <a href=""><img id="slide-img-4" src="' . FWURL . SUBDIR . APPDIR . '/widgets/wdsolutions_slider_widget/images/photo3.png" class="slide" alt="http://sparkframe.com" /></a>
    <a href=""><img id="slide-img-5" src="' . FWURL . SUBDIR . APPDIR . '/widgets/wdsolutions_slider_widget/images/photo4.png" class="slide" alt="http://sparkframe.com" /></a>
    <a href=""><img id="slide-img-6" src="' . FWURL . SUBDIR . APPDIR . '/widgets/wdsolutions_slider_widget/images/photo5.png" class="slide" alt="http://sparkframe.com" /></a>
	<a href=""><img id="slide-img-7" src="' . FWURL . SUBDIR . APPDIR . '/widgets/wdsolutions_slider_widget/images/photo6.png" class="slide" alt="http://sparkframe.com" /></a>
    <a href=""><img id="slide-img-8" src="' . FWURL . SUBDIR . APPDIR . '/widgets/wdsolutions_slider_widget/images/photo7.png" class="slide" alt="http://sparkframe.com" /></a>
    <div id="slide-controls">
     <p id="slide-client" class="text"><strong></strong><span></span></p>
     <p id="slide-desc" class="text"></p>
     <p id="slide-nav"></p>
    </div>
</div>

	<!--content featured gallery here -->
   </div>
   <script type="text/javascript">
    if(!window.slider) var slider={};slider.data=[{"id":"slide-img-1","client":"","desc":""},{"id":"slide-img-2","client":"image slider","desc":"add your description here"},{"id":"slide-img-3","client":"image slider","desc":"add your description here"},{"id":"slide-img-4","client":"image slider","desc":"add your description here"},{"id":"slide-img-5","client":"image slider","desc":"add your description here"},{"id":"slide-img-6","client":"image slider","desc":"add your description here"},{"id":"slide-img-7","client":"image slider","desc":"add your description here"},{"id":"slide-img-8","client":"image slider","desc":"add your description here"}];
   </script>
  </div></div>';
		return $result;
	}

}
?>