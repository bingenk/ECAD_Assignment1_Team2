<?php
// Detect the current session
session_start();
// Include the Page Layout header

// Reading inputs entered in previous page
$email = $_POST["Log_In_Email"];
$pwd = $_POST["Log_In_Password"];

// Include the PHP file that establishes database connection handle: $conn
include_once("mysql_conn.php");

// Define the SELECT SQL statement
$qry = "SELECT * FROM Shopper WHERE email = ?";
$stmt = $conn->prepare($qry);
$stmt->bind_param("s", $email);

// Execute the prepared statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();
$stmt->close();

if ($result->num_rows > 0) { // SQL statement executed successfully
    $row = $result->fetch_array();
    $hashed_pwd = $row["Password"];
    
    if ($pwd == $hashed_pwd) {
        // Successful login logic

        // Set session variables for ShopperID and ShopperName
        $_SESSION["ShopperID"] = $row["ShopperID"];
        $_SESSION["ShopperName"] = $row["Name"];

        // Get active shopping cart
        include_once("mysql_conn.php");
        $qry = "SELECT sc.ShopCartID, COUNT(sci.ProductID) AS NumItems 
                FROM ShopCart sc LEFT JOIN ShopCartItem sci 
                ON sc.ShopCartID=sci.ShopCartID 
                WHERE sc.ShopperID=? AND sc.OrderPlaced=0";
        $stmt = $conn->prepare($qry);
        $stmt->bind_param("i", $_SESSION["ShopperID"]); // "i" - integer
        $stmt->execute();
        $result2 = $stmt->get_result();
        $stmt->close();

        if ($result2->num_rows > 0) {
            $row = $result2->fetch_array();
            $_SESSION["Cart"] = $row["ShopCartID"];
            $_SESSION["NumCartItem"] = $row["NumItems"];
        }

         

        header("Location: index.php");
        exit();
    } else {
        // Incorrect password
        header("Location: login.php?error=password");
        exit();
    }
} else {
    // Email not found
    header("Location: login.php?error=email");
    exit();
}


// Close database connection
$conn->close();

// Include the Page Layout footer
include("footer.php");
?>
