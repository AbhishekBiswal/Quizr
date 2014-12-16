<?php
# We require the library
require("fbauth/facebook.php");

# Creating the facebook object
$facebook = new Facebook(array(
    'appId'  => '297881950295796',
    'secret' => '3c0cd222495330d22731aa461527c9db',
    'cookie' => true
));

# Let's see if we have an active session
$session = $facebook->getSession();

if(!empty($session)) {
    # Active session, let's try getting the user id (getUser()) and user info (api->('/me'))
    try{
        $uid = $facebook->getUser();
        $user = $facebook->api('/me');
    } catch (Exception $e){}

    if(!empty($user)){
        # User info ok? Let's print it (Here we will be adding the login and registering routines)
        print_r($user);
    } else {
        # For testing purposes, if there was an error, let's kill the script
        die("There was an error.");
    }
} else {
    # There's no active session, let's generate one
    $login_url = $facebook->getLoginUrl();
    header("Location: ".$login_url);
}
?>