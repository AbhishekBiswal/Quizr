<?php
	session_start();
	include('fn/loggedin.php');
	include_once('fn/loadquiz.php');
	$qid = $_GET['id'];
	if(!$qid)
	{
		include('404.php');
		exit();
	}

	include_once('fn/browse.php');
	include('db.php');
	$check = $DBH->prepare("SELECT * FROM quizmeta WHERE id=?");
	$check->execute(array($qid));

	if($check->rowCount() == 0)
	{
		include('404.php');
		exit();
	}

	//load vars:
	while($row = $check->fetch())
	{
		$qid = $row['id']; // quizid
		$qTitle = $row['title'];
		$qDesc = $row['qdesc'];
		$qUser = $row['user'];
		$qQuestions = $row['questions'];
		$qPlays = $row['plays'];
		$qPub = $row['pub'];
		$qCat = $row['cat'];
	}

	$thegod = 0;
	if($curUser == $qUser)
	{
		$thegod = 1;
	}

	include_once('fn/loaduser.php');
	$pageName = $qTitle . " - Quizr";
	include('temp/header.php');

	/* Check if user liked this quiz / not */
	$liked = 0; // for loggedin == 0
	if($loggedin == 1)
	{
		$liked = liked($qid,$curUser,$DBH);
	}

?>

<div class="det-head">
	<h2><?php echo $qTitle; ?><span class="quizby">By <a href="/<?php echo loadUName($qUser,$DBH); ?>/"><?php echo loadUser($qUser,$DBH); ?></a></span></h2>
	<div class="info-boxes">
		<div class="info-box">
			<span class="one"><?php echo $qQuestions; ?></span>
			<span class="two">questions</span>
		</div>
		<div class="info-box">
			<span class="one"><?php echo $qPlays; ?></span>
			<span class="two">plays</span>
		</div>
		<div class="info-box">
			<span class="one"><a href="/browse.php?cat=<?php echo $qCat; ?>"><?php echo checkCat($qCat); ?></a></span>
			<span class="two">Quiz</span>
		</div>
	</div>
</div>

<div class="promote-box hide">
	<h3>Promote.</h3>
	<p>Request or Challenge an existing user to play this quiz. Enter the username of an existing user to send a request.</p><br>
	<center>
	<form class="ajax" action="/ajax/promote-sub.php">
	<p class="submitinfo"></p>
	<input id="promote-input" type="text" name="username" placeholder="Username">
	<div class="area-points">
		<span class="points-big tred">-2</span>
		<p class="grayinfo">For Promoting this Quiz.</p>
	</div><br>
	<input type="hidden" name="user" value="<?php echo $_SESSION['qp']; ?>">
	<input type="hidden" name="quiz" value="<?php echo $qid; ?>">
	<input type="submit" class="btn" value="Promote">
	</form>
	</center>
</div>

<div class="content u-page-box nine columns">


	<div>
		<p class="grayinfo"><?php echo $qDesc; ?></p>
	</div>
	<a href="/play/?id=<?php echo $qid; ?>" class="btn btn-blue">PLAY</a>
	<!-- <a id="fav-btn" data-id="" class="btn btn-grey">Favourite</a>
	<div class="hidden-quiz-area fav-btn-area"></div> -->


	<div class="quiz-lb">
		<!--quiz-leaderboard-->

		<table><tbody>
		<tr class="lb-header"><td width="100%" colspan="2">Leaderboard</td></tr>

		<?php
			$quizLB = $DBH->prepare("SELECT * FROM users WHERE id IN(SELECT user FROM played WHERE qid=? AND playedtill=? AND skipped=0 ORDER BY TIMESTAMPDIFF(SECOND,stopped,started) ASC) LIMIT 10");
			$quizLB->execute(array($qid,$qQuestions));
			if($quizLB->rowCount() == 0)
			{
				echo '<tr><td><p class="grayinfo">Nothing Here.</p></td></tr>';
			}
			else
			{

				while($lbrow = $quizLB->fetch())
				{
		?>
				<tr>
					<td width="30%"><center>
					<?php if($lbrow['oauthp'] == "facebook") { ?>
					<img src="http://graph.facebook.com/<?php echo $lbrow['fbusername']; ?>/picture">
					<?php } elseif($row['oauthp'] == "twitter") { ?>
					<img src="<?php
					$twitterImageURL = $lbrow['twusername'];
					echo getTwitterImage($twitterImageURL);
					?>">
					<?php } ?>
					</center></td>
					<td width="70%"><a href="/<?php echo $lbrow['username']; ?>/"><?php echo $lbrow['fullname']; ?></a></td>
				</tr>
		<?php			
				}
			}
		?>

		</tbody></table>

	</div>


</div>

<div class="admin-tools columns five"><center>

		<div class="quiz-opts">
			<a id="<?php echo $qid; ?>" class="like-btn btn btn-small <?php if($liked==1) echo "btn-blue liked"; ?>">
				<?php
				if($liked==1) echo "Liked";
				else echo "Like";
				?>
			</a>
		</div>

		<?php

		if($thegod == 1)
		{
		?>
		<div class="u-page-header">Admin Tools:</div>
		<a href="#" class="promote-open btn btn-small">Promote</a>
		<a class="btn btn-small" href="/quiz/edit-quiz.php?id=<?php echo $qid; ?>">Edit Quiz</a><br>
		<a class="btn btn-small" href="/quiz/add.php?id=<?php echo $qid; ?>">Add Questions</a><br>
		<a class="btn btn-small" href="/quiz/questions.php?id=<?php echo $qid; ?>">Edit Questions</a><br>
		<a class="btn btn-small btn-red" href="/quiz/delete.php?id=<?php echo $qid; ?>">DELETE</a><br> 

		<?php if($qPub == 0) { ?> <a class="btn btn-small btn-blue" href="/quiz/pub.php?id=<?php echo $qid; ?>">Publish</a> <?php } ?>

		<?php
		}

		?>

</center></div>
<link rel="stylesheet" type="text/css" href="/assets/css/autocomplete.css">
<script src="/assets/js/jqueryui-autocomplete.js"></script>
<script type="text/javascript">
	$("#promote-input").autocomplete({source: "/ajax/promote.php", minLength: 3});
</script>

<?php
	include('temp/footer.php');
?>