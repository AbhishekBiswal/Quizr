<?php
	
	// vars:
	@$term = $_POST['search-term'];

	if(!$term)
	{
		exit();
	}

	$term = htmlentities($term);

	include_once('db.php');
	include_once('fn/browse.php');

	// to search : quizzes/users

	// quizzes:
	$quizzes = $DBH->prepare("SELECT * FROM quizmeta WHERE title LIKE ? AND pub=1 LIMIT 20");
	$quizzes->execute(array("%$term%"));
?>
	<div class="search-quiz">
		<h3 class="search-title">Quizzes:</h3>
<?php
	if($quizzes->rowCount() == 0)
	{
		// nothing.
		echo '<p class="grayinfo">Nothing Found.</p>';
	}
	else
	{
		browseLoad($quizzes);
	}

	include_once('fn/loggedin.php');

?>
	</div><!--search-quiz-->
	<br></br>
	<div class="search-users">
		<h3 class="search-title">Users:</h3>
<?php
	$users = $DBH->prepare("SELECT * FROM users WHERE username LIKE ? OR fullname LIKE ? LIMIT 20");
	$users->execute(array("%$term%","%$term%"));
	if($users->rowCount() == 0)
	{
		// nothing.
		echo '<p class="grayinfo">Nothing Found.</p>';
	}
	else
	{
?>
		<table class="leaderb">
		<tbody>
			<tr>
				<th width="10%"></th>
				<th width="50%">User</th>
				<th width="40%">Points</th>
			</tr>
<?php
		while($row = $users->fetch())
		{
?>
		<tr>
				<td width="10%"><center>
					<?php if($row['oauthp'] == "facebook") { ?>
					<img src="http://graph.facebook.com/<?php echo $row['fbusername']; ?>/picture">
					<?php } elseif($row['oauthp'] == "twitter") { ?>
					<img src="<?php
					$getTwitterURL = $row['twusername'];
					echo getTwitterImage($getTwitterURL);
					?>">
					<?php } ?>
				</center></td>
				<td width="50%"><a href="/<?php echo $row['username']; ?>/"><?php echo $row['fullname']; ?></a></td>
				<td width="40%"><?php echo $row['points']; ?></td>
		</tr>
<?php
		}
?>
		</tbody>
		</table>
<?php
	}
?>

	</div>