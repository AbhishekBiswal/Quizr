<?php
	session_start();
	include('fn/loggedin.php');
	if($loggedin == 0)
	{
		echo "Error. Please try again after some time";
		exit();
	}
	/*Profile-Submit Page*/
	// vars:
	$fullName = $_POST['fname'];
	$userBio = $_POST['bio'];

	// validation:
	if((strlen($fullName)<3) || (strlen($fullName)>150))
	{
		echo "Invalid Name";
		exit();
	}

	if(strlen($userBio)>300)
	{
		echo "Profile Bio Invalid";
		exit();
	}

	include('db.php');
	$insert = $DBH->prepare("UPDATE users SET fullname=?,bio=? WHERE id=?");
	$insert->execute(array($fullName,$userBio,$curUser));
	echo "Profile Updated";

?>