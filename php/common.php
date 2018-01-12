<?php
require("servers.php");

function sendCommand($command, $server = false)
{
  return true;
	global $servers;
	if($server === false) $server = $servers[0];
	require_once("rcon.php");
	$rcon = new MinecraftRcon();
	$rcon->connect($server->host, $server->rcon_port, $server->rcon_password, 2);
	$rcon->command($command);
	$rcon->disconnect();
}

function isAdmin()
{
	$hash = getSessionHash();
	if ($hash === false) return false;
	$sql = getMysql();
	$result = $sql->query("SELECT `level` FROM `login` WHERE `password`='" . $hash . "';");
	$data = $result->fetch_assoc();
	$sql->close();
	if ($data["level"] == 1)
	{
		return true;
	}
	
	return false;
}


function isMod()
{
	$hash = getSessionHash();
	if ($hash === false) return false;
	$sql = getMysql();
	$result = $sql->query("SELECT `level` FROM `login` WHERE `password`='" . $hash . "';");
	$data = $result->fetch_assoc();
	$sql->close();
	if ($data["level"] == 0)
	{
		return true;
	}
	
	return false;
}

function isLogged()
{
	doSession();
	$return = (isset($_SESSION["hash"]) && isset($_SESSION["id"]));
	session_write_close();
	return $return;
}

function isAuth()
{
	if (isAdmin()) return true;
	return isMod();
}

function getSessionHash()
{
	doSession();
	if(isset($_SESSION["hash"]))
	{
		$hash =  $_SESSION["hash"];
		session_write_close();
		return $hash;
	}
	session_write_close();
	return false;
}

function getMysql()
{
	$sql = new mysqli("localhost", "root", "PdYFTDpdZT9PEV9NyJ9eqtMG", "admin");
	
	if ($sql->connect_errno)
	{
		die("SQL Error");
	}

	return $sql;
}

function getRootMysql()
{
	$sql = new mysqli("localhost", "root", "PdYFTDpdZT9PEV9NyJ9eqtMG", "");
	
	if ($sql->connect_errno)
	{
		die("SQL Error");
	}

	return $sql;
}



function getRegMysql()
{
	$sql = new mysqli("localhost", "redacted", "redacted", "register");
	
	if ($sql->connect_errno)
	{
		die("SQL Error");
	}

	return $sql;
}


function getPexMysql()
{
	$sql = new mysqli("localhost", "redacted", "redacted", "perms");
	
	if ($sql->connect_errno)
	{
		die("SQL Error");
	}

	return $sql;

}


function doSession()
{
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
}



function getUserPexDetails($name)
{
	$sql = getPexMysql();
	$query = "SELECT `permissions_entity`.*,`permissions_inheritance`.`parent` FROM `permissions_entity` INNER JOIN `permissions_inheritance` WHERE `child`=`name` AND `permissions_entity`.type='1' AND `name`='" . $sql->real_escape_string($name) . "';";
	$result = $sql->query($query);
	if ($result->num_rows == 0) 
	{
		$result->close();
		$sql->close();
		return array();
	}
	$row = $result->fetch_array(MYSQLI_ASSOC);
	$result->close();
	$sql->close();
	return $row;
};


function getPexGroups()
{
	$sql = getPexMysql();
	$query =  "SELECT `permissions_entity`.*,  `permissions_inheritance`.`parent`,  `permissions_inheritance`.`child` FROM `permissions_entity` INNER JOIN `permissions_inheritance` ON `child`=`permissions_entity`.`name`  WHERE `permissions_entity`.`type`='0'  GROUP BY `child`;";
	$result = $sql->query($query);
	if ($sql->error)
	{
		echo $sql->error;
		$error = $sql->error;
		$result->close();
		$sql->close();
		return array();
	}
	$rows = array();

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
		$rows[] = $row;
	}

	$result->close();
	$sql->close();
	return $rows;
}

