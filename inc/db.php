<?php

	$server_type_pdo = $_SERVER['SERVER'];

	if($server_type_pdo == "local")
	{
		$host = "";
		$dbname = "";
		$seruser = "";
		$pass = "";	

	}
	else
	{
		$host = "";
		$dbname = "";
		$seruser = "";
		$pass = "";
	}

	try 
	{  
		# MySQL with PDO_MYSQL 
		global $DBH;
		$DBH = new PDO("mysql:host=$host;dbname=$dbname", $seruser, $pass);  
	}  
	catch(PDOException $e)
	{  
		    echo $e->getMessage();  
	}  

?>