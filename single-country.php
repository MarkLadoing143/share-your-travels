<?php
if( !isset($_GET['iso']) || $_GET['iso'] == "" ) { header('Location: error.php'); }

require_once('includes/travel-config.php');

//outputs the details of the country
function outputCountryDetails() {
	if( isset($_GET['iso']) ) {
		try {
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			$sql = "SELECT CountryName, Capital, Area, Population, CurrencyName, CountryDescription FROM GeoCountries where ISO= ?";
			$statement = $pdo->prepare($sql);
			$statement->bindValue(1, $_GET['iso']);
			$statement->execute();
			while( $row = $statement->fetch() ) {
				echo "<h2>" . $row['CountryName'] . "</h2>";
				echo "<p>Capital: <b>" . $row['Capital'] . "</b></p>";
				echo "<p>Area: <b>" . number_format($row['Area']) . "</b> sq. km</p>";
				echo "<p>Population: <b>" . number_format($row['Population']) . "</b></p>";
				echo "<p>Currency: <b>" . $row['CurrencyName'] . "</b></p>";
				echo "<p>" . utf8_encode($row['CountryDescription']) . "</p>";
			}
			$pdo = null;
		}
		catch (PDOException $e) {
			die( $e->getMessage() );
		}
	}
}

//gets the name of the country
function getCountry() {
	if( isset($_GET['iso']) ) {
		try {
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			$sql = "SELECT CountryName FROM GeoCountries where ISO= ?";
			$statement = $pdo->prepare($sql);
			$statement->bindValue(1, $_GET['iso']);
			$statement->execute();
			while( $row = $statement->fetch() ) {
				echo $row['CountryName'];
			}
			$pdo = null;
		}
		catch (PDOException $e) {
			die( $e->getMessage() );
		}
	}
}

//gets the images related to the country
function getCountryImages() {
	if( isset($_GET['iso']) ) {
		try {
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			$sql = "SELECT TravelImage.ImageID, Path, Title FROM TravelImage INNER JOIN TravelImageDetails ON TravelImage.ImageID = TravelImageDetails.ImageID WHERE TravelImageDetails.CountryCodeISO = ?";
			$statement = $pdo->prepare($sql);
			$statement->bindValue(1, $_GET['iso']);
			$statement->execute();
			while( $row = $statement->fetch() ) {
				echo "<div class='thumbnails col-md-3'>";
				echo "<a href= 'single-image.php?id=" . $row['ImageID'] . "'><img src='travel-images/medium/" . $row['Path'] . "' alt='" . $row['Title'] . "' class='img-thumbnail col-md-12' /></a>";
				echo "</div>";
			}
			$pdo = null;
		}
		catch (PDOException $e) {
			die( $e->getMessage() );
		}
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
					<li><a href="browse-countries.php">Countries</a></li>
					<li class="active"><?php getCountry(); ?></li>
				</ol>
			
				<div class="well">
					<?php outputCountryDetails(); ?>
				</div>
				
				
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Images from <?php getCountry(); ?></h3>
					</div>
					<div class="panel-body">
						<?php getCountryImages(); ?>
					</div>
				</div>
			
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