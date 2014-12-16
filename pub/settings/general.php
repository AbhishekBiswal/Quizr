<?php
	session_start();
	include('fn/loggedin.php');
	if($loggedin == 0)
	{
		header('Location:/');
		exit();
	}

	/*Load vars:*/
	include('db.php');
	$load = $DBH->prepare("SELECT * FROM users WHERE id=?");
	$load->execute(array($curUser));
	if($load->rowCount() == 0)
	{
		echo "Error! Please try again after some time.";
		exit();
	}

	while($u = $load->fetch())
	{
		$userfName = $u['fullname'];
		$userBio = $u['bio'];
	}

	$pageName = "Settings - Profile";
	include('temp/header.php');
?>

<div class="content">
	<!-- <form class="ajax" action="profile-sub.php">
		<p class="submitinfo"></p>
		<input type="text" name="fname" value="<?php echo $userfName; ?>"></input><span class="helpinline">Your Name</span><br>
		<textarea name="bio"><?php echo $userBio; ?></textarea><span class="helpinline">Your Bio</span><br>
		<input type="submit" class="btn" value="Save">
	</form> -->
	<h3>Under Construction</h3>
</div>

<?php
	include('temp/footer.php');
?>