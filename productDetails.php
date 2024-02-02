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
    $currentDate = date('Y-m-d');
    $isOnOffer = $row['Offered'] == 1 && $currentDate >= $row['OfferStartDate'] && $currentDate <= $row['OfferEndDate'];

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

     // Display the product's price
     if ($isOnOffer && $row['OfferedPrice'] < $row['Price']) {
      $formattedOfferPrice = number_format($row["OfferedPrice"], 2);
      $discountPercentage = round((1 - ($row['OfferedPrice'] / $row['Price'])) * 100);  
      echo "<p class='showcase-badge'style='background-color: var(--ocean-green);  color: white; font-weight: var(--weight-500); padding: 0 8px; border-radius: var(--border-radius-sm); display: inline-block;'>Offer {$discountPercentage}%</p>"; 
      echo "<div class='price-box' style='display: flex; align-items: baseline;'>";
      echo "<p style='font-size: 1.4em; color: red !important; font-weight: bold; margin-bottom: 15px;'>S$ $formattedOfferPrice</p>";
      echo "<del style='font-size: 1.4em; color: grey; margin-left: 8px;'>$" . htmlspecialchars($row['Price'],2) . "</del>";                    
      echo "</div>"; // .price-box
      } else {
            $formattedPrice = number_format($row["Price"], 2);
            echo "<p style='font-size: 1.4em; color: red; font-weight: bold; margin-bottom: 15px;'>S$ $formattedPrice</p>";
      }

    // Add to Cart Form
    echo "<form action='cartFunctions.php' method='post' style='margin-bottom: 15px;'>";
    $cartQtyQuery = "SELECT Quantity FROM ShopCartItem WHERE ProductID=? AND ShopCartID=?";
    $cartStmt = $conn->prepare($cartQtyQuery);
    $cartStmt->bind_param("ii", $pid, $_SESSION["Cart"]); // Assuming $_SESSION["Cart"] holds the Cart ID
    $cartStmt->execute();
    $cartResult = $cartStmt->get_result();
    $cartStmt->close();
    $cartQty = 0;
    if ($cartRow = $cartResult->fetch_array()) {
        $cartQty = $cartRow['Quantity'];
    }
    $availableQty = min($row['Quantity'] - $cartQty, 10);

    // Check if the product is out of stock
    if ($row['Quantity'] <= 0) {
        echo "<p class='showcase-badge' style='background-color: red;  color: white; font-weight: var(--weight-500); padding: 0 8px; border-radius: var(--border-radius-sm); display: inline-block;'>Out of Stock!</p> ";
        echo "<button type='submit' disabled style='margin: 15px 0; color: white; border-radius:6px; background-color: hsl(353, 95%, 76%); padding: 6px 7px 6px 7px; opacity: 0.5;'>Add to Cart</button>";
    } 
    elseif ($availableQty <= 0) {
        echo "<p class='showcase-badge' style='background-color: red;  color: white; font-weight: var(--weight-500); padding: 0 8px; border-radius: var(--border-radius-sm); display: inline-block;'>Max Quantity Reached!</p> ";
        echo "<button type='submit' disabled style='margin: 15px 0; color: white; border-radius:6px; background-color: hsl(353, 95%, 76%); padding: 6px 7px 6px 7px; opacity: 0.5;'>Add to Cart</button>";
    }
    else {
        echo "<input type='hidden' name='action' value='add' />";
        echo "<input type='hidden' name='product_id' value='$pid' />";
        echo "Quantity: <select name='quantity' style='margin-right: 10px;' required>";
        
        // Populate the dropdown
        for ($i = 1; $i <= $availableQty; $i++) {
            echo "<option value='$i'>$i</option>";
        }
    
        echo "</select>";
        echo "<button type='submit' style='margin: 15px 0; color: white; border-radius:6px; background-color: hsl(353, 95%, 76%); padding: 6px 7px 6px 7px;'>Add to Cart</button>";
    }
    echo "</form>";

    echo "</div>"; // End of right column
    echo "</div>"; // End of row
}

$conn->close(); // Close database connection
?>
</div> <!-- End of container -->
<?php 
include("footer.php"); // Include the Page Layout footer
?>
