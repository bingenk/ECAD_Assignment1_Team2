<?php
  session_start();
  include_once("mysql_conn.php");
  include_once("myPayPal.php");

  $cartId = 0;

  $canCheckout = true;

  if (isset($_SESSION['Cart']) && isset($_SESSION["Items"]))
  {
    $cartId = $_SESSION['Cart'];
  }
  else if (isset($_SESSION['ShopperID']))
  {
    header("Location: shoppingCart.php");
    exit;
  }
  else
  {
    header("Location: index.php");
    exit;
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout</title>
  
  <link rel="shortcut icon" href="./assets/images/logo/favicon.ico" type="image/x-icon">

  <link rel="stylesheet" href="css/style-prefix.css">
  <link rel="stylesheet" href="./css/checkout-style.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>
    
    <div class='container'>
    <div class='window'>
        <div class='order-info'>
        <div class='order-info-content'>
            <a href="shoppingCart.php"><i class="fa fa-arrow-left" style="margin-top: 15px;"></i></a><h2 style="margin-top:0px">Order Items</h2>
            <div class='line'></div>
            <div class="order-container">
              <?php
                $stmt = $conn->prepare("SELECT sci.Name, sci.Price, sci.Quantity, p.ProductImage, p.ProductId, p.Quantity as Stock FROM ShopCartItem sci LEFT JOIN Product p 
                                    ON sci.ProductID=p.ProductID 
                                    WHERE sci.ShopCartID= ?");
                $stmt->bind_param("i", $cartId);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0)
                {
                  while($row = $result->fetch_array())
                  {
                    $productName = $row['Name'];
                    $productPrice = $row['Price'];
                    $productQuantity = $row['Quantity'];
                    $productImage = $row['ProductImage'];
                    
                    echo "<table class='order-table'>";
                    echo "<tbody>";
                    echo "<tr>";
                    echo "<td><img src='./Images/Products/$productImage' class='full-width'></img></td>";
                    echo "<td>";
                    echo "<br> <span class='thin'>$productName</span>";
                    echo "<br> <span class='thin small'>Quantity: $productQuantity<br><br></span>";

                    if ($row['Stock'] < $productQuantity)
                    {
                      echo "<div style='color:red; font-size:0.8rem'>This product is out of stock.</div>";
                      echo "<div style='color:red; font-size:0.7rem'>Please return to shopping cart and amend your purchase.</div>";
                      $canCheckout = false;
                    }

                    echo "</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>";
                    echo "<div class='price'>$$productPrice</div>";
                    echo "</td>";
                    echo "</tr>";
                    echo "</tbody>";
                    echo "</table>";
                    echo "<div class='line'></div>";
                  }
                }
              
              $shipping = 0;

              if (isset($_SESSION["selected_shipping"]))
              {

                if ($_SESSION["selected_shipping"] == "normal")
                {
                  $shipping = 5;
                  $_SESSION["shipping"] = "Normal";
                }
                else if ($_SESSION["selected_shipping"] == "express")
                {
                  $shipping = 10;
                  $_SESSION["shipping"] = "Express";
                }

                if (isset($_SESSION["is_free"]))
                {
                  $shipping = 0;
                  $_SESSION["shipping"] = "Free";
                }
              } 

              foreach($_SESSION['Items'] as $key=>$item){
                $pid = $item["productId"];
                $qry = "SELECT Quantity FROM product WHERE ProductID = ?";
                $stmt = $conn->prepare($qry);
                $stmt->bind_param("i", $pid);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_array();
                $stmt->close();
              }

              ?>
            
            </div>

      </div>
      </div>
          <div class='credit-info'>
          <div class='credit-info-content'>
          <h3>Order Summary</h3>

          <div class='summary'>

          <?php
          $qry = "SELECT * FROM GST WHERE EffectiveDate <= CURDATE() ORDER BY EffectiveDate DESC LIMIT 1";

          $conn->query($qry);
          $result = $conn->query($qry);
          if ($result->num_rows > 0)
          {
            while ($row = $result->fetch_array())
            {
              $gstrate = $row['TaxRate'];
            }
          }
          else
          {
            header("Location: shoppingCart.php");
            exit;
          }

          ?>

          <span style='float:left;'>
              <div class='order'>Sub-Total:</div>
              <div class='order'>Discount:</div>
              <?php echo "<div class='order'>GST ($gstrate%):</div>";?>
              <?php echo "<div class='order'>$_SESSION[shipping] Delivery:</div>" ?>
              <div class='order order-total'>TOTAL:</div>
          </span>
          <span style='float:right; text-align:right;'>
          <?php
              $stmt = $conn->prepare("SELECT * FROM ShopCart WHERE ShopCartID= ?");
              $stmt->bind_param("i", $cartId);
              $stmt->execute();
              $result = $stmt->get_result();
              if ($result -> num_rows > 0)
              {
                while($row = $result->fetch_array())
                {
                  $discount = $row['Discount'];
                }
              }

              $subtotal = 0;

              $stmt = $conn->prepare("SELECT * FROM ShopCartItem WHERE ShopCartID= ?");
              $stmt->bind_param("i", $cartId);
              $stmt->execute();
              $result = $stmt->get_result();
              if ($result -> num_rows > 0)
              {
                
                while($row = $result->fetch_array())
                {
                  $subtotal += $row['Price'] * $row['Quantity'];
                }
              }
              $tax = ($gstrate/100) * $subtotal;
              $total = $subtotal + $tax + $shipping;
                

              echo "<div class='order'>$$subtotal</div>"; 
              echo "<div class='order'>-$$discount</div>";
              echo "<div class='order'>+$$tax</div>";
              echo "<div class='order'>+$$shipping</div>";
              echo "<div class='order order-total'>$$total</div>";

              $_SESSION['SubTotal'] = $subtotal;
              $_SESSION['Tax'] = $tax;
              $_SESSION['ShipCharge'] = $shipping;
              $_SESSION['Total'] = $total;
            ?>
            </span>
            </div>
            <form action="checkoutProcess.php" method="post">
            <div style="margin:10px">
              Message for Gift (Optional)
            <input class='input-field' name="message"></input>
                </div>
                <img src='./Images/PayPal.png' height='80' class='credit-card-image' id='credit-card-image'></img>
                <?php
                    if ($canCheckout)
                    {
                        echo "<button class='pay-btn' name='checkoutBtn'>";
                        echo "Checkout With Paypal";
                        echo "</button>";
                    }
                    else
                    {
                        echo "<button class='pay-btn' name='checkoutBtn' disabled >";
                        echo "<small style='font-size:0.8rem'>Please amend your shopping cart to checkout</small>";
                        echo "</button>";
                    }
                ?>
            </form>
              </div>
            </div>
        </div>
    </div>
</body>
</html>




<!-- 

if (isset($_POST['checkoutBtn']) && !($subtotal == 0|| $total == 0 || $tax == 0 || $shipping == 0))
{
  $_SESSION['SubTotal'] = $subtotal;
  $_SESSION['Tax'] = $tax;
  $_SESSION['ShipCharge'] = $shipping;
  $_SESSION['Total'] = $total;
  checkoutProcess();
}

function checkoutProcess()
{
	foreach ($_SESSION["Items"] as $key => $item) {
    $pid = $item["productId"];
    $name = $item["name"];
    $qry = "SELECT Quantity FROM product WHERE ProductID = ?";
    $stmt = $conn->prepare($qry);
    $stmt->bind_param("i", $pid);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_array();
    $stmt->close();
    
    if ($row["Quantity"] < $item["Quantity"]) {
        echo "<div style='color:red'><b>Product $pid: $name is out of stock.</b></div>";
        echo "<div style='color:red'><b>Please return to the shopping cart to amend your purchase.</b></div>";
        exit;
    }
  }
	
	$paypal_data = '';

	foreach($_SESSION['Items'] as $key=>$item) {
		$paypal_data .= '&L_PAYMENTREQUEST_0_QTY'.$key.'='.urlencode($item["Quantity"]);
	  	$paypal_data .= '&L_PAYMENTREQUEST_0_AMT'.$key.'='.urlencode($item["Price"]);
	  	$paypal_data .= '&L_PAYMENTREQUEST_0_NAME'.$key.'='.urlencode($item["Name"]);
		$paypal_data .= '&L_PAYMENTREQUEST_0_NUMBER'.$key.'='.urlencode($item["ProductID"]);
	}
	
	// $_SESSION["Tax"] = round($_SESSION["SubTotal"]*0.09,2);
	// $_SESSION["ShipCharge"] = 2.00; 
	
	$padata = '&CURRENCYCODE='.urlencode($PayPalCurrencyCode).
			  '&PAYMENTACTION=Sale'.
			  '&ALLOWNOTE=1'.
			  '&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($PayPalCurrencyCode).
			  '&PAYMENTREQUEST_0_AMT='.urlencode($_SESSION["SubTotal"] +
				                                 $_SESSION["Tax"] + 
												 $_SESSION["ShipCharge"]).
			  '&PAYMENTREQUEST_0_ITEMAMT='.urlencode($_SESSION["SubTotal"]). 
			  '&PAYMENTREQUEST_0_SHIPPINGAMT='.urlencode($_SESSION["ShipCharge"]). 
			  '&PAYMENTREQUEST_0_TAXAMT='.urlencode($_SESSION["Tax"]). 	
			  '&BRANDNAME='.urlencode("FloraGifts").
			  $paypal_data.				
			  '&RETURNURL='.urlencode($PayPalReturnURL ).
			  '&CANCELURL='.urlencode($PayPalCancelURL);	
		
	$httpParsedResponseAr = PPHttpPost('SetExpressCheckout', $padata, $PayPalApiUsername, 
	                                   $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
		
	if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || 
	   "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {					
		if($PayPalMode=='sandbox')
			$paypalmode = '.sandbox';
		else
			$paypalmode = '';
				
		$paypalurl ='https://www'.$paypalmode. 
		            '.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='.
					$httpParsedResponseAr["TOKEN"].'';
		header('Location: '.$paypalurl);
	}
	else {

		echo "<div style='color:red'><b>SetExpressCheckOut failed : </b>".
		      urldecode($httpParsedResponseAr["L_LONGMESSAGE0"])."</div>";
		echo "<pre>".print_r($httpParsedResponseAr)."</pre>";
	}


  if(isset($_GET["token"]) && isset($_GET["PayerID"])) 
  {	
    $token = $_GET["token"];
    $playerid = $_GET["PayerID"];
    $paypal_data = '';
    
    foreach($_SESSION['Items'] as $key=>$item) 
    {
      $paypal_data .= '&L_PAYMENTREQUEST_0_QTY'.$key.'='.urlencode($item["Quantity"]);
        $paypal_data .= '&L_PAYMENTREQUEST_0_AMT'.$key.'='.urlencode($item["Price"]);
        $paypal_data .= '&L_PAYMENTREQUEST_0_NAME'.$key.'='.urlencode($item["Name"]);
      $paypal_data .= '&L_PAYMENTREQUEST_0_NUMBER'.$key.'='.urlencode($item["ProductID"]);
    }
    
    $padata = '&TOKEN='.urlencode($token).
          '&PAYERID='.urlencode($playerid).
          '&PAYMENTREQUEST_0_PAYMENTACTION='.urlencode("SALE").
          $paypal_data.	
          '&PAYMENTREQUEST_0_ITEMAMT='.urlencode($_SESSION["SubTotal"]).
                '&PAYMENTREQUEST_0_TAXAMT='.urlencode($_SESSION["Tax"]).
                '&PAYMENTREQUEST_0_SHIPPINGAMT='.urlencode($_SESSION["ShipCharge"]).
          '&PAYMENTREQUEST_0_AMT='.urlencode($_SESSION["SubTotal"] + 
                                            $_SESSION["Tax"] + 
                                  $_SESSION["ShipCharge"]).
          '&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($PayPalCurrencyCode);
    
    $httpParsedResponseAr = PPHttpPost('DoExpressCheckoutPayment', $padata, 
                                      $PayPalApiUsername, $PayPalApiPassword, 
                      $PayPalApiSignature, $PayPalMode);
    
    if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || 
      "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) 
    {
      $qry = "UPDATE poduct SET Quantity = Quantity - ? WHERE ProductID = ?";
      $stmt = $conn->prepare($qry);
      $stmt ->bind_param("ii", $item["quantity"], $item["productId"]);
      $stmt -> execute();
      $stmt -> close();
      
      $total = $_SESSION["SubTotal"] + $_SESSION["Tax"] + $_SESSION["ShipCharge"];
      $qry = "UPDATE shopcart SET OrderPlaced = 1, Quantity=?, SubTotal=?,
          ShipCharge=?, Tax=?, Total=? WHERE ShopCartID=?";
      $stmt = $conn->prepare($qry);
      $stmt->bind_param("iddddi", $_SESSION["NumCartItem"],
                $_SESSION["SubTotal"], $_SESSION["ShipCharge"],
                $_SESSION["Tax"], $total,
                $_SESSION["Cart"]);
      $stmt->execute();
      $stmt->close();

      $transactionID = urlencode(
                      $httpParsedResponseAr["PAYMENTINFO_0_TRANSACTIONID"]);
      $nvpStr = "&TRANSACTIONID=".$transactionID;
      $httpParsedResponseAr = PPHttpPost('GetTransactionDetails', $nvpStr, 
                                        $PayPalApiUsername, $PayPalApiPassword, 
                        $PayPalApiSignature, $PayPalMode);

      if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || 
        "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) 
        {
        
        $ShipName = addslashes(urldecode($httpParsedResponseAr["SHIPTONAME"]));
        
        $ShipAddress = urldecode($httpParsedResponseAr["SHIPTOSTREET"]);
        if (isset($httpParsedResponseAr["SHIPTOSTREET2"]))
          $ShipAddress .= ' '.urldecode($httpParsedResponseAr["SHIPTOSTREET2"]);
        if (isset($httpParsedResponseAr["SHIPTOCITY"]))
            $ShipAddress .= ' '.urldecode($httpParsedResponseAr["SHIPTOCITY"]);
        if (isset($httpParsedResponseAr["SHIPTOSTATE"]))
            $ShipAddress .= ' '.urldecode($httpParsedResponseAr["SHIPTOSTATE"]);
        $ShipAddress .= ' '.urldecode($httpParsedResponseAr["SHIPTOCOUNTRYNAME"]). 
                        ' '.urldecode($httpParsedResponseAr["SHIPTOZIP"]);
          
        $ShipCountry = urldecode(
                      $httpParsedResponseAr["SHIPTOCOUNTRYNAME"]);
        
        $ShipEmail = urldecode($httpParsedResponseAr["EMAIL"]);			
        
        $stmt = $conn->prepare("INSERT INTO OrderData (ShipName, ShipAddress, ShipCountry,
                                      ShipEmail, ShopCartID) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi",$ShipName, $ShipAddress, $ShipCountry, $ShipEmail, $_SESSION["Cart"]);
        $stmt->execute();
        $stmt->close();
        $qry = "SELECT LAST_INSERT_ID() AS OrderID";
        $result = $conn->query($qry);
        $row = $result->fetch_array();
        $_SESSION["OrderID"] = $row["OrderID"];
          
        $conn->close();
            
        $_SESSION["NumCartItem"] = 0;
        unset($_SESSION["Cart"]);
          
        header("Location: orderConfirmation.php");
        exit;
      } 
      else 
      {
          echo "<div style='color:red'><b>GetTransactionDetails failed:</b>".
                        urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
        echo "<pre>".print_r($httpParsedResponseAr)."</pre>";
        $conn->close();
      }
    }
    else {
      echo "<div style='color:red'><b>DoExpressCheckoutPayment failed : </b>".
                      urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
      echo "<pre>".print_r($httpParsedResponseAr)."</pre>";
    }
  }
}

?> -->

            <!-- <div class='total'>
            
            <span style='float:left;'>
                <div class='thin dense'>Sub-Total</div>
                <div class='thin dense'>Discount</div>
                <div class='thin dense'>VAT 19%</div>
                <div class='thin dense'>Delivery</div>
                TOTAL
            </span>
            <span style='float:right; text-align:right;'>
           
            </span>
            </div> -->

<!-- <tr>
                    <td> First Name*
                    <input class='input-field'  required></input>
                    </td>
                    <td> Last Name*
                    <input class='input-field' required></input>
                    </td>
                </tr>
                </table>

                Email Address*
                <input class='input-field' type='email' required></input>

                Phone Number*
                <input class='input-field' type="number" required></input>

                Delivery Address*
                <input class='input-field' required></input>

                Country*
                <input class='input-field' required></input> -->

<!-- <table class='order-table'>
            <tbody>
            <tr>
            <td><img src='https://dl.dropboxusercontent.com/s/sim84r2xfedj99n/%24_32.JPG' class='full-width'></img>
                </td>
                <td>
                    <br> <span class='thin'>Nike</span>
                    <br> Free Run 3.0 Women<br> <span class='thin small'> Color: Grey/Orange, Size: 10.5<br><br></span>
                </td>

                </tr>
                <tr>
                <td>
                    <div class='price'>$99.95</div>
                </td>
                </tr>
            </tbody>
            </table>
            <div class='line'></div>
            </div> -->


             <!-- 
                $stmt = $conn->prepare("SELECT * FROM ShopCart WHERE ShopCartID= ?");
                $stmt->bind_param("i", $_SESSION['cartId']);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result -> num_rows > 0)
                {
                  while($row = $result->fetch_array())
                  {
                    $subtotal = $row['SubTotal'];
                    $discount = $row['Discount'];
                    $total = $row['Total'];
                    $tax = $row['Tax'];
                    $shipping = $row['ShipCharge'];
                    echo "<div class='thin dense'>$$subtotal</div>"; 
                    echo "<div class='thin dense'>-$$discount</div>";
                    echo "<div class='thin dense'>+$$tax</div>";
                    echo "<div class='thin dense'>+$$shipping</div>";
                    echo "$$total";
                  }
                }
             -->

