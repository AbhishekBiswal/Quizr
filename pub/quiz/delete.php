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
		}

	$pageName = "Delete Quiz";
	include('temp/header.php');

?>

<div class="det-head">
	<h2><?php echo $quiz_title; ?></h2>
	<h3><?php echo $quiz_desc; ?></h3>
</div>

<div class="u-page-box ten columns content">
	<h3>Do you really want to delete the quiz titled "<?php echo $quiz_title; ?>"?</h3>
	<form class="ajax" action="/ajax/del.php">
		<p class="submitinfo"></p>
		<input type="hidden" name="confirm" value="1">
		<input type="hidden" name="id" value="<?php echo $quizID; ?>">
		<input type="submit" value="DELETE" class="btn btn-red">
	</form>
</div>


<?php
	include('temp/footer.php');
?>