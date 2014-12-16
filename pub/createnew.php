<?php
	session_start();
	include('fn/loggedin.php');
	if($loggedin==0)
	{
		header('Location:/');
		exit();
	}

	$qid = $_GET['id'];
	if(empty($qid))
	{
		header('Location:/create/');
		exit();
	}

	include('db.php');
	$checkid = $DBH->prepare("SELECT * FROM quizmeta WHERE id=?");
	$checkid->execute(array($qid));
	if($checkid->rowCount() == 0)
	{
		include('404.php');
		exit();
	}
?>