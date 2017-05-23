<?php
require_once('includes/travel-config.php');

function outputContinents() {
	try {
		$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$sql = "SELECT ContinentName FROM GeoContinents GROUP BY ContinentName";
		$result = $pdo->query($sql);
		while( $row = $result->fetch() ) {
			echo "<li class='list-group-item'><a href=#>" . $row['ContinentName'] . "</a></li>";
		}
		$pdo = null;
	}
	catch (PDOException $e) {
		die( $e->getMessage() );
	}
}

function outputPopCountries() {
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
		 
		 <div class="panel panel-default">
           <div class="panel-heading">Search</div>
           <div class="panel-body">
             <form>
               <div class="input-group">
                  <input type="text" class="form-control" placeholder="search ...">
                  <span class="input-group-btn">
                    <button class="btn btn-warning" type="button"><span class="glyphicon glyphicon-search"></span>          
                    </button>
                  </span>
               </div>  
             </form>
           </div>
         </div>  <!-- end search panel -->       
      
         <div class="panel panel-info">
           <div class="panel-heading">Continents</div>
           <ul class="list-group">   
		    <?php outputContinents(); ?>

           </ul>
         </div>  <!-- end continents panel -->  
         <div class="panel panel-info">
           <div class="panel-heading">Popular Countries</div>
           <ul class="list-group">  
		    <?php outputPopCountries(); ?>
  
           </ul>
         </div>  <!-- end countries panel -->    