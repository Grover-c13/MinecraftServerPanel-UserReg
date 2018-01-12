<?php
require_once "../../../../php/common.php";
isAuth() or die("False: unauthorised");

if(!isset($_GET['id'])) die('false: must provide id');
$sql = getPexMysql();


$query = "DELETE FROM `permissions` WHERE `id`=" . $sql->real_escape_string($_GET['id']) . ";";
$result = $sql->query($query);

if ($sql->error)
{
	$error = $sql->error;
	$sql->close();
	die("false: " . $error);
}


$sql->close();

echo "true";
sendCommand("pex reload");
$sql->close();

?>