<?php
require_once "../../../../php/common.php";
isAuth() or die("False: unauthorised");


if(!isset($_GET['name'])) die('false: must provide name');

$sql = getPexMysql();
$query =  "SELECT * FROM `permissions` WHERE `name` = '" . $sql->real_escape_string($_GET["name"]) . "';";


$query .= ";";
$result = $sql->query($query);
if ($sql->error)
{
	$error = $sql->error;
	$sql->close();
	die("false: " . $error);
}

$rows = array();

while($row = $result->fetch_array(MYSQLI_ASSOC))
{

	$rows[] = $row;
}



echo json_encode($rows);
$sql->close();

?>