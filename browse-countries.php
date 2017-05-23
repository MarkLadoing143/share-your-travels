<?php
require_once('includes/travel-config.php');

//outputs the list of countries
function outputCountries() {
	try {
		$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$sql = "SELECT DISTINCT CountryName, GeoCountries.ISO FROM GeoCountries INNER JOIN TravelImageDetails ON GeoCountries.ISO = TravelImageDetails.CountryCodeISO ORDER BY CountryName";
		$result = $pdo->query($sql);
		while( $row = $result->fetch() ) {
			echo "<li class='list-group-item'><a href='single-country.php?iso=" . $row['ISO'] . "'>" . $row['CountryName'] . "</a></li>";
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
					<li class="active">Countries</li>
				</ol>          
		  
				<div class="jumbotron" id="postJumbo">
					<h1>Countries</h1>
					<p>We have images from these countries.</p>
					<p><a class="btn btn-warning btn-lg">Learn more &raquo;</a></p>
				</div>
				
				<ul class="list-group">  
					 <?php outputCountries(); ?>
				</ul>
		
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