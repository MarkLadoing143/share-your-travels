<?php
require_once('includes/travel-config.php');

//outputs the post
function outputPost() {
	try {
		$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$sql = "SELECT PostID, travelpost.UID, Title, traveluserdetails.FirstName, traveluserdetails.LastName, Message, PostTime FROM travelpost INNER JOIN traveluserdetails ON travelpost.UID = traveluserdetails.UID";
		$result = $pdo->query($sql);
		while( $row = $result->fetch() ) {
			echo "<div class='row'>";
			echo "<div class='col-md-2'>";
			getPostImage($row['PostID']);
			echo "</div>";
			echo "<div class='col-md-10'>";
			echo "<h2>" . $row['Title'] . "</h2>";
			echo "<div class='details'>";
			echo "Posted By <a href='single-user.php?id=" . $row['UID'] . "'>" . utf8_encode($row['FirstName'] . " " . $row['LastName']) . "</a>";
			
			$date = new DateTime($row['PostTime']);
			
			echo "<span class='pull-right'>" . $date->format('n/j/Y') . "</span>";
			echo "</div>";
			
			$excerpt = utf8_encode( substr($row['Message'],0,200) . '...' );
			
			echo "<p class='excerpt'>" . $excerpt . "</p>";
			echo "<p><a href='single-post.php?id=" . $row['PostID'] . "' class='btn btn-primary btn-sm'>Read More</a></p>";
			echo "</div>";
			echo "</div><hr/>";
		}
		$pdo = null;
	}
	catch (PDOException $e) {
		die( $e->getMessage() );
	}
}

//helper function to get the post's main image
function getPostImage($postID) {
	$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	$sql = "SELECT Path, Title FROM travelimage INNER JOIN travelimagedetails ON travelimage.ImageID = travelimagedetails.ImageID INNER JOIN travelpostimages ON travelimage.ImageID = travelpostimages.ImageID WHERE PostID = " . $postID . " GROUP BY PostID";
	$result = $pdo->query($sql);
	while( $row = $result->fetch() ) {
		echo "<div class='postThumbnail'><img src='travel-images/medium/" . $row['Path'] . "' alt='" . $row['Title'] . "' class='img-thumbnail'/></div>";
	}
	$pdo = null;
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
					<li class="active">Posts</li>
				</ol>
				
				<div class="jumbotron" id="postJumbo">
					<h1>Posts</h1>
					<p>Read travellers' posts... or create your own.</p>
					<p><a class="btn btn-warning btn-lg">Learn more &raquo;</a></p>
				</div>
				
				<div class="postlist">
					<?php 
					outputPost(); 
					?>
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