<?php
//Session included in header.php
// Include the Page Layout header 
include("header.php");

$allItemsInStock = false;

  

if (!isset($_SESSION["ShopperID"])) { // Check if user logged in 
    header("Location: login.php");
    exit;
}

// Handle shipping option form submission
if (isset($_POST['shipping_option'])) {
    $_SESSION['selected_shipping'] = $_POST['shipping_option'];
}

function validateCartItems($conn) {
  include_once("mysql_conn.php");


  $isValid = true;
  $cartId = $_SESSION["Cart"];
  $qry = "SELECT s.ProductID, s.Quantity, p.Quantity AS Stock
          FROM ShopCartItem s
          JOIN Product p ON s.ProductID = p.ProductID
          WHERE s.ShopCartID = ?";
  $stmt = $conn->prepare($qry);
  $stmt->bind_param("i", $cartId);
  $stmt->execute();
  $result = $stmt->get_result();

  while ($row = $result->fetch_assoc()) {
      if ($row["Quantity"] > $row["Stock"]) {
          // Item quantity exceeds stock, adjust the cart or notify the user
          $isValid = false;
          // Optionally adjust the item quantity in the cart to match the stock level
          // Or flag this item for user notification
      }
  }
  $stmt->close();
  return $isValid;
}


if(isset($_SESSION["ConversionRate"])){

  $conversionRate = $_SESSION["ConversionRate"];    
  
}
else{
  $conversionRate = 1;
  $currency = "SGD";

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
      $allItemsInStock = true; // Assume all items are in stock initially

      $_SESSION["Items"] = array();
      $subTotal = 0; 
      while ($row = $result->fetch_array()) {
        $currentDate = date('Y-m-d');
        $isOnOffer = $row['Offered'] == 1 && $currentDate >= $row['OfferStartDate'] && $currentDate <= $row['OfferEndDate'];
          
        // Choose the correct price based on whether the item is on offer
        $price = $isOnOffer ? $row["OfferedPrice"]*$conversionRate : $row["Price"]*$conversionRate;
        $totalPrice = $price * $row["Quantity"];
        $formattedPrice = number_format($price, 2);
        $formattedTotal = number_format($totalPrice, 2);
      
      echo "<div class='product'>";
      echo "<div class='product-image'>";
      echo "<img src='Images/Products/$row[ProductImage]' />";
      echo "</div>";
      echo "<div class='product-details'>";
      echo "<div style='display: flex; align-items: center;'>";
      echo "<div class='product-title'>$row[Name]</div>";
      // Display the hourglass icon for low stock items here
      if ($row["Stock"] < 10 && $row["Stock"] > 0) {
        echo "<div style='display: flex; align-items: center; margin-top: 5px;'>";
        echo "<img src='Images/images.jpeg' style='height:20px; width:20px; margin-right: 5px;' title='Low Stock' />";
        echo "<span style='font-size: 14px; color: orange;'>Low Stock</span>";
        echo "</div>";
      }
      echo "</div>"; // Close flex container
      echo "<p class='product-description'>$row[ProductDesc]</p>";
      echo "</div>";


      echo "<div class='product-price'>$formattedPrice</div>";

      if ($row["Stock"] == 1 && !isset($_SESSION['updateSubmitted'])) {
        
        echo "<form id='autoSubmitForm' action='cartFunctions.php' method='post'>";
        echo "<input type='hidden' name='action' value='update' />";
        echo "<input type='hidden' name='product_id' value='{$row['ProductID']}'/>";
        echo "<input type='hidden' name='quantity' value='1'/>"; // Set quantity to 1
        echo "</form>";
        
        // Check if a specific parameter is present in the URL
        if (isset($_GET['autosubmit'])) {
            $_SESSION['updateSubmitted'] = True;
            echo "<script>document.addEventListener('DOMContentLoaded', function() {";
            echo "document.getElementById('autoSubmitForm').submit();";
            echo "});</script>";
        }
        
 
    } else if (isset($_SESSION['updateSubmitted'])) {
        // Clear the session flag to allow for normal operations on the next visit
        unset($_SESSION['updateSubmitted']);
    }
    
    

      echo "<form action='cartFunctions.php' method='post'>";
      echo "<div class='product-quantity'>";

      if ($row["Stock"] <= 0) {
        $allItemsInStock = false;
          echo "<p style='color: red;'>Out of stock. Please remove this item.</p>";
          // Note: The quantity selector is omitted here since the item is out of stock
      } 
     elseif ($row["Quantity"] > $row["Stock"]) {
          $allItemsInStock = false;
          echo "<p>Please adjust the quantity. Only $row[Stock] left in stock.</p>";
          echo "<select name='quantity' onChange='this.form.submit()'>";
          for($i = 1; $i <= $row["Stock"]; $i++) {
              $selected = ($i == $row["Quantity"]) ? "selected" : "";
              echo "<option value='$i' $selected>$i</option>";
          }
          echo "</select>";
      } else {
          // Stock is sufficient, show the select element as normal
          echo "<select name='quantity' onChange='this.form.submit()'>";
          $maxOptions = min($row["Stock"], 10); // Limiting the max options to 10 or stock if lower
          for($i=1; $i <= $maxOptions; $i++) {
              $selected = ($i == $row["Quantity"]) ? "selected" : "";
              echo "<option value='$i' $selected>$i</option>";            
          }
          echo "</select>";
      }

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
  
  // Define shipping prices in SGD
  $normalPriceSGD = 5;
  $expressPriceSGD = 10;
  
  // Convert shipping prices to the selected currency
  $normalPriceConverted = $normalPriceSGD * $conversionRate;
  $expressPriceConverted = $expressPriceSGD * $conversionRate;
  
  echo '<input type="radio" id="normal" name="shipping_option" value="normal" onchange="this.form.submit()"'.(isset($_SESSION['selected_shipping']) && $_SESSION['selected_shipping'] == 'normal' ? ' checked' : '').'>';
  echo '<label for="normal">Normal (Delivery within 2 Working Days) - ' . htmlspecialchars($selectedCurrency) . ' ' . number_format($normalPriceConverted, 2) . '</label><br/>';
  
  echo '<input type="radio" id="express" name="shipping_option" value="express" onchange="this.form.submit()"'.(isset($_SESSION['selected_shipping']) && $_SESSION['selected_shipping'] == 'express' ? ' checked' : '').'>';
  echo '<label for="express">Express (Delivery within 24 Hours) - ' . htmlspecialchars($selectedCurrency) . ' ' . number_format($expressPriceConverted, 2) . '</label>';
  
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
  $formattedTaxAmount = number_format($taxAmount, 2);
  echo '<div class="totals-value" id="cart-tax">'.$formattedTaxAmount.'</div>';
  echo '</div>';
  echo '<div class="totals-item">';
  echo '<label>Shipping</label>';
 
  if ($subTotal <= 200) {
      // Check if a shipping option was previously selected
      $shipping = (isset($_SESSION['selected_shipping']) && $_SESSION['selected_shipping'] == 'express') ? number_format(10*$conversionRate,2) : number_format(5*$conversionRate,2);
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
  $totalprice = number_format($totalprice, 2);

  echo '<div class="totals-value" id="cart-total">'.$totalprice.'</div>';
  echo '</div>';
  echo '</div>';

  $cartIsValid = validateCartItems($conn);

  if ($cartIsValid && $allItemsInStock) {
    echo "<form method='post' action='checkout.php'>";
    echo '<button class="checkout" type="submit">Checkout</button>';
    echo "</form>";
} else {
    echo "<button class='checkout' style='background-color: red; color: white;' disabled>Unable to checkout</button>";
    // Optionally, add JavaScript to alert the user or dynamically update the page to show which items need attention.
}



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


// Before showing the checkout button, validate cart item

// Include logic to show notification or disable checkout based on $cartIsValid

?>
<!-- 
<script>
function validateShipping() {
    if (!document.getElementById('normal').checked && !document.getElementById('express').checked) {
        alert('Please select a shipping option.');
        return false;
    }
    return true;
}

document.querySelector('.checkout').addEventListener('click', function(e) {
    // Perform client-side validation or AJAX calls to ensure cart validity
    // Prevent checkout if the cart is invalid
    fetch('validate_cart.php') // Assume this endpoint performs similar checks as validateCartItems()
        .then(response => response.json())
        .then(data => {
            if (!data.isValid) {
                alert('Please adjust your cart items according to stock availability.');
                e.preventDefault(); // Prevent form submission
            }
        })
        .catch(error => {
            console.error('Error validating cart:', error);
            e.preventDefault();
        });
});

</script> -->