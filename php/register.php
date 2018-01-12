<?php
require_once "common.php";


session_start();
$id = $_SESSION['userid'];
if (!isset($_GET["data"])) die("false: no meta!"); 
//sql
$sql = getRegMySQL();

// get user
$result = $sql->query("SELECT * FROM `users` WHERE `id`='" . $sql->real_escape_string($id)  . "';");

if($result)
{
	if ($result->num_rows !== 0)
	{
		$array = $result->fetch_assoc();
		if ($array["status"] != "0")
		{
			$result->close();
			$sql->close();
			die("false: already registered");
		}
	}
}

$result->close();

// update status

$result = $sql->query("UPDATE `users` SET  `status` = 1,`meta`='" . $sql->real_escape_string($_GET['data']) . "' WHERE  `id` =  '" .  $sql->real_escape_string($id) . "';");
if($sql->error)
{
	$sql->close();
	die("false"); 
}
$sql->close();

$success = false;
try
{
	sendCommand("register id " . $id, $servers[0]);
	$success = true;
} catch (Exception $e) { 
	var_dump($e);
}

echo (($success) ? "true" : "false");



?>