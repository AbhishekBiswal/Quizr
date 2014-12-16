<?php
	include('db.php');

	$fullname = $user['name'];
	$fbusername = $user['username'];
	$oauthid = $user['id'];

	// check if the user exists.
	$checkUser = $DBH->prepare("SELECT * FROM users WHERE oauthp='facebook' AND oauthid=?");
	$checkUser->execute(array($oauthid));

	if($checkUser->rowCount() == 0)
	{
		$insertUser = $DBH->prepare("INSERT INTO users(fullname,fbusername,oauthp,oauthid) VALUES(?,?,'facebook',?)");
		$insertUser->execute(array($fullname,$fbusername,$oauthid));
		$checkUser = $DBH->prepare("SELECT * FROM users WHERE oauthp='facebook' AND oauthid=?");
		$checkUser->execute(array($oauthid));
		while($row = $checkUser->fetch())
		{
			$_SESSION['qu'] = $row['username'];
			$_SESSION['qp'] = $row['id'];
		}
		if($_SESSION['qu'] == "")
		{
			header('Location:/username.php');
			exit();
		}
		if($cont)
		{
			header('Location:' . $cont);
			exit();
		}
		header('Location:/');
		exit();
	}
	else
	{
		while($row = $checkUser->fetch())
		{
			$_SESSION['qu'] = $row['username'];
			$_SESSION['qp'] = $row['id'];
		}
		if($_SESSION['qu'] == "")
		{
			header('Location:/username.php');
			exit();
		}
		if($cont)
		{
			header('Location:/' . $cont);
			exit();
		}
		header('Location:/');
	}

?>