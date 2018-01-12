<DOCTYPE !HTML>
<html>
	<head>
				
		
		<?php
			include 'resources.php';
		?>
		
		<script>
		$(function()
		{
			var elements = $(".shorter");
			$.each(elements, function(index, element)
			{
				element = $(element);
				if (element.text().length > 100)
				{
					element.addClass("link");
					element.attr("data-full", element.text());
					element.text(element.text().substring(0, 100) + "...");
					element.mouseenter(function(e)
					{
						$(e.currentTarget).text($(e.currentTarget).attr("data-full"));
					});
					
					element.mouseout(function(e)
					{
						$(e.currentTarget).text($(e.currentTarget).attr("data-full").substring(0, 100) + "...");
					});
				}
			});
		
			$(".reload").click(function(e)
			{
				var element = $(e.currentTarget);
				$.ajax({type: "GET", url: "php/plugin/reload.php?plugin=" + element.attr("data-plugin")});
			})
			
			$(".remove").click(function(e)
			{
				var element = $(e.currentTarget);
				$.ajax({type: "GET", url: "php/plugin/remove.php?plugin=" + element.attr("data-plugin")});
				element.parent().parent().remove();
			})
		});
		</script>
		<?php
			require_once "../php/common.php";
			$plugins = json_decode(file_get_contents(getServer()->plugins_json), true);
		?>
	</head>
	<body>
		<div id="container">
			<?php include 'header.php'; ?>
			
			
			<div id="content">
				
				<table id="plugins">
					<p class='footnote'>
					
					</p>
					<tr><th width='20%'>Name</th><th width='20%'>Version</th><th>Description</th><th>Website</th><th width='20%'>Actions</th></tr>
					<?php
						foreach($plugins as $plugin)
						{
							if ($plugin['website'] == null)
							{
								$website = "";
							} else 
							{
								$website = "Visit";
							
							}
							if ($plugin['name'] === "Madmin") continue;
							echo <<<EOT
								<tr>
									<td>{$plugin['name']}</td>
									<td>{$plugin['version']}</td>
									<td><div class='shorter'>{$plugin['description']}</div></td>
									<td><a href='{$plugin['website']}'>$website</a></td>
									<td><button data-plugin='{$plugin['name']}' class='reload'>Reload</button> <button class='remove' data-plugin='{$plugin['name']}'>Remove</button></td>
								</tr>
EOT;
						}
					
					?>
		
				</table>
				<br />
			</div>

			

		</div>
	</body>
</html>