{top_bar_tpl}
{top_menu_tpl}

	<!-- Contact Page specific scripts
	================================================== -->
	
	<!-- Google Map -->
	<script src="http://maps.google.com/maps/api/js?sensor=true"></script>
	<script src="{VIEWDIR}js/jquery.ui.map.min.js"></script>
	
	<!-- Google Map Init-->
	<script type="text/javascript">
		jQuery(function($){
			//getter
			var zoom= $('#map_canvas').gmap('option', 'zoom');
			
			$('#map_canvas').gmap().bind('init', function(ev, map) {
				$('#map_canvas').gmap('addMarker', {'position': '56.9552946,24.1976943', 'bounds': true});
				$('#map_canvas').gmap('option', 'zoom', 13);
			});
		});
	</script>

<div class="container">

	<!-- Info
	================================================== -->
	<div class="sixteen columns clearfix">
		<!-- BEGIN GOOGLE MAP -->
		<div class="map-wrapper">
			<div id="map_canvas" style="width:940px;height:400px;margin: 0 0 40px 0"></div>
		</div>
		<!-- END GOOGLE MAP -->
	</div><!-- end sixteen columns  -->

	<div class="sixteen columns">
		<div class="eleven columns alpha">
			
<h3>Contact Form</h3>
{if '{error_message}'!=''}
<div class="alert alert-error">
<i class="icon-warning-sign"></i>
{error_message}
</div>
{/if}
							<!-- BEGIN CONTACT FORM -->
							<form method="post" action="{site_url}send_email" id="contact-form" class="contact-form">
								<div class="field">
									<label for="full_name">{name}:</label>
									<input type="text" name="full_name" value='{full_name}' id="name">
								</div>
								<div class="field">
									<label for="email">Email:</label>
									<input type="email" name="email" value='{email}' id="email">
								</div>
								<div class="field">
									<label for="message">{message}:</label>
									<textarea name="body" id="comments" cols="30" rows="10">{body}</textarea>
								</div>
<div class="field">
	<label for="captchaImage">{enter_code}:</label>
	<img src="{site_url}{CMS0}/captcha" alt="" />
</div>
<div class="field">
	<label for="confirmCaptcha"></label>
	<input type="text" id="captcha" name="captcha" />
</div>
								<div class="button-wrapper">
									<input type="submit" name="submit" id="submit" value="{submit}">
								</div>
								<div id="response"></div>
							</form>
							<!-- END CONTACT FORM -->
		</div>
		<div class="five columns omega">
			<h3>Contact Info</h3>
				<p>Lorem ipsum</p>
				<address>
					<i class="fa fa-home"></i> <strong>Line for Street Address</strong><br>
					<i class="fa fa-phone"></i> +1 (234) 567-890-123<br>
					<i class="fa fa-envelope"></i> <a href="mailto:info@email.com">info@email.com</a><br>
					<i class="fa fa-globe"></i> <a href="http://www.website.com">www.website.com</a>
				</address>
		</div>
	</div><!-- end sixteen columns  -->


</div>
