<?php
	session_start();
	//include('fn/loggedin.php');
	$curUser = $_SESSION['qp'];
	if(!isset($_SESSION['qp']))
	{
		header('Location:/');
		exit();
	}
	$loggedin = 1;
	include_once('db.php');
	include_once('fn/loadquiz.php');

	// todo : add exception for usernames not null
	$userName = $_POST['username'];
	$userName = str_replace(" ","",$userName); /* removing spaces. */

	$userMail = $_POST['email'];

	include_once('validate/do.php');
	$validator = new Validator();

	if((strlen($userName)<3) || (strlen($userName)>20))
	{
		echo "Username is invalid";
		exit();
	}

	function validate_username($str) 
	{
	    return preg_match('/^[a-zA-Z0-9_]+$/',$str);
	}
	if(validate_username($userName) == 0)
	{
		echo "The Username is not valid";
		exit();
	}

	$blockedNames = array("god","butter","baap","baaap","dad","maa","ma","bhenkaloda","loda","quizr","flower","facebook","twitter","stevejobs","billgates","quizzer");
	$i = 0;
	while($i < count($blockedNames))
	{
		if($userName == $blockedNames[$i])
		{
			echo "The Username is Invalid";
			exit();
		}
		$i++;
	}


	$checkU = checkUsername($userName,$DBH);
	if($checkU == 1)
	{
		echo "The Username is not available!";
		//echo '<script>$("input[type=submit]").val("Check");</script>';
		exit();
	}

	if($validator->isValid($userMail,'email') == false)
	{
		echo "Invalid Email Address.";
		exit();
	}

	$checkE = checkEmail($userMail,$DBH);
	if($checkE == 1)
	{
		echo "This Email Address is already in use.";
		//echo '<script>$("input[type=submit]").val("Check");</script>';
		exit();
	}
	
	$updUname = $DBH->prepare("UPDATE users SET username=?, email=? WHERE id=?");
	$updUname->execute(array($userName,$userMail,$curUser));
	$_SESSION['qu'] = $userName;
	//header('Location:/' . $userName);
	echo '<script>location.href = "/' . $userName . '/";</script>';

?>