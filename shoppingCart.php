<?php
//Session included in header.php
// Include the Page Layout header 
include("header.php");
if (!isset($_SESSION["ShopperID"])) { // Check if user logged in 
    header("Location: login.php");
    exit;
}

// Handle shipping option form submission
if (isset($_POST['shipping_option'])) {
    $_SESSION['selected_shipping'] = $_POST['shipping_option'];
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
    $qry = "SELECT s.*, p.ProductImage, p.ProductDesc, p.Offered, p.OfferedPrice, p.OfferStartDate, p.OfferEndDate, (s.Price * s.Quantity) AS Total,p.Quantity AS Stock
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
        $currentDate = date('Y-m-d');
        $isOnOffer = $row['Offered'] == 1 && $currentDate >= $row['OfferStartDate'] && $currentDate <= $row['OfferEndDate'];
          
        // Choose the correct price based on whether the item is on offer
        $price = $isOnOffer ? $row["OfferedPrice"] : $row["Price"];
        $totalPrice = $price * $row["Quantity"];
        $formattedPrice = number_format($price, 2);
        $formattedTotal = number_format($totalPrice, 2);
      
      echo "<div class='product'>";
      echo "<div class='product-image'>";
      echo "<img src='Images/Products/$row[ProductImage]' />";
      echo "</div>";
      echo "<div class='product-details'>";
      echo "<div class='product-title'>$row[Name]</div>";
      echo "<p class='product-description'>$row[ProductDesc]</p>";
      echo "</div>";

      echo "<div class='product-price'>$formattedPrice</div>";

  echo "<form action='cartFunctions.php' method='post'>";
  echo "<div class='product-quantity'>";
  echo "<select name='quantity' onChange='this.form.submit()'>";
  if($row["Stock"] > 10){
     
			for($i=1; $i<=10; $i++) {
				if ($i == $row["Quantity"]) 
					// Select drop-down list item with value same as the quantity of purchase
				    $selected ="selected";
				else 
					 $selected ="";// No specific item is selected
				echo "<option value='$i' $selected>$i</option>";			
			}
    }

  else{
   $stock_left = $row["Stock"];
    for($i=1; $i<=$stock_left; $i++) {
      if ($i == $row["Quantity"]) 
        // Select drop-down list item with value same as the quantity of purchase
          $selected ="selected";
      else 
        $selected ="";// No specific item is selected
      echo "<option value='$i' $selected>$i</option>";
    }

  }
      echo "</select>";
      echo "<input type='hidden' name='action' value='update' />";
      echo "<input type='hidden' name='product_id' value='$row[ProductID]'/>";
      echo "</div>"; // Close product-quantity
      echo "</form>";

     echo "<form action='cartFunctions.php' method='post'>";
  echo "<div class='product-removal'>";
  echo "<input type='hidden' name='action' value='remove' />";
  echo "<input type='hidden' name='product_id' value='$row[ProductID]'/>";
  echo "<button class='remove-product'>Remove</button>";
  echo "</div>"; // Close product-removal
  echo "</form>";


  echo "<div class='product-line-price'>$formattedTotal</div>";

      echo "</div>";
       // Store the shopping cart items in session variable as an associate array
				$_SESSION["Items"][]=array("productId"=>$row["ProductID"],
        "name"=>$row["Name"],
        "price"=>$row["Price"],
        "quantity"=>$row["Quantity"]);
        // Accumulate the running sub-total
        $subTotal += $formattedTotal;
    }
    
  echo '<div class="cart-bottom-section">'; // Container for the form and totals

  // Delivery Options Form

  
  echo '<div class="delivery-options">';
  echo '<form id="deliveryForm" action="" method="post">'; // This form will now submit when a shipping option is selected
  echo '<label>Choose Shipping:</label><br/>';
  echo '<input type="radio" id="normal" name="shipping_option" value="normal" onchange="this.form.submit()"'.(isset($_SESSION['selected_shipping']) && $_SESSION['selected_shipping'] == 'normal' ? ' checked' : '').'>';
  echo '<label for="normal">Normal (Delivery within 2 Working Days) - $5</label><br/>';
  echo '<input type="radio" id="express" name="shipping_option" value="express" onchange="this.form.submit()"'.(isset($_SESSION['selected_shipping']) && $_SESSION['selected_shipping'] == 'express' ? ' checked' : '').'>';
  echo '<label for="express">Express (Delivery within 24 Hours) - $10</label>';
  echo '</form>';
  echo '</div>';

  echo '<div class="totals">';
  echo '<div class="totals-item">';
  echo '<label>Subtotal</label>';
  $formattedSubTotal = number_format($subTotal, 2);
  echo '<div class="totals-value" id="cart-subtotal">'.$formattedSubTotal.'</div>';
  echo '</div>';
  echo '<div class="totals-item">';
  $qry2="SELECT * FROM gst
  where EffectiveDate <= ?
  ORDER BY EffectiveDate DESC LIMIT 1";
  $stmt2 = $conn->prepare($qry2);
  $date=date("Y-m-d");
  $stmt2->bind_param("s",$date); 
  $stmt2->execute();
  $result2 = $stmt2->get_result();
  $stmt2->close();
  $row2 = $result2->fetch_array();

  if($row2 != null){
    $tax = $row2["TaxRate"];
  }
  else{
    $tax = 0;
  }
  
  echo '<label>Tax ('.$tax.'%)</label>';
  $taxAmount = $subTotal * $tax/100;
  echo '<div class="totals-value" id="cart-tax">'.$taxAmount.'</div>';
  echo '</div>';
  echo '<div class="totals-item">';
  echo '<label>Shipping</label>';
 
  if ($subTotal <= 200) {
      // Check if a shipping option was previously selected
      $shipping = (isset($_SESSION['selected_shipping']) && $_SESSION['selected_shipping'] == 'express') ? 10 : 5;
      unset($_SESSION['is_free']);
  } 
  else{
      $shipping = 0;
      $_SESSION['is_free'] = 1;
  }

if(isset($_SESSION['is_free'])){
  echo '<div class="totals-value" id="cart-shipping">'.$shipping.'</div>';
}
else{
  echo '<div class="totals-value" id="cart-shipping">'.$shipping.'</div>';
}
  echo '</div>';
  echo '<div class="totals-item totals-item-total">';
  echo '<label>Grand Total</label>';
  if(isset($_SESSION['is_free'])){
    $totalprice= $subTotal + $taxAmount;
  }
  else{
    $totalprice= $subTotal + $taxAmount +$shipping ;
  }

  echo '<div class="totals-value" id="cart-total">'.$totalprice.'</div>';
  echo '</div>';
  echo '</div>';

  echo "<form method='post' action='checkout.php' onsubmit='return validateShipping()'>";       
  echo '<button class="checkout" type="submit">Checkout</button>';
  echo "</form>";

  echo '</div>';  
  echo '</div>'; // Close the cart-bottom-section div

		}
    else {      
      echo "<h3 style='text-align:center; color:red;'>Empty shopping cart!</h3>";
      echo '</div>';
    }

}
 
else {
	echo "<h3 style='text-align:center; color:red;'>Empty shopping cart!</h3>";
  echo '</div>';
}

// Include the Page Layout footer 
include("footer.php");
?>

<script>
function validateShipping() {
    if (!document.getElementById('normal').checked && !document.getElementById('express').checked) {
        alert('Please select a shipping option.');
        return false;
    }
    return true;
}
</script>