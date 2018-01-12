<?php
require_once "../../../php/common.php";
isAdmin() or die("False: unauthorised");

if (!isset($_GET['plugin'])) die("false: no plugin provided");


sendCommand("pm reload " . $_GET['plugin'], getServer());


?>