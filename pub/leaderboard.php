<?php
	/* Leaderboard - Sort by points - top 20 users */
	include('../inc/fn/loggedin.php');
	include_once('db.php');

	$pageName = "Top 20 Quizzers";
	include('temp/header.php');

?>

<div class="det-head">
	<h2>Top 20 Quizzers</h2>
</div>

<div class="content">

		<table class="leaderb">
		<tbody>
			<tr>
				<th width="10%"></th>
				<th width="50%">User</th>
				<th width="40%">Points</th>
			</tr>
<?php
	$top = $DBH->prepare("SELECT * FROM users ORDER BY points DESC LIMIT 20");
	$top->execute();
	while($row = $top->fetch())
	{
?>

			<tr>
				<td width="10%"><center>
					<?php if($row['oauthp'] == "facebook") { ?>
					<img src="http://graph.facebook.com/<?php echo $row['fbusername']; ?>/picture">
					<?php } elseif($row['oauthp'] == "twitter") { ?>
					<img src="<?php echo getTwitterImage($row['twusername']); ?>">
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

</div><!--content-->

<?php
	include('temp/footer.php');
?>