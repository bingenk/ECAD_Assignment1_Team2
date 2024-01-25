<?php
// Detect the current session
session_start();
// Include the Page Layout header 
include("header.php");
if (! isset($_SESSION["ShopperID"])) { // Check if user logged in 
	// redirect to login page if the session variable shopperid is not set
	header ("Location: login.php");
	exit;
}
?>
<h2 class="shopping-cart-title">Shopping Cart</h2>
<div class="shopping-cart">
  <div class="column-labels">
    <label class="product-image">Image</label>
    <label class="product-details">Product</label>
    <label class="product-price">Price</label>
    <label class="product-quantity">Quantity</label>
    <label class="product-removal">Remove</label>
    <label class="product-line-price">Total</label>
  </div>

  <?php
if (isset($_SESSION["Cart"])) {
	include_once("mysql_conn.php");
	// To Do 1 (Practical 4): 
	// Retrieve from database and display shopping cart in a table
	$qry = "SELECT s.*, p.ProductImage, p.ProductDesc, (s.Price * s.Quantity) AS Total
        FROM ShopCartItem s
        INNER JOIN Product p ON s.ProductID = p.ProductID
        WHERE s.ShopCartID = ?";

	$stmt = $conn->prepare($qry);
	$stmt->bind_param("i",$_SESSION["Cart"]); //"i" - integer
	$stmt->execute();
	$result = $stmt->get_result();
	$stmt->close();

	if ($result->num_rows > 0) {

    $_SESSION["Items"] = array();
    $subTotal = 0; 
    while ($row = $result->fetch_array()) {
      array_push($_SESSION["Items"], $row["ProductID"]);
      echo "<div class='product'>";
      echo "<div class='product-image'>";
      echo "<img src='Images/Products/$row[ProductImage]' />";
      echo "</div>";
      echo "<div class='product-details'>";
      echo "<div class='product-title'>$row[Name]</div>";
      echo "<p class='product-description'>$row[ProductDesc]</p>";
      echo "</div>";
      echo "<div class='product-price'>$row[Price]</div>";
      echo "<form action='cartFunctions.php' method='post'>";
			echo "<select name='quantity' onChange='this.form.submit()' >";
			for($i=1; $i<=10; $i++) {
				if ($i == $row["Quantity"]) 
					// Select drop-down list item with value same as the quantity of purchase
				    $selected ="selected";
				else 
					 $selected ="";// No specific item is selected
				echo "<option value='$i' $selected>$i</option>";			
			}
			echo "</select>";
			echo "<input type='hidden' name='action' value='update' />";
			echo "<input type='hidden' name='product_id' value='$row[ProductID]'/>";
			echo "</form>";

      echo "<form action='cartFunctions.php' method='post'>";
      echo "<div class='product-removal'>";
      echo "<input type='hidden' name='action' value='remove' />";
      echo "<input type='hidden' name='product_id' value='$row[ProductID]'/>";
      echo "<button class='remove-product'>Remove</button>";
      echo "</div>";
      echo "</form>";
      $formattedTotal = number_format($row["Total"], 2);
      echo "<div class='product-line-price'>$formattedTotal</div>";
      echo "</div>";
       // Store the shopping cart items in session variable as an associate array
				$_SESSION["Items"][]=array("productId"=>$row["ProductID"],
        "name"=>$row["Name"],
        "price"=>$row["Price"],
        "quantity"=>$row["Quantity"]);
        // Accumulate the running sub-total
        $subTotal += $row["Total"];
    }
    

    
  
  echo '<div class="totals">';
  echo '<div class="totals-item">';
  echo '<label>Subtotal</label>';
  $formattedSubTotal = number_format($subTotal, 2);
  echo '<div class="totals-value" id="cart-subtotal">'.$formattedSubTotal.'</div>';
  echo '</div>';
  echo '<div class="totals-item">';
  echo '<label>Tax (5%)</label>';
  echo '<div class="totals-value" id="cart-tax">3.60</div>';
  echo '</div>';
  echo '<div class="totals-item">';
  echo '<label>Shipping</label>';
  echo '<div class="totals-value" id="cart-shipping">15.00</div>';
  echo '</div>';
  echo '<div class="totals-item totals-item-total">';
  echo '<label>Grand Total</label>';
  echo '<div class="totals-value" id="cart-total">90.57</div>';
  echo '</div>';
  echo '</div>';
  echo '<button class="checkout">Checkout</button>';
  echo '</div>';
		}
    else {
      echo "<h3 style='text-align:center; color:red;'>Empty shopping cart!</h3>";
    }





}
 

else {
	echo "<h3 style='text-align:center; color:red;'>Empty shopping cart!</h3>";
}


// Include the Page Layout footer 
include("footer.php");
?>
