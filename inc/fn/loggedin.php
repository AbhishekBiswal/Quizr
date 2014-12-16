<?php
	function loggedin()
	{
		global $loggedin;
		global $curUser;
		$loggedin = 0;
		if(isset($_SESSION['qp']))
		{
			$loggedin = 1;
			$curUser = $_SESSION['qp'];
		}
		if($loggedin == 1)
		{
			if((!isset($_SESSION['qu'])) || ($_SESSION['qu'] == NULL))
			{
				header('Location:/username.php');
				exit();
			}
		}
	}
	loggedin();

	function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
	  $connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
	  return $connection;
	}

	function getTwitterImage($twitteruser)
	{
		require_once("tw/twitteroauth.php"); //Path to twitteroauth library
		$notweets = 30;
		$consumerkey = "kYbSNE8R9ZwTbRCnZozQ";
		$consumersecret = "o5bAseJiUcQ3IsW5SPiXDl6WenPQ8YgYaunl4zLlg";
		$accesstoken = "240286080-d31MBLJYnvir6SnvrLIGXEo4W4H8whDErjjgtCgd";
		$accesstokensecret = "1nOxxLTfwm6f0m5C6ou7omFi1C4XvpPpCvIUf9GHE";
		  
		$connection = getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);

		$tweets = $connection->get("https://api.twitter.com/1.1/users/show.json?screen_name=$twitteruser");

		return $tweets->profile_image_url;
	}

?>