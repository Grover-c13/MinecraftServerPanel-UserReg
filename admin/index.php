<DOCTYPE !HTML>
<html>
	<head>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<link href='../style2.css' rel='stylesheet' type='text/css'>
		<?php
			require_once "../php/common.php";
			doSession();
			$index = true;
			if(isLogged())
			{
				header("Location: perms.php");
			}
			
			if(isset($_POST["do"]))
			{
				$sql = getMysql();
				$hash = sha1($_POST["password"]);
				$result = $sql->query("SELECT `id` FROM `login` WHERE `password` = '" . $sql->real_escape_string($hash) . "' AND `username`='" . $sql->real_escape_string($_POST["username"]) . "';");
				$row = $result->fetch_array(MYSQLI_ASSOC);
				if ($result->num_rows == 1)
				{
					
					doSession();
					$_SESSION["id"] = $row["id"];
					$_SESSION["hash"] = $hash;
					$result->close();
					$sql->close();
					header("Location: perms.php");
				}
				$sql->close();
			}
		
		?>
	</head>
	<body>
		<div id="container">
			<?php include 'header.php'; ?>
			
			
			<div id="content-login">
				<form method="post">
					<input type="hidden" value="go" name="do" />
					Username: <input type="text" name="username" id="username" />
					<br />
					Password: <input type="password" name="password" id="password" />
					<br />
					<button>Login</button>
				</form>
			</div>

			

		</div>
	</body>
</html>