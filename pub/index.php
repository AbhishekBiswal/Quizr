<?php
	session_start();
	include('fn/loggedin.php');
	if($loggedin == 1)
	{
		header('Location:/dash.php');
		exit();
	}
	$pageName = "Home";
	include('temp/header.php');
	@$key = $_GET['beta_key'];
	$betaa = 0;
	if(($key == "betausers") || ($key == "hackernews"))
	{
		$betaa = 1;
	}
?>

<div class="det-head"><h2>Welcome to <span class="lblue">Quizr</span></h2></div>
<div class="main homepage">
<div class="u-page-box">

	<div id="quizr-dict">
	<div id="quizr-dict" class="quizr-dict">
		<h2>[<strong>kwiz</strong>-<strong>zer</strong>]</h2>
		<!-- <div class="pron">"qui-zer"</div> -->
		<div class="pron">noun</div>
		<div class="desc">An online quizzing platform that's just handcrafted for the modern quizzer. <br /><a href="http://quizr.me/about/" target="_blank">Here</a>'s how.</div>
	</div></div>

<br>

<div class="clear"></div>


		
		<div class="login-box">
			<h1>Join In:</h1>
			<div class="columns eight">
				<a href="/fb/fbauth.php" class="login-btn login-fb float-right">Facebook</a>
			</div>
			<div class="columns eight">
				<a href="/tw/twitter_login.php" class="login-btn login-twitter float-left">Twitter</a>
			</div>
		</div>
		<div class="clear"></div>

		<div class="video-box">
			<center>
				<iframe src="http://player.vimeo.com/video/68785494?title=0&amp;byline=0&amp;portrait=0" width="720" height="405" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
			</center>
		</div>
		<div class="clear"></div>

		<div class="divider"></div>


	<div class="hp-tour">
		<div class="column one-third">
			<center><img src="/assets/img/quizr-hp-browse.png"></center>
			<h3>Explore.</h3>
		</div>
		<div class="column one-third">
			<center><img src="/assets/img/quizr-hp-play.png"></center>
			<h3>Play.</h3>
		</div>
		<div class="column one-third">
			<center><img src="/assets/img/quizr-hp-create.png"><center>
			<h3>Create.</h3>
		</div>
	</div>
	<div class="divider"></div><br>
	<div>
		<center>
			<a href='http://betali.st/startups/quizr' title='Visit our startup post on Beta List'><img border='0' src='http://betali.st/assets/badges/rectangle_v1.png' /></a>
		</center>
	</div>

</div></div><!--main-->

<div class="clear"></div>

<script type="text/javascript">
	document.write('</div>');
</script>

<?php
	include('temp/footer.php');
?>