<?php
	/* edit a question - backend copied from add-sub.php */
	session_start();
	$curUser = $_SESSION['qp'];
	include('fn/loggedin.php');
	if($loggedin == 0)
	{
		header('Location:/');
		exit();
	}
	// form vars:
	$qid = $_POST['q-id']; // quiz id.
	$qQuestion = $_POST['question'];
	$qAnswer = $_POST['answer'];
	$qAnswer2 = $_POST['answertwo'];
	$qAnswer3 = $_POST['answerthree'];
	$hint = $_POST['q-hint'];
	$qDesc = $_POST['q-desc'];
	$qImage = $_POST['q-image'];
	$qPlus = $_POST['plus'];
	$questionid = $_POST['id'];

	$qQuestion = htmlentities($qQuestion);
	$qAnswer = htmlentities($qAnswer);
	$qAnswer2 = htmlentities($qAnswer2);
	$qAnswer3 = htmlentities($qAnswer3);
	$hint = htmlentities($hint);
	$qDesc = htmlentities($qDesc);
	$qImage = htmlentities($qImage);
	$qPlus = htmlentities($qPlus);
	$questionid = htmlentities($questionid);
	//$qMinus = $_POST['minus'];
	//$qsecAnswer = $_POST['sec-answer'];

	$qAnswer = str_replace(" ","",$qAnswer);

	if($hint == NULL)
	{
		$hasHint = 0;
	}
	else
	{
		$hasHint = 1;
	}

	$qPlusp = 0;
	if($qPlus == "easy") $qPlusp = 4;
	elseif($qPlus == "moderate") $qPlusp = 6;
	elseif($qPlus == "hard") $qPlusp = 10;
	else exit();

	if(!$qAnswer)
	{
			echo "Error! {Ans}";
			exit();
	}

	/*if(($qPlus<2) || ($qPlus>10))
	{
		echo "Plus Points invalid! The Value must be between 2 and 10";
		exit();
	}
	if(($qMinus<2) || ($qMinus>10))
	{
		echo "Minus Points invalid! The Value must be between 2 and 10";
		exit();
	}
*/	

	include_once('validate/do.php');
	$validator = new Validator();
	//$validator->isValid($qImage,'url');
	if($qImage != NULL)
	{
		if($validator->isValid($qImage,'url') == false)
		{
			echo "The Image URL is invalid";
			exit();
		}
	}
	
	include('db.php');
	$checkQid = $DBH->prepare("SELECT * FROM questions WHERE id=? AND user=?");
	$checkQid->execute(array($qid, $curUser));
	if($checkQid->rowCount() == 0)
	{
		echo "Error! Please try again later. $qid";
		exit();
	}
	//echo $seq;

	$qAnswer = strtolower($qAnswer);
	$qAnswer = str_replace(" ","",$qAnswer);

	
	/*$testArr = array($qQuestion,$qAnswer,$hint,$qDesc,$qImage,$qPlusp,$questionid,$qAnswer2,$qAnswer3);
	print_r($testArr);
	exit();*/

	// everything's alright
	$insert = $DBH->prepare("UPDATE questions SET question=?, answer=?, hint=?, qdesc=?, image=?, plus=?, answer2=?, answer3=? WHERE id=?");
	$insert->execute(array($qQuestion,$qAnswer,$hint,$qDesc,$qImage,$qPlusp,$qAnswer2,$qAnswer3,$questionid));
	//done {update}

	echo "Updated.";
	//echo '<script>location.reload();</script>';

	// done. working rev. 06/8/12
?>