<?php

	session_start();

	require('twitteroauth.php');

	// The TwitterOAuth instance  
	$twitteroauth = new TwitterOAuth('kYbSNE8R9ZwTbRCnZozQ', 'o5bAseJiUcQ3IsW5SPiXDl6WenPQ8YgYaunl4zLlg');  
	// Requesting authentication tokens, the parameter is the URL we will be redirected to  
	if($_SERVER['SERVER'] == "local")
	{
		$request_token = $twitteroauth->getRequestToken('http://quizr.local/tw/twitter_oauth.php');
	}
	else
	{
		$request_token = $twitteroauth->getRequestToken('http://quizr.me/tw/twitter_oauth.php');
	}

	// Saving them into the session  
	$_SESSION['oauth_token'] = $request_token['oauth_token'];  
	$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];  
	//echo $_SESSION['oauth_token_secret'];
	//exit();
	// If everything goes well..  
	if($twitteroauth->http_code==200){  
	    // Let's generate the URL and redirect  
	    $url = $twitteroauth->getAuthorizeURL($request_token['oauth_token']); 
	    header('Location: '. $url); 
	} else { 
	    // It's a bad idea to kill the script, but we've got to know when there's an error.  
	    die('Something wrong happened.');  
	}

?>