<DOCTYPE !HTML>
<html>
	<head>

		
		
		<?php
			include 'resources.php';

		?>
		<script>
		
		
		</script>

	</head>
	<body>
		<div id="container">
			<?php include 'header.php'; ?>
			
			
			<div id="content">
				<h2>Groups</h2>
				<table>
						<tr>
							<th>Name</th>
							<th>Prefix</th>
							<th>Suffix</th>
							<th>Parent</th>
							<th>Edit</th>
						</tr>
						
						<?php
							$groups = getPexGroups();
							foreach ($groups as $group)
							{
								echo "<tr>";
								echo "<td>" . $group["name"] . "</td>";
								echo "<td><span class='editfy' data-url='php/pex/entity/edit.php' data-get-fill='prefix' data-get='{\"id\":" . $group["id"] . "}'>"  . "</span></td>";
								echo "<td><span class='editfy' data-url='php/pex/entity/edit.php' data-get-fill='suffix' data-get='{\"id\":" . $group["id"] . "}'>"  . "</span></td>";
								echo "<td><select>" . pexGroupSelectOptions($groups, $group["parent"]) . "</select></td>";
								echo "<td><a href='groupdetails.php?name=" . $group["name"] . "'>Edit perms..</a></td>";
								echo "</tr>";
							}
						?>
				</table>
				<br />
				<br />
			</div>

			

		</div>
	</body>
</html>
<script>

		var elements = $(".editfy");
		$.each(elements, function(index, value)
		{
			editfy($(value));
		});

			
</script>