<?php
if (!defined('FW'))
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit ();
}

class Googlemaps_widget
{

	function __construct()
	{
	}

	public function index()
	{
// To get Google Maps API Key here:
// http://code.google.com/intl/en/apis/maps/signup.html
		$Google_Maps_API_Key = '';
// To get coordinates here:
// http://maps.google.com
		$result = '    <link rel="stylesheet" href="' . FWURL . 'application/widgets/googlemaps_widget/css/googlemaps.css" type="text/css" />
    <script type="text/javascript" src="' . FWURL . '/js/googlemaps/jquery.googlemaps1.01.js"></script>
	<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=' . $Google_Maps_API_Key . '" type="text/javascript"></script>
	<script type="text/javascript">
	$(document).ready(function() {
	  $(\'#map_canvas\').googleMaps({
				latitude: 	56.955247,
				longitude: 24.197608,
			markers: {
				latitude: 	56.955247,
				longitude: 24.197608}
		});
	});
    </script>
    <div id="map_canvas"></div>';
		return $result;
	}

}
?>