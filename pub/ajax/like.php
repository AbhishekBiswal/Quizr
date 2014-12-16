<?php
	session_start();
	include('fn/loggedin.php');
	if($loggedin == 0)
	{
		echo '<script>notify("Please Login To Continue.");</script>';
		exit();
	}

	/* vars */
	$quizID = $_POST['quizid'];
	$userID = $curUser;
	if((!$quizID) || (!$userID))
	{
		echo '<script>notify("Error Occured. Please Try Again Later.");</script>';
	}

	include_once('db.php');
	$check = $DBH->prepare("SELECT * FROM liked WHERE quizid=? AND user=?");
	$check->execute(array($quizID,$userID));
	if($check->rowCount() == 1)
	{
		// exists. delete.
		$delete = $DBH->prepare("DELETE FROM liked WHERE quizid=? AND user=?");
		$delete->execute(array($quizID,$userID));
		$upd = $DBH->prepare("UPDATE quizmeta SET likes=likes-1 WHERE id=?");
		$upd->execute(array($quizID));
		// done. deleted.
		echo '<script>$(".like-btn").removeClass("btn-blue");</script>';
		echo '<script>$(".like-btn").html("Like");</script>';
	}
	else
	{
		// create.
		$insert = $DBH->prepare("INSERT INTO liked(quizid,user) VALUES(?,?)");
		$insert->execute(array($quizID,$userID));
		// done. created.
		$upd = $DBH->prepare("UPDATE quizmeta SET likes=likes+1 WHERE id=?");
		$upd->execute(array($quizID));
		echo '<script>$(".like-btn").addClass("btn-blue");</script>';
		echo '<script>$(".like-btn").html("Liked");</script>';
	}

?>