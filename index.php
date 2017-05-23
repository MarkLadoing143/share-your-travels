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

		
<div id="myCarousel" class="carousel slide" data-ride="carousel"> <!-- start carousel -->
	<!-- Indicators -->
	<ol class="carousel-indicators">
		<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
		<li data-target="#myCarousel" data-slide-to="1"></li>
		<li data-target="#myCarousel" data-slide-to="2"></li>
	</ol>

	<!-- Wrapper for slides -->
	<div class="carousel-inner" role="listbox">
		<div class="item active">
			<img src="travel-images/large/6114881215.jpg" alt="">
			<div class="carousel-caption">
				<h2>Brandenburg Gate, Berlin</h2>
				<p><a class="btn btn-primary btn-lg" href="single-image.php?id=25" role="button">Learn more</a></p>
			</div>
		</div>

		<div class="item">
			<img src="travel-images/large/6115548152.jpg" alt="">
			<div class="carousel-caption"> <!-- does not work -->
				<h2>Checkpoint Charlie</h2>
				<p><a class="btn btn-primary btn-lg" href="single-image.php?id=28" role="button">Learn more</a></p>
			</div>
		</div>

		<div class="item">
			<img src="travel-images/large/6114960821.jpg" alt="">
			<div class="carousel-caption">
				<h2>Downtown Frankfurt</h2>
				<p>Downtown Frankfurt from the Frankfurt Cathedral</p>
				<p><a class="btn btn-primary btn-lg" href="single-image.php?id=24" role="button">Learn more</a></p>
			</div>
		</div>
	</div>

	<!-- Left and right controls -->
	<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
		<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		<span class="sr-only">Previous</span>
	</a>
	<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
		<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
		<span class="sr-only">Next</span>
	</a>
</div> <!-- end carousel -->
		

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