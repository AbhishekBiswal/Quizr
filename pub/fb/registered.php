<?php
	session_start();
	include('fn/loggedin.php');
	if($loggedin == 1)
	{
		header('Location:../');
		exit();
	}

	include('temp/header.php');

?>
<div class="container main">
	<div class="infopage">
		<h2>You have Succesfully Registered.</h2>
		<form class="ajax" action="/ajax/subs/username.php">
			<p class="submitinfo"></p>
			<input type="text" name="username" class="check_username">
			<input class="btn btn-big" type="submit" value="Save">
		</form>
	</div>
</div>

<?php
	include('temp/footer.php');
?>