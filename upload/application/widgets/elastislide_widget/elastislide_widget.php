<?php
if (!defined('FW'))
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit ();
}

class Elastislide_widget
{

	function __construct()
	{
	}

	public function index()
	{
		$result = '';
		$result .= '<link rel="stylesheet" href="' . FWURL . 'application/widgets/elastislide_widget/css/elastislide.css" type="text/css" media="screen" />';
		$result .= '<link rel="stylesheet" href="' . FWURL . 'application/widgets/elastislide_widget/css/custom.css" type="text/css" media="screen" />';
		$result .= '<link rel="stylesheet" href="' . FWURL . 'application/widgets/elastislide_widget/js/modernizr.custom.17475.js" type="text/css" media="screen" />';
		$result .= '<link rel="stylesheet" href="' . FWURL . 'application/widgets/elastislide_widget/js/jquerypp.custom.js" type="text/css" media="screen" />';
		$result .= '<link rel="stylesheet" href="' . FWURL . 'application/widgets/elastislide_widget/js/jquery.elastislide.js" type="text/css" media="screen" />';
		$result .= "<script type=\"text/javascript\">
$( '#carousel' ).elastislide( {
	minItems : 2
} );
</script>";
		$result .= '				<div>
					<!-- Elastislide Carousel -->
					<ul id="carousel" class="elastislide-list">
						<li><a href="#"><img src="' . FWURL . 'application/widgets/elastislide_widget/images/small/1.jpg" alt="image01" /></a></li>
						<li><a href="#"><img src="' . FWURL . 'application/widgets/elastislide_widget/images/small/2.jpg" alt="image02" /></a></li>
						<li><a href="#"><img src="' . FWURL . 'application/widgets/elastislide_widget/images/small/3.jpg" alt="image03" /></a></li>
						<li><a href="#"><img src="' . FWURL . 'application/widgets/elastislide_widget/images/small/4.jpg" alt="image04" /></a></li>
						<li><a href="#"><img src="' . FWURL . 'application/widgets/elastislide_widget/images/small/5.jpg" alt="image05" /></a></li>
						<li><a href="#"><img src="' . FWURL . 'application/widgets/elastislide_widget/images/small/6.jpg" alt="image06" /></a></li>
						<li><a href="#"><img src="' . FWURL . 'application/widgets/elastislide_widget/images/small/7.jpg" alt="image07" /></a></li>
						<li><a href="#"><img src="' . FWURL . 'application/widgets/elastislide_widget/images/small/8.jpg" alt="image08" /></a></li>
						<li><a href="#"><img src="' . FWURL . 'application/widgets/elastislide_widget/images/small/9.jpg" alt="image09" /></a></li>
						<li><a href="#"><img src="' . FWURL . 'application/widgets/elastislide_widget/images/small/10.jpg" alt="image10" /></a></li>
						<li><a href="#"><img src="' . FWURL . 'application/widgets/elastislide_widget/images/small/11.jpg" alt="image11" /></a></li>
						<li><a href="#"><img src="' . FWURL . 'application/widgets/elastislide_widget/images/small/12.jpg" alt="image12" /></a></li>
						<li><a href="#"><img src="' . FWURL . 'application/widgets/elastislide_widget/images/small/13.jpg" alt="image13" /></a></li>
						<li><a href="#"><img src="' . FWURL . 'application/widgets/elastislide_widget/images/small/14.jpg" alt="image14" /></a></li>
						<li><a href="#"><img src="' . FWURL . 'application/widgets/elastislide_widget/images/small/15.jpg" alt="image15" /></a></li>
						<li><a href="#"><img src="' . FWURL . 'application/widgets/elastislide_widget/images/small/16.jpg" alt="image16" /></a></li>
						<li><a href="#"><img src="' . FWURL . 'application/widgets/elastislide_widget/images/small/17.jpg" alt="image17" /></a></li>
						<li><a href="#"><img src="' . FWURL . 'application/widgets/elastislide_widget/images/small/18.jpg" alt="image18" /></a></li>
						<li><a href="#"><img src="' . FWURL . 'application/widgets/elastislide_widget/images/small/19.jpg" alt="image19" /></a></li>
						<li><a href="#"><img src="' . FWURL . 'application/widgets/elastislide_widget/images/small/20.jpg" alt="image20" /></a></li>
					</ul>
					<!-- End Elastislide Carousel -->
				</div>';
		return $result;
	}

}
?>