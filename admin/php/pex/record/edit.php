<?php
require_once "../../../../php/common.php";
isAuth() or die("False: unauthorised");
if(!isset($_GET['id'])) die('false: must provide id');
$sql = getPexMysql();



$query =  "UPDATE `permissions` SET "; 
$c = 0;
if (isset($_GET["permission"]))
{
	$query .= "`permission` = '" . $_GET["permission"] . "' ";
	$c++;
}

if (isset($_GET["world"]))
{
	if ($c != 0)
	{
		$query .= ",";
	}
	$query .= " `world` = '" . $_GET["world"] . "' ";
	$c++;
}

if (isset($_GET["value"]))
{
	if ($c != 0)
	{
		$query .= ",";
	}
	$query .= " `value` = '" . $_GET["value"] . "' ";
  $query .= " `type` = 0 ";
	$c++;
}


$query .= "WHERE `id`='" . $_GET['id'] . "'; ";
$result = $sql->query($query);

if ($sql->error)
{
	$error = $sql->error;
	$sql->close();
	die("false: " . $error);
}

$sql->close();
echo "true";

//sendCommand("pex reload");



?>