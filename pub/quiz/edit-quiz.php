<?php
	session_start();
	include('fn/loggedin.php');
	if($loggedin == 0)
	{
		header('Location:/');
		exit();
	}

	$quizid = $_GET['id'];
	if(!$quizid)
	{
		header('Location:/');
		exit();
	}

	include_once('db.php');
	$check = $DBH->prepare("SELECT * FROM quizmeta WHERE id=? AND user=?");
	$check->execute(array($quizid,$curUser));
	if($check->rowCount() == 0)
	{
		header('Location:/');
		exit();
	}

	while($data = $check->fetch())
	{
		$qTitle = $data['title'];
		$qDesc = $data['qdesc'];
		$qCat = $data['cat'];
	}

	$pageName = "Create a new Quiz";
	include('temp/header.php');

?>
<div class="det-head">
		<h2>Edit Quiz</h2>
		<h3><?php echo $qTitle; ?></h3>
</div>

<div id="editquiz">
	<div class="quiz">
		<form class="create-quiz-det ajax withhelp" action="/ajax/create/editquiz.php">
			<p class="submitinfo"></p>
			<div><input type="text" name="title" placeholder="Title" value="<?php echo $qTitle; ?>"></div>
			<textarea name="desc" placeholder="Description Here (Optional)"><?php echo $qDesc; ?></textarea>

			<br>
			<input type="hidden" name="id" value="<?php echo $quizid; ?>">
			<p class="text-info">Select a Category:
			<select class="select-cat" name="cat">
				<option value="1" <?php if($qCat == 1) echo "selected"; ?>>General</option>
				<option value="2" <?php if($qCat == 2) echo "selected"; ?>>Technology</option>
				<option value="3" <?php if($qCat == 3) echo "selected"; ?>>Gaming</option>
				<option value="4" <?php if($qCat == 4) echo "selected"; ?>>Sports</option>
				<option value="5" <?php if($qCat == 5) echo "selected"; ?>>History</option>
				<option value="6" <?php if($qCat == 6) echo "selected"; ?>>Science</option>
				<option value="7" <?php if($qCat == 7) echo "selected"; ?>>Music</option>
				<option value="8" <?php if($qCat == 8) echo "selected"; ?>>Miscellaneous</option>
			</select>
			</p>
			
			<input type="submit" class="btn disp-block" value="UPDATE">
		</form>
	</div>
</div>

<?php
	include('temp/footer.php');
?>