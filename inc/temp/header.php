<!DOCTYPE html>
<html>
<!-- v0.1 23/12/12 ab -->
<head>
	<title><?php echo $pageName; ?> / Quizr</title>

	<meta name="description" content="Quizr is here to redefine how you've always thought about online quizzing - answering questions on Facebook pages has always been a pain, hasn't it? Quizr is an online platform where you can create quizzes, share them with your friends, and attempt other quizzes yourself.">
	<meta name="keywords" content="quiz,quizzing,quizr,create,play,tech,share">
	<meta name="robot" content="index,follow">
	<meta name="copyright" content="Copyright © 2012 Quizr. All Rights Reserved.">
	<meta name="language" content="English">

	<link href="/assets/css/grid.css" rel="stylesheet" type="text/css">
	<link href="/assets/css/style.css" rel="stylesheet" type="text/css">
	<link href="/assets/css/ab.css" rel="stylesheet" type="text/css">
	<?php
	if(getenv('HOST_ENV') == "dotme")
	{
		echo "<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>";
	}
	?>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
	<script src="/assets/js/main.js"></script>
	<script src="/assets/js/livequery.js"></script>
	<?php if(@$page == "questionslist") echo '<script src="/assets/js/jqueryui.js"></script>'; ?>
</head>
<body>

<div id="dashbar">
	<div class="container">
		<ul class="nav columns sixteen">
			<li><a href="/">Home</a></li>
			<li><a href="/browse/">Browse</a></li>
			<li><a href="/create.php">Create</a></li>
			<li><a href="/leaderboard/">Leaderboard</a></li>
			<li><a href="/search/">Search</a></li>
		<?php
			if($loggedin == 1)
			{
		?>
			<li class="dropit text-right float-right"><a class="dropit" href="#"><?php echo $_SESSION['qu']; ?></a>
				<ul class="dropdown">
					<li><a href="/<?php echo $_SESSION['qu']; ?>/">Profile</a></li>
					<li><a href="/settings/profile.php">Settings</a></li>
					<li><a href="/logout.php">Logout</a></li>
				</ul>
			</li>
		<?php		
			}
			else
			{
		?>
			
		<?php		
			}
		?>
		</ul>
	</div>

</div>

<header id="header">
<div class="container">
	<div class="header-logo">
		<a href="/"><img src="/assets/img/ablogo.png"></a>
	</div>
</div><!--container-->
</header>

<div class="container" id="wrap">