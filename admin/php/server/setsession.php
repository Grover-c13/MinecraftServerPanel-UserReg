<?php
require_once "../../../php/common.php";
isAuth() or die("False: unauthorised");
if (!isset($_GET['index'])) die("False: no index");
setServer($_GET['index']);
echo "true";
?>