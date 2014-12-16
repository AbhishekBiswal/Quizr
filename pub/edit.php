<?php

	session_start();
	include('fn/loggedin.php');
	if($loggedin == 0)
	{
		header('Location:/login.php');
		exit();
	}
	
	if(isset($_GET['id']))
	{
		include('edit/edit.php');
		exit();
	}
	else
	{
		include('edit/create.php');
		exit();
	}

?>