<?php

function getDatabaseConnection()
{
	$servername = "db";
	$username = "root";
	$password = "root";
	$database = "products";

	//Create mysqli connection
	$conn = new mysqli($servername, $username, $password);

	//Check mysqli connection
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}

	//Select database
	mysqli_select_db($conn, $database) or die("Could not select database!");
	
	return $conn;
}

?>