<?php
if (!defined('FW'))
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit ();
}

class Poll_widget
{

	function __construct()
	{
	}

	public function index($poll_group = '')
	{
// Caching OFF
		Registry :: library('db')->setCacheOn(0);
		Registry :: library('lang')->loadLanguageWidget('poll_widget');
		$prefix = Registry :: library('db')->getPrefix();
		$sys_cms = Registry :: library('db')->getSys();
		$settings_site0 = Registry :: setting('settings_site0');
		$userip = $_SERVER['REMOTE_ADDR'];
		$userip_converted = ip2long($userip);
		$skip = 1;
		$string = '';
		if ($poll_group == '')
		{
			$sql = 'SELECT *
					FROM ' . $prefix . 'poll
					WHERE poll_sys = "' . $sys_cms . '"
					AND visible = "y"
					ORDER BY `pollid` DESC
					LIMIT 1';
		}
		else
		{
			$sql = 'SELECT *
					FROM ' . $prefix . 'poll
					LEFT JOIN ' . $prefix . 'poll_group ON ' . $prefix . 'poll_group.groupid = ' . $prefix . 'poll.pollid
					WHERE poll_sys = "' . $sys_cms . '"
					AND visible = "y"
					AND group = ' . $poll_group . '
					ORDER BY `pollid` DESC
					LIMIT 1';
		}
		Registry :: library('db')->execute($sql);
		if (Registry :: library('db')->numRows() != 0)
		{
			$query = Registry :: library('db')->getRows();
			$data = array();
			$skip = 0;
			$pollid = $query['pollid'];
			$answer = array();
			$question = $query['question'];
			$answer[0] = $query['answer0'];
			$answer[1] = $query['answer1'];
			$answer[2] = $query['answer2'];
			$answer[3] = $query['answer3'];
			$answer[4] = $query['answer4'];
			$answer[5] = $query['answer5'];
			$answer[6] = $query['answer6'];
			$answer[7] = $query['answer7'];
			$answer[8] = $query['answer8'];
			$answer[9] = $query['answer9'];
			$visible = $query['visible'];
			$num_of_answers = 2;
			$string = '"' . $answer[0] . '","' . $answer[1] . '"';
			if ($answer[2] != '')
			{
				$string = $string . ',"' . $answer[2] . '"';
				$num_of_answers = $num_of_answers + 1;
			}
			if ($answer[3] != '')
			{
				$string = $string . ',"' . $answer[3] . '"';
				$num_of_answers = $num_of_answers + 1;
			}
			if ($answer[4] != '')
			{
				$string = $string . ',"' . $answer[4] . '"';
				$num_of_answers = $num_of_answers + 1;
			}
			if ($answer[5] != '')
			{
				$string = $string . ',"' . $answer[5] . '"';
				$num_of_answers = $num_of_answers + 1;
			}
			if ($answer[6] != '')
			{
				$string = $string . ',"' . $answer[6] . '"';
				$num_of_answers = $num_of_answers + 1;
			}
			if ($answer[7] != '')
			{
				$string = $string . ',"' . $answer[7] . '"';
				$num_of_answers = $num_of_answers + 1;
			}
			if ($answer[8] != '')
			{
				$string = $string . ',"' . $answer[8] . '"';
				$num_of_answers = $num_of_answers + 1;
			}
			if ($answer[9] != '')
			{
				$string = $string . ',"' . $answer[9] . '"';
				$num_of_answers = $num_of_answers + 1;
			}
		}
		$result = '';
		$result .= '<style>

label.error { float: none; color: red; padding-left: .5em; vertical-align: top; }

#wPoll ul {
	margin-left:-10px;
}
    form.webPoll {
        background:#ededed;
        behavior:url(poll_widget/css/PIE.php);
        border:1px solid #bebebe;
        -moz-border-radius:8px;
        -webkit-border-radius:8px;
        border-radius:8px;
        -moz-box-shadow:#666 0 2px 3px;
        -webkit-box-shadow:#666 0 2px 3px;
        box-shadow:#666 0 2px 3px;
        margin:10px 0 10px 0px;
        padding:6px;
        position:relative;
        width:200px;
    }
form.webPoll ul {
    behavior:url(poll_widget/css/PIE.php);
    border:2px #bebebe solid;
    -moz-border-radius:10px;
    -webkit-border-radius:10px;
    border-radius:10px;
    list-style-type:none;
    margin:0 -12px 0 0;
    padding:10px 0;
    position:relative;
}

fieldset.webPoll {
width:177px;
border:0px;
	}
li.webPoll {
margin:0 0 0 5px;
font-family:verdana;
font-size:10px;
	}
li.bordered {
	border-bottom:1px #bebebe solid;
}
form.webPoll .result {
    background: #d81b21;
    background: -webkit-gradient(linear, left top, left bottom, from(#ff8080), to(#aa1317));
    background: -moz-linear-gradient(top, #ff8080, #aa1317);
    -pie-background: linear-gradient(#ff8080, #aa1317);
    border:1px red solid;
    -moz-border-radius:3px;
    -webkit-border-radius:3px;
    border-radius:3px;
    clear:both;
    color:#EFEFEF;
    padding-left:2px;
    behavior: url(\'poll_widget/css/PIE.php\');
}
form.webPoll h4 {
    color:#444;
    font-family:Georgia, serif;
    font-size:19px;
    font-weight:400;
    line-height:1.4em;
    padding:0;
}
.buttons {
    margin:8px 0 1px;
    padding:0;
    text-align:right;
    width:122px;
}
.vote {

}
.vote:hover {
    cursor:pointer;
}
form.webPoll ul,li { /*// Make IE6 happy //*/
    zoom:1;
}
		</style>';
		$sql = 'SELECT *
				FROM ' . $prefix . 'poll_vote
				WHERE poll_vote_sys = "' . $sys_cms . '"
				AND pollid = "' . $pollid . '"
				AND userip = "' . $userip_converted . '"';
		Registry :: library('db')->execute($sql);
		if (Registry :: library('db')->numRows() == 0)
		{
			$result .= '
';
// <script type="text/javascript" src="' . FWURL . 'js/jquery_validate/jquery.validate.min.js"></script>
			$userid = Registry :: library('authenticate')->getUserID();
			if ($userid == null)
			{
				$userid = 0;
			}
			$result .= "<script type=\"text/javascript\">
$(document).ready(function(){

	$('#poll-vote').submit(function(){

		//check the form is not currently submitting
		if($(this).data('formstatus') !== 'submitting'){

			//setup variables
			var form = $(this),
				formData = form.serialize() + '&pollid=' + " . $pollid . " + '&userip=' + " . $userip_converted . "  + '&voted=0' + '&userid=' + '" . $userid . "' + '&poll_vote_sys=' + '" . $sys_cms . "' + '&num_of_answers=' + '" . $num_of_answers . "',
				formUrl = form.attr('action'),
				formMethod = form.attr('method'),
				responseMsg = $('#poll-response');
// alert(formData);
			//add status data to form
			form.data('formstatus','submitting');

			//show response message - waiting
			responseMsg.hide()
					   .addClass('response-waiting')
					   .text('" . Registry :: library('lang')->line('please_wait_poll_widget') . "')
					   .fadeIn(200);

			//send data to server for validation
			$.ajax({
				url: formUrl,
				type: formMethod,
				data: formData,
				success:function(msg){
var cleaned = msg.split('<meta http-equiv=');
msg = cleaned[0];
// alert(msg);
var response = jQuery.parseJSON(msg);

//change h4
jQuery('div#wPoll').find('h4').text('" . $question . " (Votes: ' + response[0].votesTotal + ')');

//remove form
jQuery('#wPoll').slideUp('slow');



var results_html = '<div id=\"wPoll\"><form class=\"webPoll\" method=\"post\" action=\"/poll/test.php\"><h4>" . $question . " (Votes: ' + response[0].votesTotal + ')</h4><fieldset class=\"webPoll\"><ul class=\"webPoll\">';";
			$i = 0;
			while ($i < $num_of_answers)
			{
				$result .= "results_html = results_html + '<li class=\"webPoll\"><div class=\"result\" style=\"width:' + response[" . $i . "].percentLength + 'px;\">\&nbsp\;</div><label class=\"poll_results\">' + response[" . $i . "].percent + '\%\: ' + response[" . $i . "].votes + '</label></li>';";
				$i++;
			}
			$result .= "results_html = results_html + '</ul></fieldset></form></div>';";
			$result .= "$('div#poll-results').append(results_html);





				}
			});
		}

		//prevent form from submitting
		return false;
	});
});
</script>";
			$result .= '
<div id="wPoll">
<form id="poll-vote" class="webPoll" method="post" action="' . FWURL . '/poll_module/vote">
	<h4>' . $question . '</h4>
    <fieldset class="webPoll">
    <ul class="webPoll">';
			$i = 0;
			while ($i < $num_of_answers)
			{
				if ($i != ($num_of_answers - 1))
				{
					$result .= '<li class="webPoll bordered">';
				}
				else
				{
					$result .= '<li class="webPoll">';
				}
				$result .= '<label class=\'poll_active\'>
            	<input class="required" type=\'radio\' name=\'answerID\' value=\'' . $i . '\'>
            	' . $answer[$i] . '
            </label>
        </li>';
				$i++;
			}
			$result .= '</ul>
    </fieldset>
    <p class="buttons">
        <button type="submit" class="vote">Vote!</button>
    </p>
	<p id="poll-response"></p>
</form>
</div>
<div id="poll-results"></div>
		';
		}
		else
		{
			$sql = 'SELECT *
				FROM ' . $prefix . 'poll_results
				WHERE poll_results_sys = "' . $sys_cms . '"
				AND poll_id = "' . $pollid . '"';
			$cache = Registry :: library('db')->cacheQuery($sql);
			$votesTotal = 0;
			$a = array();
			$a[0] = 0;
			$a[1] = 0;
			$a[2] = 0;
			$a[3] = 0;
			$a[4] = 0;
			$a[5] = 0;
			$a[6] = 0;
			$a[7] = 0;
			$a[8] = 0;
			$a[9] = 0;
			if (Registry :: library('db')->numRowsFromCache($cache) != 0)
			{
				$data = Registry :: library('db')->rowsFromCache($cache);
				foreach ($data as $k => $v)
				{
					$a[$v['choices']] = $v['votes'];
					$votesTotal = $votesTotal + $v['votes'];
				}
				$percent = array();
				$percentLength = array();
				$percent[0] = 0;
				$percent[1] = 0;
				$percent[2] = 0;
				$percent[3] = 0;
				$percent[4] = 0;
				$percent[5] = 0;
				$percent[6] = 0;
				$percent[7] = 0;
				$percent[8] = 0;
				$percent[9] = 0;
				$percentLength[0] = 0;
				$percentLength[1] = 0;
				$percentLength[2] = 0;
				$percentLength[3] = 0;
				$percentLength[4] = 0;
				$percentLength[5] = 0;
				$percentLength[6] = 0;
				$percentLength[7] = 0;
				$percentLength[8] = 0;
				$percentLength[9] = 0;
				foreach ($data as $k => $v)
				{
					$percent[$v['choices']] = round($v['votes'] / $votesTotal * 100);
					$percentLength[$v['choices']] = $percent[$v['choices']] * 1.8;
				}
			}
			$result .= '
<div id="wPoll">
<form class="webPoll" method="post" action="/poll/test.php">
    <h4>' . $question . ' (Votes: ' . $votesTotal . ')</h4>
    <fieldset class="webPoll">
    <ul class="webPoll">';
			$i = 0;
			while ($i < $num_of_answers)
			{
				$result .= '
        <li class="webPoll">
    		<div class=\'result\' style=\'width:' . $percentLength[$i] . 'px;\'>&nbsp;</div>
    		<label class=\'poll_results\'>
        	' . $percent[$i] . '%: ' . $answer[$i] . '
    		</label>
        </li>';
				$i++;
			}
			$result .= '</ul>
    </fieldset>
</form>
</div>
			';
		}
// Restore CacheOn & Delete Cache
		Registry :: library('db')->setCacheOn(Registry :: setting('settings_cached'));
		if (Registry :: setting('settings_cached') == 1)
		{
			Registry :: library('db')->deleteCache('cache_', true);
		}
		return $result;
	}

}
?>