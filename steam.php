<DOCTYPE !HTML>
<html>
	<head>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<link href='style.css' rel='stylesheet' type='text/css'>
		<script src="js/jquery-1.11.0.min.js"></script>
		<script src="http://connect.facebook.net/en_US/all.js"></script>
		<script src="js/google.js"></script>
		<script src="https://apis.google.com/js/client.js?onload=handleClientLoad"></script>
		<script src="js/register.js"></script>
			<?php

			$done = false;
			require 'php/openid.php';
		
			if (isset($_GET["oauth_redirect"]))
			{
				$openid = new LightOpenID('http://mc.icannt.org/');
				if (!$openid->mode) {
					$openid->identity = 'http://steamcommunity.com/openid';
					header('Location: ' . $openid->authUrl());
				} elseif ($openid->mode == 'cancel') {
				} else {
					if ($openid->validate()) {
						$id = $openid->identity;
						echo "<script>data='steamID:" . $id . "';</script>";
						$done = true;
					} 
				}
			
			
			} 
		
		
		
		
		
		?>
		
	</head>
	<body>
		<div id="container">
		
			<?php 
				include 'header.php';
				include "templates/loading.php";
				include "templates/success.php";
				include "templates/failure.php";
			?>
			
		</div>
		<?php include 'templates/footer.php'; ?>
	</body>
</html>
<?php
	if ($done)
	{
		echo "<script> chosen = true;  complete();</script>";
	} else {
		echo "<script> showFailure();</script>";
	}
?>