<div id="header">
	<a href="https://icannt.org"><img src="../images/icannt.png" alt="ICannt.org" /></a>
	<ul id="links">
		<?php
			doSession();
			if (isLogged())
			{
		?>
		<li><a href="perms.php">Users</a></li>
		<li><a href="groups.php">Groups</a></li>
		<li><a href="plugins.php">Plugins</a></li>
		<li><a href="logout.php">Logout</a></li>
		<br />
		<div class='server'>
			Server:
			<select id='server'>
				<?php
					foreach($servers as $index => $server)
					{
						$selected = "";
						if ($server->label === getServer()->label) $selected = "selected";
						echo "<option " . $selected .  ">" . $server->label . "</option>";
					}
				?>
			</select>
		</div>
		<?php }  ?>
	</ul>
</div>
<br />