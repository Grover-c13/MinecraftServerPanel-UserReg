<DOCTYPE !HTML>
<html>
	<head>

		<?php
			include 'resources.php';
			doSession();
			unset($_SESSION["id"]);
			unset($_SESSION["hash"]);
		
		?>
	</head>
	<body>
		<div id="container">
			<?php include 'header.php'; ?>
			
			
			<div id="content">
				<p>Logged out</p>
			</div>

			

		</div>
	</body>
</html>