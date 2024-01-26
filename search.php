<?php 
//Session included in header.php
include("header.php"); // Include the Page Layout header
?>



<?php
// The non-empty search keyword is sent to server
if (isset($_GET["search"]) && trim($_GET['search']) != "") {
    // To Do (DIY): Retrieve list of product records with "ProductTitle" or "ProductDesc"
    include_once("mysql_conn.php");
    $qry = "SELECT * FROM product WHERE ProductTitle LIKE '%" . $_GET["search"] . "%' OR ProductDesc LIKE '%" . $_GET["search"] . "%'";
    $result=$conn->query($qry);
	// contains the keyword entered by shopper, and display them in a table.
	echo "<div class='row' style='padding:5px'>";// Start a new row

	// Left column - display a text link showing the product's name ,
	//               display the selling price in red in a new paragraph
    if($result-> num_rows>0){
    while ($row=$result-> fetch_array()){
        echo "<div class='row' style='padding:5px'>";// Start a new row
        $product ="productDetails.php?pid=$row[ProductID]";
        echo "<div class='col-8'>" ;// 67% of row width
        echo "<p><a href=$product>$row[ProductTitle]</a></p>";
        echo"</div>";
        echo"</div>"; //End of a row
    }//End of a row
	// To Do (DIY): End of Code
}
else{
    echo "No record found!";
}
}

echo "</div>"; // End of container
include("footer.php"); // Include the Page Layout footer
?>