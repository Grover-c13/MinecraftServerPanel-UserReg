<?php

function getUserByIp()
{
	$ip = $_SERVER['REMOTE_ADDR'];
	$mysqli = new mysqli('localhost', 'register', 'QHucJLxyW4yw6XUq', 'register');
	if ($mysqli->connect_error) return false;
	$result = $mysqli->query("SELECT * FROM `users` WHERE `ip`='" . $ip  . "';");
	$name = false;
	if($result)
	{
  
    if ($result->num_rows !== 0)
    {
      $array = $result->fetch_assoc();
      $name = $array["name"];
      session_start();
      $_SESSION['userid'] = $array["id"];
     }
	}

	$result->close();
	$mysqli->close();
	return $name;
				
}	
	
?>