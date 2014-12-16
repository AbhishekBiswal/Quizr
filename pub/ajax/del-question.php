<?php
	session_start();
	include('fn/loggedin.php');
	if($loggedin == 0)
	{
		exit();
	}

	/*
		Do not touch this file,
		took me 1-2hr to fix the re-ordering problem.
		Now it works.
		Phew.
	*/

	$questionID = $_POST['id'];
	$quizID = $_POST['qid'];

	// check if user is the owner of the question.
	include_once("db.php");
	$check = $DBH->prepare("SELECT user FROM questions WHERE id=?");
	$check->execute(array($questionID));
	if($check->rowCount() == 0)
	{
		echo '<script>notify("The Question doesn\'t exist.");</script>';
		exit();
	}
	while($row = $check->fetch())
	{
		$user = $row['user'];
	}

	if($user != $curUser)
	{
		echo '<script>notify("You are not allowed to do this.");</script>';
		exit();
	}


	$loadMeta = $DBH->prepare("SELECT questions FROM quizmeta WHERE id=?");
	$loadMeta->execute(array($quizID));
	if($loadMeta->rowCount() == 0)
	{
		exit();
	}

	while($data = $loadMeta->fetch())
	{
		$qs = $data['questions'];
	}

	$getSeq = $DBH->prepare("SELECT seq FROM questions WHERE id=?");
	$getSeq->execute(array($questionID));
	if($getSeq->rowCount() == 0)
	{
		exit();
	}
	while($seqData = $getSeq->fetch())
	{
		$seq = $seqData['seq'];
	}

	$delete = $DBH->prepare("DELETE FROM questions WHERE id=?");
	$delete->execute(array($questionID));
	$deletemeta = $DBH->prepare("UPDATE quizmeta SET questions=questions-1 WHERE id=?");
	$deletemeta->execute(array($quizID));

	// todo : reorder the questions.

	// re-ordering the questions:

	// seq -> $seq
	/*int i = $seq + 1;*/
	//echo $qs; // 3
	$i = $seq + 1; // 2, 2+1
	while($i <= $qs)
	{
		//$i++;
		$updateSeq = $DBH->prepare("UPDATE questions SET seq=seq-1 WHERE qid=? AND seq=?");
		$updateSeq->execute(array($quizID,$i));
		$i++;
	}


	// done.

	echo '<script>
	$("li#arrayorder_"+' . $questionID . ').remove();</script>';
?>