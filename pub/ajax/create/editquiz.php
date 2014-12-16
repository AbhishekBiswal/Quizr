<?php
	session_start();
	include('fn/loggedin.php');
	if($loggedin == 0)
	{
		exit();
	}

	$user = $curUser;

	$qTitle = $_POST['title'];
	$qDesc = $_POST['desc'];
	$qCat = $_POST['cat'];
	$quizid = $_POST['id'];

	$qTitle = htmlentities($qTitle);
	$qDesc = htmlentities($qDesc);
	$qCat = htmlentities($qCat);
	$quizid = htmlentities($quizid);

	if(empty($qTitle))
	{
		echo "All The Fields are Manadatory.";
		exit();
	}

	if((strlen($qTitle)<5) || (strlen($qTitle)>300))
	{
		echo "The Title entered is invalid";
		exit();
	}

	if(strlen($qDesc)>500)
	{
		echo "The Description enetered is invalid";
		exit();
	}

	/* Select Category */
	include_once('fn/browse.php');
	if(checkCat($qCat) == false)
	{
		echo "Error Occured. Reload and Try Again?";
		exit();
	}

	include('db.php');
	$check = $DBH->prepare("SELECT title FROM quizmeta WHERE id=? AND user=?");
	$check->execute(array($quizid,$user));
	if($check->rowCount() == 0)
	{
		echo '<script>notify("Error Occured. Please Try Again Later.");</script>';
		exit();
	}
	$insert = $DBH->prepare("UPDATE quizmeta SET title=?,qdesc=?,cat=? WHERE id=? AND user=?");
	$insert->execute(array($qTitle,$qDesc,$qCat,$quizid,$user));
	echo '<script>notify("Updated.");</script>';
?>