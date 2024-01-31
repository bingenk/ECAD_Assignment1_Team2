<?php 
//Session included in header.php
include("header.php"); // Include the Page Layout header
?>

<!-- Create a container, 90% width of viewport -->
<div style='width:90%; margin:auto;'>

<?php 
$pid=$_GET["pid"]; // Read Product ID from query string

// Include the PHP file that establishes database connection handle: $conn
include_once("mysql_conn.php"); 
$qry = "SELECT * from product where ProductID=?";
$stmt = $conn->prepare($qry);
$stmt->bind_param("i", $pid); // "i" - integer 
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

// Display Product information
if ($row=$result->fetch_array()){
      // Display Product's image on the left
      $img = "./Images/products/$row[ProductImage]";
      echo "<div class='row' style='display:flex; align-items: center;'>";
      echo "<div class='col-sm-6' style='margin: 15px;'>";
      echo "<img src='$img' style='min-width:90%; height:auto; display: block; margin: 15px auto;'/>";
      echo "</div>";

      // Display Product details on the right
      echo "<div class='col-sm-6' style='margin: 15px;'>";
      echo "<h2 style='margin-top:0; margin-bottom: 15px;'>$row[ProductTitle]</h2>";
      echo "<p style='font-size: 1.2em; margin-bottom: 15px;'>$row[ProductDesc]</p>";

      // Display the product's Specification
      $qry="SELECT s.SpecName,ps.SpecVal from productspec ps
            INNER JOIN specification s ON ps.SpecID=s.SpecID
            WHERE ps.ProductID=?
            ORDER BY ps.priority";
      $stmt=$conn->prepare($qry);
      $stmt->bind_param("i",$pid); // "i" - integer
      $stmt->execute();
      $result2 = $stmt->get_result();
      $stmt->close();
      while ($row2=$result2->fetch_array()){
            echo "<p style='margin-bottom: 15px;'><strong>".$row2["SpecName"].":</strong> ".$row2["SpecVal"]."</p>";
      }

      // Display the product's price and Add to Cart form
      $formattedPrice = number_format($row["Price"],2);
      echo "<p style='font-size: 1.4em; color: red; font-weight: bold; margin-bottom: 15px;'>S$ $formattedPrice</p>";
      echo "<form action='cartFunctions.php' method='post' style='margin-bottom: 15px;'>";
      echo "<input type='hidden' name='action' value='add' />";
      echo "<input type='hidden' name='product_id' value='$pid' />";
      echo "Quantity:<input type='number' name='quantity' value='1' min='1' max='10' style='width:60px; margin-right: 10px;' required />";
      echo "<button type='submit' style='margin: 15px 0; color: white; border-radius:6px; background-color: hsl(353, 95%, 76%); padding: 6px 7px 6px 7px;'>Add to Cart</button>";
      echo "</form>";

      echo "</div>"; // End of right column
      echo "</div>"; // End of row
}

$conn->close(); // Close database connnection
?>
</div> <!-- End of container -->
<?php 
include("footer.php"); // Include the Page Layout footer
?>
