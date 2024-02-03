<?php


if (!isset($_SESSION["OrderID"]))
{
    header("Location: index.php");
    exit;
}

include ("header.php");

?>

<!DOCTYPE html>
<html lang="en">
    <title>Email Template for Order Confirmation Email</title>

    <script>
        function printPageArea(areaID){
            var printContent = document.getElementById(areaID).innerHTML;
            var originalContent = document.body.innerHTML;
            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = originalContent;
        }
    </script>

</head>
<body>
    <div class="container order" id="print">
        <!-- Start header Section -->
        <div class="header">
            <h2>You order has been confirmed!</h2>
            <p style="font-size: 14px; line-height: 18px; color: #666666;">Thank you for shopping at FloraGifts</p>
            <p style="font-size: 14px; line-height: 18px; color: #666666;">Singapore, Singapore 123456</p>
            <p style="font-size: 14px; line-height: 18px; color: #666666;">Phone: 310-807-6672 | Email: floragifts@support.com</p>
            <p style="font-size: 14px; line-height: 18px; color: #666666; padding-bottom: 25px;">
            <?php
            $stmt = $conn->prepare("SELECT * FROM orderdata WHERE OrderID = ?");
            $stmt->bind_param("i", $_SESSION["OrderID"]);
            $stmt->execute();
            $result = $stmt->get_result();
            $orderrow = $result->fetch_assoc();
            echo "<strong>Order Number:</strong> " . $orderrow["OrderID"] . " | <strong>Order Date:</strong> " . $orderrow["DateOrdered"];
            ?>
            </p>
        </div>
        <!-- End header Section -->

        <!-- Start address Section -->
        <?php
        echo "<div class='address-section'>";
        echo "<div class='address-column'>";
        echo "<p style='font-size: 16px; font-weight: bold; color: #666666; padding-bottom: 5px;'>Delivery Address</p>";
        echo "<p style='font-size: 14px; line-height: 18px; color: #666666;'>" . $orderrow["ShipName"] . "</p>";
        echo "<p style='font-size: 14px; line-height: 18px; color: #666666;'>" . $orderrow["ShipAddress"] . "</p>";
        echo "</div>";
        echo "</div>";
        ?>
        <!--  -->
        <!-- End address Section -->

        <!-- Start product Section -->
        <div class="product-section">


            <?php
            $stmt = $conn->prepare("SELECT p.ProductImage, sci.Name, sci.Quantity, sci.Price FROM ShopCartItem sci 
                                    INNER JOIN Product p on p.ProductID = sci.ProductID WHERE ShopCartID = ?");
            $stmt->bind_param("i", $orderrow["ShopCartID"]);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                echo "<div style='display: flex; align-items: center; justify-content: space-between; padding-bottom: 10px;'>";
                echo "<div style='display: flex; align-items: center;'>";
                echo "<img style='height: 80px; margin-right: 10px;' src='Images/Products/" . $row["ProductImage"] . "' alt='Product Image' />";
                echo "<div>";
                echo "<div style='font-size: 14px; font-weight: bold; color: #666666; padding-bottom: 5px;'>" . $row["Name"] . "</div>";
                echo "<div style='font-size: 14px; line-height: 18px; color: #757575;'>Quantity: " . $row["Quantity"] . "</div>";
                echo "</div>";
                echo "</div>";
                echo "<div style='font-size: 14px; line-height: 18px; color: #757575; text-align: right;'>";
                echo "<b style='color: #666666;'>Total: $" . $row["Price"] . "</b>";
                echo "</div>";
                echo "</div>";
            }
            
            

            ?>
            
            <!-- Product 2 -->
            <!-- Repeat the structure for other products -->

        </div>
        <!-- End product Section -->

        <!-- Start calculation Section -->
        <div class="calculation-section">
            <table>
                <?php 
                $stmt = $conn->prepare("SELECT * FROM ShopCart WHERE ShopCartID = ?");
                $stmt->bind_param("i", $orderrow["ShopCartID"]);
                $stmt->execute();
                $result = $stmt->get_result();
                $cartrow = $result->fetch_assoc();

                echo "<tr>";
                echo "<td style='font-size: 14px; line-height: 18px; color: #666666;'>Sub-Total:</td>";
                echo "<td style='font-size: 14px; line-height: 18px; color: #666666; text-align: right;'>$" . $cartrow["SubTotal"] . "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td style='font-size: 14px; line-height: 18px; color: #666666; '>GST Tax</td>";
                echo "<td style='font-size: 14px; line-height: 18px; color: #666666; text-align: right;'>$" . $cartrow["Tax"] . "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td style='font-size: 14px; line-height: 18px; color: #666666; padding-bottom: 10px; border-bottom: 1px solid #eeeeee;'>Shipping (".$orderrow["DeliveryMode"].")</td>";
                echo "<td style='font-size: 14px; line-height: 18px; color: #666666; padding-bottom: 10px; text-align: right; border-bottom: 1px solid #eeeeee;'>$" . $cartrow["ShipCharge"] . "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td style='font-size: 14px; font-weight: bold; line-height: 18px; color: #666666;padding-top: 10px; padding-bottom: 10px;'>Order Total</td>";
                echo "<td style='font-size: 14px; font-weight: bold; line-height: 18px; color: #666666;padding-top: 10px; padding-bottom: 10px; text-align: right;'>$" . $cartrow["Total"] . "</td>";
                echo "</tr>";
                ?>

                <!-- <tr>
                    <td style="font-size: 14px; line-height: 18px; color: #666666;">Sub-Total:</td>
                    <td style="font-size: 14px; line-height: 18px; color: #666666; text-align: right;">$1,234.50</td>
                </tr>
                <tr>
                    <td style="font-size: 14px; line-height: 18px; color: #666666; padding-bottom: 10px; border-bottom: 1px solid #eeeeee;">Sub-Total:</td>
                    <td style="font-size: 14px; line-height: 18px; color: #666666; padding-bottom: 10px; border-bottom: 1px solid #eeeeee; text-align: right;">$10.20</td>
                </tr>
                <tr>
                    <td style="font-size: 14px; font-weight: bold; line-height: 18px; color: #666666; padding-top: 10px;">Shipping</td>
                    <td style="font-size: 14px; font-weight: bold; line-height: 18px; color: #666666; padding-top: 10px; text-align: right;">$1,234.50</td>
                </tr>
                <tr>
                    <td style="font-size: 14px; font-weight: bold; line-height: 18px; color: #666666;">GST Tax</td>
                    <td style="font-size: 14px; font-weight: bold; line-height: 18px; color: #666666; text-align: right;">100%</td>
                </tr>
                <tr>
                    <td style="font-size: 14px; font-weight: bold; line-height: 18px; color: #666666; padding-bottom: 10px;">Order Total</td>
                    <td style="font-size: 14px; font-weight: bold; line-height: 18px; color: #666666; text-align: right; padding-bottom: 10px;">$1,234.50</td>
                </tr> -->
            </table>
        </div>
        <!-- End calculation Section -->

        <!-- Start payment method Section -->
        <div class="payment-method-section">
            <table>
                <?php
                $stmt = $conn->prepare("SELECT * FROM Shopper WHERE ShopperID = ?");
                $stmt->bind_param("i", $_SESSION["ShopperID"]);
                $stmt->execute();
                $result = $stmt->get_result();
                $shopperrow = $result->fetch_assoc();

                echo "<tr>";
                echo "<td colspan='2' style='font-size: 16px; font-weight: bold; color: #666666; padding-bottom: 5px;'>Payment Method (Paypal)</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td style='font-size: 14px; line-height: 18px; color: #666666;'>Buyer Name: " . $shopperrow["Name"] . "</td>";
                echo "<td style='font-size: 14px; line-height: 18px; color: #666666;'>Buyer Phone: " . $shopperrow["Phone"] . "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td style='font-size: 14px; line-height: 18px; color: #666666;padding-bottom:10px;'>Buyer Email: " . $shopperrow["Email"] . "</td>";
                echo "<td style='font-size: 14px; line-height: 18px; color: #666666;padding-bottom:10px;'>Buyer Address: " . $shopperrow["Address"] . "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td colspan='2' style='text-align: center; font-style: bold; font-size: 13px; font-weight: 600; color: #666666; padding: 15px 0; border-top: 1px solid #eeeeee;'>";
                echo "<b style='font-size: 14px;'>Message to Receiver (".$orderrow["ShipName"].") :</b> " . $orderrow["Message"];
                echo "</td>";
                echo "</tr>";

                ?>
            </table>
        </div> 
        <!-- End payment method Section

        < Add any additional styles or scripts as needed -->
    </div>
    <div class="button-container">

        <button class="back-button" onclick="window.location.href='index.php'">
        Back to Home
        </button>
        <button class="print-button" onclick="printPageArea('print')">
        Print
        </button>

    </div>
  
