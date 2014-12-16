<?php
	session_start();
	include('fn/loggedin.php');
	if($loggedin == 0)
	{
		header('Location:/');
		exit();
	}
	/*Reorder Questions*/
	$page = "reorderquestions";
	$qid = $_GET['id'];
	if(!$qid)
	{
		include('404.php');
		exit();
	}

	include('db.php');
	$check = $DBH->prepare("SELECT * FROM quizmeta WHERE id=? AND user=?");
	$check->execute(array($qid,$curUser));
	if($check->rowCount() == 0)
	{
		include('404.php');
		exit();
	}
	// loading quizmeta:
	while($row = $check->fetch())
	{
		$qID = $row['id'];
		$qQuestions = $row['questions'];
		$qTitle = $row['title'];
		$qDesc = $row['qdesc'];
		$qUser = $row['user'];
	}

	$load = $DBH->prepare("SELECT * FROM questions WHERE qid=? ORDER BY seq ASC");
	$load->execute(array($qID));
	$noQuestions = 0;
	if($load->rowCount() == 0)
	{
		$noQuestions = 1;
	}

	$page = "questionslist";
	$pageName = $qTitle;
	include('temp/header.php');

?>

<div class="page-head">
	<h2><?php echo $qTitle; ?></h2>
	<h3><?php echo $qDesc; ?></h3>
</div>

<div class="content columns eight">

	<?php
		if($noQuestions == 1)
		{
	?>
		<p class="grayinfo">Add Some Questions First.</p>
	<?php
		}
		else
		{
	?>
	<div id="list" class="questions-list">
		<div id="response" class="submitinfo"></div>

		<ul>
			<?php
				while($row = $load->fetch())
				{
			?>
				<li id="arrayorder_<?php echo $row['id'];?>">
					<span class="question"><?php echo $row['question']; ?></span>
					<span><a href="/quiz/edit.php?id=<?php echo $row['id']; ?>">edit</a> <a id="<?php echo $row['id']; ?>" href="#" class="del-question" data-qid="<?php echo $qID; ?>">delete</a></span>
				</li>
			<?php		
				}
			?>
		</ul>

	</div>

	<?php		
		}
	?>

</div>

<div class="columns four sidebar float-right">

	<div class="hintbox helpbox">
		Drag the questions to reorder them.
	</div>

</div>

<?php
	include('temp/footer.php');
?>