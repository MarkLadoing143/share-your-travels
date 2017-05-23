<?php
require_once('includes/travel-config.php');

//displays images according to filter settings
function displayImages() {
	if( isset($_GET['city']) && isset($_GET['country']) && $_GET['city'] > 0 && $_GET['country'] == 'ZZZ' ) { //if city set
		try {
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
			$sql = "SELECT TravelImage.ImageID, Path, Title FROM TravelImage INNER JOIN TravelImageDetails ON TravelImage.ImageID = TravelImageDetails.ImageID WHERE TravelImageDetails.CityCode = ?";
			$statement = $pdo->prepare($sql);
			$statement->bindValue(1, $_GET['city']);
			$statement->execute();
			while( $row = $statement->fetch() ) {
				echo "<div class='col-md-3'>";
				echo "<a href='single-image.php?id=" . $row['ImageID'] . "'><img src='travel-images/medium/" . $row['Path'] . "' alt='" . $row['Title'] . "' class='img-thumbnail col-md-12'/></a>";
				echo "</div>";
			}
			$pdo = null;
		}
		catch (PDOException $e) {
			die( $e->getMessage() );
		}
	}
	else if( isset($_GET['city']) && isset($_GET['country']) && $_GET['city'] == 0 && $_GET['country'] != 'ZZZ' ) { //if country set
		try {
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
			$sql = "SELECT TravelImage.ImageID, Path, Title FROM TravelImage INNER JOIN TravelImageDetails ON TravelImage.ImageID = TravelImageDetails.ImageID WHERE TravelImageDetails.CountryCodeISO = ?";
			$statement = $pdo->prepare($sql);
			$statement->bindValue(1, $_GET['country']);
			$statement->execute();
			while( $row = $statement->fetch() ) {
				echo "<div class='col-md-3'>";
				echo "<a href='single-image.php?id=" . $row['ImageID'] . "'><img src='travel-images/medium/" . $row['Path'] . "' alt='" . $row['Title'] . "' class='img-thumbnail col-md-12'/></a>";
				echo "</div>";
			}
			$pdo = null;
		}
		catch (PDOException $e) {
			die( $e->getMessage() );
		}
	}
	else if( isset($_GET['city']) && isset($_GET['country']) && $_GET['city'] > 0 && $_GET['country'] != 'ZZZ' ) { //if city and country set
		try {
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
			$sql = "SELECT TravelImage.ImageID, Path, Title FROM TravelImage INNER JOIN TravelImageDetails ON TravelImage.ImageID = TravelImageDetails.ImageID WHERE TravelImageDetails.CountryCodeISO = ? AND TravelImageDetails.CityCode = ?";
			$statement = $pdo->prepare($sql);
			$statement->bindValue(1, $_GET['country']);
			$statement->bindValue(2, $_GET['city']);
			$statement->execute();
			while( $row = $statement->fetch() ) {
				echo "<div class='col-md-3'>";
				echo "<a href='single-image.php?id=" . $row['ImageID'] . "'><img src='travel-images/medium/" . $row['Path'] . "' alt='" . $row['Title'] . "' class='img-thumbnail col-md-12'/></a>";
				echo "</div>";
			}
			$pdo = null;
		}
		catch (PDOException $e) {
			die( $e->getMessage() );
		}
	}
	else { //default
		try {
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			$sql = "SELECT TravelImage.ImageID, Path, Title FROM TravelImage INNER JOIN TravelImageDetails ON TravelImage.ImageID = TravelImageDetails.ImageID";
			$result = $pdo->query($sql);
			while( $row = $result->fetch() ) {
				echo "<div class='col-md-3'>";
				echo "<a href='single-image.php?id=" . $row['ImageID'] . "'><img src='travel-images/medium/" . $row['Path'] . "' alt='" . $row['Title'] . "' class='img-thumbnail col-md-12'/></a>";
				echo "</div>";
			}
			$pdo = null;
		}
		catch (PDOException $e) {
			die( $e->getMessage() );
		}
	}
}

//outputs the list of cities for filter
function outputCities() {
	try {
		$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$sql = "SELECT AsciiName, GeoCities.GeoNameID FROM GeoCities INNER JOIN TravelImageDetails ON GeoCities.GeoNameID=TravelImageDetails.CityCode GROUP BY GeoCities.AsciiName";
		$result = $pdo->query($sql);
		while( $row = $result->fetch() ) {
			echo "<option value='" . $row['GeoNameID'] . "'>" . $row['AsciiName'] . "</option>";
		}
		$pdo = null;
	}
	catch (PDOException $e) {
		die( $e->getMessage() );
	}
}

//outputs the list of countries for filter
function outputCountries() {
	try {
		$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$sql = "SELECT CountryName, ISO FROM GeoCountries INNER JOIN TravelImageDetails ON GeoCountries.ISO=TravelImageDetails.CountryCodeISO GROUP BY CountryName";
		$result = $pdo->query($sql);
		while( $row = $result->fetch() ) {
			echo "<option value='" . $row['ISO'] . "'>" . $row['CountryName'] . "</option>";
		}
		$pdo = null;
	}
	catch (PDOException $e) {
		die( $e->getMessage() );
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Travel Template</title>
	<?php include 'includes/travel-head.inc.php'; ?>
</head>

<body>

<?php include 'includes/travel-header.inc.php'; ?>
   
<div class="container">  <!-- start main content container -->
	<div class="row">  <!-- start main content row -->
		<div class="col-md-3">  <!-- start left navigation rail column -->
			<?php include 'includes/travel-left-rail.inc.php'; ?>
		</div>  <!-- end left navigation rail --> 
      
		<div class="col-md-9">  <!-- start main content column -->
		
		<ol class="breadcrumb">
			<li><a href="index.php">Home</a></li>
			<li><a href="browse.php">Browse</a></li>
			<li class="active">Images</li>
		</ol>          
    
		<div class="well well-sm">
			<form class="form-inline" role="form" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<div class="form-group" >
					<select class="form-control" name="city">
						<option value="0">Filter by City</option>
						<?php outputCities(); ?>
					</select>
				</div>
				<div class="form-group">
					<select class="form-control" name="country">
						<option value="ZZZ">Filter by Country</option>
						<?php outputCountries(); ?>
					</select>
				</div>  
				<button type="submit" class="btn btn-primary">Filter</button>
			</form>         
		</div>      <!-- end filter well -->
         
		<div class="well">
			<div class="row">
				<!-- display image thumbnails code here -->
				<?php displayImages(); ?>
			</div>
		</div>   <!-- end images well -->

		</div>  <!-- end main content column -->
	</div>  <!-- end main content row -->
</div>   <!-- end main content container -->
   
<?php include 'includes/travel-footer.inc.php'; ?>   

 <!-- Bootstrap core JavaScript
 ================================================== -->
 <!-- Placed at the end of the document so the pages load faster -->
 <script src="bootstrap3_travelTheme/assets/js/jquery.js"></script>
 <script src="bootstrap3_travelTheme/dist/js/bootstrap.min.js"></script>
 <script src="bootstrap3_travelTheme/assets/js/holder.js"></script>
</body>
</html>