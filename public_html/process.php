<?php
	// LINK TO GITHUB: https://github.com/EddySigma/ShoppingCarProject
	// LINK TO TRELLO: https://trello.com/b/ISB224wM/team-project
	// LINK TO SCHEME, STORY, AND MOCKUP: https://docs.google.com/document/d/1bLvSXYz2f04fX__txUaq6gRwudEKtYop4M7HvVejhRk/edit?usp=sharing
	
	 // starting the session
	session_start();
?>

<html>
<head>
<link rel="icon"
      type="image/png"
      href="images/favicon.ico">
<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

<title>Shopping Cart</title>
<link rel="stylesheet" type="text/css" href="css/theme.css">

</head>

<body>

<?php

	include('functions.php');
	$dbConn = connectToDatabase();
	
	// using sessions
	$songs = $_SESSION['shoppingCart'];

		// to get the songs that were selected
		$placeholders  = implode(",",$songs);

		$sql = "SELECT Songs.name,
				Songs.artist,
				Genres.genre,
				Catalog.price,
				Catalog.songID,
				Catalog.pictureLink,
				Songs.length
				FROM Songs
				INNER JOIN Genres ON Genres.genreID = Songs.genreID
				INNER JOIN Catalog ON Catalog.songID = Songs.songID
				WHERE Catalog.songID IN ($placeholders)";

		echo "<center><h2 style='background-color:#911C16;'>Here is your shopping cart</h2></center>";
					echo "<div class='songDisplay'>";

	if(count($songs) == 0)
		echo "<center><h1>Nothing selected</h1></center>";
		
		
			

	else {
		
				$total = displayShoppingCart($dbConn,$sql);

		echo "<div class='outer'><center><div class='box'>Total:$$total</div></center></div>";
	}
	
	echo "<center><a href='javascript:history.go(-1)'><h3>Go back to Music Store</h3></center>";

	echo "</div>";

	
?>

</div>
 
</body>

</html>

