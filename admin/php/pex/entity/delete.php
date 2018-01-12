<?php
require_once "../../../../php/common.php";
isAuth() or die("False: unauthorised");

if (!isset($_GET['id'])) die("false: no id");

$sql = getPexMysql();


$query =  "DELETE FROM `permissions_entity` WHERE `id` ='" . $sql->real_escape_string($_GET["id"]) . "';";


$sql->query($query);
if ($sql->error)
{
	$error = $sql->error;
	$sql->close();
	die("false: " . $error);
}

echo "true";
$sql->close();
sendCommand("pex reload");


?>