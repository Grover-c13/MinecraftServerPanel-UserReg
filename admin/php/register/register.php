<?php
require_once "../../../php/common.php";
isAuth() or die("False: unauthorised");

if(!isset($_GET['id'])) die('false: must provide id');
if(!isset($_GET['name'])) die('false: must provide name');

$sql = getRegMysql();


$result = $sql->query("UPDATE `users` SET  `status` =  1 WHERE  `id` =  '" . $sql->real_escape_string($_GET['id']) . "';");
if($sql->error)
{
	$sql->close();
	die("false"); 
}



sendCommand("pex user " + $_GET['name'] + " group set builder");
echo "true";



?>