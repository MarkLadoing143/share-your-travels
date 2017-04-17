<?php
require_once('includes/travel-config.php');

//outputs list of users
function outputUsers() {
	try {
		$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$sql = "SELECT FirstName, LastName, UID FROM traveluserdetails";
		$result = $pdo->query($sql);
		while( $row = $result->fetch() ) {
			echo "<li class='list-group-item'><a href='single-user.php?id=" . $row['UID'] . "'>" . utf8_encode($row['FirstName'] . " " . $row['LastName']) . "</a></li>";
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
					<li class="active">Users</li>
				</ol>          
		  
				<div class="jumbotron" id="postJumbo">
					<h1>Users</h1>
					<p>Learn about other users... or create your own user profile.</p>
					<p><a class="btn btn-warning btn-lg">Learn more &raquo;</a></p>
				</div>
				
				<ul class="list-group">  
					 <?php outputUsers(); ?>
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