</body>
</html>


<?php include 'footer.php'; ?>


<style type="text/css">
        body {
            margin: 0;
            padding: 0;
            font-family: Helvetica, Arial, sans-serif;
        }
        
        .container.order {
            width: 100%;
            /* max-width: 800px; Adjust the maximum width as needed */
            margin: 20px auto; /* Add margin for centering */
            background-color: #ffffff;
            padding: 20px; /* Add padding to the container */
            border: 2px solid black;
        }
        
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #eeeeee;
        }
        
        .header img {
            max-width: 100%;
            height: auto;
        }
        
        .address-section {
            padding-top: 20px;
            border-bottom: 1px solid #bbbbbb;
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        
        .address-section .address-column {
            width: 50%;
        }
        
        .product-section {
            border-bottom: 1px solid #eeeeee;
            margin-bottom: 20px; /* Add margin for spacing */
        }
        
        .product-section img {
            height: 80px;
        }
        
        .calculation-section {
            border-bottom: 1px solid #bbbbbb;
            margin-bottom: 20px; /* Add margin for spacing */
        }
        
        .calculation-section table {
            width: 100%;
        }
        
        .payment-method-section {
            padding: 20px 10px;
        }
        
        .payment-method-section table {
            width: 100%;
        }
        
        .note {
            text-align: center;
            font-style: italic;
            font-size: 13px;
            font-weight: 600;
            color: #666666;
            padding: 15px 0;
            border-top: 1px solid #eeeeee;
            margin-top: 20px; 
        }

        .button-container {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
        }

        .print-button,
        .back-button {
        padding: 10px 20px;
        font-size: 16px;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin-top: 20px;
        margin-left: 10px;
        }

        .print-button {
        background-color: #4CAF50;
        }

        .back-button {
        background-color: #ff69b4; 
        }

        .print-button:hover,
        .back-button:hover {
        filter: brightness(1.2); 
        }
    </style>

<!-- 
<div class="address-section">
            <div class="address-column">
                <p style="font-size: 16px; font-weight: bold; color: #666666; padding-bottom: 5px;">Delivery Address</p>
                <p style="font-size: 14px; line-height: 18px; color: #666666;">James C Painter</p>
                <p style="font-size: 14px; line-height: 18px; color: #666666;">3939 Charles Street, Farmington Hills</p>
                <p style="font-size: 14px; line-height: 18px; color: #666666;">Michigan, 48335</p>
            </div>
            <div class="address-column">
                <p style="font-size: 16px; font-weight: bold; color: #666666; padding-bottom: 5px;">Billing Address</p>
                <p style="font-size: 14px; line-height: 18px; color: #666666;">James C Painter</p>
                <p style="font-size: 14px; line-height: 18px; color: #666666;">3939 Charles Street, Farmington Hills</p>
                <p style="font-size: 14px; line-height: 18px; color: #666666;">Michigan, 48335</p>
            </div>
        </div> -->

        <!-- <div style="display: flex; align-items: center; justify-content: space-between; padding-bottom: 10px;">
                <div style="display: flex; align-items: center;">
                    <img style="height: 80px; margin-right: 10px;" src="images/product-1.jpg" alt="Product Image" />
                    <div>
                        <div style="font-size: 14px; font-weight: bold; color: #666666; padding-bottom: 5px;">Lorem ipsum dolor sit amet</div>
                        <div style="font-size: 14px; line-height: 18px; color: #757575;">Quantity: 100</div>
                        <div style="font-size: 14px; line-height: 18px; color: #757575;">Color: White & Blue</div>
                        <div style="font-size: 14px; line-height: 18px; color: #757575;">Size: XL</div>
                    </div>
                </div>
                <div style="font-size: 14px; line-height: 18px; color: #757575; text-align: right;">
                    <b style="color: #666666;">Total: $1,234.50</b>
                </div>
            </div> -->