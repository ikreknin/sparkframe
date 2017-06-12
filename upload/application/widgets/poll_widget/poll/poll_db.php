<?php

	//db connection details
	$host = "localhost";
  	$user = "demo";
  	$password = "demo";
  	$database = "demo";
	
	$tablename1 = "mycms_Poll_Results";
	$tablename2 = "mycms_Poll_Vote";
	
	//make connection
  	$server = mysql_connect($host, $user, $password);
  	$connection = mysql_select_db($database, $server);

	//get post data
	$selected = $_POST['choice'];

	$pieces = explode("|", $selected);
	$selected1 = mysql_real_escape_string($pieces[0]);
	$selected2 = mysql_real_escape_string($pieces[1]);
	$userip = mysql_real_escape_string($pieces[2]);
	$voted = mysql_real_escape_string($pieces[3]);

if ($voted == 0) {
	//update table
	mysql_query("UPDATE $tablename1 SET votes = votes + 1 WHERE choices = '$selected1' AND poll_id = '$selected2'");

	mysql_query("INSERT INTO $tablename2 (pollid, userip) VALUES($selected2, $userip)");
}

	//query the database
  	$query = mysql_query("SELECT * FROM $tablename1 WHERE poll_id = '$selected2'");
	
	//loop through and return results
  	for ($x = 0, $numrows = mysql_num_rows($query); $x < $numrows; $x++) {
    $row = mysql_fetch_assoc($query);
		
		//make array
		$json[$x] = array("choice" => $row["choices"], "votes" => $row["votes"]);
  	}
	
	//echo results
	echo json_encode($json);

	//close connection
	mysql_close($server);
	
?>