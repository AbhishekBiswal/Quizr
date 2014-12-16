<?php
	
	/* Skip Question. */

	session_start();
	include('fn/loggedin.php');
	if($loggedin == 0)
	{
		echo "Please Login.";
		exit();
	}
	/*Submit answer (/play/sub.php)*/
	/*
	Get:
	quetsion id, answer
	*/
	// vars:
	$quid = $_POST['q-id']; // question ID
	$qseq = $_POST['seq'];
	$quizID = $_POST['qid'];
	$answer = $_POST['ans'];
	$answer = strtolower($answer);
	$answer = htmlentities($answer);
	$answer = str_replace(" ","",$answer);
	if(!$quid)
	{
		echo "An Error occured. Please try again later. (1)";
		exit();
	}

	include_once('fn/points.php');
	include_once('db.php');

	$checkUser = $DBH->prepare("SELECT user FROM quizmeta WHERE id=?");
	$checkUser->execute(array($quizID));
	while($userData = $checkUser->fetch())
	{
		$quizOwner = $userData['user'];
		$totalQuestions = $userData['questions'];
	}

	$checkquid = $DBH->prepare("SELECT * FROM questions WHERE id=?");
	$checkquid->execute(array($quid));
	if($checkquid->rowCount() == 0)
	{
		echo "Error. Try again later (3)";
		exit();
	}

	/*// traverse played table:
	$played = $DBH->prepare("SELECT * FROM played WHERE qid=? AND user=?");
	$played->execute(array($quizID,$curUser));
	if($played->rowCount() == 0)
	{
		echo "Error. {4}";
		exit();
	}

	while($playedData = $played->fetch())
	{
		$playedTill = $playedData['playedtill'];
	}*/



	$skipped = $DBH->prepare("UPDATE played SET skipped=skipped+1 WHERE qid=? AND user=?");
	$skipped->execute(array($quizID,$curUser));
	/* skipped. */

	/* Question + 1 - skip in questions table. */
	$skipQuestion = $DBH->prepare("UPDATE played SET playedtill=playedtill+1 WHERE qid=? AND user=?");
	$skipQuestion->execute(array($quizID,$curUser));
	echo '<script>location.reload();</script>';


?>