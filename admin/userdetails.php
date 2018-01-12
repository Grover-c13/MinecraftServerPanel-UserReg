<DOCTYPE !HTML>
<html>
	<head>

		
		
		<?php
			include 'resources.php';

			$name = $_GET["name"];
			$pex = getUserPexDetails($name);
			$reg = getUserRegDetails($name);
		?>
		<script src="js/jquery.minecraftskin.js"></script>
		<script>
		    $(function()
			{
				<?php 
					echo "var name = '" . $name . "';"; 
				?>
				
				$(".mc-skin").minecraftSkin({scale: 6, hat: true, draw : 'model'});
				
				$.ajax({url: "php/pex/record/get.php?name=" + name}).done(function(json)
				{
					var records = JSON.parse(json);
					var row = "<tr class='noremove permth'><th width='30%'>Perm</th><th width='30%'>Value</th><th width='30%'>World</th><th width='10%'>Action</th></tr>";
					for (key in records)
					{
						var get = {id: records[key].id, name: name};
						row += "<tr>";
						row += "<td><span class='editfy' data-url='php/pex/record/edit.php' data-get-fill='permission' data-get='" + JSON.stringify(get) + "'>" + records[key].permission + "</span></td>";
						row += "<td><span class='editfy' data-url='php/pex/record/edit.php' data-get-fill='value' data-get='" + JSON.stringify(get) + "'>" + records[key].value + "</span></td>";
						row += "<td><span class='editfy' data-url='php/pex/record/edit.php' data-get-fill='world' data-get='" + JSON.stringify(get) + "'>" + records[key].world + "</span></td>";
						row += "<td><button class='delete' data-url='php/pex/record/delete.php' data-get='" + JSON.stringify(get) + "'>Delete</button></td></tr>";
					}
					row += "<tr class='noremove end'><td colspan=4><button class='newperm'>New...</button></td></tr>";
					$(".permlist").html(row);
					$(".newperm").click(function()
					{
						$.ajax({type: "GET", url: "php/pex/record/add.php", data: {name: name}}).done(function(result)
						{
							if(result.indexOf("false") > -1) return;
							
							var get = {id: result, name: name};
							var newline = "";
							newline += "<tr>";
							newline += "<td><span class='editfy' data-url='php/pex/record/edit.php' data-get-fill='permission' data-get='" + JSON.stringify(get) + "'></span></td>";
							newline += "<td><span class='editfy' data-url='php/pex/record/edit.php' data-get-fill='value' data-get='" + JSON.stringify(get) + "'></span></td>";
							newline += "<td><span class='editfy' data-url='php/pex/record/edit.php' data-get-fill='world' data-get='" + JSON.stringify(get) + "'></span></td>";
							newline += "<td><button class='delete' data-url='php/pex/record/delete.php' data-get='" + JSON.stringify(get) + "'>Delete</button></td></tr>";
							$(".end").before($(newline));
							doEditfy();
							doDelete();
						});
						
						
					});
					
					$(".doReg").click(function(e)
					{
						$(e.currentTarget).remove();
						handleAjax($(e.currentTarget), function(result) { 
							$("#regStatus").text("Registered");
						});
					});
					
					
					$("#groupChange").change(function(e)
					{
						handleAjax($(e.currentTarget), function(result) {});
					});
					
					doEditfy();
					doDelete();
				});
				
				


			});
			
			
			function doDelete()
			{
				$(".delete").click(function(e)
				{
					console.info("click");
					handleAjax($(e.target), function(result) { 
						$(e.target).parent().parent().remove();
					});
				});
				
			}
			
			
			function doEditfy()
			{
					var elements = $(".editfy");
					$.each(elements, function(index, value)
					{
						editfy($(value));
					});
			}
		
		</script>

	</head>
	<body>
		<div id="container">
			<?php include 'header.php'; ?>
			
			
			<div id="content">
				<div id="details">
					<table class="small-left-details">
						<tr><th>User Details</th><td></td></tr>
						<tr><td>Name</td><td><?php echo $name; ?></td></tr>
						<tr><td>Group</td><td><select id='groupChange' data-url='php/pex/entity/changegroup.php' data-get-fill='group' data-get='{"name": "<?php echo $pex["name"]; ?>"}'><?php
							foreach(getPexGroups() as $group)
							{
								echo $pex["parent"] . " == ";
								echo $group["name"] . "\n";
								echo "<option " . ($pex["parent"] === $group["name"] ? "selected" : "") . ">" . $group["name"] . "</option>";
							}
						?></select></td></tr>
						<tr><td>PEX ID</td><td><?php echo $pex["id"]; ?></td></tr>
						<tr><td>Reg ID</td><td><?php echo $reg["id"]; ?></td></tr>
						<tr><td>UUID</td><td><?php echo $reg["uuid"]; ?></td></tr>
						<tr><td>Registration IP</td><td><?php echo $reg["ip"]; ?></td></tr>
						<tr><td>Registration Date</td><td><?php echo date("Y-m-d H:i:s", $reg["date"]); ?></td></tr>
						<tr><td>Registration Status</td><td id='regStatus'><?php echo ($reg["status"] == 1 ? 'Registered' : 'Unregistered  <button class="doReg smallButton softright" data-url="php/register/register.php" data-get=\''.json_encode(array("id"=>$reg['id'], "name"=>$reg["name"])).'\'>Register</button>'); ?></td></tr>
						<tr><td>Registration Meta</td><td><?php echo $reg["meta"]; ?></td></tr>
					</table>
					
					<div class="mc-skin" data-minecraft-username="<?php echo $name; ?>"></div>
				</div>
				
				<h2>Permissions</h2>
				<table class="permlist">
						<tr class='noremove permth'>
							<td>Perm</th>
							<th>Value</th>
							<th>World</th>
							<th>Action</th>
						</tr>
						<tr class='noremove'><td colspan=3><button id='new'>New...</button></td></tr>
				</table>
				<br />
				<br />
			</div>

			

		</div>
	</body>
</html>