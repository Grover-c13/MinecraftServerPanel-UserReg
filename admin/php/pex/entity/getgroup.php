<?php
require_once "../../../../php/common.php";
isAuth() or die("False: unauthorised");


if (!isset($_GET["name"]))
{
	die("false: missing name");
}

$sql = getPexMysql();
$query = "SELECT `parent` FROM `permissions_inheritance` WHERE `child` = '" . $sql->real_escape_string($_GET["name"]) . "' LIMIT 1;";
$result = $sql->query($query);

if ($sql->error)
{
	$error = $sql->error;
	$result->close();
	$sql->close();
	die("false: " . $error);
}

$row = $result->fetch_array(MYSQLI_ASSOC);

echo $row["parent"];
$result->close();
$sql->close();
?>