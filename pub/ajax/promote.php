<?php
	/* Ajax load */
	session_start();
	include('fn/loggedin.php');
	include('db.php');
	$text = htmlentities($_GET['term']);
	$query = $DBH->prepare("SELECT username FROM users WHERE username LIKE ? AND id!=? ORDER BY username ASC");
	$query->execute(array("%$text%",$curUser));
	$json = '[';
	$first = true;
	while($row = $query->fetch())
	{
		if (!$first) { $json .=  ','; } else { $first = false; }
    	$json .= '{"value":"'.$row['username'].'"}';
	}
	$json .= ']';
	echo $json;
?>