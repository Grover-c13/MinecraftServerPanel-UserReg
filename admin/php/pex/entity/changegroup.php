<?php
require_once "../../../../php/common.php";
isAuth() or die("False: unauthorised");


if (!isset($_GET["name"]))
{
	die("false: missing name");
}

if (!isset($_GET["group"]))
{
	die("false: missing group");
}

$sql = getPexMysql();


$query = "UPDATE `permissions_inheritance` SET `parent` = '" . $sql->real_escape_string($_GET["group"])  . "' WHERE `child` = '" . $sql->real_escape_string($_GET["name"]) . "' LIMIT 1;";
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