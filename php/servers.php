<?php
$servers = array();
class  Vanilla extends Server
{
	public $label = "Vanilla";
	public $host = "mc2.icannt.org";
	public $rcon_port = 189752;
	public $rcon_password = "redacted";
	public $plugins_json = "C:\\Live\\1.8 Spigot\\.plugins.json";
}

$servers[] = new Vanilla();


?>