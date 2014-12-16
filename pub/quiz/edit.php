<?php
	session_start();
	$curUser = $_SESSION['qp'];
	include('fn/loggedin.php');
	if($loggedin == 0)
	{
		header('Location:/');
		exit();
	}
	$questionid = $_GET['id'];
	if(!$questionid)
	{
		header('Location:/create.php');
		exit();
	}

	include('db.php');
	$checkid = $DBH->prepare("SELECT * FROM questions WHERE id=? AND user=?");
	$checkid->execute(array($questionid,$curUser));
	if($checkid->rowCount() == 0)
	{
		include('404.php');
		exit();
	}

	while($row = $checkid->fetch())
	{
		$questionid = $row['id'];
		$question = $row['question'];
		$qdesc = $row['qdesc'];
		$answer = $row['answer'];
		$answer2 = $row['answer2'];
		$answer3 = $row['answer3'];
		//$hasHint = $row['hashint'];
		$hint = $row['hint'];
		$qImage = $row['image'];
		$qPlus = $row['plus'];
		$qid = $row['qid'];
	}
		
	$pageName = "Edit a Question - Quizr";
	include('temp/header.php');
?>

<header class="page-head">
	<hgroup>
		<h2>Edit Question:</h2>
	</hgroup>
</header>

<div class="content columns ten">

	<form class="ajax" action="edit-sub.php">
	<p class="submitinfo"></p>
		<input type="hidden" name="id" value="<?php echo $questionid; ?>">
		<input type="text" name="question" placeholder="Question" value="<?php echo $question; ?>"><br>
		<a class="add-image btn btn-small"><?php if($qImage == "") { ?>Add Image<?php } else { ?>Remove Image<?php } ?></a>
		<div class="add-image <?php if($qImage == "") { ?>hide<?php } ?>">
			<p class="disp-block text-info">The URL of the Image to be included in the question:</p>
			<input class="image" type="text" name="q-image" placeholder="Image URL" value="<?php echo $qImage; ?>">
		</div><br><br>
		<textarea name="q-desc" placeholder="Description / More Info"><?php echo $qdesc; ?></textarea><br>
		<input type="text" class="" name="answer" placeholder="Answer" value="<?php echo $answer; ?>">

		<!-- <a id="secondanswer" class="add-answer btn btn-small secondanswer">Add Another Answer</a> -->
		<div id="secondanswer" class="">
			<input type="text" class="" name="answertwo" placeholder="Second Answer" value="<?php echo $answer2; ?>">
			<!-- <a id="thirdanswer" class="add-answer btn btn-small">Add Another Answer</a> -->
		</div>
		<div id="thirdanswer" class="">
			<input type="text" class="" name="answerthree" placeholder="Third Answer" value="<?php echo $answer3; ?>">
		</div>

		<input type="hidden" name="q-id" value="<?php echo $questionid; ?>">
		<a class="add-hint btn btn-small"><?php if($hint == "") { ?>Add Hint<?php } else { ?>Remove Hint<?php } ?></a>
		<div class="add-hint <?php if($hint == "") { ?>hide<?php } ?>">
			<input class="small" type="text" name="q-hint" placeholder="Hint" value="<?php echo $hint; ?>">
		</div>
		<p class="text-info">Select difficulty for question :
		<select class="difficulty" name="plus">
			<option value="easy" <?php if($qPlus == 4) echo "selected"; ?>>Easy</option>
			<option value="moderate" <?php if($qPlus == 6) echo "selected"; ?>>Moderate</option>
			<option value="hard" <?php if($qPlus == 10) echo "selected"; ?>>Hard</option>
		</select>
		</p>
		<div id="form-buttons">
			<button class="btn" type="submit" name="add-another">Update</button>
		</div>
	</form>

</div>

<div class="columns five sidebar">

	<h3>Questions:</h3>
	<ul class="edit-ques-list">
	<?php
		include_once('fn/loadquiz.php');
		questionsList($qid,$curUser,$DBH);
	?>
	</ul>

</div>

<?php
	include('temp/footer.php');
?>