<?php
if( !isset($_GET['id']) || !is_numeric($_GET['id']) ) { header('Location: error.php'); }

require_once('includes/travel-config.php');

//gets the user's information
function getUserDetails() {
	if( isset($_GET['id']) ) {
		try {
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			$sql = "SELECT FirstName, LastName, Address, City, Country, Email FROM traveluserdetails WHERE UID= ?";
			$statement = $pdo->prepare($sql);
			$statement->bindValue(1, $_GET['id']);
			$statement->execute();
			while( $row = $statement->fetch() ) {
				echo "<h2>" . utf8_encode($row['FirstName'] . " " . $row['LastName']) . "</h2>";
				echo "<p>Address: <b>" . utf8_encode($row['Address']) . "</b></p>";
				echo "<p>City, Country: <b>" . utf8_encode($row['City'] . ", " . $row['Country']) . "</b></p>";
				echo "<p>Email: <b>" . utf8_encode($row['Email']) . "</b></p>";
			}
		}
		catch (PDOException $e) {
			die( $e->getMessage() );
		}
	}
}

//gets the user's full name
function getUserName() {
	if( isset($_GET['id']) ) {
		try {
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			$sql = "SELECT FirstName, LastName FROM traveluserdetails WHERE UID = ?";
			$statement = $pdo->prepare($sql);
			$statement->bindValue(1, $_GET['id']);
			$statement->execute();
			while( $row = $statement->fetch() ) {
				echo utf8_encode($row['FirstName'] . " " . $row['LastName']);
			}
			$pdo = null;
		}
		catch (PDOException $e) {
			die( $e->getMessage() );
		}
	}
}

//gets images owned by the user
function getUserImages() {
	if( isset($_GET['id']) ) {
		try {
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			$sql = "SELECT travelimagedetails.ImageID, Path, Title FROM travelimage INNER JOIN travelimagedetails ON travelimage.ImageID = travelimagedetails.ImageID WHERE travelimage.UID = ?";
			$statement = $pdo->prepare($sql);
			$statement->bindValue(1, $_GET['id']);
			$statement->execute();
			while( $row = $statement->fetch() ) {
				echo "<div class='thumbnails col-md-3'>";
				echo "<a href= 'single-image.php?id=". $row['ImageID'] . "'><img src='travel-images/medium/" . $row['Path'] . "' alt='" . $row['Title'] . "' class='img-thumbnail col-md-12' /></a>";
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
					<li><a href="browse-users.php">Users</a></li>
					<li class="active"><?php getUserName(); ?></li>
				</ol> 
				
				<div class="well">
					<?php getUserDetails(); ?>
				</div>
				
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Images from <?php getUserName(); ?></h3>
					</div>
					<div class="panel-body">
						<?php getUserImages(); ?>
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