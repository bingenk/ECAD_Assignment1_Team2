<?php
session_start(); // Detect the current session
include_once("mysql_conn.php"); // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Read the data input from previous page
    $name = $_POST["Name"];
    $email = $_POST["Sign_Up_Email"];
    $dob = $_POST["Dob"];
    $phone = $_POST["Phone"];
    $address = $_POST["Address"];
    $country = $_POST["Country"];
    $password = $_POST["Sign_Up_Password"];
    $security_question = $_POST["Security_Question"];
    $answer = $_POST["Answer"];

    // Check if the email already exists in the database
    $checkEmailQuery = "SELECT Email FROM Shopper WHERE Email = ?";
    $checkStmt = $conn->prepare($checkEmailQuery);
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    if ($checkResult->num_rows > 0) {
        echo json_encode(["success" => false, "message" => "This email is already registered. Please use a different email."]);
        exit();
    }

    // Create a password hash using the default bcrypt algorithm
   

    // Define the INSERT SQL statement
    $qry = "INSERT INTO Shopper (Name, BirthDate, Address, Country, Phone, Email, Password, PwdQuestion, PwdAnswer) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($qry);
    $stmt->bind_param("sssssssss", $name, $dob, $address, $country, $phone, $email, $password, $security_question, $answer);

    if ($stmt->execute()) { // SQL statement executed successfully
        // Retrieve the shopper ID assigned to the new shopper
        $qry = "SELECT LAST_INSERT_ID() AS ShopperID";
        $result = $conn->query($qry); // Execute the SQL and get the returned result
        while ($row = $result->fetch_array()) {
            $_SESSION["ShopperID"] = $row["ShopperID"];
        }

        $_SESSION["ShopperName"] = $name; // Save the shopper name in a session variable
        echo json_encode(["success" => true, "shopperId" => $_SESSION["ShopperID"]]);
    } else {
        echo json_encode(["success" => false, "message" => "Error in inserting record"]);
    }

    $stmt->close();
    $conn->close();
} else {
    // Redirect to the registration page or show an error for non-AJAX requests
    header('Location: login.php'); // Adjust this as needed
}
?>
