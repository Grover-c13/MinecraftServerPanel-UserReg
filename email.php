<DOCTYPE !HTML>
<html>
	<head>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<link href='style2.css' rel='stylesheet' type='text/css'>
		<script src="js/jquery-1.11.0.min.js"></script>
		<script src="http://connect.facebook.net/en_US/all.js"></script>
		<script src="js/google.js"></script>
		<script src="https://apis.google.com/js/client.js?onload=handleClientLoad"></script>
		<script src="js/register.js"></script>


	</head>
	<body>
		<div id="container">
			<?php include 'header.php'; ?>
			
			<div id="content">
				<br />
				<br />
				<br />
				
				
				<p >
				<?php 
					$done = false;
					session_start();
					$id = $_SESSION['userid'];
					if (!isset($_GET['do']))
					{
						echo "Please enter a valid email address; a confirmation link will be sent after you hit submit which you will be required to visit at least once before registration is complete.";
					} else {
					
						if($_GET["do"] == "email")
						{
							$_SESSION['email'] = $_GET["email"];
							$mysqli = new mysqli('localhost', 'register', 'QHucJLxyW4yw6XUq', 'register');
							if ($mysqli->connect_error) die("Register is not working right now! please speak to a moderator or admin");
							$linkid = crypt($_GET["email"], $id);
							$result = $mysqli->query("UPDATE  `users` SET  `meta` =  '" . $linkid . "' WHERE  `id` =  '" . $id . "';");
							
							$mysqli->close();

							echo "Thanks! please check your inbox and follow the link to complete registration";
							
							require_once "Mail.php";

									$from = "mc.icannt.org@gmail.com";
									$to = $_GET["email"];
									$subject = "ICannt Minecraft Registration";

$body = <<<EOT
Hi,

Thank you for registering for an account on the ICannt Minecraft server.
Before you can play, you must complete your registration by visiting:

http://mc.icannt.org/email.php?do=confirm&key={$linkid}

You should now be able to play! If you have any issues or questions, feel free to ask an ICannt member.

See you in-game,
The ICannt Minecraft Team.
EOT;
												
									$host = "ssl://smtp.gmail.com";
									$port = "465";
									$gmailusername = "minecraftregistration@icannt.org";
									$gmailpassword = "aqUMUfVNxLRNJppFSe4zTgGJ";

									$headers = array ('From' => $from,
									  'To' => $to,
									  'Subject' => $subject);
									$smtp = Mail::factory("smtp", array ('host' => $host,
																		'port' => $port,
																		'auth' => true,
																		'username' => $gmailusername,
																		'password' => $gmailpassword));
															

															
									$mail = $smtp->send($to, $headers, $body);
						}
						
						if($_GET["do"] == "confirm")
						{
							$mysqli = new mysqli('localhost', 'register', 'QHucJLxyW4yw6XUq', 'register');
							if ($mysqli->connect_error) die("Register is not working right now! please speak to a moderator or admin");
							$result = $mysqli->query("SELECT `meta` FROM `users` WHERE `id`='" . $id . "';");
							if($result)
							{
								$array = $result->fetch_assoc();
								$meta = $array["meta"];

								if ($_GET["key"] === $meta)
								{
									echo "<script>data='Email:" . $_SESSION['email'] . "';</script>";
									$done = true;
								}
									
									

												
              }
              
              $result->close();
							$mysqli->close();

            }
										
	
						
										
					}
									

					
					
				?>
				</p>
				
				<br />
				
				<div class="center" <?php if (isset($_GET['do'])) echo "style='display: none;'"; ?>>
						<form method="get">
							<b class="center">Email Address</b><br />
							<input type="text" name="email">
							<br />
							<div class="center"><button class="center">Submit</button></div>
							<input type="hidden" value="email" name="do" />
						</form>
				</div>
			</div>
			
			
			
			<?php
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