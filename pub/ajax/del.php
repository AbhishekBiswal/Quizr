<?php
	session_start();
	include('fn/loggedin.php');
	if($loggedin == 0)
	{
		echo "Please Login first.";
		exit();
	}
	$conf = $_POST['confirm'];
	$quizid = $_POST['id'];

		include_once('db.php');
		$loadQuiz = $DBH->prepare("SELECT * FROM quizmeta WHERE id=? AND user=?");
		$loadQuiz->execute(array($quizid,$curUser));
		if($loadQuiz->rowCount() == 0)
		{
			exit();
		}

	if($conf == 1)
	{
		$delQuiz = $DBH->prepare("DELETE FROM quizmeta WHERE id=? AND user=?");
		$delQuiz->execute(array($quizid,$curUser));
		$delQuizrecs = $DBH->prepare("DELETE FROM played WHERE qid=?");
		$delQuizrecs->execute(array($quizid));
		echo "<script>window.location='/';</script>";
	}

?>