<?php
if( !isset($_GET['id']) || !is_numeric($_GET['id']) ) { header('Location: error.php'); }

require_once('includes/travel-config.php');

//outputs main image
function outputImage() {
	if( isset($_GET['id']) ) {
		try {
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			$sql = "SELECT Path, Title, Description FROM travelimage INNER JOIN travelimagedetails ON travelimage.ImageID = travelimagedetails.ImageID WHERE travelimage.ImageID = ?";
			$statement = $pdo->prepare($sql);
			$statement->bindValue(1, $_GET['id']);
			$statement->execute();
			while( $row = $statement->fetch() ) {
				echo "<div class='col-md-12'><h1>" . $row['Title'] . "</h1><hr/></div>";
				echo "<div class='col-md-9'>";
				echo "<a data-toggle='modal' data-target='#myModal'><img src='travel-images/medium/" . $row['Path'] . "' alt='" . $row['Title'] . "' class='thumbnail'/></a><br/>";
				echo "<p>" . $row['Description'] . "</p>";
				echo "</div>";
			}
			$pdo = null;
		}
		catch (PDOException $e) {
			die( $e->getMessage() );
		}
	}
}

//modal for full size image
function fullSizeImage() {
	if( isset($_GET['id']) ) {
		try {
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
			$sql = "SELECT Path, Title FROM travelimage INNER JOIN travelimagedetails ON travelimage.ImageID = travelimagedetails.ImageID WHERE travelimage.ImageID = ?";
			$statement = $pdo->prepare($sql);
			$statement->bindValue(1, $_GET['id']);
			$statement->execute();
			while( $row = $statement->fetch() ) {
				echo "<div class='modal fade' id='myModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>";
				echo "<div class='modal-dialog'>";
				echo "<div class='modal-content'>";
				echo "<div class='modal-header'>";
				echo "<button type='button' class='close' data-dismiss='modal'>&times;</button>";
				echo "<h4 class='modal-title'>" . $row['Title'] . "</h4>";
				echo "</div>";
				echo "<div class='modal-body'>";
				echo "<img src='travel-images/large/" . $row['Path'] . "' alt='" . $row['Title'] . "' />";
				echo "</div>";
				echo "</div>";
				echo "</div>";
				echo "</div>";
			}
			$pdo = null;
		}
		catch (PDOException $e) {
			die( $e->getMessage() );
		}
	}
}

//gets the link and name of image's owner
function getUserName() {
	if( isset($_GET['id']) ) {
		try {
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			$sql = "SELECT travelimage.UID, FirstName, LastName FROM travelimage INNER JOIN traveluserdetails ON travelimage.UID = traveluserdetails.UID WHERE ImageID = ?";
			$statement = $pdo->prepare($sql);
			$statement->bindValue(1, $_GET['id']);
			$statement->execute();
			while( $row = $statement->fetch() ){
				echo "<a href='single-user.php?id=" . $row['UID'] . "'>" . utf8_encode( $row['FirstName'] . " " . $row['LastName'] ). "</a>";
			}
			$pdo = null;
		}
		catch (PDOException $e) {
			die( $e->getMessage() );
		}
	}
}

//get the details of the image
function getImageDetails() {
	if( isset($_GET['id']) ) {
		try {
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			$sql = "SELECT AsciiName, CountryName, travelimagedetails.CountryCodeISO FROM travelimagedetails LEFT JOIN geocities ON GeoNameID = CityCode LEFT JOIN geocountries ON travelimagedetails.CountryCodeISO = ISO WHERE ImageID = ?";
			$statement = $pdo->prepare($sql);
			$statement->bindValue(1, $_GET['id']);
			$statement->execute();
			while( $row = $statement->fetch() ) {
				if( !is_null($row['AsciiName']) ) { //if city not available, display only the country
						echo $row['AsciiName'] . ", ";
						echo "<a href='single-country.php?iso=" . $row['CountryCodeISO'] . "'>" . $row['CountryName'] . "</a>";
				}
				else if( !is_null($row['CountryName']) ) {
					echo "<a href='single-country.php?iso=" . $row['CountryCodeISO'] . "'>" . $row['CountryName'] . "</a>";
				}
			}
			$pdo = null;
		}
		catch (PDOException $e) {
			die( $e->getMessage() );
		}
	}
}

//gets the title of the image
function getImageTitle() {
	if( isset($_GET['id']) ) {
		try {
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			$sql = "SELECT Title FROM travelimagedetails WHERE ImageID = ?";
			$statement = $pdo->prepare($sql);
			$statement->bindValue(1, $_GET['id']);
			$statement->execute();
			$result = $statement->fetch();
			echo $result['Title'];
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
					<li><a href="browse-images.php">Images</a></li>
					<li class="active"><?php getImageTitle(); ?></li>
				</ol>
				
				<div class="row">
					
					<?php outputImage(); ?>
					
					<div class="col-md-3">
						<div class="panel panel-default">
							<div class="panel-heading">Image By</div>
							<div class="panel-body">
								<?php getUserName(); ?>
							</div>
						</div>
						
						<div class="panel panel-default">
							<div class="panel-heading">Image Details</div>
							<div class="panel-body">
								<?php getImageDetails(); ?>	
								<?php fullSizeImage(); ?>
							</div>
						</div>
						
						<div class="panel panel-default">
							<div class="panel-heading">Social</div>
							<div class="panel-body">
								<p><a class="btn btn-primary btn-md">Add to Favorites</a></p>
								<p><a class="btn btn-success btn-md">View Favorites</a></p>
							</div>
						</div>
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