function getUserRegDetails($name)
{
	$sql = getRegMysql();
	$query =  "SELECT * FROM `users` WHERE `name`='" . $sql->real_escape_string($name) . "'; ";
	$result = $sql->query($query);
	if ($result->num_rows == 0) 
	{
		$result->close();
		$sql->close();
		return array();
	}
	$row = $result->fetch_array(MYSQLI_ASSOC);
	$result->close();
	$sql->close();
	return $row;
};

function pexGroupSelectOptions($groups, $selected)
{
	$html = "";
	foreach($groups as $group)
	{
		if ($group["name"] == $selected) { $html .= "<option selected>" . $group["name"] . "</option>"; continue; }
		$html .= "<option>" . $group["name"] . "</option>";
	}
	
	return $html;
}

function setServer($server)
{
	if(!isAuth()) return false;
	doSession();
	$_SESSION["server"] = $server;
	session_write_close();
	
}

function getServer()
{
	global $servers;
	doSession();
	if(!isset($_SESSION["server"])) { session_write_close(); return $servers[0]; }
	$server = $servers[$_SESSION["server"]];
	session_write_close();
	return $server;

}


function getPlugins($server)
{
	return json_decode(file_get_contents($server->plugins_json), true);
}

function getPlugin($server, $pluginf)
{
	$plugins = getPlugins($server);
	foreach($plugins as $plugin)
	{
		if($plugin["name"] == $pluginf) return $plugin;
	}

	return false;
}

function getPrismearliest($name)
{
	$sql = getRootMysql();

	
	$query = "SELECT MIN(`epoch`) v FROM `vanillaprism`.`prism_data` d INNER JOIN `vanillaprism`.`prism_players` p ON p.player_id = d.player_id WHERE `player` = '" . $name . "';";
	

	$result = $sql->query($query);
	echo $sql->error;
	$row = $result->fetch_array(MYSQLI_ASSOC);
	$result = $row["v"];
	$sql->close();
	
	return $result;
}



function getPrismLatest($name)
{
	$sql = getRootMysql();

	
	$query = "SELECT MAX(`epoch`) v FROM `vanillaprism`.`prism_data` d INNER JOIN `vanillaprism`.`prism_players` p ON p.player_id = d.player_id WHERE `player` = '" . $name . "';";
	

	$result = $sql->query($query);
	echo $sql->error;
	$row = $result->fetch_array(MYSQLI_ASSOC);
	$result = $row['v'];
	$sql->close();
	
	return $result;
}


function getPrismWorlds()
{
	$sql = getRootMysql();

	$query = "SELECT * FROM `vanillaprism`.`prism_worlds`;";

	$result = $sql->query($query);
	echo $sql->error;
	$rows = array();
	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
		$rows[$row['world_id']] = utf8ize($row);
	}
	$sql->close();
	
	return $rows;
}



function getPrismActions()
{
	$sql = getRootMysql();
	$query = "SELECT * FROM `vanillaprism`.`prism_actions`;";
	$result = $sql->query($query);
	echo $sql->error;
	$rows = array();
	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
		$rows[$row['action_id']] = utf8ize($row);
	}
	$result->close();
	$sql->close();
	
	return $rows;
}


function getPrismPlayerId($uuid)
{
	$sql = getRootMysql();
	$query = "SELECT `player_id` FROM `vanillaprism`.`prism_players` WHERE `player_uuid` = 0x" .  $uuid . ";";
	$result = $sql->query($query);
	echo $sql->error;
	$row = $result->fetch_array(MYSQLI_ASSOC);
	$result = $row['player_id'];
	$sql->close();
	
	return $result;

}


function utf8ize($d) {
	if (is_array($d)) {
		foreach ($d as $k => $v) {
			$d[$k] = utf8ize($v);
		}
	} else {
		return utf8_encode($d);
	}
	return $d;
}

class Server
{
	function __construct()
	{
			$servers[] = $this;
	}
}





?>