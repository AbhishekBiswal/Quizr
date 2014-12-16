<?php
	function loadUser($id,$DBH) // fullname
	{
		$loadfName = "Anonymous";
		$loadUser = $DBH->prepare("SELECT fullname FROM users WHERE id=?");
		$loadUser->execute(array($id));
		while($row = $loadUser->fetch())
		{
			$loadfName = $row['fullname'];
		}
		return $loadfName;
	}

	function loadUName($id,$DBH) //username
	{
		$loadUName = NULL;
		$loadUser = $DBH->prepare("SELECT username FROM users WHERE id=?");
		$loadUser->execute(array($id));
		while($row = $loadUser->fetch())
		{
			$loadUName = $row['username'];
		}
		return $loadUName;
	}
?>