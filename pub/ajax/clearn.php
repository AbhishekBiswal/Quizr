<?php
	session_start();
	include('fn/loggedin.php');
	if($loggedin == 0)
	{
		echo '<script>location.reload();</script>';
		exit();
	}

	include('db.php');
	$clear = $DBH->prepare("UPDATE notifs SET done=1 WHERE user=?");
	$clear->execute(array($curUser));

	echo '<script>location.reload();</script>';
?>