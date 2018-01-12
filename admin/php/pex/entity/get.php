<?php
require_once "../../../../php/common.php";
isAuth() or die("False: unauthorised");
$sql = getRootMysql();


$query =  "SELECT * FROM `perms`.`permissions_entity` INNER JOIN `register`.`users` ON `permissions_entity`.`name`=`users`.`name` WHERE `type`='1' ";

if (isset($_GET["search"]))
{
	$query .= "AND `permissions_entity`.`name` LIKE '%" . $sql->real_escape_string($_GET["search"]) . "%'";
}
$query .= " GROUP BY `permissions_entity`.`name`";
if (isset($_GET["orderby"]))
{
	$query .= "ORDER BY `" . $sql->real_escape_string($_GET["orderby"]) . "` ";
	
	if(isset($_GET["orderdir"]))
	{
		$order = $_GET["orderdir"];
	} else {
		$order = "ASC";
	}
	$query .= $order . " ";
} else {
	$query .= "ORDER BY `permissions_entity`.`id` DESC";
}


if (isset($_GET["page"]) && !isset($_GET["search"]))
{
	$offset = $_GET["page"]*50;
} else {
	$offset = 0;
}


$query .=  " LIMIT " . $offset .  ",50";


$query .= ";";
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
	$query2 = "SELECT `parent` FROM `perms`.`permissions_inheritance` WHERE `child` = '" . $sql->real_escape_string($row["name"]) . "' LIMIT 1;";
	$result2 = $sql->query($query2);
	if ($result2->num_rows > 0)
	{
		$group = $result2->fetch_array(MYSQLI_ASSOC);
		$row["group"] = $group["parent"];
	} else {
		$row["group"] = "ERROR NOT FOUND";
	}
	
	$rows[] = $row;
	$result2->close();
}

$result->close();
$sql->close();





echo json_encode($rows);

?>