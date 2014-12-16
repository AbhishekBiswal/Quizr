<?php
	
	// request for hint
	session_start();
	include('fn/loggedin.php');
	if($loggedin == 0)
	{
		exit();
	}

	$quid = $_POST['id'];
	if(!$quid)
	{
		echo "Error {ID}";
		exit();
	}

	include_once('db.php');

	$hintViewed = $DBH->prepare("SELECT * FROM hints WHERE quid=? AND uid=?");
	$hintViewed->execute(array($quid,$curUser));
	if($hintViewed->rowCount() == 0)
	{
		$createHint = $DBH->prepare("INSERT INTO hints(quid,uid) VALUES(?,?)");
		$createHint->execute(array($quid,$curUser));
		echo '<script>location.reload();</script>';
	}
	else
	{
		echo '<script>location.reload();</script>';
	}

?>