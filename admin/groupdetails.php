<DOCTYPE !HTML>
<html>
	<head>
		<?php
			include 'resources.php';

			$name = $_GET["name"];
			$pex = getUserPexDetails($name);
			$reg = getUserRegDetails($name);
		?>
		
		<script src="js/common.js"></script>
<script>
		    $(function()
			{
				<?php 
					echo "var name = '" . $name . "';"; 
				?>
				

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
							if(result.indexOf("false") > -1) 
              {
                console.info(result);
                return;
							}
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
			

		
		</script>
	</head>

	<body>
		<div id="container">
			<?php include 'header.php'; ?>
			
			
			<div id="content">
				
				<h2>Group Permissions for <?php echo $name; ?></h2>
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
