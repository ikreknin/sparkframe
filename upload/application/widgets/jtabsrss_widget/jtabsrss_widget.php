<?php
if (!defined('FW'))
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit ();
}

class Jtabsrss_widget
{

	function __construct()
	{
	}

	public function index($string = '')
	{
		$result = '';
		$result .= '<link rel="stylesheet" href="' . FWURL . SUBDIR . APPDIR . '/widgets/jtabsrss_widget/css/style.css" type="text/css" media="screen" />
					';
		$result .= '    <script>
	  $(document).ready(function(){
		$("a.tab").click(function () {
			$(".active").removeClass("active");
			$(this).addClass("active");
			$(".content").slideUp();
			var content_show = $(this).attr("title");
			$("#"+content_show).slideDown();
		});
	  });
  </script>';
		$result .= '<div id="tabbed_box_1" class="tabbed_box">
    <div class="tabbed_area">

        <ul class="tabs">
            <li><a href="#" title="content_1" class="tab active">Topics</a></li>
            <li><a href="#" title="content_2" class="tab">Archives</a></li>
            <li><a href="#" title="content_3" class="tab">Pages</a></li>
        </ul>

        <div id="content_1" class="content">
        	<ul>
            	<li><a href="">HTML Techniques <small>4 Posts</small></a></li>
            	<li><a href="">CSS Styling <small>32 Posts</small></a></li>
            	<li><a href="">Flash Tutorials <small>2 Posts</small></a></li>
            	<li><a href="">Web Miscellanea <small>19 Posts</small></a></li>
            	<li><a href="">Site News <small>6 Posts</small></a></li>
            	<li><a href="">Web Development <small>8 Posts</small></a></li>
			</ul>
        </div>
        <div id="content_2" class="content">
        	<ul>
            	<li><a href="">December 2008 <small>6 Posts</small></a></li>
            	<li><a href="">November 2008 <small>4 Posts</small></a></li>
            	<li><a href="">October 2008 <small>22 Posts</small></a></li>
            	<li><a href="">September 2008 <small>12 Posts</small></a></li>
            	<li><a href="">August 2008 <small>3 Posts</small></a></li>
            	<li><a href="">July 2008 <small>1 Posts</small></a></li>
			</ul>
        </div>
        <div id="content_3" class="content">
        	<ul>
            	<li><a href="">Home</a></li>
            	<li><a href="">About</a></li>
            	<li><a href="">Contribute</a></li>
            	<li><a href="">Contact</a></li>
			</ul>
        </div>

    </div>
</div>
';
		return $result;
	}

}
?>