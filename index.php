<?php
session_start();

if (isset($_POST['songs']))
{
	$_SESSION['shoppingCart'] = $_POST['songs'];
	header("Location: process.php");
}

?>


<html>
<title>Online Store</title>
<style>
table {
  width:500px;
  margin: 10px auto;
  height:auto;
  width:auto;
}


#list, .show {display: none; }
.hide:focus + .show {display: inline; }
.hide:focus { display: none; }
.hide:focus ~ #list { display:block; }

img
{
	width:150px;
	height:150px;
}

ul {
  list-style-type: none;
}
</style>
<body>
<center><h1>Top Singles - Online Store</h1></center>
<center>
<form action="" method="POST">


Search artist: <input type="text" name="artistName">

  Select Genre: <select name="genre">
	   	<option disabled selected value> -- select an option -- </option>

    <option value=1>Hip-Hop</option>
    <option value=2>Rock</option>
    <option value=3>Pop</option>
    <option value=4>Country</option>
  </select>

   Sort by price: <select name="sortPrice">
	   	<option disabled selected value> -- select an option -- </option>

    <option value="desc">high-low</option>
    <option value="asc">low-high</option>
  </select>

  <br /><br />
  <center><input type="submit" name="submit" value="Submit Query">
</form>
</center>
<!--
FORM SEARCH - END
-->
<?php
include ('functions.php');

$dbConn = connectToDatabase();

// base sql

$sql = "SELECT Songs.name,
				Songs.artist,
				Songs.length,
				Genres.genre,
				Catalog.price,
				Catalog.songID,
				Catalog.pictureLink
				FROM Songs
				INNER JOIN Genres ON Genres.genreID = Songs.genreID
				INNER JOIN Catalog ON Catalog.songID = Songs.songID";

// Check to see if button was pressed and atleast one option
// was selected

if (isset($_POST['submit']) && atLeastOne())
{
	$genreSet = false;
	if (isset($_POST['genre']) && $_POST['genre'] != "")
	{
		echo "genre selected";
		$sql.= " WHERE Genres.genreID=" . $_POST['genre'];
		$genreSet = true;
	}

	if (isset($_POST['artistName']) && $_POST['artistName'] != "")
	{
		echo $_POST['artistName'];
		if ($genreSet) $sql.= " AND ";
		$sql.= " WHERE Songs.artist='" . $_POST['artistName'] . "'";
	}

	if (isset($_POST['sortPrice']))
	{
		echo "somethign selected";
		$sql.= " ORDER BY price " . $_POST['sortPrice'];
	}
}

$do = $_SERVER['PHP_SELF'];
echo "<form method='POST' action='" . htmlspecialchars($do) . "'>";
displayData($dbConn, $sql);
echo "<input type='submit' name='buy' value='Buy Now'>";
echo "</form>";

function atLeastOne()
{


 return isset($_POST['genre']) || isset($_POST['sortPrice']) 
							 || isset($_POST['artistName']);

}




?>
</body>
</html>