<!-- $stmt = $conn->prepare("SELECT sci.Name, sci.Price, sci.Quantity, p.ProductImage FROM ShopCartItem sci LEFT JOIN Product p 
                                      ON sci.ProductID=p.ProductID 
                                      WHERE sci.ShopCartID= ?");
                  $stmt->bind_param("i", $cartId);
                  $stmt->execute();
                  $result = $stmt->get_result();
                  if ($result->num_rows > 0)
                  {
                    while($row = $result->fetch_array())
                    {
                      $productName = $row['Name'];
                      $productPrice = $row['Price'];
                      $productQuantity = $row['Quantity'];
                      $productImage = $row['ProductImage'];
                      
                      echo "<table class='order-table'>";
                      echo "<tbody>";
                      echo "<tr>";
                      echo "<td><img src='./Images/Products/$productImage' class='full-width'></img></td>";
                      echo "<td>";
                      echo "<br> <span class='thin'>$productName</span>";
                      echo "<br> <span class='thin small'>Quantity: $productQuantity<br><br></span>";
                      echo "</td>";
                      echo "</tr>";
                      echo "<tr>";
                      echo "<td>";
                      echo "<div class='price'>$$productPrice</div>";
                      echo "</td>";
                      echo "</tr>";
                      echo "</tbody>";
                      echo "</table>";
                      echo "<div class='line'></div>";
                    }
                  }

                if (isset($_SESSION["selected_shipping"]))
                {
                  $shippingType = $_SESSION["selected_shipping"];
                  if (isset($_SESSION["is_free"]))
                  {
                    $shipping = 0;
                  }
                  else
                  {
                    if ($shippingType == "normal")
                    {
                      $shipping = 5;
                    }
                    else if ($shippingType == "express")
                    {
                      $shipping = 10;
                    }
                  }
                } -->