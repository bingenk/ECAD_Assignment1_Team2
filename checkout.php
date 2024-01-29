<?php
  session_start();
  include_once("mysql_conn.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout</title>
  <link rel="stylesheet" href="./css/checkout-style.css">
  <link rel="shortcut icon" href="./assets/images/logo/favicon.ico" type="image/x-icon">

  <link rel="stylesheet" href="css/style-prefix.css">

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
            <a href="#"><i class="fa fa-arrow-left" style="margin-top: 15px;"></i></a><h2 style="margin-top:0px">Order Items</h2>
            <div class='line'></div>
            <div class="order-container">
              <?php
              
              $qry = ("SELECT sc.ShopCartID
                                      FROM ShopCart sc LEFT JOIN ShopCartItem sci 
                                      ON sc.ShopCartID=sci.ShopCartID 
                                      WHERE sc.ShopperID=1");
              $result = $conn->query($qry);
              if ($result->num_rows > 0)
              {
                while ($row = $result->fetch_array()) 
                {
                  $cartId = $row['ShopCartID'];
                  $_SESSION['cartId'] = $cartId;

                  $stmt = $conn->prepare("SELECT sci.Name, sci.Price, sci.Quantity, p.ProductImage FROM ShopCartItem sci LEFT JOIN Product p 
                                      ON sci.ProductID=p.ProductID 
                                      WHERE sci.ShopCartID= ?");
                  $stmt->bind_param("i", $_SESSION['cartId']);
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
                }
              }
              else
              {
                echo "No items in cart";
              }
                ?>
            
            </div>
      
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
              echo "No items in cart";
            }

            ?>

            <span style='float:left;'>
                <div class='order'>Sub-Total:</div>
                <div class='order'>Discount:</div>
                <?php echo "<div class='order'>GST ($gstrate%):</div>";?>
                <div class='order'>Delivery:</div>
                <div class='order order-total'>TOTAL:</div>
            </span>
            <span style='float:right; text-align:right;'>
            <?php
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
                    echo "<div class='order'>$$subtotal</div>"; 
                    echo "<div class='order'>-$$discount</div>";
                    echo "<div class='order'>+$$tax</div>";
                    echo "<div class='order'>+$$shipping</div>";
                    echo "<div class='order order-total'>$$total</div>";
                  }
                }
            ?>
            </span>
              </div>
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


                <div class='checkout'>
                <img src='./Images/PayPal.png' height='80' class='credit-card-image' id='credit-card-image'></img>
                <button class='pay-btn'>Checkout With Paypal </button>
                </div>
              </div>

            </div>
        </div>
    </div>
</body>
</html>

<?php

function ()
{

}
?>

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


             <!-- <?php
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
            ?> -->