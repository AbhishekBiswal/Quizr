<?php

	session_start();

	require('twitteroauth.php');

	if(!empty($_GET['oauth_verifier']) && !empty($_SESSION['oauth_token']) && !empty($_SESSION['oauth_token_secret'])){  
	    // We've got everything we need 

		// TwitterOAuth instance, with two new parameters we got in twitter_login.php  
		$twitteroauth = new TwitterOAuth('kYbSNE8R9ZwTbRCnZozQ', 'o5bAseJiUcQ3IsW5SPiXDl6WenPQ8YgYaunl4zLlg', $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);  
		// Let's request the access token  
		$access_token = $twitteroauth->getAccessToken($_GET['oauth_verifier']); 
		// Save it in a session var 
		$_SESSION['access_token'] = $access_token; 
		// Let's get the user's info 
		$user_info = $twitteroauth->get('account/verify_credentials'); 
		// Print user's info
		//print_r($user_info);  

		include('db.php');

		if(isset($user_info->error)){  
		    // Something's wrong, go back to square 1  
		    header('Location:/tw/twitter_login.php'); 
		} else { 
		    // Let's find the user by its ID  
		    $query = $DBH->prepare("SELECT * FROM users WHERE oauthp = 'twitter' AND oauthid = ?");
		    $query->execute(array($user_info->id));  
		    if($query->rowCount() == 0)
		    {  
		        $query = $DBH->prepare("INSERT INTO users (oauthp, oauthid, twusername, fullname) VALUES (?,?,?,?)");
		        $query->execute(array('twitter',$user_info->id,$user_info->screen_name,$user_info->name));
		        /* 'twitter', {$user_info->id}, '{$user_info->screen_name}', '{$access_token['oauth_token']}', '{$access_token['oauth_token_secret']}' */
		       /* $query = mysql_query("SELECT * FROM users WHERE id = " . mysql_insert_id());  
		        $result = mysql_fetch_array($query); */ 

		    }
		    else {  
		        // Update the tokens  
		        
		    } 

		    $query = $DBH->prepare("SELECT * FROM users WHERE oauthp = 'twitter' AND oauthid = ?");
		     $query->execute(array($user_info->id));
		    while($row = $query->fetch())
		    {
		    	$_SESSION['qp'] = $row['id'];
		    	$_SESSION['qu'] = $row['username'];
		    }
		

		if($_SESSION['qu'] == NULL)
		{
			echo "end of script";
			header('Location:/username.php');
			exit();
		}
		else
		{
			header('Location:/');
			exit();
		}
		    
		}  // db

	}
	else {  
	    // Something's missing, go back to square 1  
	    header('Location:/tw/twitter_login.php');  
	}  

?>