<?php
if (!defined('FW'))
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit ();
}

class Ajaxemailsignup_widget
{

	function __construct()
	{
	}

	public function index()
	{
		Registry :: library('lang')->loadLanguageWidget('ajaxemailsignup_widget');
		$result = '';
		$result .= '<link rel="stylesheet" href="' . FWURL . 'application/widgets/ajaxemailsignup_widget/css/ajaxemailsignup_widget.css" type="text/css" media="screen" />';
		$result .= "<script type=\"text/javascript\">
$(document).ready(function(){
	$('#newsletter-signup').submit(function(){

		//check the form is not currently submitting
		if($(this).data('formstatus') !== 'submitting'){

			//setup variables
			var form = $(this),
				formData = form.serialize(),
				formUrl = form.attr('action'),
				formMethod = form.attr('method'),
				responseMsg = $('#signup-response');

			//add status data to form
			form.data('formstatus','submitting');

			//show response message - waiting
			responseMsg.hide()
					   .addClass('response-waiting')
					   .text('" . Registry :: library('lang')->line('please_wait_ajaxemailsignup_widget') . "')
					   .fadeIn(200);

			//send data to server for validation
			$.ajax({
				url: formUrl,
				type: formMethod,
				data: formData,
				success:function(data){

					//setup variables
					var responseData = jQuery.parseJSON(data),
						klass = '';

					//response conditional
					switch(responseData.status){
						case 'error':
							klass = 'response-error';
						break;
						case 'success':
							klass = 'response-success';
						break;
					}

					//show reponse message
					responseMsg.fadeOut(200,function(){
						$(this).removeClass('response-waiting')
							   .addClass(klass)
							   .text(responseData.message)
							   .fadeIn(200,function(){
								   //set timeout to hide response message
								   setTimeout(function(){
									   responseMsg.fadeOut(200,function(){
									       $(this).removeClass(klass);
										   form.data('formstatus','idle');
									   });
								   },3000)
								});
					});
				}
			});
		}

		//prevent form from submitting
		return false;
	});
});
</script>";
		$result .= '<form id="newsletter-signup" action="http://sparkframe.id.lv/ajaxemailsignup_module/add" method="post">
    <fieldset>
        <label for="signup-email">' . Registry :: library('lang')->line('message_ajaxemailsignup_widget') . ':</label>
        <input type="text" name="signup-email" id="signup-email" />
        <input type="submit" id="signup-button" value="' . Registry :: library('lang')->line('sign_me_up_ajaxemailsignup_widget') . '" />
        <p id="signup-response"></p>
    </fieldset>
</form>';
		return $result;
	}

}
?>