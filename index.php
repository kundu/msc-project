<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Test</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

	<style>
		#sites-div-main , #quries-div-main{
			display: none;
		}
	</style>

</head>
<body>
	<?php
		include "database.php";

		$sql = "CREATE TABLE distance (
			id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			tableName VARCHAR(30) NOT NULL, 
			theNumber VARCHAR(30) NOT NULL, 
			created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
			)";
		mysqli_query($mysqli, $sql);


		$sql = "CREATE TABLE sqlSave (
			id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			sqlData VARCHAR(30) NOT NULL,  
			created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
			)";
		mysqli_query($mysqli, $sql);


		if(isset($_POST["submitClick"])){
			$siteData = $_POST["siteData"];
			$distanceData = $_POST["distanceData"];
			$queryData = $_POST["queryData"];
			foreach ($siteData as $key => $value) { 
				$sql = "CREATE TABLE $value (
					id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					theData VARCHAR(30) NOT NULL, 
					created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
					)"; 
				if (mysqli_query($mysqli, $sql)) { 
					$tempDistance = $distanceData[$key];
					$insertSql = "INSERT into distance(tableName, theNumber) values('$value', '$tempDistance')";
					mysqli_query($mysqli, $insertSql);
				} else {
					echo "Error creating table: " . mysqli_error($mysqli);
				}
			}

			foreach ($queryData as $key => $value) {
				$insertSql = "INSERT into sqlSave(sqlData) values('$value')";
				mysqli_query($mysqli, $insertSql);
			}
		}
	?>
	
	<div class="container">
		<div class="well well-lg">Input Query</div>
		<form class="form-inline">
			<div class="form-group">
				<label for="email">Site number:</label>
				<input type="number" class="form-control" id="number_of_sites_id">
			</div>
			<div class="form-group">
				<label for="pwd">Query number:</label>
				<input type="number" class="form-control" id="number_of_quries_id">
			</div> 
			<button type="button" class="btn btn-default" onclick="populateDataClick()">Submit</button>
		</form>
	</div>
	<br><br>



	<form action="" method="post">
		<div class="container" id="sites-div-main">
			<div class="well well-sm">Site Names</div>
			<div class="form-inline">
				<div id="sites_div_id">
					<div class="form-group">
						<label for="email">Site Name:</label>
						<input type="text" class="form-control" name="siteData[]" required id="email">
					</div>
					<div class="form-group">
						<label for="pwd">Distance:</label>
						<input type="number" class="form-control" name="distanceData[]" required id="pwd">
					</div> 
					<br>
				</div>
			</div>
		</div>

		<br><br>



		<div class="container" id="quries-div-main">
			<div class="well well-sm">Query</div>
			<div class="form-inline">
				<div id="quries_div_id">
					<div class="form-group">
						<label for="email">Query data:</label>
						<input type="text" class="form-control" name="queryData[]" required id="email">
					</div> 
					<br>
				</div>
			</div>


			<button type="submit" name="submitClick" class="btn btn-info">Submit</button>
		</div> 
	</form>


	<br><br>

		
		

		<div class="container">

		<?php 
			if(isset($_POST["distanceSubmitClick"])){
				$distance = $_POST["distance"];

				$sql = "SELECT * from distance where theNumber < '$distance' order by theNumber DESC Limit 1";
				$result = $mysqli->query($sql);

				if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) { 
					echo "Your closest Site Name: ".$row["tableName"];
				}
				} else {
				echo "0 results";
				}
			}

		
		?>

		
			<div class="well well-lg">Distance Site</div>
			<form class="form-inline" method="post" action="">
				<div class="form-group">
					<label for="email">Distance:</label>
					<input type="number" name="distance" class="form-control">
				</div> 
				<button type="submit" name="distanceSubmitClick" class="btn btn-default">Submit</button>
			</form>
		</div>



	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


	<script>
		function populateDataClick(){
			$number_of_sites_id = document.getElementById("number_of_sites_id").value;
			$sites_div_id = document.getElementById("sites_div_id").innerHTML; 

			$("#sites-div-main").show(1200); 

			for (let i = 1; i < $number_of_sites_id; i++) {
				document.getElementById("sites_div_id").innerHTML =document.getElementById("sites_div_id").innerHTML + $sites_div_id; 
			} 

			$number_of_quries_id = document.getElementById("number_of_quries_id").value;
			$quries_div_id = document.getElementById("quries_div_id").innerHTML; 

			$("#quries-div-main").show(1200); 

			for (let i = 1; i < $number_of_quries_id; i++) {
				document.getElementById("quries_div_id").innerHTML =document.getElementById("quries_div_id").innerHTML + $quries_div_id; 
			} 
			
		}
	</script>
</body>
</html>



 
