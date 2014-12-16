<?php
	/*Play a Quiz*/
	$qid = $_GET['id'];
	session_start();
	include('fn/loggedin.php');
	if($loggedin == 0)
	{
		header('Location:/');
		exit();
	}

	if(!$qid)
	{
		include('404.php');
		exit();
	}

	include('db.php');
	$check = $DBH->prepare("SELECT * FROM quizmeta WHERE id=?");
	$check->execute(array($qid));
	if($check->rowCount() == 0)
	{
		include('404.php');
		exit();
	}
	// load quizmeta
	while($row = $check->fetch())
	{
		$qQuestions = $row['questions'];
		$qTitle = $row['title'];
		$qDesc = $row['qdesc'];
		$qUser = $row['user'];
		$qPlays = $row['plays'];
	}

	include_once('fn/loadquiz.php');
	$plusPoints = $qPlays+1;
	if($plusPoints%10 == 0)
	{
		include_once('fn/points.php');
		addPoints($qUser,5,$DBH);
		$msg = "+5 for 10+ Views on the quiz '$qTitle'.";
		notify($qUser,$msg,$DBH);
	}

	$thegod = 0;
	if($qUser == $curUser)
	{
		$thegod = 1;
	}

	/*Todo - check if user is the current user. dont' allow*/

		$checkPlay = $DBH->prepare("SELECT * FROM played WHERE qid=? AND user=?");
		$checkPlay->execute(array($qid,$curUser));
		if($checkPlay->rowCount() == 0)
		{
			$questionTostart = 1;
			if($thegod == 0)
			{
				$createRecord = $DBH->prepare("INSERT INTO played(qid,user,playedtill, started) VALUES(?,?,?, NOW())");
				$createRecord->execute(array($qid,$curUser,0));
				$addPlays = $DBH->prepare("UPDATE quizmeta SET plays=plays+1 WHERE id=?");

				$addPlays->execute(array($qid));
			}
		}
		else
		{
			while($row = $checkPlay->fetch())
			{
				$playedTill = $row['playedtill'];
			}
			$questionTostart = $playedTill+1;
			if($questionTostart > $qQuestions)
			{
				$checkTime = $DBH->prepare("SELECT stopped FROM played WHERE qid=? AND user=?");
				$checkTime->execute(array($qid,$curUser));
				while($checkRow = $checkTime->fetch())
				{
					$stopTime = $checkRow['stopped'];
				}
				if($stopTime == NULL)
				{
					$addTime = $DBH->prepare("UPDATE played SET stopped=NOW() WHERE qid=? AND user=?");
					$addTime->execute(array($qid,$curUser));
				}
				header('Location:/q/' . $qid);
				exit();
			}
		}
	


	$pageName = $qTitle . " - Quizr";
	include('temp/header.php');

?>

<div class="page-head">
	<h2><?php echo $qTitle; ?></h2>
	<h3><?php echo $qDesc; ?></h3>
</div>

<?php
	//load question:
	$load = $DBH->prepare("SELECT * FROM questions WHERE qid=? AND seq=?");
	$load->execute(array($qid,$questionTostart));
	$noquestions = 0;
	if($load->rowCount() == 0)
	{
		$noquestions = 1;
	}
	else
	{
		while($data = $load->fetch())
		{
			$questionID = $data['id'];
			$qQuestion = $data['question'];
			$qDesc = $data['qdesc'];
			$qSeq = $data['seq'];
			$qImage = $data['image'];
			$qPlus = $data['plus'];
			$qHint = $data['hint'];
		}
		$hintTaken = 0;
		$checkHintTaken = $DBH->prepare("SELECT id FROM hints WHERE uid=? AND quid=?");
		$checkHintTaken->execute(array($curUser,$questionID));
		if($checkHintTaken->rowCount() == 1)
		{
			$hintTaken = 1;
		}
	}
?>
<div class="content play-quiz columns eleven u-page-box">
<input type="hidden" value="<?php echo $questionID; ?>" class="q">
<?php
	if($noquestions == 1)
	{
		echo '<p class="grayinfo">No Questions are added yet.</p></div>';
		include('temp/footer.php');
		exit();
	}
?>

<div id="quiz-area">

	<div class="question-no">
		<?php echo $qSeq . ' <span>/</span> ' . $qQuestions; ?>
	</div>
	
	<form id="play-quiz-form" class="ajax" action="sub.php">
		<p class="submitinfo"></p>
	<div class="quiz-area-in">
		<span class="question"><?php echo $qQuestion; ?></span>
		<?php if($qDesc != NULL) { echo $qDesc; } ?>
		<?php
			if($qImage != NULL)
			{
				echo '<br><img class="q-play-image" src="' . $qImage . '"><br>';
			}
		?>
		<br><br><input type="text" name="ans" placeholder="Answer"><br>
		<input type="hidden" name="q-id" value="<?php echo $questionID; ?>">
		<input type="hidden" name="seq" value="<?php echo $qSeq; ?>">
		<input type="hidden" name="qid" value="<?php echo $qid; ?>">
	</div>
		<input type="submit" class="btn btn-blue" value="Try">
		<a class="skip-btn btn" href="#">Skip</a>
	</form>

</div>

</div><!--content-->

<div class="sidebar columns four">

	<div class="area-points">
		<span class="points-big disp-block">+<?php echo $qPlus; ?></span>
		<span class="points-big-h">Points</span>
	</div>
	<div class="divider"></div>
	<div class="area-hint">
		<?php
		if($qHint != NULL)
		{
			if($hintTaken == 1){
		?>
			<span class="points-big-h">HINT</span>
			<p class="hintbox"><?php echo $qHint; ?></p>

		<?php
			}
			else
			{
		?>
			<center><a id="<?php echo $questionID; ?>" class="btn disp-block view-hint-button">View Hint</a></center>
		<?php
			}
		}
		else {
		?>
			<span class="points-big-h">No Hint</span>
		<?php } ?>
	</div>
	<div class="divider"></div>
	<div class="area-hint-minus">
		<div class="area-points">
			<span class="points-big red">-2</span>
			<span class="points-big-h">For The Hint</span>
		</div>
	</div>

</div>

<?php
	include('temp/footer.php');
?>