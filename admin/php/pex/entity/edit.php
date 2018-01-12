<?php
require_once "../../../../php/common.php";
isAuth() or die("False: unauthorised");


if (!isset($_GET["id"]))
{
	die("false: missing id");
}

$sql = getPexMysql();
$valid = false;
$first = true;
$query =  "UPDATE `permissions_entity` SET ";
if (isset($_GET["prefix"]))
{
	$prefix = $sql->real_escape_string($_GET["prefix"]);
	$query .= " `prefix` = '" . $prefix . "' ";
	$valid = true;
	$first = false;
}

if (isset($_GET["suffix"]))
{
	$suffix = $sql->real_escape_string($_GET["suffix"]);
	if (!$first) $query .= ", ";
	$query .= "`suffix` = '" . $suffix . "' ";
	$valid = true;	
}

if (!$valid) { $sql->close(); die("false: Nothing changed"); }

$query .= "WHERE `id` = " . $sql->real_escape_string($_GET["id"]) . ";";
$sql->query($query);
if ($sql->error)
{
	$error = $sql->error;
	$sql->close();
	die("false: " . $error);
}
echo "true";
sendCommand("pex reload");
$sql->close();


?>