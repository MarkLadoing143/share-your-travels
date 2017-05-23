<?php
if( !isset($_GET['id']) || !is_numeric($_GET['id']) ) { header('Location: error.php'); }

require_once('includes/travel-config.php');

//outputs the post's title and message
function outputPost() {
	if( isset($_GET['id']) ) {
		try {
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			$sql = "SELECT PostID, Title, Message FROM TravelPost WHERE PostID = ?";
			$statement = $pdo->prepare($sql);
			$statement->bindValue(1, $_GET['id']);
			$statement->execute();
			while( $row = $statement->fetch() ) {
				echo "<div class='col-md-12'><h2>" . utf8_encode($row['Title']) . "</h2><hr/></div>";
				echo "<div class='col-md-9'>";
				echo "<p>" . utf8_encode($row['Message']) . "</p>";		
				getPostImages();
				echo "</div>";
			}
			$pdo = null;
		}
		catch (PDOException $e) {
			die( $e->getMessage() );
		}
	}
}

//gets the user's name and a link to their page
function getPostUserLink() {
	if( isset($_GET['id']) ) {
		try {
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			$sql = "SELECT TravelPost.UID, TravelUserDetails.FirstName, TravelUserDetails.LastName FROM TravelPost INNER JOIN TravelUserDetails ON TravelPost.UID = TravelUserDetails.UID WHERE PostID = ?";
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

//gets the title of the post
function getPostName() {
	if( isset($_GET['id']) ) {
		try {
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			$sql = "SELECT Title FROM TravelPost WHERE PostID = ?";
			$statement = $pdo->prepare($sql);
			$statement->bindValue(1, $_GET['id']);
			$statement->execute();
			while( $row = $statement->fetch() ){
				echo $row['Title'];
			}
			$pdo = null;
		}
		catch (PDOException $e) {
			die( $e->getMessage() );
		}
	}
}

//gets the user's id
function getUserID() {
	if( isset($_GET['id']) ) {
		try {
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			$sql = "SELECT DISTINCT UID FROM TravelPost WHERE PostID = ?";
			$statement = $pdo->prepare($sql);
			$statement->bindValue(1, $_GET['id']);
			$statement->execute();
			$result = $statement->fetch();
			return $result['UID'];
			$pdo = null;
		}
		catch (PDOException $e) {
			die( $e->getMessage() );
		}
	}
}

//gets the user's other related posts
function getUserPosts() {
	try {
		$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$sql = "SELECT PostID, Title FROM TravelPost WHERE UID = " . getUserID();
		$result = $pdo->query($sql);
		while( $row = $result->fetch() ) {
			echo "<p><a href='single-post.php?id=" . $row['PostID'] . "'>" . $row['Title'] . "</a></p>";
		}
		$pdo = null;
	}
	catch (PDOException $e) {
		die( $e->getMessage() );
	}
}

//gets related images for the post
function getPostImages() {
	if( isset($_GET['id']) ) {
		try {
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			$sql = "SELECT TravelPostImages.ImageID, Path, Title FROM TravelPostImages INNER JOIN TravelImage ON TravelPostImages.ImageID = TravelImage.ImageID INNER JOIN TravelImageDetails ON TravelPostImages.ImageID = TravelImageDetails.ImageID WHERE PostID = ?";
			$statement = $pdo->prepare($sql);
			$statement->bindValue(1, $_GET['id']);
			$statement->execute();
			echo "<div class='well'>";
			echo "<h4>Images From Post</h4>";
			echo "<div class='row'>";
			while( $row = $statement->fetch() ){
				echo "<div class='thumbnails col-md-3'>";
				echo "<a href= 'single-image.php?id=" . $row['ImageID'] . "'><img src='travel-images/medium/" . $row['Path'] . "' alt='" . $row['Title'] . "' class='img-thumbnail' /></a>";
				echo "</div>";
			}
			echo "</div>";
			echo "</div>";
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
					<li><a href="browse-posts.php">Posts</a></li>
					<li class="active"><?php getPostName(); ?></li>
				</ol>
				
				<div class="row">
				
					<?php outputPost(); ?>
					
					<div class="col-md-3">
						<div class="panel panel-default">
							<div class="panel-heading">Posted By</div>
							<div class="panel-body">
								<?php getPostUserLink(); ?><hr/>
								<p><i>Posts by this user</i></p>
								<?php getUserPosts(); ?>
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