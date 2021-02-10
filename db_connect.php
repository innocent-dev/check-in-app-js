<?php 
	$username 		= "root";
	$password 		= "";
	$servername 	= "localhost";
	$databasename 	= "practice_1";

	//parameters : server, username, password, database
	$connection = mysqli_connect($servername, $username, $password, $databasename);

	// Check connection
	if (mysqli_connect_errno()) 
	{
		echo "failed to connect to database, check your database connection parameters"; 
		die;
	}

?>