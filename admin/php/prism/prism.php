
<?php 


	
	if (!isset($_GET["player_id"])) die();
	require_once "../../../php/common.php";
	isAuth() or die("False: unauthorised");
	$sql = getRootMysql();

	
	//$query = "SELECT `epoch`, `action`,`block_id`, `block_subid`, `x`, `y`, `z`, `world`, `old_block_id`, `old_block_subid`, `data` FROM `vanillaprism`.`prism_data` d INNER JOIN `vanillaprism`.`prism_players` p ON p.player_id = d.player_id INNER JOIN `vanillaprism`.`prism_actions` a ON a.action_id = d.action_id INNER JOIN `vanillaprism`.`prism_worlds` w ON w.world_id = d.world_id LEFT JOIN `vanillaprism`.`prism_data_extra` ex ON ex.data_id = d.id ";
	$query = "SELECT `epoch`, `block_id`, `block_subid`, `x`, `y`, `z`, `world_id`, `old_block_id`, `old_block_subid`, `data`, `action_id` FROM `vanillaprism`.`prism_data` d LEFT JOIN `vanillaprism`.`prism_data_extra` ex ON ex.data_id = d.id ";
	
	
	$query .= "WHERE `player_id`='" . $sql->real_escape_string($_GET['player_id']) . "' ";
	
	if (isset($_GET["start"]) && isset($_GET["end"]))
	{
		$query .= "AND `epoch` BETWEEN " . $sql->real_escape_string($_GET['start']) . " AND " . $sql->real_escape_string($_GET['end']) . " ";
	}
	
	$query .= "ORDER BY `epoch` ASC LIMIT 200;";
	

	
	$result = $sql->query($query);
	echo $sql->error;
	$rows = array();

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
		$rows[] = utf8ize($row);
	}
	$result->close();
	$sql->close();

	echo json_encode($rows);


?>
