<?php
require_once "../../../../php/common.php";
isAuth() or die("False: unauthorised");

if(!isset($_GET['name'])) die('false: must provide name');
$sql = getPexMysql();


$query = "SELECT * FROM `permissions` WHERE `name`='" . $sql->real_escape_string($_GET['name']) . "' AND `permission`='';";
$result = $sql->query($query);

if($result->num_rows == 1)
{
	$result->close();
	$sql->close();
	die("false: already have blank entry");
}

$result->close();



$query =  "INSERT INTO `permissions` (`name`, `type`, `permission`, `world`, `value`) VALUES ('" . $sql->real_escape_string($_GET['name']) . "', 0, '', '', '');";
$result = $sql->query($query);
if ($sql->error)
{
	$error = $sql->error;
	$sql->close();
	die("false: " . $error);
}

echo $sql->insert_id;
$sql->close();
//sendCommand("pex reload");

?>