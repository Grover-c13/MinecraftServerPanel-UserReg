<?php
require_once "../../../../php/common.php";
isAuth() or die("False: unauthorised");
$sql = getPexMysql();


$query =  "SELECT * FROM `permissions_entity` WHERE `type`='0';";


$result = $sql->query($query);
if ($sql->error)
{
	$error = $sql->error;
	$result->close();
	$sql->close();
	die("false: " . $error);
}



$rows = array();

while($row = $result->fetch_array(MYSQLI_ASSOC))
{
	$rows[] = $row;
}

$result->close();
$sql->close();
echo json_encode($rows);


?>