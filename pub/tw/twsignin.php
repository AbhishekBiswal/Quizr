<?php

	if(!empty($_GET['oauth_verifier']) && !empty($_SESSION['oauth_token']) && !empty($_SESSION['oauth_token_secret'])){  
	    // We've got everything we need 


	}
	else {  
	    // Something's missing, go back to square 1  
	    header('Location:twauth.php');
	}

?>