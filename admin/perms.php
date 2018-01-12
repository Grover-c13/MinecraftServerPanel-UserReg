<DOCTYPE !HTML>
<html>
	<head>
		
		<?php
			include 'resources.php';
		?>
		<script src="js/perms.js"></script>

	</head>
	<body>
		<div id="container">
			<?php include 'header.php'; ?>
			
			
			<div id="content">
				<div class="navBar">
					<div id="navDiv">
						<span class="previous link"> < Previous </span>
						|
						<span class="next link"> Next > </span>
						
					</div>
					<div id="searchDiv">Search <input type="text" id="search" /></div>
				</div>
				
				<table id="perms">
					<tr>
						<th width="5%" onclick='toggleOrder("id")'>ID</th>
						<th width="60%" onclick='toggleOrder("name")'>Name</th>
						<th width="5%" class='reg'>Reg</th>
						<th>Group</th>
						<th>Details</th>
						<th>Prism</th>
					</tr>
		
				</table>
				<br />
				<div class="navBar">
					<div id="navDiv">
						<span class="previous link"> < Previous </span>
						|
						<span class="next link"> Next > </span>
						
					</div>
					<div id="searchDiv">Search <input type="text" id="search" /></div>
				</div>
			</div>

			

		</div>
	</body>
</html>