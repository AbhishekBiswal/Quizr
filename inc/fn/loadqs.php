<?php
	include_once('db.php');

	function quizList($fetch)
	{
		// the loop
		if($fetch->rowCount() == 0)
		{
			echo '<p class="grayinfo">Nothing Here.</p>';
		}
		else
		{
			while($row = $fetch->fetch())
			{
				$qlistId = $row['id'];
				$qlistTitle = $row['title'];
				$qlistQuestions = $row['questions'];
			}
?>
			<li><span class="grey"><?php echo $qlistQuestions; ?> Questions</span> <a href="/"><?php echo $qlistTitle; ?></a></li>
<?php
		}
	}

	function loadQuizlist($userid, $DBH) // created by a user
	{
		$fetch = $DBH->prepare("SELECT * FROM quizmeta WHERE user=?");
		$fetch->execute(array($userid));
		quizList($fetch);
	}

?>