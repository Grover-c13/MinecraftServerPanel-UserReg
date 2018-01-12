<?php
	require_once "../php/common.php";
	if(!isAuth())
	{
		header("Location: index.php");
	}
?>

<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<link href='../style2.css' rel='stylesheet' type='text/css'>
<script src="js/jquery-1.11.0.min.js"></script>
<script src="js/common.js"></script>
<link href="../js/jquery-ui-1.10.4.custom/css/custom-theme/jquery-ui-1.10.4.custom.css" rel="stylesheet">
<script src="../js/jquery-ui-1.10.4.custom/js/jquery-1.10.2.js"></script>
<script src="../js/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.js"></script>

