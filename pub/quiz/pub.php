<?php

	session_start();
	include('fn/loggedin.php');
	if($loggedin == 0)
	{
		header('Location:/');
		exit();
	}

// pub page. to publish a quiz.

	$quizID = $_GET['id'];
	@$conf = $_GET['confirm'];
	if(!$quizID)
	{
		header('Location:/');
		exit();
	}

	include('db.php');
		$loadQuiz = $DBH->prepare("SELECT * FROM quizmeta WHERE id=? AND user=?");
		$loadQuiz->execute(array($quizID,$curUser));
		if($loadQuiz->rowCount() == 0)
		{
			include('404.php');
			exit();
		}

		while($row = $loadQuiz->fetch())
		{
			$quiz_title = $row['title'];
			$quiz_desc = $row['qdesc'];
			$quiz_questions = $row['questions'];
		}

	if(($conf == 1) && ($quiz_questions != 0))
	{
		$delQuiz = $DBH->prepare("UPDATE quizmeta SET pub=1 WHERE id=?");
		$delQuiz->execute(array($quizID));
		header('Location:/q/?id='.$quizID);
		exit();
	}

	$pageName = "Make Quiz public";
	include('temp/header.php');

?>

<div class="det-head">
	<h2><?php echo $quiz_title; ?></h2>
	<h3><?php echo $quiz_desc; ?></h3>
</div>

<div class="u-page-box ten columns content">
<?php if($quiz_questions == 0) { ?>
	<h3>Please add some questions before publishing the quiz.</h3>
	<a href="/quiz/add.php?id=<?php echo $quizID; ?>" class="btn">Add Questions</a>
<?php } else { ?>
	<h3>Do you really want to make the quiz titled "<?php echo $quiz_title; ?>" public?</h3>
	<a href="/quiz/pub.php?id=<?php echo $quizID; ?>&confirm=1" class="btn">Do it!</a>
<?php } ?>
</div>


<?php
	include('temp/footer.php');
?>