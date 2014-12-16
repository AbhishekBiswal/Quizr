<?php
	session_start();
	include('fn/loggedin.php');
	if($loggedin == 0)
	{
		echo '<script>notify("Please Login To Continue.");</script>';
		exit();
	}

	$quizID = $_POST['quiz'];
	$userID = $_POST['user'];
	$userName = $_POST['username'];

	if(!$userName)
	{
		echo "Please Enter a Valid Username";
		exit();
	}

	include('db.php');

	// check if username exists:

	$unCheck = $DBH->prepare("SELECT * FROM users WHERE username=?");
	$unCheck->execute(array($userName));
	if($unCheck->rowCount() == 0)
	{
		echo "Invalid User. Please Check The Username";
		exit();
	}

	// username exists : find out the user id:
	while($row = $unCheck->fetch())
	{
		$promtoid = $row['id'];
	}

	// got the id. value in : $promtoid, read it as "Promote To ID", niggers.

	// Load Quiz Info:

	$quizInfo = $DBH->prepare("SELECT * FROM quizmeta WHERE id=?");
	$quizInfo->execute(array($quizID));

	if($quizInfo->rowCount() == 0)
	{
		echo "Error Occurred. Please Try Again Later.";
		exit();
	}

	while($qinfo = $quizInfo->fetch())
	{
		$quizTitle = $qinfo['title'];
	}


	// check if the request exists..

	$checkR = $DBH->prepare("SELECT * FROM notifs WHERE user=? AND msg LIKE ?");
	$checkR->execute(array($promtoid,"%$quizTitle%"));
	if($checkR->rowCount() != 0)
	{
		echo "Request Already Exists.";
		exit();
	}

	include_once('fn/loadquiz.php');
	// using notify function..

	$curUsername = $_SESSION['qu'];

	$msg = "<a href='/$curUsername/'>$curUsername</a> has requested you to play the quiz : <a href='/q/$quizID'>$quizTitle</a>.";

	notify($promtoid,$msg,$DBH);

	echo '<script>
	$("promote-box").slideUp();
	notify("Promoted.");
	$("#promote-input").value = "";
	</script>';

?>