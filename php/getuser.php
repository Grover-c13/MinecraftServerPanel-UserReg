<?php
$found = false;
$user = $_GET["user"];
$mysqli = new mysqli('localhost', 'register', 'QHucJLxyW4yw6XUq', 'register');
if ($mysqli->connect_error) die("false");
$result = $mysqli->query("SELECT * FROM `users` WHERE `name`='" . $user  . "';");

if($result)
{
	if ($result->num_rows !== 0)
	{
		$array = $result->fetch_assoc();
		$found = true;
		// store in session
		session_start();
		$_SESSION['userid'] = $array["id"];
		if ($array["status"] != "0")
		{
			echo "You are already registered";
			$result->close();
			$mysqli->close();
			die();
		}
	}
}

$result->close();
$mysqli->close();

if ($found) 
{
	echo "true";
} else {
	echo "No user record found! please join the server first";
}			
			
?>