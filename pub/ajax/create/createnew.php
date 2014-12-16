<?php
	session_start();
	include('fn/loggedin.php');
	if($loggedin == 0)
	{
		echo "Please Login to continue.";
		exit();
	}

	$user = $curUser;

	/*Creating a New Quiz -- Validate acche se.*/
	$qTitle = $_POST['title'];
	$qDesc = $_POST['desc'];
	$qCat = $_POST['cat'];

	$qTitle = htmlentities($qTitle);
	$qDesc = htmlentities($qDesc);
	$qCat = htmlentities($qCat);

	if((empty($qTitle)) || (empty($qDesc)))
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
	$check = $DBH->prepare("SELECT id FROM quizmeta WHERE user=? AND title=?");
	$check->execute(array($user,$qTitle));
	if($check->rowCount() == 1)
	{
		echo "Please Choose another Title.";
		exit();
	}
	$insert = $DBH->prepare("INSERT INTO quizmeta(title,qdesc,user,dt,cat) VALUES(?,?,?,NOW(),?)");
	$insert->execute(array($qTitle,$qDesc,$user,$qCat));
	$selectId = $DBH->prepare("SELECT id FROM quizmeta WHERE user=? AND title=?");
	$selectId->execute(array($user,$qTitle));
	while($row = $selectId->fetch())
	{
		$qid = $row['id'];
	}
	echo '<script>window.location="/quiz/add.php?id=' . $qid . '";</script>';
?>