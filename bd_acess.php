<?php	
    $servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "mydb";

	// Create connection
	$conexao = mysqli_connect($servername, $username, $password, $dbname);
	mysqli_set_charset($conexao,"utf8");
	
	// Check connection
	if (!$conexao) 
		{
    	die("Connection failed: " . mysqli_connect_error());
		};			
?>