<?php
	
	session_start();
	include('fn/loggedin.php');
	if($loggedin == 0)
	{
		echo "Please Login to Continue";
		exit();
	}

	$quizid = $_GET['qid'];

	include_once('db.php');
	$check = $DBH->prepare("SELECT id FROM favs WHERE user=? AND quizid=?");
	$check->execute(array($curUser,$quizid));

	if($check->rowCount() == 1) /* Already there. */
	{
		// delete
		$del = $DBH->prepare("DELETE FROM favs WHERE user=? AND quizid=?");
		$del->execute(array($curUser,$quizid));
		echo '<script>$("#fav-btn").removeClass("faved");</script>';
	}
	else
	{
		$fav = $DBH->prepare("INSERT INTO favs(user,quizid) VALUES(?,?)");
		$fav->execute(array($curUser,$quizid));
		echo '<script>$("#fav-btn").addClass("faved");</script>';
	}

?>