<?php
	/*Script used for adding points to user's profile.*/
	function addPoints($user,$points,$DBH)
	{
		$addPoints = $DBH->prepare("UPDATE users SET points=points+? WHERE id=?");
		$addPoints->execute(array($points,$user));
	}

	function subPoints($user,$points,$DBH)
	{
		$subPoints = $DBH->prepare("UPDATE users SET points=points-? WHERE id=?");
		$subPoints->execute(array($points,$user));
	}
?>